<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'fav_icon',
        'cover_video',
        'cover_text',
        'sender_name',
        'sender_email',
    ];
}
