<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsRequest;
use App\Http\Traits\Notify;
use App\Models\BasicSetting;
use App\Models\BuildType;
use App\Models\Job;
use App\Models\Language;
use App\Models\Nationality;
use App\Models\State;
use App\Models\TravelAllowance;
use App\Models\UserShortlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    use Notify;
    public function index()
    {
        return view('content.home');
    }
    public function howitworks()
    {
        return view('content.howitworks');
    }
    public function faqs()
    {
        return view('content.faqs');
    }
    public function privacypolicy()
    {
        return view('content.privacypolicy');
    }
    public function termsandconditions()
    {
        return view('content.termsandconditions');
    }
    public function contactus(Request $request)
    {
        $job_id = null;
        if ($request->has('report')) {
            $job_id = $request->input('report');
        }
        $job = Job::find($job_id);
        $user = null;
        if(auth()->user())
            $user = auth()->user();
        return view('content.contactus', compact('user', 'job'));
    }

    public function get_contactus_details($job_id)
    {
        try {
            if($job_id){
                $job = Job::find($job_id);
                return response()->json(['success' => true, 'data' => $job]);
            }
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }
    
    public function doContactUs(ContactUsRequest $request)
    {
        try {
            $this->mailToBasicSender($request->message, $request->subject);
            return response()->json(['success' => true, []]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function travel_allowances()
    {
        $data = TravelAllowance::all();
        return response()->json(['success' => true, 'data' => $data]);
    }
    
    public function nationalities()
    {
        $data = Nationality::all();
        return response()->json(['success' => true, 'data' => $data]);
    }
    
    public function build_types()
    {
        $data = BuildType::all();
        return response()->json(['success' => true, 'data' => $data]);
    }
    
    public function states()
    {
        $data = State::all();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function languages()
    {
        $data = Language::all();
        return response()->json(['success' => true, 'data' => $data]);
    }

}