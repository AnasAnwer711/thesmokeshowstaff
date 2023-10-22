<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisputeBooking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function disputer () {
        return $this->belongsTo(User::class, 'disputed_by');
    }
    
    public function disputed () {
        return $this->belongsTo(User::class, 'disputed_to');
    }

    public function job_applicant () {
        return $this->belongsTo(JobApplicant::class, 'job_applicant_id');
    }

    public function dispute_title () {
        return $this->belongsTo(DisputeTitle::class, 'dispute_title_id');
    }
}
