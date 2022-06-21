<?php

namespace App\Carbon;

use Carbon\Carbon;

class RkCarbon extends Carbon {

    public function lowercaseDayName() {
        return strtolower($this->shortDayName);
    }
}