<?php

namespace App\Report;

use Illuminate\Support\Facades\DB;

class RouteTotalsReport {

    public function __construct(Stubs $stubs)
    {
        $this->stubs = $stubs;
    }

    public function baseQuery($date) {

        // Recipient numMeals totals by route and weekday
        $sub = DB::table('recipient_route')
            ->join('recipients','recipients.id','=','recipient_id')
            ->join('routes','routes.id','=','route_id')
            ->groupBy('name','weekday') // Group by route name and weekday
            ->select('routes.id as route_id', 'weekday')
            ->selectRaw('sum(recipients.numMeals) as agg_num_meals');

        return $sub;

        // return DB::table('driver_route')
        return DB::query()->fromSub($this->stubs->driverSubsAsWeekdays(), 'driver_subs_weekdays')
            ->joinSub($sub,'sub',function($join) {
                $join->on('sub.route_id','=','driver_subs_weekdays.route_id')
                    ->on('sub.weekday','=','driver_subs_weekdays.weekday');
            })
            ->join('routes','routes.id','=','driver_subs_weekdays.route_id')
            ->join('drivers','drivers.id','=','driver_id')
            ->join('people','drivers.person_id','=','people.id')
            ->select(
                'driver_id',
                'driver_subs_weekdays.route_id as route_id',
                'driver_subs_weekdays.weekday',
                'agg_num_meals as totalNumMeals',
                'name as route_name',
                'firstName as driver_firstName',
                'lastName as driver_lastName',
                'email as driver_email',
                'phoneHome as driver_phoneHome',
                'phoneCell as driver_phoneCell');
    }

    public function data($date) {
        return $this->baseQuery($date)->get();
    }

    public function dayTotals($date) {
        return $this->baseQuery($date)
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