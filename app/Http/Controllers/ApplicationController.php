<?php

namespace App\Http\Controllers;

use App\Models\JobApplicant;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('content.applications.index');
    }

    public function get_applicants()
    {
        try {
            // $qry = 
            $applications = JobApplicant::where('staff_id',auth()->user()->id)->with('job', 'staff')->where('source', 'received')
            ->whereHas('job', function($q){
                $q->where('job_status', 'open');
            })
            ->where(function($q) {
                $q->where('current_status', '!=', 'booked')->where('current_status', '!=', 'unbooked');
            })
            ->get();
            $invitations = JobApplicant::where('staff_id',auth()->user()->id)->with('job', 'staff')->where('source', 'invited')
            ->whereHas('job', function($q){
                $q->where('job_status', 'open');
            })
            ->where(function($q) {
                $q->where('current_status', '!=', 'booked')->where('current_status', '!=', 'unbooked');
            })
            ->get();
            $booked = JobApplicant::where('staff_id',auth()->user()->id)->with('job.user', 'staff')
            ->where(function($q) {
                $q->where('current_status', 'booked')
                ->orWhere('current_status', 'unbooked')
                ->orWhere('current_status', 'completed')
                ->orWhere('current_status', 'disputed');
            })
            // ->where('current_status', 'booked')->orWhere('current_status', 'unbooked')
            ->get();
            // $data['job_applicants'] = $job_applicants;
            $data['applications'] = $applications;
            $data['invitations'] = $invitations;
            $data['booked'] = $booked;
            // dd($data);
            return response()->json(['success'=>true, 'data'=>$data]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }
}