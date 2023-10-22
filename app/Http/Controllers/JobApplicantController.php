<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExtendBookingRequest;
use App\Http\Traits\Notify;
use App\Models\Job;
use App\Models\JobApplicant;
use App\Models\JobApplicantTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobApplicantController extends Controller
{

    use Notify;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $source_type = 'received';
            $current_status = 'received';
            $job_id = $request->source_id;
            $staff_id = auth()->user()->id;
            $keywordFirst = 'Job';
            $keywordSecond = 'invited/applied';
            if($request->source == 'invite'){
                $source_type = 'invited';
                $current_status = 'invited';
                $staff_id = $request->source_id;
                $job_id = $request->job_id;
                $keywordFirst = 'Staff';
                $keywordSecond = 'invited/applied';

            }

            $job = Job::find($job_id);

            if($job->job_status != 'open'){
                return response()->json(['message'=>'Sorry! All position for this job has been full'], 422);
            }

            // if(JobApplicant::where('job_id',$job_id)->where('staff_id',$staff_id)->where('source', $source_type)->doesntExist()){
            if(JobApplicant::where('job_id',$job_id)->where('staff_id',$staff_id)->where('current_status', '!=', 'contacted')->doesntExist()){
                $job_pay = $job->pay_rate;
                if($job->pay_type == 'per_hour')
                    $job_pay = $job->duration*$job->pay_rate;
                DB::beginTransaction();
                $data = JobApplicant::updateOrCreate(
                    [
                        "job_id" => $job_id,
                        "staff_id" => $staff_id,],
                    [
                        "source" => $source_type,
                        "code" => 'PS-'.$request->source_id.'-'.$source_type,
                        "current_status" => $current_status,
                        "description" => $request->description,
                        "job_actual_hours" => $job->duration,
                        "job_pay_type" => $job->pay_type,
                        "job_pay_rate" => $job->pay_rate,
                        "job_pay" => $job_pay,
                    ]
                );

                $data->makeTransaction();

            } else {
                return response()->json(['message'=>$keywordFirst.' has already been '.$keywordSecond], 422);
            }

            $eData['job_applicant'] = $data;
            if($request->source == 'invite'){
                $staff = User::where('id', $staff_id)->first();
                $eData['user_data'] = $staff;
                $this->notify('job_invitation', $eData);
            } else if ($request->source == 'received'){
                $host = User::where('id', $job->user_id)->first();
                $eData['user_data'] = $host;
                $this->notify('job_application', $eData);
            }
            DB::commit();
            // $data = User::with('shortlists')->where('id', auth()->user()->id)->first();
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobApplicant  $jobApplicant
     * @return \Illuminate\Http\Response
     */
    public function show(JobApplicant $jobApplicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobApplicant  $jobApplicant
     * @return \Illuminate\Http\Response
     */
    public function edit(JobApplicant $jobApplicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobApplicant  $jobApplicant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobApplicant $jobApplicant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobApplicant  $jobApplicant
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobApplicant $jobApplicant)
    {
        //
    }

    public function extended_booking(ExtendBookingRequest $request)
    {
        try {
            JobApplicant::where('id', $request->job_applicant_id)
            ->update([
                'job_extended_hours' => $request->job_extended_hours,
                'job_pay' => $request->job_pay,
            ]);
            return response()->json(['success' => true, 'data' => []]);

        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);

        }
    }

    public function get_applicant_job_ids($applicant_id)
    {
        try {
            //code...
            $data = JobApplicant::where('staff_id', $applicant_id)->where('current_status', '!=', 'contacted')->pluck('job_id')->toArray();
            return $this->sendResponse($data);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }
}
