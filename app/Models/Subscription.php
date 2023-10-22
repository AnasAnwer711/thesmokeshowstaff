<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['calculated_limit'];

    public function subscription_plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function getCalculatedLimitAttribute()
    {
        return number_format((($this->utilized_limit/$this->total_limit)*100),2);
    }

}
