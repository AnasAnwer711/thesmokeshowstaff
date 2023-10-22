<?php

namespace App\Http\Traits;

use App\Models\BasicSetting;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

trait Notify {


    public function notify($for, $data)
    {
        switch ($for) {
            case 'registration':
                $this->registration($data);
                break;
            
            case 'review_profile':
                $this->review_profile($data);
                break;
            
            case 'violation_attempt':
                $this->violation_attempt($data);
                break;
            
            // case 'approval':
            //     $this->approval($data);
            //     break;
            
            case 'profile_published':
                $this->profile_published($data);
                break;
            
            case 'complete_your_profile':
                $this->complete_your_profile($data);
                break;
            
            case 'job_invitation':
                $this->job_invitation($data);
                break;
            
            case 'job_application':
                $this->job_application($data);
                break;
            
            case 'job_accepted':
                $this->job_accepted($data);
                break;
            
            case 'job_invitation_declined':
                $this->userRegistration($data);
                break;
            
            case 'job_live':
                $this->job_live($data);
                break;
            
            case 'new_message':
                $this->new_message($data);
                break;
            
            case 'job_started_staff':
                $this->job_started_staff($data);
                break;

            case 'job_started_host':
                $this->job_started_host($data);
                break;

            case 'job_feedback':
                $this->job_feedback($data);
                break;

            case 'job_closed':
                $this->job_closed($data);
                break;
            
            case 'account_blocked':
                $this->account_blocked($data);
                break;
            
            case 'payment_failure':
                $this->payment_failure($data);
                break;
            
            case 'job_status_changed':
                $this->job_status_changed($data);

                break;
            
            
            default:
                # code...
                break;
        }
    }

