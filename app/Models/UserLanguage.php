<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
