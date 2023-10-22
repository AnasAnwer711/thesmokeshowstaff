<?php

namespace App\Http\Traits;
use App\Models\PaymentConfiguration;
use Stripe;

trait StripePayment {

    public function getStripeSecret()
    {
        $pc = PaymentConfiguration::first();
        if($pc->secret_key)
            return $pc->secret_key;
        else 
            return false;
        
    }

    //create token
    public function createStripeToken($data) {
        $stripe_secret = $this->getStripeSecret();
        $stripe = new Stripe\StripeClient($stripe_secret);
        try {
            $token = $stripe->tokens->create($data);
            return ['success'=>true,'token'=>$token];
        } catch (\Throwable $th) {
            return ['success'=>false,'message'=>$th->getMessage()];
        }
    }

    //create card
    public function createStripeCard($customer_id, $cardData) {
        $stripe_secret = $this->getStripeSecret();
        $stripe = new Stripe\StripeClient($stripe_secret);
        $source = $this->createStripeToken($cardData);
        if($source['success']){

            try {
                $card = $stripe->customers->createSource(
                    $customer_id,
                    ['source' => $source['token']]
                );
                return ['success'=>true,'card'=>$card];
            } catch (\Throwable $th) {
                return ['success'=>false,'message'=>$th->getMessage()];
            }
            
        } else {
            return ['success'=>false,'message'=>$source['message']];

        }
    }

    // create charge
    public function createStripeCharge($data) {
        $stripe_secret = $this->getStripeSecret();
        $stripe = new Stripe\StripeClient($stripe_secret);
        $charge = $stripe->charges->create($data);

        return $charge;
    }

    // create customer
    public function createStripeCustomer($name) {
        $stripe_secret = $this->getStripeSecret();
        $stripe = new Stripe\StripeClient($stripe_secret);
        $customer = $stripe->customers->create([
            'name' => $name
        ]);

        return $customer;
    }

    public function postPaymentStripe($data) {


        $expiry = explode("/",$data['expiry']);
        $month = trim($expiry[0], " ");
        $year = trim($expiry[1], " ");

        dd($month, $year);
        $pc = PaymentConfiguration::first();
        if($pc->secret_key){
            // $stripe = Stripe\Stripe::setApiKey(Crypt::decrypt($pc->secret_key));
            $stripe = Stripe\Stripe::setApiKey($pc->secret_key);
            
        } else {
            return ['success' => false, 'msgtype' => 'danger', 'errors' => [ [ "Stripe secret key is not configured!"] ] ];
        }

        // $charge = Stripe\Charge::create([
        //     'card' => $token['id'],
        //     'currency' => 'USD',
        //     'amount' => bcmul($data['amount'], 100), //stripe take amount in cents
        //     'description' => $data['description'],
        // ]);
        try {
            $charge = Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $data['stripeToken'],
                "description" => "This payment is tested purpose thesmokeshowstaff.com"
            ]);

            if($charge['status'] == 'succeeded') {           
                return ['success' => true, 'data' => $charge];
            } else {
                return ['success' => false, 'msgtype' => 'danger', 'errors' => [ [ "Payment not added!"] ] ];
            }
        }  catch (\Stripe\Exception\CardException $e) {
            return ['success' => false, 'msgtype' => 'danger', 'errors' => [ [ $e->getMessage()] ] ];
        }
    }
}