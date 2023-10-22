<?php

namespace App\Models;

use App\Http\Traits\StripePayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCard extends Model
{
    use HasFactory, SoftDeletes, StripePayment;

    protected $guarded = [];

    public function user_transactions()
    {
        return $this->hasMany(UserTransaction::class);
    }

    public function makeUserTransaction($amount, $description, $source_type = null, $source_id = null, $status = 'paid')
    {
        try {
            //code...
            $ut  = UserTransaction::where('user_id', $this->user_id)
            ->where('source_type' , $source_type)
            ->where('source_id' , $source_id)->first();
            if ($ut){
                $ut->increment('no_of_attempts', 1);
                $ut->status = $status;
                $ut->save();
            }
            $ut = UserTransaction::create([
                'user_id' => $this->user_id,
                'user_card_id' => $this->id,
                'amount' => $amount,
                'source_type' => $source_type,
                'source_id' => $source_id,
                'purpose' => $description,
                'status' => $status,
            ]);
            if($status == 'unpaid'){
                User::where('id', $this->user_id)->decrement('credit', $amount);
            }
            return true;
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }

    public function makeCardAndCharge($amount, $description, $source_type = null, $source_id = null)
    {
        $payment_configuration = PaymentConfiguration::with('currency')->first();
        $currency = 'usd';
        if($payment_configuration && $payment_configuration->currency)
            $currency = $payment_configuration->currency->name;

        $user = User::find($this->user_id);
        $cardData = [
            'card' => $this->stripe_card_id,
            'amount' => $amount * 100,
            'customer' => $user->stripe_customer_id,
            'currency' => $currency,
            'description' => $description.' for '.$user->name,
        ];

        try {
            $charge = $this->createStripeCharge($cardData);
            $status = 'unpaid';
            if($charge && $charge->captured)
                $status = 'paid';
            $ut = $this->makeUserTransaction($amount, $description, $source_type, $source_id, $status);
            return $charge;

        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return false;
        }

    }
}
