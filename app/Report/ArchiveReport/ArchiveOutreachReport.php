<?php

namespace App\Report\ArchiveReport;

use App\Carbon\RkCarbon;
use App\Report\ArchiveReport\Subqueries;
use Illuminate\Support\Facades\DB;

class ArchiveOutreachReport {

    public function __construct(Subqueries $subq)
    {
       $this->subq = $subq; 
    }

    /**
     * Retrieves all recipients assigned to a given day, regardless of route
     */
    public function data($date) {
        // $weekday = $date->dayOfWeek;
        $startOfWeek = RkCarbon::parse($date)->startOf('week', RkCarbon::SUNDAY);
        $recipients_for_week = $this->subq->recipientsForWeek($date);
        $people_for_week = $this->subq->peopleForWeek($date);

        return DB::table('recipient_route_archive')
        ->whereDate('recipient_route_archive.startOfWeek', $startOfWeek)
        // ->where('weekday',$weekday)
        ->joinSub($recipients_for_week, 'recipients', function($join) {
            $join->on('recipients.resource_id','=','recipient_route_archive.recipient_id');
        })
        ->joinSub($people_for_week, 'people', function($join) {
            $join->on('people.resource_id','=','recipients.person_id');
        })
        // ->join('people', 'recipients.person_id', '=', 'people.id')
        ->get();
    }
}