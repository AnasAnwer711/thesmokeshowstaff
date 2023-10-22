<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'initiated_by', 'participant_id', 'last_message_at'
    ];

    public function job() {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function sender() {
        return $this->hasOne(User::class, 'id', 'initiated_by');
    }

    public function receiver() {
        return $this->hasOne(User::class, 'id', 'participant_id');
    }

    public function messages() {
        return $this->hasMany(UserMessage::class, 'chat_id', 'id');
    }
}
