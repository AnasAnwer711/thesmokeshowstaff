<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sub_categories()
    {
        return $this->belongsTo(StaffCategory::class, 'skill_id');
    }
}
