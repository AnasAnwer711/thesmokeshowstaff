<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    public function scopeActive($query, $value)
    {
        return $query->where('status', $value);
    }
}
