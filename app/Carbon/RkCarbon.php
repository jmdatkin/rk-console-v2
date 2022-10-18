<?php

namespace App\Carbon;

use Carbon\Carbon;

class RkCarbon extends Carbon {

    // Subclass of Carbon date library to add custom behavior

    public function __construct($time = null, $tz = null) {
        parent::__construct($time, $tz);
        $this->setTimezone('-4:00');
    }

    public static function parseStd(string $date) {
        return self::parse($date)->tz('Etc/UTC');
    }

    public function lowercaseDayName() {
        return strtolower($this->shortDayName);
    }
}