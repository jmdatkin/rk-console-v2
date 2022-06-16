<?php

namespace App\Facade;

use Carbon\Carbon;

class DateAdapter {
    public function make($date) {
        return Carbon::createFromFormat("mdY", $date);
    }

    public function weekday($date) {
        return strtolower($date->shortDayName);
    }
}