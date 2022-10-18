<?php

namespace App\Report;

use Illuminate\Support\Facades\DB;

class OutreachReport {

    /**
     * Retrieves all recipients assigned to a given day, regardless of route
     */
    public function data($date) {
        $weekday = $date->dayOfWeek;

        return DB::table('recipient_route')
        ->where('weekday',$weekday)
        ->join('recipients','recipients.id','=','recipient_id')
        ->where('recipients.paused', '0')
        ->join('agencies', 'agencies.id', '=', 'agency_id')
        ->join('people', 'recipients.person_id', '=', 'people.id')
        ->select([
            'recipient_id',
            // 'agency_id',
            'firstName',
            'lastName',
            'email',
            'phoneHome',
            'phoneCell',
            'numMeals',
            'address',
            'paused',
            'people.notes as recipient_notes',
            'agencies.name as agency_name',
            'agencies.notes as agency_notes',
        ])
        ->get();
    }
}