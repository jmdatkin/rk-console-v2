<?php

namespace App\Report;

use Illuminate\Support\Facades\DB;

class OutreachReport {

    /**
     * Retrieves all recipients assigned to a given day, regardless of route
     */
    public function data($date) {
        $weekday = $date->lowercaseDayName();

        return DB::table('recipient_route')
        ->where('weekday',$weekday)
        // ->join('recipients','recipients.id','=','recipient_id')
        ->join('recipients', function($join) {
            $join->on('recipients.id','=','recipient_id')
            // ->paused();  
            ->where('paused', false);
        })
        ->join('people', 'recipients.person_id', '=', 'people.id')
        ->get();
    }
}