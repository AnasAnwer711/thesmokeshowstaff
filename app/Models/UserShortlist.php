<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShortlist extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function target()
    {
        if($this->type == 'job'){
            $job = $this->belongsTo(Job::class);
            return $job;
        } else if ($this->type == 'staff'){
            $user = $this->belongsTo(User::class)->with('address.state', 'nationality');
            // dd($user);
            return $user;
        }
    }
}
