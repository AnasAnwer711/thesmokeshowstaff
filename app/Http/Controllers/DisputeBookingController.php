<?php

namespace App\Http\Controllers;

use App\Models\DisputeBooking;
use App\Models\JobApplicant;
use App\Models\User;
use Illuminate\Http\Request;

class DisputeBookingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = User::find(auth()->user()->id);
            if($user){
                $data = DisputeBooking::create([
                    'job_applicant_id' => $request->job_applicant_id,
                    'dispute_title_id' => $request->dispute_title_id,
                    'disputed_to' => $request->disputed_to,
                    'disputed_by' => $user->id,
                    'concern' => $request->concern,
                ]);

                $job_applicant = JobApplicant::find($request->job_applicant_id);
                $job_applicant->update(['host_status' => 2, 'staff_status' => 2, 'current_status'=>'disputed']);
                $job_applicant->makeTransaction();
                return response()->json(['success'=>true, 'data'=>$data]);
            }
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function getDisputes()
    {
        $disputes = DisputeBooking::with([
            'disputer:id,name,display_pic,email,phone',
            'disputed:id,name,display_pic,email,phone',
            'dispute_title:id,title',
            'job_applicant:id,job_id',
            'job_applicant.job:id,job_title,start_time,end_time,no_of_positions,occupied_positions,pay_type,location,description',
            'job_applicant.job.user:id,name',
        ])->where('status', 'open')->get([
            'id', 'concern', 'dispute_title_id', 'disputed_to', 'disputed_by', 'job_applicant_id', 'status', 'created_at',
        ]);

        return $this->sendResponse($disputes);
    }

    public function resolveDispute(Request $request)
    {
        $data = $request->all();

        $dispute = DisputeBooking::find($data['id']);
        $dispute->update(['status' => $data['status']]);

        return $this->sendResponse([], 'Dispute Resolved Successfully');
    }
}
