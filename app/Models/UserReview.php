<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function source()
    {
        return $this->belongsTo(User::class, 'source_id');
    }
    
    public function target()
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

}
