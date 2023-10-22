<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\SaveProfileRequest;
use App\Http\Resources\SkillPhotosResource;
use App\Http\Traits\Notify;
use App\Libs\Common;
use App\Models\Address;
use App\Models\BasicSetting;
use App\Models\DeviceToken;
use App\Models\PaymentConfiguration;
use App\Models\StaffCategory;
use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Image;

class UserController extends Controller
{
    use Notify;
    
    public function index()
    {
        $auth = Auth::user();
        if(!$auth)
            return view('content.auth.login');
        else {
            $phone_code = $auth->phone_code ?? 'ca';
            if($auth->hasRole('host') || $auth->hasRole('admin') || $auth->hasRole('super-admin')) {
                return view('content.profile.host', compact('phone_code'));
            }
                
            else if($auth->hasRole('staff'))
                return view('content.profile.staff', compact('phone_code'));

            // else if($auth->hasRole('admin') || $auth->hasRole('super-admin'))
            //     return view('content.profile.admin', compact('phone_code'));
            else
                return view('content.auth.login');

        }
    }

    public function viewProfile (User $user) {
        $phone_code = $user->phone_code ?? 'ca';
        if ($user->hasRole('host'))
            return view('content.profile.host', compact('user', 'phone_code'));
        else if ($user->hasRole('staff'))
            return view('content.profile.staff', compact('user', 'phone_code'));
    }

    public function show(User $user) {
        // $parts = explode('/', request()->headers->get('referer'));

        // if (in_array("admin", $parts) && Common::hasAdminRights()) {
        //     $id = $parts[count($parts) - 1];
        //     $user = User::where('id', $id)->with(['nationality', 'address.state', 'cards', 'jobs'])->first();
        // } else {
        //     $user = User::where('id', Auth::user()->id)->with(['nationality', 'address.state', 'cards', 'jobs'])->first();
        // }
        $user->load(['nationality', 'languages.language', 'address.state', 'cards', 'jobs', 'skill_photos', 'skill_photos.skills']);

        if(!$user)
            return response()->json(['message'=>'User not logged in'], 422);
        else {
            if($user->hasRole('host')){
                $user['is_host'] = true;
                $user['is_staff'] = false;
            } else {
                $user['is_staff'] = true;
                $user['is_host'] = false;
            }
            $payment_configuration = PaymentConfiguration::first();
            // $host_transaction_fee = 0;
            // if($payment_configuration)
                // $host_transaction_fee = $payment_configuration->host_transaction_fee ?? 0;

            $gender = $user->gender;
            $user_skills = StaffCategory::whereNull('category_id')->with('sub_categories')->where(function($q) use ($gender){
                $q->where('gender',$gender)->orWhereNull('gender');
            })->get();
            
            return response()->json(['success'=>true, 'data'=>$user, 'user_skills' => $user_skills, 'skill_photos' => $user->skillsAndPhotos()])->setEncodingOptions(JSON_NUMERIC_CHECK);
            // return response()->json(['success'=>true, 'data'=>$user, 'host_transaction_fee' => $host_transaction_fee]);
        }
    }

    public function get_profile()
    {
        $user = User::where('id', Auth::user()->id)->with(['nationality', 'languages.language', 'address.state', 'cards', 'jobs', 'active_jobs', 'skill_photos', 'skill_photos.skills'])->first();
        if(Auth::user()){
            if(!$user)
                return response()->json(['message'=>'User not logged in'], 422);
            else {
                if($user->hasRole('host')){
                    $user['is_host'] = true;
                    $user['is_staff'] = false;
                } else {
                    $user['is_staff'] = true;
                    $user['is_host'] = false;
                }

                $gender = $user->gender;
                $user_skills = StaffCategory::whereNull('category_id')->with('sub_categories')->where(function($q) use ($gender){
                    $q->where('gender',$gender)->orWhereNull('gender');
                })->get();
                return response()->json(['success'=>true, 'data'=>$user, 'user_skills' => $user_skills, 'skill_photos' => $user->skillsAndPhotos()])->setEncodingOptions(JSON_NUMERIC_CHECK);
            }
        } else {
            return response()->json(['message'=>'User not logged in'], 422);
        }
    }

