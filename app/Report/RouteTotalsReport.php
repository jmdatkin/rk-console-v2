<?php

namespace App\Report;

use Illuminate\Support\Facades\DB;

class RouteTotalsReport {

    public function baseQuery() {

        $sub = DB::table('recipient_route')
            ->join('recipients','recipients.id','=','recipient_id')
            ->join('routes','routes.id','=','route_id')
            ->groupBy('name','weekday')
            ->select('routes.id as route_id', 'weekday')
            ->selectRaw('sum(recipients.numMeals) as agg_num_meals');

        return DB::table('driver_route')
            ->joinSub($sub,'sub',function($join) {
                $join->on('sub.route_id','=','driver_route.route_id')
                    ->on('sub.weekday','=','driver_route.weekday');
            })
            ->join('routes','routes.id','=','driver_route.route_id')
            ->join('drivers','drivers.id','=','driver_id')
            ->join('people','drivers.person_id','=','people.id')
            ->select(
                'driver_id',
                'driver_route.route_id as route_id',
                'driver_route.weekday',
                'agg_num_meals as totalNumMeals',
                'name as route_name',
                'firstName as driver_firstName',
                'lastName as driver_lastName',
                'email as driver_email',
                'phoneHome as driver_phoneHome',
                'phoneCell as driver_phoneCell');
    }

    public function data() {
        return $this->baseQuery()->get();
    }

    public function dayTotals() {
        return $this->baseQuery()
        // ->groupBy('driver_route.weekday')
        // ->select('driver_route.weekday as weekday')
        // ->selectRaw('sum(agg_num_meals) as day_total')
        // ->get();
        ->groupBy('driver_route.weekday')
        ->select('driver_route.weekday as weekday')
        ->selectRaw('sum(agg_num_meals) as day_total')
        ->get();
    }
}