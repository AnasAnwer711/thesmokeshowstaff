<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Violation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        return view('content.admin.dashboard');
    }

    public function staffRequests() {
        return view('content.admin.staff-requests');
    }
    
    public function users() {
        return view('content.admin.users');
    }

    public function defaultSettings() {
        return view('content.admin.default-settings');
    }

    public function jobs() {
        return view('content.admin.jobs');
    }

    public function staffCategories()
    {
        return view('content.admin.staff-categories');
    }

    public function subscriptionPlans()
    {
        return view('content.admin.subscription-plans');
    }

    public function helpfulKeys() {
        return view('content.admin.helpful-keys');
    }

    public function disputes() {
        return view('content.admin.disputes');
    }
    
    public function violates() {
        return view('content.admin.violates');
    }
    
    public function violate_detail($violate_id) {
        $violate = Violation::where('id',$violate_id)->first();
        return view('content.admin.violate-detail', ['violate' => $violate]);
    }

    public function jobChats(Job $job) {
        return view('content.messages.index', ['job_id' => $job->id]);
    }
}
