<?php

namespace App\Http\Controllers;

use App\Models\BasicSetting;
use DateTime;
use DateTimeZone;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function convertToUtc($date)
    {
        $datetime = new DateTime($date);
        $datetime->setTimezone(new DateTimeZone("UTC"));
        return $datetime->format("Y-m-d H:i:s");
    }
    
    public function convertToUtcDate($date)
    {
        $datetime = new DateTime($date);
        $datetime->setTimezone(new DateTimeZone("UTC"));
        return $datetime->format("Y-m-d");
    }
    
    public function convertToUtcTime($date)
    {
        $datetime = new DateTime($date);
        $datetime->setTimezone(new DateTimeZone("UTC"));
        return $datetime->format("H:i:s");
    }

    // public function notify($for, $data)
    // {
    //     switch ($for) {
    //         case 'registration':
    //             $this->registration($data);
    //             break;
            
    //         case 'approval':
    //             $this->approval($data);
    //             break;
            
    //         case 'profile_published':
    //             $this->profile_published($data);
    //             break;
            
    //         case 'complete_your_profile':
    //             $this->complete_your_profile($data);
    //             break;
            
    //         case 'job_invitation':
    //             $this->job_invitation($data);
    //             break;
            
    //         case 'job_application':
    //             $this->job_application($data);
    //             break;
            
    //         case 'job_invitation_declined':
    //             $this->userRegistration($data);
    //             break;
            
    //         case 'job_live':
    //             $this->job_live($data);
    //             break;
            
    //         case 'new_message':
    //             $this->userRegistration($data);
    //             break;
            
            
    //         default:
    //             # code...
    //             break;
    //     }
    // }

    // public function registration($data)
    // {
    //     if($data['user_data']->hasRole('staff'))
    //         $this->sendMail('emails.staff_registration', $data, 'Registration');
    //     else if($data['user_data']->hasRole('host'))
    //         $this->sendMail('emails.host_registration', $data, 'Registration');
    // }
    
    // public function complete_your_profile($data)
    // {
    //     $this->sendMail('emails.complete_your_profile', $data, 'Complete Your Profile');
    // }
    
    // public function profile_published($data)
    // {
    //     $this->sendMail('emails.complete_your_profile', $data, 'Profile Published');
    // }
    
    // public function job_live($data)
    // {
    //     $this->sendMail('emails.job_live', $data, 'Your job is now live');
    // }
    
    // public function job_invitation($data)
    // {
    //     $this->sendMail('emails.job_invitation', $data, 'New Job Invitation');
    // }
    
    // public function job_application($data)
    // {
    //     $this->sendMail('emails.job_application', $data, 'New Job Application');
    // }

    // public function sendMail($view, $data, $subject)
    // {
    //     // add default settings in data array
    //     $basic_setting = BasicSetting::first();
    //     // $emailData = [];
    //     $emailData = $data;
    //     $emailData['basic_setting'] = $basic_setting;
    //     Mail::send($view, $emailData, function ($m) use ($data, $subject) {
    //         $m->to($data['user_data']->email, $data['user_data']->name)->subject($subject);
    //     });
    // }

    public function sendResponse($data, $message = "")
    {
    	$response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

    public function sendError($message = 'Internal Server Error', $code = 500)
    {
        return response()->json(['message' => $message], $code);
    }
}
