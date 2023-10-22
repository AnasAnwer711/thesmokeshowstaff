<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Violation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user_message()
    {
        return $this->belongsTo(UserMessage::class, 'user_message_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function createViolation($job_id, $user_id, $user_message_id, $chat_thread_id , $matched_string)
    {
        $v = Self::create([
            'job_id' => $job_id,
            'user_id' => $user_id,
            'user_message_id' => $user_message_id,
            'chat_thread_id' => $chat_thread_id,
            'matched_string' => $matched_string
        ]);
        return $v;
    }
    
}
