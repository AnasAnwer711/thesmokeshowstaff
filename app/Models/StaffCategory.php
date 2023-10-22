<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffCategory extends Model
{
    use HasFactory;

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['is_selected'];

    public function scopeActive($query, $value)
    {
        return $query->where('is_active', $value);
    }

    public function sub_categories()
    {
        return $this->hasMany(StaffCategory::class, 'category_id')->active(true);
    }

    public function getIsSelectedAttribute()
    {
        $auth = auth()->user();
        if($auth){

            if(UserSkill::where('user_id', $auth->id)->where('skill_id', $this->id)->exists())
                return true;
            else
                return false;
        } else
            return false;

    }

    public function category() {
        return $this->hasOne(StaffCategory::class, 'id', 'category_id');
    }

    public function helpful_key() {
        return $this->belongsTo(HelpfulKey::class);
    }
}
