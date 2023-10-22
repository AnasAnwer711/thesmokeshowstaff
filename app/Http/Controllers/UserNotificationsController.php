<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
    //
    public function seeAllNotifications()
    {
        return view('content.notifications.index');
    }

    public function getAllNotifications(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $id = auth()->id();
        $qry = UserNotification::where('user_id', $id)->with(['user', 'source'])->orderBy('id', 'DESC');
        $totalRecords = $qry->count();
        $no_of_limit = 5;

        if (isset($data['page'])) {
            $skip = $data['page'] * $no_of_limit - $no_of_limit;
            $qry = $qry->skip($skip)->take($no_of_limit);
        } else {
            $qry = $qry->take($no_of_limit);
        }
        
        $data = $qry->get();
        $lastPage = ceil($totalRecords/$no_of_limit);
        $filterRecords = count($data);

        return response()->json(['success'=>true,'totalRecords'=>$totalRecords, 'lastPage'=>$lastPage, 'filterRecords' => $filterRecords, 'data'=>$data]);

        // return $this->sendResponse($data, '');
    }

    public function destroy($id)
    {
        try {
            $user_notification = UserNotification::find($id);
            $user_notification->delete();
            return response()->json(['success'=>true]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }
    
    public function delete_all_notifications()
    {
        try {
            $user_notification = UserNotification::where('user_id', auth()->user()->id);
            $user_notification->delete();
            return response()->json(['success'=>true]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }
}