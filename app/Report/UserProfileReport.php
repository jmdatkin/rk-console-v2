<?php

namespace App\Report;

use App\Models\User;

class UserProfileReport {

    public function data() {
        return User::find(1);        
    }
}