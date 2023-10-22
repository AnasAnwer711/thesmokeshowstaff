<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'source_id',
        'message',
        'is_seen',
    ];

    public function chat() {
        return $this->belongsTo(ChatThread::class, 'chat_id', 'id');
    }

    public function source()
    {
        return $this->belongsTo(User::class, 'source_id', 'id');
    }
}
