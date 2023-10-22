<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillPhotoMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_id',
        'user_skill_photo_id',
        'user_id',
        'is_default_skill_photo'
    ];

    public function skill_photos() {
        return SkillPhotoMapping::with(['photo:id,picture,org_picture'])->where('skill_id', $this->skill_id)->where('user_id', $this->user_id)->get(['user_skill_photo_id', 'is_default_skill_photo']);
        // return UserSkillPhoto::whereIn('id', $photos)->get(['picture', 'org_picture']);
    }

    public function photo () {
        return $this->belongsTo(UserSkillPhoto::class, 'user_skill_photo_id', 'id');
    }
}
