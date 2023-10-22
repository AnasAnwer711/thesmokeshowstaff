<?php

namespace App\Http\Controllers;

use App\Http\Traits\Notify;
use App\Models\PaymentConfiguration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Session;

class ReferralProgramController extends Controller
{
    use Notify;

    public function index($msg = null)
    {
        $payment_configuration = PaymentConfiguration::first();
        $referral_fee = 0;
        if($payment_configuration)
            $referral_fee = $payment_configuration->referral_reward ?? 0;
        return view('content.referral_program', compact('referral_fee', 'msg'));
    }
    
    public function store(Request $request)
    {
        try {
            if(!isset($request->emails))
                return redirect()->back()->with('error', 'Referral email field is required');

            $emails = explode(',', $request->emails);
            foreach ($emails as $key => $email) {
                $email = trim($email," ");
                $validator = Validator::make(['email' => $email],[
                    'email' => 'required|email'
                ]);
                if($validator->fails())
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            foreach ($emails as $key => $email) {
                $email = trim($email," ");
                $validator = Validator::make(['email' => $email],[
                    'email' => 'required|email'
                ]);
                  
                if($validator->passes()){
                    $eData['source_data'] = User::find(auth()->user()->id);
    
                    Mail::send('emails.referral', $eData, function ($m) use ($email) {
                        $m->to($email)->subject('Referral Signup');
                    });
    
                } 
            }

            $msg = 'Emails have been sent successfully!';
            return $this->index($msg);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
