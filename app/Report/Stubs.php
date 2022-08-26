<?php

namespace App\Report;

use App\Carbon\RkCarbon;
use App\Models\DriverSub;
use Illuminate\Support\Facades\DB;

class Stubs
{


    /**
     * 'driver_route' table with substitutes merged
     */
    public function driverRouteWithSubs($date)
    {

        $weekday = RkCarbon::parse($date)->dayOfWeek;

        $sub = DB::table('driver_subs')
            ->whereDate('date', $date)
            ->select('*')

            // This line is DB-specific
            // It converts the datetime field in 'driver_subs' to a weekday number
            // So it can be joined with 'driver_route'

            //Sqlite:
            ->selectRaw('cast(strftime("%w", date) as integer) as weekday');

        // return $sub;

        return DB::table('driver_route')
            ->where('driver_route.weekday', $weekday)

            // ->addSelect([
            ->select()
            ->addSelect([
                // 'sub_driver_id' => DB::query()->fromSub(function ($query) use ($date) {
                //     $query->from('driver_subs')
                //         ->whereDate('date', $date)
                //         ->select('*')

                //         // This line is DB-specific
                //         // It converts the datetime field in 'driver_subs' to a weekday number
                //         // So it can be joined with 'driver_route'

                //         //Sqlite:
                //         ->selectRaw('cast(strftime("%w", date) as integer) as weekday');
                // }, 'weekday_subs')
                'sub_driver_id' => $sub
                    ->select('sub_driver_id')
                    ->whereColumn([
                        ['driver_id', '=', 'driver_route.driver_id'],
                        ['route_id', '=', 'driver_route.route_id'],
                        ['weekday', '=', 'driver_route.weekday'] //$weekday
                    ])
                    // ->where([
                    //     'driver_id' => 'driver_route.driver_id',
                    //     'route_id' => 'driver_route.route_id',
                    //     'weekday' => 'driver_route.weekday' //$weekday
                    // ])
            ])
        ;
    }
}
