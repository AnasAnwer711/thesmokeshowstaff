<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FindStaffController extends Controller
{
    public function find_staff()
    {
        return view('content.find-staff.staffs');
    }
    public function staff_detail($id)
    {
        return view('content.find-staff.detail', compact('id'));
    }

    public function get_staff_detail($id)
    {
        // dd($id);
        $detail = User::where('id',$id)->with(['uploaded_skill_photos', 'nationality', 'address.state', 'cards','skills.sub_categories.helpful_key', 'build_type', 'languages.language'])->first();
        return response()->json(['success'=>true,'data'=>$detail]);
    }
    
    public function get_staff(Request $request)
    {
        // dd($request->all());
        // $staff = User::role('employee')->get();
        $data = $request->all();
        $auth_user = auth()->user() ? auth()->user()->id : null;
        $qry = User::where('id', '!=', $auth_user)->whereHas('roles', function ($q) {
            $q->where('name', 'staff');
        })->where('status', 'approved')->with('address.state');

        if(isset($data['skillvalues'])){
            // $skillvalues = $data['skillvalues']
            $skillvalues = explode (",", $data['skillvalues']); 
            // dd($skillvalues);
            $qry->whereHas('skills', function($q) use ($skillvalues){
                $q->whereIn('skill_id', $skillvalues);
            });
        } 
        
        if(isset($data['state_id'])){
            $state_id = $data['state_id']; 
            // dd($state_id);
            $qry->whereHas('address', function($q) use ($state_id){
                $q->where('state_id', $state_id);
            });
        } 
        if(isset($data['name'])){

            $qry->where('name', 'like', "%" . $data['name'] . "%");
        } 
        if(isset($data['gender'])){

            $qry->where('gender', $data['gender']);
        } 

        if(isset($data['age'])){
            $min_date = null;
            $max_date = null;
            switch ($data['age']) {
                case '18-30':
                    # code...
                    $min_date = date('Y-m-d', strtotime('-18 years'));
                    $max_date = date('Y-m-d', strtotime('-30 years'));
                    break;
                case '31-40':
                    $min_date = date('Y-m-d', strtotime('-31 years'));
                    $max_date = date('Y-m-d', strtotime('-40 years'));
                    break;
                case '41-50':
                    $min_date = date('Y-m-d', strtotime('-41 years'));
                    $max_date = date('Y-m-d', strtotime('-50 years'));
                    break;
                case '51-60':
                    $min_date = date('Y-m-d', strtotime('-51 years'));
                    $max_date = date('Y-m-d', strtotime('-60 years'));
                    break;
                case '61-70':
                    $min_date = date('Y-m-d', strtotime('-61 years'));
                    $max_date = date('Y-m-d', strtotime('-70 years'));
                    break;
                case 'Above 70':
                    $min_date = date('Y-m-d', strtotime('-71 years'));
                    $max_date = date('Y-m-d', strtotime('-150 years'));
                    break;
                
                default:
                    $min_date = null;
                    $max_date = null;
                    break;
            }

            // dd($min_date, $max_date);
            if($min_date){
                $qry->whereBetween('dob', [$max_date,$min_date]);
                // dd($user_age);
            }

        } 


        // dd($data['qualification']);
        if(isset($data['qualification'])){

            $q = null;
            switch ($data['qualification']) {
                case 'RSA':
                    # code...
                    $q = 'rsa_qualified';
                    break;
                case 'RCG':
                    $q = 'rcg_qualified';
                    # code...
                    break;
                case 'Security':
                    $q = 'security_qualified';
                    # code...
                    break;
                case 'Silver Service':
                    $q = 'silver_service_qualified';
                    # code...
                    break;
                
                default:
                    $q = null;
                    # code...
                    break;
            }
            if($q)
                $qry->where($q, 1);
        } 
        if(isset($data['build_type_id'])){

            $qry->where('build_type_id', $data['build_type_id']);
        } 
        $totalRecords = $qry->count();
        $no_of_limit = 12;

        if (isset($data['page'])) {
            $skip = $data['page'] * $no_of_limit - $no_of_limit;
            $staff = $qry->skip($skip)->take($no_of_limit);
        } else {
            $staff = $qry->take($no_of_limit);
        }
        // dd($staff->count());
        $data = $staff->get();
        $lastPage = ceil($totalRecords/$no_of_limit);
        $filterRecords = count($data);
        return response()->json(['success'=>true,'totalRecords'=>$totalRecords, 'lastPage'=>$lastPage, 'filterRecords' => $filterRecords, 'payload'=>$data]);
    }
}