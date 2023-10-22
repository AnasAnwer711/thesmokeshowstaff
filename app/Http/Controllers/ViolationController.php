<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViolationRequest;
use App\Models\User;
use App\Models\UserCard;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViolationController extends Controller
{
    public function getViolates()
    {
        $violates = Violation::select('*', DB::raw('count(*) as violates_count'))->with('user_message.chat.job', 'user')->groupBy('job_id')->get();
        return $this->sendResponse($violates);
    }

    public function updateViolation(ViolationRequest $request)
    {
        $violation = Violation::where('user_message_id', $request->user_message_id)->first();
        $user = User::find($violation->user_id);
        if(isset($request->is_penalized) && $request->is_penalized == '1' && $request->penalized_amount > 0) {
            $card = UserCard::where('user_id', $user->id)->first();
            if($card){
                $card->makeCardAndCharge($request->penalized_amount, 'Penalized Charge in Violation');
            }
        }
        if(isset($request->is_blocked) && $request->is_blocked == 1) {
            $user->status = 'blocked';
            $user->save();
        }
        Violation::where('user_message_id', $request->user_message_id)->update(
            [
                'is_penalized' => isset($request->is_penalized) ? $request->is_penalized : 0,
                'penalized_amount' => isset($request->is_penalized) ? $request->penalized_amount : 0,
                'is_blocked' => isset($request->is_blocked) ? $request->is_blocked : 0,
                'notes' => isset($request->notes) ? $request->notes : 0,
            ]
        );
        return $this->sendResponse([], 'Violation updated successfully');
    }
}
