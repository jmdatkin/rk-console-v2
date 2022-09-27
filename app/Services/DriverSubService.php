<?php

namespace App\Services;

use App\Carbon\RkCarbon;
use App\Models\DriverSub;
use App\Models\DriverSubPeriod;

class DriverSubService {


    /**
     * Assigns or updates a driver substitution.
     * 
     * @param int $route_id
     * @param int $driver_id
     * @param int $sub_driver_id
     * @param int $date
     */
    public function assign_driver_sub($route_id, $driver_id, $sub_driver_id, $date)
    {
        // $driver_sub = DriverSub::where(
        //     [
        //         'route_id' => $route_id,
        //         'driver_id' => $driver_id,
        //     ]
        // )->whereDate('date', RkCarbon::parse($date))->first();

        // if (!isset($driver_sub)) {
            $driver_sub = new DriverSub();
            $driver_sub->route_id = $route_id;
            $driver_sub->date = RkCarbon::parse($date);
        // }

        $driver_sub->driver_id = $driver_id;
        $driver_sub->sub_driver_id = $sub_driver_id;

        $driver_sub->save();
    }

    /**
     * Create a DriverSubPeriod resource.
     * 
     * @param int $driver_id
     * @param RkCarbon $date_start
     * @param RkCarbon $date_end
     * 
     * @return Model
     * 
     */
    public function make_driver_sub_period(int $driver_id, int $date_start, int $date_end): Model {
        $driver_sub_period = new DriverSubPeriod();

        $driver_sub_period->driver_id = $driver_id;
        $driver_sub_period->date_start = $date_start;
        $driver_sub_period->date_end = $date_end;

        $driver_sub_period->save();

        return $driver_sub_period;
    }
}