<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationStatusRequest;
use App\Http\Traits\Notify;
use App\Models\CancellationPolicy;
use App\Models\Job;
use App\Models\JobApplicant;
use App\Models\PaymentConfiguration;
use App\Models\Subscription;
use App\Models\SubscriptionUsage;
use App\Models\User;
use App\Models\UserCard;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvitationController extends Controller
{
    use Notify;
    public function show($id)
    {
        $job_id = $id;
        return view('content.invitations.index',compact('job_id'));
    }
    
    public function get_invitation($job_id)
    {
        try {
            $job = Job::with('invitations.staff.address', 'applications.staff.address', 'booked.staff.address', 'booked.job.user', 'staff_category:id,title')->withCount('applications', 'invitations', 'booked')->where('id',$job_id)->first();
            return response()->json(['success'=>true, 'data'=>$job]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function checkRole($user_id)
    {
        $staff_user = User::where('id', $user_id)->whereHas('roles', function ($q) {
            $q->where('name', 'staff');
        })->where('status', 'approved')->first();
        $host_user = User::where('id', $user_id)->whereHas('roles', function ($q) {
            $q->where('name', 'host');
        })->where('status', 'approved')->first();

        if($host_user)
            $role = 'host';
        else if($staff_user)
            $role = 'staff';
        else
            $role = null;

        return $role;
    }

    public function applyPolicy($user_type, $data, $rule_type='cancel')
    {
        $job_applicant = JobApplicant::find($data['job_applicant_id']);
        
        $date = $this->convertToUtcDate($job_applicant->job->date);
        $start_time = $this->convertToUtcTime($job_applicant->job->start_time);
        $end_time = $this->convertToUtcTime($job_applicant->job->end_time);

        $job_start_date = $date .' '.$start_time;

        $start_date = new DateTime(now());
        $since_start = $start_date->diff(new DateTime($job_start_date));

        $duration = $since_start->days * 24 * 60;
        $duration += $since_start->h * 60;
        $duration += $since_start->i;

        // dd($duration);
        if ($rule_type == 'no-show') {
            $cancellation_policy = CancellationPolicy::where('user_type', $user_type)
            ->where('rule_type', $rule_type)
            ->first();
        } else {
            $cancellation_policy = CancellationPolicy::where('user_type', $user_type)
            ->where('duration', '>', $duration)
            ->orderBy('duration', 'asc')
            ->first();
        }

        return $cancellation_policy;
        
        // dd($cancellation_policy);
    }

    public function applyCharge($policy, $job_applicant_id,$action_by, $role)
    {
        if($policy->transaction_type == 'flat')
            $charge_apply = $policy->charges;

        if($policy->transaction_type == 'percentage'){
            $job_applicant = JobApplicant::find($job_applicant_id);
            if($role == 'staff'){
                $charge_apply = $job_applicant->host_fee * $policy->charges / 100;
            } else if ($role == 'host'){
                $charge_apply = $job_applicant->job_pay * $policy->charges / 100;
            }
        }
        $charge_card = $job_applicant->bookingCardCharge($action_by,$charge_apply, 'Booking Cancellation Penalty', $job_applicant_id, 'job-applicant-unbooking');
        if(!$charge_card){
            // $card = UserCard::where('user_id', $action_by)->first();
            // $card->makeUserTransaction($charges_calculation, 'Staff Payment Failed', $this->id, 'job-applicant-booking-failed', 'unpaid');
            return false;
        }
        else
            return true;
    }

    public function applyCancellationPolicy($data)
    {
        $role = $this->checkRole($data['action_by']);
        if(!$role){
            return false;
        }
        $payment_configuration = PaymentConfiguration::first();

        if($role == 'staff')
            if(!$payment_configuration->staff_cancellation)
                return false;
        if($role == 'host')
            if(!$payment_configuration->host_cancellation)
                return false;

        $policy = $this->applyPolicy($role, $data, $data['rule_type'] ?? 'cancel');
        if(!$policy)
            return false;
        else{
            $charge = $this->applyCharge($policy, $data['job_applicant_id'],$data['action_by'], $role);
            return $charge;
        }
    }

    public function change_job_application_status(JobApplicationStatusRequest $request)
    {
        try {
            //code...

            DB::beginTransaction();
            $job_applicant = JobApplicant::find($request->job_applicant_id);

            $source = $job_applicant->source;
            if($request->status == 'reinvited')
                $source = 'invited';

            if($request->status == 'unbooked'){
                $this->applyCancellationPolicy($request->all());
                Job::where('id', $job_applicant->job_id)->decrement('occupied_positions', 1);
                Job::where('id', $job_applicant->job_id)->update(['job_status'=>'open']);
                if($job_applicant->host_payment_mode == 'subscribe'){
                    $this->additionInSubscription($job_applicant->id);
                }
                $this->changeInStaffEarning($job_applicant, 'decrement');
            }

            $staff_status = $job_applicant->staff_status;
            $host_status = $job_applicant->host_status;
             
            $current_status = $request->status;
            if($request->status == 'completed'){
                if($job_applicant->staff_id == auth()->user()->id){
                    $staff_status = 1;
                } else {
                    $host_status = 1;
                }
                
                if($job_applicant->host_status || $job_applicant->staff_status){
                    $job_applicant->applyChargeToStaff();
                    // $this->applyChargeToStaff($job_applicant);                
                } else {
                    $current_status = $job_applicant->current_status;
                }
            }

            JobApplicant::where('id',$request->job_applicant_id)
            ->update([
                'current_status' => $current_status,
                'source' => $source,
                'staff_status' => $staff_status,
                'host_status' => $host_status,
            ]);
            $job_applicant->refresh();
            $job_applicant->makeTransaction();

            $eData['current_status'] =  $request->status;
            $eData['job_applicant'] =  $job_applicant;
            if($job_applicant->staff_id == auth()->user()->id){
                $eData['user_data'] =  User::find($job_applicant->job->user->id);
                $eData['source_data'] =  User::find(auth()->user()->id);
            }
            else{
                $eData['user_data'] =  User::find($job_applicant->staff_id);
                $eData['source_data'] =  User::find(auth()->user()->id);
            }
                
            $this->notify('job_status_changed', $eData);
                
            DB::commit();
            return response()->json(['success'=>true, 'data'=>$job_applicant]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function accept_invitation($job_applicant_id)
    {
        try {
            $job_applicant = JobApplicant::find($job_applicant_id);
            $job = Job::find($job_applicant->job_id);
            $host = User::find($job->user_id);

            if($job->occupied_positions >= $job->no_of_positions)
                return response()->json(['message'=>'Sorry! All position for this job has been full'], 422);

            DB::beginTransaction();
            $card_id = $host->cards[0]->id;
            if(!$card_id)
                return response()->json(['message'=>'Host card credentials is missing'], 422);
            if($host->active_subscription){

                $subscription = Subscription::where('id', $host->active_subscription->id)
                ->where('status', 'active')
                ->whereColumn('utilized_limit', '<', 'total_limit')
                ->whereDate('expiry_date' ,'>', Carbon::now())
                ->first();

                if ($subscription)
                    $charge = $this->deductionFromSubscription($subscription, $job_applicant_id);
                else 
                    $charge = $this->chargeFromCard($card_id, $job_applicant_id);
                    
            } else 
                $charge = $this->chargeFromCard($card_id, $job_applicant_id);

            if(!$charge){
                DB::rollBack();
                return response()->json(['message'=>'Something went wrong during charge/subscription'], 422);
            }
            
            $host_payment_mode = 'card';
            $payment_configuration = PaymentConfiguration::first();

            $host_transaction_fee = 0;
            if($payment_configuration && $payment_configuration->host_transaction_fee)
                $host_transaction_fee = $payment_configuration->host_transaction_fee;
            $fee = $host_transaction_fee;
            if($host->active_subscription && $subscription){
                $host_payment_mode = 'subscribe';
                $plan = $subscription->subscription_plan;
                $fee = $plan->unit_price;
            }

            $job_applicant->host_payment_mode = $host_payment_mode;
            $job_applicant->host_fee = $fee;
            $job_applicant->current_status = 'booked';
            $job_applicant->save();
            $job_applicant->makeTransaction();

            $this->changeInStaffEarning($job_applicant, 'increment');

            $job->increment('occupied_positions', 1);
            if($job->occupied_positions == $job->no_of_positions)
                $job->job_status = 'occupied';
            $job->save();

            $staff = User::where('id', $job_applicant->staff_id)->first();

            $eData['current_status'] =  'accepted';
            $eData['job_applicant'] =  $job_applicant;
            $eData['user_data'] =  $host;
            $eData['source_data'] =  $staff;
            
            $this->notify('job_status_changed', $eData);

            // $job = Job::with('invitations.staff.address', 'applications.staff.address', 'booked.staff.address')->withCount('applications', 'invitations', 'booked')->where('id',$job_applicant->job_id)->first();
            DB::commit();

            return response()->json(['success'=>true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }
    
    public function accept_application($job_applicant_id, Request $request)
    {
        try {
            $job_applicant = JobApplicant::find($job_applicant_id);
            $job = Job::find($job_applicant->job_id);
            $host = User::find($job->user_id);

            if($job->occupied_positions >= $job->no_of_positions)
                return response()->json(['message'=>'Sorry! All position for this job has been full'], 422);

            DB::beginTransaction();
            if($host->active_subscription && $request->subscription_type != 'card'){
                
                $subscription = Subscription::where('id', $host->active_subscription->id)
                ->where('status', 'active')
                ->whereColumn('utilized_limit', '<', 'total_limit')
                ->whereDate('expiry_date' ,'>', Carbon::now())
                ->first();

                if ($subscription)
                    $charge = $this->deductionFromSubscription($subscription, $job_applicant_id);
                else 
                    $charge = $this->chargeFromCard($request->card_id, $job_applicant_id);
                    
            } else 
                $charge = $this->chargeFromCard($request->card_id, $job_applicant_id);

            if(!$charge){
                DB::rollBack();
                return response()->json(['message'=>'Something went wrong during charge/subscription'], 422);
            }
            
            $host_payment_mode = 'card';
            $payment_configuration = PaymentConfiguration::first();

            $host_transaction_fee = 0;
            if($payment_configuration && $payment_configuration->host_transaction_fee)
                $host_transaction_fee = $payment_configuration->host_transaction_fee;
            $fee = $host_transaction_fee;
            if($request->subscription_type != 'card'){

                $host_payment_mode = 'subscribe';
                if($subscription){
                    $plan = $subscription->subscription_plan;
                    $fee = $plan->unit_price;
                }

            }
            $job_applicant->host_payment_mode = $host_payment_mode;
            $job_applicant->host_fee = $fee;
            $job_applicant->current_status = 'booked';
            $job_applicant->save();
            $job_applicant->makeTransaction();

            $this->changeInStaffEarning($job_applicant, 'increment');

            $job->increment('occupied_positions', 1);
            if($job->occupied_positions == $job->no_of_positions)
                $job->job_status = 'occupied';
            $job->save();

            $job = Job::with('invitations.staff.address', 'applications.staff.address', 'booked.staff.address', 'booked.job')->withCount('applications', 'invitations', 'booked')->where('id',$job_applicant->job_id)->first();
            
            $staff = User::where('id', $job_applicant->staff_id)->first();

            $eData['current_status'] =  'accepted';
            $eData['job_applicant'] =  $job_applicant;
            $eData['user_data'] =  $staff;
            $eData['source_data'] =  $host;
            
            $this->notify('job_status_changed', $eData);
            
            DB::commit();

            return response()->json(['success'=>true, 'data'=>$job]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function changeInStaffEarning($job_applicant, $type)
    {
        $payment_configuration = PaymentConfiguration::first();
        if(!$payment_configuration)
            return false;
        
        if(!$payment_configuration->staff_transaction_fee)
            return false;

        
        $charges_calculation = $job_applicant->staffChargesCalculation();
        if(!$charges_calculation){
            return false;
        } else {

            if($type == 'decrement')
                Job::where('id', $job_applicant->id)->decrement('staff_earnings', $charges_calculation);
            else if ($type == 'increment')
                Job::where('id', $job_applicant->id)->increment('staff_earnings',$charges_calculation);

        }
    }

    public function deductionFromSubscription($subscription, $job_applicant_id)
    {
        try {
            $subscription->increment('utilized_limit', 1);
            if($subscription->utilized_limit == $subscription->total_limit)
                $subscription->status = 'utilized';
            $subscription->save();
    
            SubscriptionUsage::create([
                'subscription_id' => $subscription->id,
                'limit_used' => 1,
                'date_utlized' => Carbon::now(),
                'job_applicant_id' => $job_applicant_id,
                'status' => 'active',
            ]);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }

    public function additionInSubscription($job_applicant_id)
    {
        try {

            $subscription_usage = SubscriptionUsage::where('job_applicant_id', $job_applicant_id)->first();
            $subscription_usage->update([
                'limit_used' => 0,
                'status' => 'revoke',
            ]);

            $subscription = Subscription::find($subscription_usage->subscription_id);

            $subscription->decrement('utilized_limit', 1);
            if($subscription->expiry_date > date('Y-m-d'))
                $subscription->status = 'active';
            $subscription->save();
    
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
    
    public function chargeFromCard($card_id, $job_applicant_id)
    {
        $payment_configuration = PaymentConfiguration::first();

        $host_transaction_fee = 0;
        if($payment_configuration && $payment_configuration->host_transaction_fee)
            $host_transaction_fee = $payment_configuration->host_transaction_fee;

        if(!$host_transaction_fee)
            return true;

        $card = UserCard::find($card_id);
        if(!$card)
            return false;
        try {
            $host = User::find($card->user_id);
            
            $chargeOnCard = $this->deductFromCredit($host, $host_transaction_fee);

            // dd($card, $host_transaction_fee);
            if($chargeOnCard > 0){
                $charge = $card->makeCardAndCharge($chargeOnCard, 'Booking Fee', 'job-applicant-booking', $job_applicant_id);
                if($charge && $charge->captured)
                    return true;
                else 
                    return false;
            } else {
                return true;
            }
            

        } catch (\Throwable $th) {
            return false;
        }

    }

    public function deductFromCredit($host, $host_transaction_fee)
    {
        try {
            //code...
            $chargeOnCard = $host_transaction_fee;
            if($host->credit && $host->credit > 0){
                $remaining_fee = $host->credit - $host_transaction_fee;
                if($remaining_fee < 0){
                    $host->credit = 0;
                    $chargeOnCard = abs($remaining_fee);
                } else {
                    $host->credit = $remaining_fee;
                    $chargeOnCard = 0;
                }
                $host->save();
            }
            return $chargeOnCard;
        } catch (\Throwable $th) {
            return false;
        }
    }

}