<?php

namespace App\Report;

use App\Carbon\RkCarbon;
use Illuminate\Support\Facades\DB;

class Stubs
{

    public function driverSubsAsWeekdays() {
        return DB::table('driver_subs')
            ->select('*')

            // This line is DB-specific
            // It converts the datetime field in 'driver_subs' to a weekday number so it can be joined with 'driver_route'

            //Sqlite:
            ->selectRaw('cast(strftime("%w", date) as integer) as weekday');
    }

    /**
     * 'driver_route' table with substitutes merged
     * 
     * @param \Carbon\Carbon $date
     * @return \Illuminate\Database\Query\Builder
     */
    public function driverRouteWithSubs($date)
    {

        $weekday = RkCarbon::parse($date)->dayOfWeek;

        // $sub = DB::table('driver_subs')
        //     ->whereDate('date', $date)
        //     ->select('*')

        //     // This line is DB-specific
        //     // It converts the datetime field in 'driver_subs' to a weekday number so it can be joined with 'driver_route'

        //     //Sqlite:
        //     ->selectRaw('cast(strftime("%w", date) as integer) as weekday');
        $sub = $this->driverSubsAsWeekdays()
            ->whereDate('date', $date);

        return DB::table('driver_route')
            ->where('driver_route.weekday', $weekday)
            ->select()  //Select all columns
            ->addSelect([   // Add sub_driver_id column
                'sub_driver_id' => $sub
                    ->select('sub_driver_id')
                    ->whereColumn([
                        ['driver_id', '=', 'driver_route.driver_id'],
                        ['route_id', '=', 'driver_route.route_id'],
                        ['weekday', '=', 'driver_route.weekday']    // Compare cast weekday column to regular weekday column
                    ])
            ])
        ;
    }
}
