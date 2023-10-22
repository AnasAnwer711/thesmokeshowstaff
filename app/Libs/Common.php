<?php

namespace App\Libs;

use Illuminate\Support\Facades\Auth;

class Common {
    public static function hasAdminRights($user = null) {
        if ($user) {
            return $user->hasRole('admin') || $user->hasRole('super-admin');
        } else {
            return Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin');
        }
    }
}