    public function save_profile(SaveProfileRequest $request)
    {
        // dd($request->all());
        try {
            if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')) {
                $user = User::find($request->id);
            } else {
                $user = auth()->user();
            }

            DB::beginTransaction();

            // delete previous language
            UserLanguage::where('user_id', $user->id)->delete();
            if(count($request->language_ids)){

                foreach ($request->language_ids as $key => $value) {
                    UserLanguage::create([
                        'user_id' => $user->id,
                        'language_id' => $value
                    ]);
                }
            }


            $pc = PaymentConfiguration::first();
            if($pc){
                if($pc->secret_key)
                    $user->addStripeCustomer();
            }

            $address_id = null;
            if($user->address)
                $address_id = $user->address->id;
            // dd($request->all());
            if($request['address'] != null && count($request['address'])){
                $address = Address::updateOrCreate(
                    ['id' => $address_id],
                    [
                        'country_id' => 1,
                        'address_line1' => $request['address']['suburb'] ?? 'Not Provided',
                        'suburb' => $request['address']['suburb'],
                        'postal_code' => $request['address']['postal_code'],
                        'state_id' => $request['address']['state_id'],
                        'longitude' => 24.8607,
                        'latitude' => 67.0011,
                    ]
                );

                $address_id = $address->id;
            }

            $old_is_profile_details = $user->is_profile_details;
            $phone_sms = isset($request->phone_sms) ? strval($request->phone_sms) : null;
            if($phone_sms[0] != '+')
                $phone_sms = '+'.$phone_sms; 
            $data = User::where('id', $user->id)->update([
                'name' => $request->first_name .' '.$request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_code' => isset($request->phone_code) ? $request->phone_code : null,
                'phone_sms' => $phone_sms,
                'phone' => $request->phone,
                'email' => $request->email,
                'address_id' => $address_id,
                'display_name' => isset($request->display_name) ? $request->display_name : null,
                'build_type_id' => isset($request->build_type_id) ? $request->build_type_id : null,
                'gender' => isset($request->gender) ? $request->gender : null,
                'dob' => isset($request->dob) ? $request->dob : null,
                'english_level' => isset($request->english_level) ? $request->english_level : null,
                'youtube' => isset($request->youtube) ? $request->youtube : null,
                'rsa_qualified' => isset($request->rsa_qualified) ? $request->rsa_qualified : null,
                'rcg_qualified' => isset($request->rcg_qualified) ? $request->rcg_qualified : null,
                'security_qualified' => isset($request->security_qualified) ? $request->security_qualified : null,
                'silver_service_qualified' => isset($request->silver_service_qualified) ? $request->silver_service_qualified : null,
                'resume' => isset($request->resume) ? $request->resume : null,
                'is_profile_details' => 1,
            ]);
            $eData['user_data'] = $user;
            if(!$old_is_profile_details && $user->hasRole('staff'))
                $this->notify('review_profile', $eData);
            
            DB::commit();

            return response()->json(['success'=>true, 'data'=>$data]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);
        }
        
    }

    public function update_profile_picture(Request $request)
    {
        $data = $request->all();

        $auth = Auth::user();

        if($auth){
            try {
                // $png_url = "profile-pic-".time().".png";
                // $path = public_path().'/images/profile/' . $png_url;
                // $display_url = url('/images/profile/'.$png_url);
                // User::where('id', $auth->id)->update(['display_pic' => $display_url]);
                // $user = User::where('id', Auth::user()->id)->with(['nationality', 'address'])->first();
                // Image::make(file_get_contents($request->image))->save($path);
                
                $response = $auth->addPhoto($data);

                return Response::json($response);
            } catch (\Throwable $th) {
                return response()->json(['message'=>$th->getMessage()], 422);
            }
        } else {
            return response()->json(['message'=>'User not logged in'], 422);
        }
    } 

    public function update_host_picture(Request $request)
    {
        $auth = Auth::user();

        if($auth){
            try {

                $png_url = "profile-pic-".time().".png";
                $path = public_path().'/images/profile/' . $png_url;
                $display_url = url('/images/profile/'.$png_url);
                User::where('id', $auth->id)->update(['display_pic' => $display_url]);
                $user = User::where('id', Auth::user()->id)->with(['nationality', 'address'])->first();
                Image::make(file_get_contents($request->image))->save($path);


                return Response::json($user);


            } catch (\Throwable $th) {
                return response()->json(['message'=>$th->getMessage()], 422);
            }
        } else {
            return response()->json(['message'=>'User not logged in'], 422);
        }
    }

    public function change_password(ChangePasswordRequest $request)
    {
        try {
            $data = User::where('id', Auth::user()->id)->update([
                'password' => bcrypt($request->password),
            ]);
            return response()->json(['success'=>true, 'data'=>$data]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function addToken(Request $request) {
        $token = $request->token;

        if (DeviceToken::where('user_id', Auth::user()->id)->where('fcm_token', $token)->count() == 0) {
            DeviceToken::create([
                'user_id' => Auth::user()->id,
                'fcm_token' => $token,
            ]);
        }

        return response()->json(['success'=>true]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home', ['logout' => true]);
    }

    public function staffRequests() {
        $staff_requests = User::whereHas('roles', function ($q) {
            $q->where('name', 'staff');
        })->where('status', 'pending')->get();

        return response()->json(['success'=>true, 'data'=>$staff_requests]);
    }

    public function changeStatus(Request $request) {
        $data = $request->all();
        try {
        
            DB::beginTransaction();
            User::where('id', $data['id'])->update(['status' => $data['status']]);

            $eData['user_data'] = User::find($data['id']);
            $eData['source_data'] = User::role('admin')->first();
            if($data['status'] == 'approved')
                $this->notify('profile_published', $eData);

            DB::commit();

            return response()->json(['success'=>true, 'message' => 'Status changed successfully']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);

            //throw $th;
        }
    }

    public function saveSkillPhoto(Request $request) {
        $user = auth()->user();
        $data = $request->all();

        if (isset($data['user_id']) && auth()->user()->hasRole('admin')) {
            $user = User::find($data['user_id']);
        }

        if ($request->hasFile('cropped_image')) {
            $file = $request->file('cropped_image');
            $name = $user->id . '-' . $data['order_no'] . '.' . 'png';
            $request->file('cropped_image')->storeAs('/skill-photos', $name, 'public');
            $data['picture'] = '/skill-photos/' . $name;
        }

        $user->addCroppedPhoto($data);

        return $this->sendResponse($user->skillsAndPhotos(), 'Photo saved successfully');
    }

    public function deleteSkillPhoto(Request $request)
    {
        $user = auth()->user();

        $data = $request->all();

        if (isset($data['user_id']) && auth()->user()->hasRole('admin')) {
            $user = User::find($data['user_id']);
        }

        $user->deleteSkillPhoto($data['order_no']);

        return $this->sendResponse([], 'Photo deleted successfully');
    }

    public function setDefaultSkillPhoto(Request $request)
    {
        $user = auth()->user();

        $data = $request->all();

        if (isset($data['user_id']) && auth()->user()->hasRole('admin')) {
            $user = User::find($data['user_id']);
        }

        $user->setDefaultSkillPhoto($request->photo_id, $request->skill_id);

        return $this->sendResponse([], 'Photo set as default successfully');
    }


    public function getUsers(Request $request) {
        $data = $request->all();

        $qry = User::query();
        
        $role = $data['role'] ?? 'both';

        if($role == 'staff' || $role == 'host'){
            $qry->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        } else {
            $qry->whereHas('roles', function ($q) use ($role) {
                $q->where('name', 'staff')->orWhere('name', 'host');
            });
        }

        if(isset($data['status'])){
            $qry->where('status', $data['status']);
        }

        $users_for_admins = $qry->get();


        return response()->json(['success'=>true, 'data'=>$users_for_admins]);
    }
}