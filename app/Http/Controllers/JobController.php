<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Http\Traits\Notify;
use App\Models\Address;
use App\Models\Job;
use App\Models\JobApplicant;
use App\Models\JobLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    use Notify;

    public function __construct()
    {
        $this->middleware('role:host')->only('store');
        // $this->middleware('auth')->only('index');
        // $this->middleware('auth')->except('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.job.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('content.job.post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        try {
            $input = $request->all();
            $address_data = $this->make_address_data($input['address']);
            $data = $this->make_job_data($input);
            


            DB::beginTransaction();


            $address = Address::create($address_data);

            $data['address_id'] = $address->id;
            
            $job = Job::create($data);

            JobLog::create([
                "job_id" => $job->id,
                "status" => 'open',
                "date" => $data['date'],
            ]);

            $eData['user_data'] = auth()->user();
 
            $this->notify('job_live', $eData);

            DB::commit();
            return response()->json(['success'=>true, 'data'=>$job]);
            
            // return response()->json(['message'=>'Unable to create job'], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);
        }

        // dd($job_date, $end_time);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        // dd('show job', $job);
        return view('content.job.view', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return view('content.job.post', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        try {
            $input = $request->all();
            $address_data = $this->make_address_data($input['address']);
            $data = $this->make_job_data($input);

            DB::beginTransaction();


            $data['address_id'] = $input['address_id'];
            Address::where('id', $data['address_id'])->update($address_data);

            
            $job = Job::where('id', $input['id'])->update($data);

            JobLog::where('job_id', $input['id'])->update([
                "date" => $data['date'],
            ]);

            DB::commit();
            return response()->json(['success'=>true, 'data'=>$job]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        try {
            if($job->applicants){
                JobApplicant::where('job_id', $job->id)->delete();
            }
            $job->delete();
            return response()->json(['success'=>true]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function duplicate_job($job_id)
    {
        $job = Job::with('address.state')->where('id',$job_id)->first();
        return view('content.job.post', compact('job'));
    }
    
    public function find_job()
    {
        return view('content.find-job.index');
    }

    public function get_jobs(Request $request)
    {
        try {

            $data = $request->all();
            // dd($request->all());
            $qry = Job::with('address.state', 'user', 'staff_category', 'applicant_users', 'booked_applicants', 'booked_applicants.staff', 'booked.staff', 'not_booked.staff')->where('status', 1);
            
            if(isset($data['sub_categories'])){

                $sc = json_decode($data['sub_categories']);
                $sub_categories = [];
                foreach ($sc as $key => $value) {
                    if($value)
                        $sub_categories[] = $key;
                    // dd($value);
                }

                $exp = implode('|',$sub_categories);

    
                // dd(implode('|',$sub_categories));

                $qry->where('job_title', 'regexp', $exp);
            }

            
            
            if( isset($data['title']) ){
                $qry->where('title', $data['title']);

            }
           
            if( isset($data['suburb']) ){
                $qry->whereHas('address', function ($q) use ($data) {
                    $q->where('suburb', 'like', "%" . $data['suburb'] . "%" );
                });
            }
            
            if( isset($data['job_status']) ){
                $qry->where('job_status', $data['job_status']);
            } else {
                $qry->where('job_status', '!=', 'closed');
            }
            
            $job = $qry->get();
            return response()->json(['success'=>true, 'data'=>$job])->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
        
    }
    
    public function get_user_jobs()
    {
        try {
            $job = Job::where('user_id', auth()->user()->id)->withCount('applications', 'invitations' , 'booked')->get();
            return response()->json(['success'=>true, 'data'=>$job])->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
        
    }

    public function get_job($job_id)
    {
        try {
            $job = Job::with('address.state', 'user', 'staff_category')->where('id',$job_id)->first();
            return response()->json(['success'=>true, 'data'=>$job])->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
        
    }
    
    public function change_job_status($job_id)
    {
        try {
            $job = Job::where('id',$job_id)->first();
            if(!$job->applicants){

                $status = !$job->status;
                $job = Job::where('id',$job_id)->update(['status'=>$status]);
                return response()->json(['success'=>true, 'data'=>$job]);
            } else {

                if($job->job_status == 'open' || $job->job_status == 'occupied'){
                    $status = !$job->status;
                    Job::where('id',$job_id)->update(['status'=>$status]);
                    $job->refresh();
                    return response()->json(['success'=>true, 'data'=>$job])->setEncodingOptions(JSON_NUMERIC_CHECK);
                } else {

                    return response()->json(['message'=>'Unable to unpublished as job status has been '.$job->job_status], 422);
                }
            }

        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
        
    }

    public function make_address_data($address_data)
    {
        $address_data = [
            "country_id" => 1 ,
            "address_line1" => $address_data['address_line1'] ?? null,
            "address_line2" => $address_data['address_line2'] ?? null,
            "suburb" => $address_data['suburb'] ?? null,
            "state_id" => $address_data['state_id'] ?? null,
            "postal_code" => $address_data['postal_code'] ?? null,
            "latitude" => $address_data['latitude'] ?? null,
            "longitude" => $address_data['longitude'] ?? null,
        ];
        return $address_data;
    }
    
    public function make_job_data($data)
    {
        $date = $this->convertToUtc($data['date']);
        $start_time = $this->convertToUtc($data['start_time']);
        $end_time = $this->convertToUtc($data['end_time']);
        
        $data = [
            "user_id" => auth()->user()->id,
            "country_id" => 1,
            "title" => $data['title'],
            "staff_category_id" => $data['staff_category_id'],
            "date" => $date,
            "description" => $data['description'],
            "gender" => $data['gender'],
            "location" => $data['location'],
            "start_time" => $start_time,
            "duration" => $data['duration'],
            "end_time" => $end_time,
            "dress_code" => $data['dress_code'],
            "job_title" => $data['job_title'],
            "pay_rate" => $data['pay_rate'],
            "pay_type" => $data['pay_type'],
            "travel_allowance_id" => $data['travel_allowance_id'] ?? null,
            "no_of_positions" => $data['no_of_positions'],
        ];
        return $data;
    }

    public function complete(Request $request) {
        $data = $request->all();

        $job = Job::where('id', $data['job_id'])->first();
        
        $job->status = 0;
        $job->save();

        return response()->json(['success' => true, 'data' => $job->refresh(), 'message' => 'Job Completed Successfully']);
    }

    public function close(Request $request) {
        $data = $request->all();

        $job = Job::where('id', $data['job_id'])->first();
        $job->changeJobStatus('closed');

        return response()->json(['success' => true, 'data' => $job->refresh(), 'message' => 'Job Closed Successfully']);
    }
}