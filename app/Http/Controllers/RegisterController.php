<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Traits\Notify;
use App\Models\PaymentConfiguration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use Notify;

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }
        $otp = rand(1000, 9999);
        $content = "Your verification code is: $otp";
        $sms = $this->sendSms($content, $request->phone);
        if($sms){
            $result = $sms->getData();
            if(!$result->success && isset($result->message))
            return response()->json(['message' => $result->message], 401);
            else {
                return response()->json(['success'=> true, 'otp' => $otp, 'message' => 'OTP sent successfully'], 200);
            }
        } else {
            return response()->json(['message' => 'Unable to send message. Please contact with admin'], 401);
        }
        
    }
    
    public function doSignup(SignupRequest $request)
    {
        try {
            $referral_by = null;
            $referral_code = null;
            
            $credit = 0;
            $pc = PaymentConfiguration::first();
            if ($request->referral_code) {
                $split_code = explode('-', $request->referral_code);
                $referral = User::find($split_code[2]) ?? null;
                $referral_by = $referral->id ?? null;
                $referral_code = $request->referral_code;
                $credit = $pc->referral_reward ?? 0;
                $referral->increment('credit', $credit);
            }
            //code...
            $status = 'approved';
            if($request->type == 'staff')
                $status = 'pending';
            DB::beginTransaction();
            $data = User::create([
                'name' => $request->first_name .' '.$request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_code' => $request->phone_code,
                'phone_sms' => $request->phone_sms ?? null,
                'phone' => $request->phone,
                'display_name' => $request->display_name ?? null,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'nationality_id' => 1,
                'gender' => $request->gender,
                'status' => $status,
                'referral_by' => $referral_by,
                'referral_code' => $referral_code,
                'is_otp_verified' => $request->is_verified ?? false,
            ]);

            for ($i = 1; $i <= 10; $i++) {
                $data->skill_photos()->create([
                    'user_id' => $data->id,
                    'picture' => '/images/Logo_SmokeShowStaff.png',
                    'org_picture' => '/images/Logo_SmokeShowStaff.png',
                    'order_no' => $i,
                    'is_uploaded' => 0,
                    'is_default' => 0
                ]);
            }
            
            if($request->type == 'staff')
                $data->assignRole('staff');
            else if($request->type == 'host')
                $data->assignRole('host');

            if($pc){
                if($pc->secret_key)
                    $data->addStripeCustomer();
            }

            $eData['user_data'] = $data;

            $this->notify('registration', $eData);
            
            DB::commit();
            $credentials = $request->only('email', 'password');  
            if (Auth::attempt($credentials)) 
                return response()->json(['success'=>true, 'data'=>$data]);
            else
                return response()->json(['success'=>true, 'data'=>$data]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function doLogin(LoginRequest $request)
    {
        $data = User::where('email', $request->email)
        ->where('status', '!=', 'blocked')
        ->first();
        if($data){
            $credentials = $request->only('email', 'password');  
            if (Auth::attempt($credentials)) {
                return response()->json(['success'=>true, 'data'=>$data]);
            } else {
                return response()->json(['message'=>'User credentials not matched'], 422);
            }
        } else {
            return response()->json(['message'=>'User not exist or blocked by admin'], 422);
        }
    }

    public function login()
    {
        return view('content.auth.login');
    }
    
    public function signup()
    {
        return view('content.auth.signup');
    }
}