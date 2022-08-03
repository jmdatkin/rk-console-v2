<?php

namespace App\Facade;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserSettings {
    public function __construct() {
        $this->user = Auth::user();
    }

    public function get($key) {
        return $this->user->settings[$key];
    }

    public function set($key, $value) {
        $this->user->settings[$key] = $value;
    }
}