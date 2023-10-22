<?php

namespace App\Libs;

use Illuminate\Support\Facades\Http;

class Notification {
    public static function send($user, $notification) {
        $tokens = $user->devices->pluck('fcm_token')->toArray();

        if (count($tokens) == 0) return;

        $fcm_data = [
            'registration_ids' => $tokens,
            'data' => $notification,
            'notification' => $notification
        ];

        $api_key = env('FIREBASE_API_KEY');

        $r = Http::withHeaders([
            'Authorization' => 'key='. $api_key
        ])->withOptions([
            'verify' => false
        ])->acceptJson()->post(env('FIREBASE_API_URL'), $fcm_data);
    }
}