<?php

namespace App\Facade;

use Carbon\Carbon;

class DateAdapter {
    public function make($date) {
        return Carbon::createFromFormat("mdY", $date);
    }
}