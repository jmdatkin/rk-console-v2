<?php

namespace App\Http\Controllers;

use Facades\App\Facade\Settings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index() {
        return Inertia::render('UserSettings');
    }

    public function save(Request $request) {
        $settings = $request->all();
        return Settings::set($settings);
    }

    public function save_user(Request $request) {
        $settings = $request->all();
        return Settings::user()->set($settings);
    }

    public function get(Request $request) {
        $keys = $request->all();
        if (count($keys) == 0)
            return Settings::get();
        return Settings::get($keys);
    }

    public function get_user(Request $request) {
        $keys = $request->all();
        return Settings::user()->get($keys);
    }
}
