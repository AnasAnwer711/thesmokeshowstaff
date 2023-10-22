<?php

namespace App\Http\Controllers;

use App\Http\Requests\BasicSettingsRequest;
use App\Models\BasicSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BasicSettingController extends Controller
{
    public function getBasicSettings() {
        $basic_settings = BasicSetting::first();
        
        return response()->json([
            'success' => true,
            'data' => $basic_settings
        ]);
    }

    public function store(BasicSettingsRequest $request) {
        $data = $request->all();
        
        if ($request->hasFile('fav_icon')) {
            $request->file('fav_icon')->storeAs('/', 'fav_icon.ico', 'public');
            $data['fav_icon'] = 'fav_icon.ico';
        }

        if ($request->hasFile('logo')) {
            $request->file('logo')->storeAs('images', 'logo-the-smokeshow-staff.png', 'public');
            $data['logo'] = 'images/logo-the-smokeshow-staff.png';
        }

        if ($request->hasFile('cover_video')) {
            $request->file('cover_video')->storeAs('images', 'TheSmokeShow-Video-5.mp4', 'public');
            $data['cover_video'] = 'images/TheSmokeShow-Video-5.mp4';
        }

        $basic_settings = BasicSetting::first() ?? new BasicSetting();

        $basic_settings->fill($data);
        $basic_settings->save();

        return response()->json([
            'success' => true,
            'data' => $basic_settings->refresh(),
            'message' => 'Basic settings updated successfully'
        ]);
    }
}