    public function mailToAdmin($content, $subject)
    {
        // add default settings in data array
        $basic_setting = BasicSetting::first();
        // $emailData = [];
        $emailData['content'] = $content;
        $emailData['basic_setting'] = $basic_setting;

        //find admins
        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            $emailData['user_data'] = $admin;
            # code...
            Mail::send('emails.admin_email', $emailData, function ($m) use ($admin, $subject) {
                $m->to($admin->email, $admin->name)->subject($subject);
            });
        }
    }

    public function mailToBasicSender($content, $subject)
    {

        $to_email = 'no-reply@datanetbpodemo.com';
        $to_name = 'Show Staff';
        $basic_setting = BasicSetting::first();
        if($basic_setting){
            if($basic_setting->sender_email)
                $to_email = $basic_setting->sender_email;
            if($basic_setting->name)
                $to_name = $basic_setting->name;
        }
        // add default settings in data array
        $basic_setting = BasicSetting::first();
        // $emailData = [];
        $emailData['content'] = $content;
        $emailData['basic_setting'] = $basic_setting;

 
        Mail::send('emails.admin_email', $emailData, function ($m) use ($to_email, $to_name, $subject) {
            $m->to($to_email, $to_name)->subject($subject);
        });
    }

    public function registration($data)
    {
        if($data['user_data']->hasRole('staff'))
            $this->sendMail('emails.staff_registration', $data, 'Registration');
        else if($data['user_data']->hasRole('host'))
            $this->sendMail('emails.host_registration', $data, 'Registration');

        $userIs = $data['user_data']->hasRole('staff') ? 'staff' : 'host';
        $content = 'New '.$userIs.' has been registered successfully';
        $this->mailToAdmin($content, 'New Registration');
        
    }
    
    public function review_profile($data)
    {
        $content = 'New staff '.$data['user_data']->name.' has completed his profile successfully. Kindly approve/reject after review staff profile';
        $this->mailToAdmin($content, 'Review Profile');
    }
    
    public function violation_attempt($data)
    {
        $content = $data['user_data']->name.' staff/host has trying to break the rule as per policy and attempt of violation has been charged. Kindly review message and take appropriate action';
        $this->mailToAdmin($content, 'Violation Attempt');
    }
    
    public function complete_your_profile($data)
    {
        $this->sendMail('emails.complete_your_profile', $data, 'Complete Your Profile');
    }
    
    public function profile_published($data)
    {
        $content = 'Congratulations your profile has been approved to our platform.';
        $this->sendMail('emails.profile_published', $data, 'Profile Published');
        $this->createNotification($data['user_data']->id, $data['source_data']->id, 'Profile Published', $content);
        $phone_number = $this->getPhoneNoWithUserId($data['user_data']->id);
        if($phone_number)
            $this->sendSms($content, $phone_number);
    }
    
    public function job_live($data)
    {
        $this->sendMail('emails.job_live', $data, 'Your job is now live');
        $content = 'Host '.$data['user_data']->name.' posted a new job and live for all staff';
        $this->mailToAdmin($content, 'Job Live');
    }
    
    public function job_invitation($data)
    {
        $content = 'You have received a job invitation from '.$data['job_applicant']->job->user->name;
        $this->sendMail('emails.job_invitation', $data, 'New Job Invitation');
        $this->createNotification($data['user_data']->id, $data['job_applicant']->job->user->id, 'Job Invitation', $content ?? 'Staff', '/applications#app_tab_2');
        $phone_number = $this->getPhoneNoWithUserId($data['user_data']->id);
        if($phone_number)
            $this->sendSms($content, $phone_number);
        
    }
    
    public function new_message($data)
    {
        $content = 'You have a new message from '.$data['sender_data']->name. ' regarding '.$data['job_title'];
        $phone_number = $this->getPhoneNoWithUserId($data['user_data']->id);
        if($phone_number)
            $this->sendSms($content, $phone_number);
        
    }
    
    public function job_application($data)
    {
        $content = 'You have received a job application from '.$data['job_applicant']->staff->name;
        $this->sendMail('emails.job_application', $data, 'New Job Application');
        $this->createNotification($data['user_data']->id, $data['job_applicant']->staff->id, 'Job Received', $content ?? 'Staff', '/invitations/'.$data['job_applicant']->job->id);
        $phone_number = $this->getPhoneNoWithUserId($data['user_data']->id);
        if($phone_number)
            $this->sendSms($content, $phone_number);
    }
    
    // public function job_accepted($data)
    // {
    //     $this->sendMail('emails.job_application', $data, 'New Job Application');
    //     $this->createNotification($data['user_data']->id,  $data['job_applicant']->job->user->id, 'Job Accepted', $data['job_applicant']->job->user->name ." have accepted application for your requested job", '/applications#app_tab_3');
    // }
    
    // public function job_declined($data)
    // {
    //     $this->sendMail('emails.job_application', $data, 'New Job Application');
    //     $this->createNotification($data['user_data']->id,  $data['job_applicant']->job->user->id, 'Job Accepted', $data['job_applicant']->job->user->name ." have accepted application for your requested job", '/applications#app_tab_3');
    // }
    
    // public function received_application($data)
    // {
    //     $this->createNotification($data,'Job Received', 'You have received a job application from '.$data['job_applicant']->staff->name ?? 'Staff');
    // }
    // $staff_phone_number = $this->getPhoneNoWithUserId($data['user_data']->id);
    // if($staff_phone_number){
    //     $content = 'Host '.$data['user_data']->name.' job has been started successfully as per given time.';
    //     $this->sendSms($content, $staff_phone_number);
    // }
    // $host_phone_number = $this->getPhoneNoWithUserId($data['user_data']->id);
    // if($host_phone_number){
    //     $content = 'Your job has been started successfully as per given time.';
    //     $this->sendSms($content, $host_phone_number);
    // }
    
    public function job_started_staff($data)
    {
        $this->sendMail('emails.job_started_staff', $data, 'Job has been started');
        $content = 'Host '.$data['job_applicant']->job->user->name.' job has been started successfully as per given time.';
        $this->mailToAdmin($content, 'Job Started');
        $phone_number = $this->getPhoneNoWithUserId($data['user_data']->id);
        if($phone_number)
            $this->sendSms($content, $phone_number);
    }

    public function job_started_host($data)
    {
        $this->sendMail('emails.job_started_host', $data, 'Job has been started');
        $content = 'Your job has been started successfully as per given time.';
        $this->mailToAdmin($content, 'Job Started');
        $phone_number = $this->getPhoneNoWithUserId($data['user_data']->id);
        if($phone_number)
            $this->sendSms($content, $phone_number);
    }
    
    public function job_feedback($data)
    {
        $this->sendMail('emails.job_feedback', $data, 'Remember to give feedback');
    }
    
    public function job_closed($data)
    {
        $this->sendMail('emails.job_closed', $data, 'Job has been closed');
        $content = 'Your job has been closed successfully. Remember to give feedback';
        $phone_number = $this->getPhoneNoWithUserId($data['user_data']->id);
        if($phone_number)
            $this->sendSms($content, $phone_number);
    }

    public function account_blocked($data)
    {
        $this->sendMail('emails.account_blocked', $data, 'Account has been suspended');
    }
    public function payment_failure($data)
    {
        $this->sendMail('emails.payment_failure', $data, 'Payment Attempt Failed');
    }
    
    public function job_status_changed($data)
    {
        $subject = $this->getSubject($data['current_status']);
        $this->sendMail('emails.job_status_changed', $data, $subject);
        $content = 'Your '.$data['job_applicant']->job->title.' job has been '.$data['current_status'].' successfully by '.$data['source_data']->name;
        // $this->createNotification($data['user_data']->id,  $data['source_data']->id, $subject, $data['source_data']->name ." have ".$data['current_status']." your job");
        $this->createNotification($data['user_data']->id,  $data['source_data']->id, $subject, $content);
    }

    public function getSubject($status)
    {
        switch ($status) {
            case 'unbooked':
                $subject = 'Job Cancelled';
                break;
            
            default:
                $subject = 'Job '.ucfirst($status);
                break;
        }

        return $subject;
    }

    public function sendMail($view, $data, $subject)
    {
        // add default settings in data array
        $basic_setting = BasicSetting::first();
        // $emailData = [];
        $emailData = $data;
        $emailData['basic_setting'] = $basic_setting;
        Mail::send($view, $emailData, function ($m) use ($data, $subject) {
            $m->to($data['user_data']->email, $data['user_data']->name ?? null)->subject($subject);
        });
    }
    
    public function createNotification($user_id, $source_id, $title, $description, $link = null)
    {
        $un = UserNotification::create([
            'user_id' => $user_id,
            'source_id' => $source_id,
            'title' => $title,
            'description' => $description,
            'link' => $link,
        ]);
    }

    public function sendSms($message, $receiverNumber)
    {
        // dd($message, $receiverNumber);
        try {
            //code...
            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_TOKEN");
            $twilio_number = env("TWILIO_FROM");
            if(!$account_sid || !$auth_token || !$twilio_number) {
                return false;
            }
            $client = new Client($account_sid, $auth_token);
            // dd($client);
    
            $client->messages->create($receiverNumber, 
            [
                'from' => $twilio_number, 
                'body' => $message
            ]);

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message'=> $th->getMessage()],401);
            
        }
    }

    private function getPhoneNoWithUserId($user_id)
    {
        $user = User::find($user_id);
        if($user){
            return $user->phone_sms;
        }
        return false;
    }

}