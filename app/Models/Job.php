<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    protected $guarded = [];
    use HasFactory, SoftDeletes;

    protected $appends = ['is_applied', 'is_invited', 'is_shortlisted', 'is_reviewed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    
    public function staff_category()
    {
        return $this->belongsTo(StaffCategory::class);
    }

    public function applicants()
    {
        return $this->hasMany(JobApplicant::class);
    }
    
    public function booked_applicants()
    {
        return $this->hasMany(JobApplicant::class)->where('current_status', 'booked');
    }
    
    public function unbooked_applicants()
    {
        return $this->hasMany(JobApplicant::class)->where('current_status', '!=' , 'booked');
    }
    
    public function booked()
    {
        return $this->hasMany(JobApplicant::class)
        ->where(function($q) {
            $q->where('current_status', 'booked')
            ->orWhere('current_status', 'unbooked')
            ->orWhere('current_status', 'completed')
            ->orWhere('current_status', 'disputed');
        });
    }

    public function not_booked()
    {
        return $this->hasMany(JobApplicant::class)
        ->where(function($q) {
            $q->where('current_status', '!=', 'booked')
            ->where('current_status', '!=', 'unbooked')
            ->where('current_status', '!=', 'completed')
            ->where('current_status', '!=', 'disputed');
        });
        // return $this->hasMany(JobApplicant::class)->where('source', 'received')->where('current_status', '!=', 'booked');
    }
    
    public function applications()
    {
        return $this->hasMany(JobApplicant::class)->where('source', 'received')
        ->whereHas('job', function($q){
            $q->where('job_status', 'open');
        })
        ->where(function($q) {
            $q->where('current_status', '!=', 'booked')->where('current_status', '!=', 'unbooked');
        });
        // return $this->hasMany(JobApplicant::class)->where('source', 'received')->where('current_status', '!=', 'booked');
    }
    
    public function invitations()
    {
        return $this->hasMany(JobApplicant::class)->where('source', 'invited')
        ->whereHas('job', function($q){
            $q->where('job_status', 'open');
        })
        ->where(function($q) {
            $q->where('current_status', '!=', 'booked')->where('current_status', '!=', 'unbooked');
        });
        // return $this->hasMany(JobApplicant::class)->where('source', 'invited')->where('current_status', '!=', 'booked');
    }

    public function applicant_users()
    {
        return $this->belongsToMany(User::class, 'job_applicants', 'job_id', 'staff_id')->withPivot('current_status');
    }

    public function getIsAppliedAttribute()
    {
        if(auth()->user() && JobApplicant::where('source', 'received')->where('job_id', $this->id)->where('staff_id', auth()->user()->id)->exists()){
            return true;
        } else 
            return false;
        
    }
    
    public function getIsInvitedAttribute()
    {
        if(auth()->user() && JobApplicant::where('source', 'invited')->where('job_id', $this->id)->where('staff_id', auth()->user()->id)->exists()){
            return true;
        } else 
            return false;
        
    }
    
    public function getIsShortlistedAttribute()
    {
        if(auth()->user() && UserShortlist::where('type', 'job')->where('target_id', $this->id)->where('user_id', auth()->user()->id)->exists()){
            return true;
        } else 
            return false;
        
    }
    
    public function getIsReviewedAttribute()
    {
        if(auth()->user() && UserReview::where('job_id', $this->id)->where('source_id', auth()->user()->id)->exists()){
            return true;
        } else 
            return false;
    }

    public static function createMessage($job_id, $staff_id) {
        $job = Job::find($job_id);

        if (!JobApplicant::where([
            ['job_id', $job_id],
            ['staff_id', $staff_id],
        ])->exists()) {
            JobApplicant::create([
                'job_id' => $job_id,
                'staff_id' => $staff_id,
                'code' => 'PS-3-message',
                'source' => 'received',
                'current_status' => 'contacted',
                'job_actual_hours' => $job->duration,
                'job_pay_type' => $job->pay_type,
                'job_pay_rate' => $job->pay_rate,
                'job_pay' => $job->pay_rate * $job->duration,
            ]);
        }
    }

    public function changeJobStatus($status)
    {
        $this->update(['job_status' => $status]);
        if($status == 'closed')
            JobApplicant::where('job_id', $this->id)->update(['current_status'=>'completed', 'host_status'=>1, 'staff_status'=>1]);
        return true;
    }

}
