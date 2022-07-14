<?php

namespace App\Carbon;

use Carbon\Carbon;

class RkCarbon extends Carbon {

    public static function parseStd(string $date) {
        return parent::parse($date)->tz('Etc/UTC');
    }

    public function lowercaseDayName() {
        return strtolower($this->shortDayName);
    }
}