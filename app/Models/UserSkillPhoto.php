<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkillPhoto extends Model
{
    use HasFactory;

    protected $guarded = [
        'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->hasMany(SkillPhotoMapping::class, 'user_skill_photo_id', 'id');
    }
}
