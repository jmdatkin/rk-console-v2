<?php

namespace App\Report\ArchiveReport;

use App\Carbon\RkCarbon;
use Illuminate\Support\Facades\DB;

class Subqueries {

    private function startOfWeek($date) {
        return RkCarbon::parse($date)->startOf('week', RkCarbon::SUNDAY);
    }

    public function recipientsForWeek($date) {
        return DB::table('recipients_archive')
            ->whereDate('recipients_archive.startOfWeek', $this->startOfWeek($date)); 
    }

    public function peopleForWeek($date) {
        return DB::table('people_archive')
            ->whereDate('people_archive.startOfWeek', $this->startOfWeek($date)); 
    }
}