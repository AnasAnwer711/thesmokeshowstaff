<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplicant extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['is_applicant_reviewed'];

    protected $guarded = [];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
    
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function getIsApplicantReviewedAttribute()
    {
        if(auth()->user() && 
            UserReview::where('job_id', $this->job->id)
            ->where('source_id', auth()->user()->id)
            ->where('target_id', $this->staff_id)
            ->exists()
        ){
            return true;
        } else 
            return false;
    }

    public function makeTransaction()
    {
        $admin_id = 1;
        $admin = User::whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })->orderBy('id', 'desc')->first();
        
        $admin_id = $admin->id;

        $initiated_by = auth()->user() ? auth()->user()->id : $admin_id;
        JobApplicantTransaction::create([
            "job_applicant_id" => $this->id,
            "initiated_by" => $initiated_by,
            "status" => $this->current_status,
        ]);
    }


    public function paymentLog($message)
    {
        PaymentLog::create([
            'message' => $message
        ]);
    }


    public function applyChargeToStaff()
    {
        // check if payment configured
        try {
            $payment_configuration = PaymentConfiguration::first();
            if(!$payment_configuration)
                return false;
            
            if(!$payment_configuration->staff_transaction_fee)
                return false;

            
            $charges_calculation = $this->staffChargesCalculation();
            if(!$charges_calculation){
                return false;
            }
            $charge_card = $this->bookingCardCharge($this->staff_id, $charges_calculation, 'Booking Completed', $this->id, 'job-applicant-booking-completed');
            if(!$charge_card){
                $card = UserCard::where('user_id', $this->staff_id)->first();
                $card->makeUserTransaction($charges_calculation, 'Staff Payment Failed', $this->id, 'job-applicant-booking-failed', 'unpaid');
                return false;

            }
            else{
                $job = Job::find($this->job_id);
                $job->changeJobStatus('closed');

                $this->is_charged = 1;
                $this->save();
                return true;
            }
        } catch (\Throwable $th) {
            // dd($th);
            $this->paymentLog($th->getMessage());
            return false;
        }
        
    }


    public function staffChargesCalculation()
    {
        try {
            
            $payment_configuration = PaymentConfiguration::first();
            if($payment_configuration->staff_transaction_type == 'flat')
                $charge_apply = $payment_configuration->staff_transaction_fee;

            else if($payment_configuration->staff_transaction_type == 'percentage'){
                $charge_apply = $this->job_pay * $payment_configuration->staff_transaction_fee / 100;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->paymentLog($th->getMessage());
        }

        return $charge_apply;
    }

    public function bookingCardCharge($user_id, $charges, $description, $source_id, $source_type)
    {
        $card = UserCard::where('user_id', $user_id)->first();
        if(!$card)
            return false;
        try {
            $charge = $card->makeCardAndCharge($charges, $description, $source_type, $source_id);
            if($charge && $charge->captured)
                return true;
            else 
                return false;

        } catch (\Throwable $th) {
            $this->paymentLog($th->getMessage());
        }
    }
}
