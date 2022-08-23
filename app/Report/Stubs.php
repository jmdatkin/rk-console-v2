<?php

namespace App\Report;

use Illuminate\Support\Facades\DB;

class Stubs {


    /**
     * 'driver_route' table with substitutes merged
     */
    public function driverRouteWithSubs($date) {

        $sub = DB::table('driver_subs')

            // This line is DB-specific
            ->whereDate('date',$date)
            ->select()
            ->selectRaw('strftime("%w", date) as weekday');

        return DB::table('driver_route')
        ->joinSub($sub, 'driver_subs_weekdays', function($join) {
            $join->on('driver_route.weekday','=','driver_subs_weekdays.weekday');
        });
    }
}