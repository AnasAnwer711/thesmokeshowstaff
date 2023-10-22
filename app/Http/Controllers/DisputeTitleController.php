<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisputeTitleRequest;
use App\Models\DisputeTitle;
use App\Models\User;
use Illuminate\Http\Request;

class DisputeTitleController extends Controller
{
    public function index()
    {
        try {
            //code...
            $user = User::find(auth()->user()->id);
            if($user){
                if($user->hasRole('staff'))
                    $data = DisputeTitle::where('user_type', 'staff')->get();
                else if ($user->hasRole('host'))
                    $data =DisputeTitle::where('user_type', 'host')->get();
                else 
                    return response()->json(['message'=> 'Unauthorized role to access dispute titles'], 422);
    
                return response()->json(['success'=>true, 'data'=>$data]);
            }
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }
}
