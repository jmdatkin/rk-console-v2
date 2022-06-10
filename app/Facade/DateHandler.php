<?php

namespace App\Facade;

use Carbon\Carbon;

class DateHandler {
    public function intakeDate($date) {
        return Carbon::createFromFormat("mdY", $date);
    }
}