<?php

namespace App\Models;

use App\Http\Traits\StripePayment;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, StripePayment;

    protected $appends = ['average_rating', 'is_shortlisted', 'is_admin'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIsShortlistedAttribute()
    {
        if(auth()->user() && UserShortlist::where('type', 'staff')->where('target_id', $this->id)->where('user_id', auth()->user()->id)->exists()){
            return true;
        } else 
            return false;
        
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }
   
    public function languages()
    {
        return $this->hasMany(UserLanguage::class);
    }
    
    public function build_type()
    {
        return $this->belongsTo(BuildType::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    
    public function shortlists()
    {
        return $this->hasMany(UserShortlist::class);
    }
    
    public function skills()
    {
        return $this->hasMany(UserSkill::class);
    }
    
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
    
    public function active_subscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active');
    }
    
    public function cards()
    {
        return $this->hasMany(UserCard::class);
    }
    
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    
    public function active_jobs()
    {
        return $this->hasMany(Job::class)->where(function($query){
            $query->where('job_status', 'open')->orWhere('job_status', 'occupied');
        });
    }

    public function devices() {
        return $this->hasMany(DeviceToken::class);
    }

    public function skill_photos() {
        return $this->hasMany(UserSkillPhoto::class);
    }
    
    public function uploaded_skill_photos() {
        return $this->hasMany(UserSkillPhoto::class)->where('is_uploaded',1);
    }

    public function user_skills() {
        return $this->hasMany(SkillPhotoMapping::class, 'user_id', 'id');
    }

    public function addStripeCustomer()
    {
        if (!$this->stripe_customer_id) {
            $customer = $this->createStripeCustomer($this->name);
            $this->stripe_customer_id = $customer->id;
            $this->save();
            return true;
        } else {
            return false;
        }
    }

    public function addCardDetail($data) {
        // $token = $this->createStripeToken($data['card']);

        // check user has stripe_customer_id or not
        try {
            $this->addStripeCustomer();
            $card = $this->createStripeCard($this->stripe_customer_id, ['card' => $data['card']]);
            if($card['success']){

                $data['user'] = [
                    'user_id' => $this->id,
                    'stripe_card_id' => $card['card']['id'],
                    'name' => $card['card']['name'],
                    'brand' => $card['card']['brand'],
                    'last4' => $card['card']['last4'],
                ];
    
                UserCard::create($data['user']); 
    
                return ['success'=>true,'card_id'=>$card['card']['id']];
            } else 
                return ['success'=>false,'message'=>$card['message']];

        } catch (\Throwable $th) {
            return ['success'=>false,'message'=>$th];
            //throw $th;
        }
    }

    public function hasAdminRights() {
        return $this->hasRole('admin') || $this->hasRole('super-admin');
    }

    public function reviews()
    {
        return $this->hasMany(UserReview::class, 'source_id');
    }

    public function getAverageRatingAttribute()
    {
        return ceil($this->reviews()->avg('rating'));
    }

    public function addSkillPhoto($url, $orderNo) {
        if ($this->skill_photos()->count() == 0) {
            for ($i = 1; $i <= 10; $i++) {
                $this->skill_photos()->create([
                    'user_id' => $this->id,
                    'picture' => '/images/Logo_SmokeShowStaff.png',
                    'org_picture' => '/images/Logo_SmokeShowStaff.png',
                    'order_no' => $i,
                    'is_uploaded' => 0,
                    'is_default' => 0
                ]);
            }
        }
        $photo = $this->skill_photos()->where('order_no', $orderNo)->first();

        $photo->picture = $url;
        $photo->org_picture = $url;
        $photo->user_id = $this->id;
        $photo->order_no = $orderNo;
        $photo->is_default = $orderNo == 1 ? 1 : 0;
        $photo->is_uploaded = 1;
        $photo->save();
    }

    public function addPhoto($data) {
        $png_url = $this->id . '-' . $data['orderNo'] .".png";
        $path = public_path().'/images/profile/' . $png_url;

        $display_url = url('/images/profile/'.$png_url);

        if ($data['orderNo'] == 1) {
            $this->display_pic = $display_url;
            $this->save();
        }

        $this->addSkillPhoto($display_url, $data['orderNo']);

        $user = $this->with(['nationality', 'address'])->first();

        \Image::make(file_get_contents($data['image']))->save($path);

        return ['success' => true, 'data' => $user];
    }

    public function addCroppedPhoto($data) {
        $photo = $this->skill_photos()->where('order_no', $data['order_no'])->first();

        $photo->picture = $data['picture'];
        $photo->cropper_data = $data['cropper_data'];

        $photo->save();

        SkillPhotoMapping::where('user_skill_photo_id', $photo->id)->delete();

        foreach (explode(',', $data['skill_ids']) as $skill_id) {
            // add default skill photo
            $has_default = SkillPhotoMapping::where([
                'user_id' => $this->id,
                'skill_id' => $skill_id,
            ])->count();

            SkillPhotoMapping::create([
                'user_skill_photo_id' => $photo->id,
                'skill_id' => $skill_id,
                'user_id' => $this->id,
                'is_default_skill_photo' => $has_default == 0  ? 1 : 0
            ]);
        }
    }

    public function skillsAndPhotos() {
        $skills = $this->user_skills()->distinct('skill_id')->get();

        return $skills->map(function ($skill) {
            return [$skill->skill_id => $skill->skill_photos()->toArray()];
        })->toArray();
    }

    public function deleteSkillPhoto($order_no) {
        $photo = $this->skill_photos()->where('order_no', $order_no)->first();

        $photo->picture = '/images/Logo_SmokeShowStaff.png';
        $photo->org_picture = '/images/Logo_SmokeShowStaff.png';
        $photo->is_default = 0;
        $photo->is_uploaded = 0;
        $photo->cropper_data = null;
        $photo->save();

        SkillPhotoMapping::where('user_skill_photo_id', $photo->id)->delete();
    }

    public function setDefaultSkillPhoto($photo_id, $skill_id) {
        SkillPhotoMapping::where([
            'skill_id' => $skill_id,
            'user_id' => $this->id,
        ])->update([
            'is_default_skill_photo' => 0
        ]);

        SkillPhotoMapping::where([
            'user_skill_photo_id' => $photo_id,
            'skill_id' => $skill_id,
        ])->update([
            'is_default_skill_photo' => 1
        ]);
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole('admin');
    }
}