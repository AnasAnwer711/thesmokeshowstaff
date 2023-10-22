<?php

namespace App\Http\Controllers;

use App\Http\Traits\Notify;
use App\Models\StaffCategory;
use App\Models\User;
use App\Models\UserSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSkillController extends Controller
{
    use Notify;
    
    public function index()
    {
        $auth = auth()->user();
        if($auth){
            $gender = $auth->gender;
            $data = StaffCategory::whereNull('category_id')->with('sub_categories')->where(function($q) use ($gender){
                $q->where('gender',$gender)->orWhereNull('gender');
            })->get();
            return response()->json(['success' => true, 'data' => $data, 'skill_photos' => $auth->skillsAndPhotos()]);
        }

    }

    public function all_skills()
    {
        $auth = auth()->user();
        if($auth){
            $data = StaffCategory::whereNull('category_id')->with('sub_categories')->get();
            return response()->json(['success' => true, 'data' => $data]);
        }

    }

    public function my_skills()
    {
        $auth = auth()->user();
        $data = UserSkill::where('user_id', $auth->id)->get();
        return response()->json(['success' => true, 'data' => $data]);

    }

    public function his_skills(User $user)
    {
        $data = UserSkill::where('user_id', $user->id)->get();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            $user = User::find($request->id);
        } else {
            $user = auth()->user();
        }
        try {
            //code...
            DB::beginTransaction();
            $experiences = $request->experiences;
            $work_details = $request->work_details;
            // validate first
            foreach ($request->skill_ids as $key => $value) {
                // dd($request->skill_ids, $key, $value);
                if($value){
                    if (!array_key_exists($key,$experiences)){
                        return response()->json(['message'=> 'Experience is required'], 422);
                    }
                    if (!array_key_exists($key,$work_details)){
                        return response()->json(['message'=> 'Work Detail is required'], 422);
                    }
                } 
            
            }

            foreach ($request->skill_ids as $key => $value) {
                // dd($request->skill_ids, $key, $value);
                if($value){
                    UserSkill::updateOrCreate(
                        ['skill_id'=> $key, 'user_id'=> $user->id],
                        ['experience'=> $experiences[$key], 'work_detail'=> $work_details[$key], 'status'=>'pending']
                    );
                } else {
                    $qry = UserSkill::where('user_id', $user->id)->where('skill_id', $key);
                    if($qry->exists()){
                        $qry->delete(); 
                    }
                }
            
            }
            $user = User::find($user->id);
            if(!$user->is_skill_details){
                $eData['user_data'] = $user;
                $this->notify('complete_your_profile', $eData);
            }
            User::where('id', $user->id)->update(['is_skill_details' => 1]);

            $user_skills = UserSkill::where('user_id',$user->id)->with('sub_categories')->get();
            DB::commit();
            return response()->json(['success'=>true, 'data'=>$user_skills]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }
   
}