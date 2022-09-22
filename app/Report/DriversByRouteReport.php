<?php

namespace App\Report;

use App\Models\Route;
use App\Repository\RouteRepository;
use Facades\App\Facade\Settings;
use Illuminate\Support\Facades\DB;

class DriversByRouteReport
{

    public function __construct(RouteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function new_new_data($date, $exclude_empty = false)
    {
        $data = $this->data($date)
        ->select('*', 'routes.id as route_id', 'routes.name as route_name');

        // if ($exclude_empty)
        //     $data = $data->whereNotNull('driver_id');

        $data = $data->get();
        // ->where
        // ->get();

        $num_subs = Settings::get('driversbyroute.num_sub_drivers');

        return $data
        ->filter(fn($r) => !$exclude_empty || count($r->drivers) > 0)
        ->map(function ($route) use ($num_subs) {
            $flat_subs = [];

            // $subs = $route->substituteDrivers()->get();

            $subs = $route->substituteDrivers;

            for ($i = 0; $i < $num_subs; $i++) {
                $flat_subs = array_merge($flat_subs, [
                    'sub_driver_' . $i . '_id' => $subs[$i]->id ?? null,
                    'sub_driver_' . $i . '_firstName' => $subs[$i]->person->firstName ?? null,
                    'sub_driver_' . $i . '_lastName' => $subs[$i]->person->lastName ?? null
                ]);
            }


            return collect($route->toArray())
                ->union(collect([
                    'driver_id' => $route->drivers[0]->id ?? null,
                    'driver_firstName' => $route->drivers[0]->person->firstName ?? null,
                    'driver_lastName' => $route->drivers[0]->person->lastName ?? null,
                ]))
                ->union(collect($flat_subs));
        });
    }

    public function new_data($date)
    {
        $weekday = $date->dayOfWeek;

        // return DB::table('driver_route')
        // ->rightJoin('driver_subs', 'driver_route.driver_id', '=', 'driver_subs.driver_id')
        // return DB::table('driver_subs')
        // ->leftJoin('driver_route', 'driver_route.driver_id', '=', 'driver_subs.driver_id')
        return DB::table('driver_route')
            // ->join('driver_subs', 'driver_route.driver_id', '=', 'driver_subs.driver_id')
            ->join('driver_subs', 'driver_route.route_id', '=', 'driver_subs.route_id')
            ->join('routes', 'routes.id', '=', 'driver_subs.route_id')
            ->join('drivers', 'drivers.id', '=', 'driver_route.driver_id')
            ->join('people as driver_people', 'driver_people.id', '=', 'drivers.person_id')
            ->join('drivers as drivers_sub', 'drivers_sub.id', '=', 'driver_subs.sub_driver_id')
            ->join('people as driver_sub_people', 'driver_sub_people.id', '=', 'drivers_sub.person_id')
            ->select([
                // 'driver_sub_people.*',
                // 'driver_people.*',
                'routes.id as route_id',
                'name as route_name',
                'drivers.id as driver_id',
                'driver_people.firstName as driver_firstName',
                'driver_people.lastName as driver_lastName',
                'driver_people.email as driver_email',
                'drivers_sub.id as driver_sub_id',
                'driver_sub_people.firstName as driver_sub_firstName',
                'driver_sub_people.lastName as driver_sub_lastName',
                'driver_sub_people.email as driver_sub_email',
                // 'driver_peofirstName as driver_first_name',
                // 'drivers.lastName as driver_last_name',
                // 'drivers.email as driver_email',
                // 'drivers.phoneHome as driver_phone_home',
                // 'drivers.phoneCell as driver_phone_cell',
                // ''
            ])
            ->get();
    }


    /**
     * 
     * Returns drivers grouped by route assignment, filtered by a given date.
     * 
     * @param RkCarbon input
     * @return Collection
     */
    public function data($date)
    {
        $weekday = $date->dayOfWeek;

        return Route::with(['drivers' => function ($q) use ($weekday) {
            $q->where('weekday', $weekday);
            // ->with(['exceptions' => function($q2) use ($date) {
            //     $q2->where('date_start', '<=', $date)
            //     ->where('date_end', '>', $date)
            //     ->with(['substitutes' => function($q3) use ($date) {
            //         $q3->whereDate('date', $date);
            //     }]);
        }])
            ->with(['substituteDrivers' => function ($q) use ($date) {
                $q->whereDate('date', $date);
            }]);
        // ->whereHas('drivers', function ($q) use ($weekday) {
        //     $q->where('weekday', $weekday);
        // });
    }

    // /**
    //  * Returns drivers grouped by route assignment, filtered by a given date.
    //  * 
    //  * @param array input
    //  * @return Collection
    //  */
    // public function data($input) {
    //     $date = $input['date'];
    //     $weekday = $date->lowercaseDayName();

    //     $replaced_driverroute_subquery = DB::table('driver_route')
    //         ->join('driver_subs', function($join) use ($date)
    //         {
    //             $join->on('driver_subs.route_id', '=', 'driver_route.route_id')
    //             ->on('driver_subs.driver_id', '=', 'driver_route.driver_id')
    //             ->whereDate('driver_subs.date',$date);
    //         })
    //         ->select(['driver_route.route_id','driver_subs.date','sub_driver_id as driver_id']);

    //     return DB::table('driver_route')
    //         ->leftJoinSub($replaced_driverroute_subquery, 'subbed_drivers', function($join) use ($weekday) {
    //             $join->on('driver_route.route_id', '=' , 'subbed_drivers.route_id')
    //             ->on('driver_route.weekday', '=', $weekday);
    //         })
    //         ->join('routes', 'routes.id','=','subbed_drivers.driver_id')
    //             ->leftJoin('drivers', 'driver_route.driver_id', '=', 'drivers.id')
    //             ->leftJoin('people', 'drivers.person_id' ,'=','people.id')
    //             // ->leftJoin('driver_subs', 'drivers.id', '=', 'driver_subs.driver_id');
    //             ->leftJoin('driver_subs', function($join) use ($date) {
    //                 $join->on('drivers.id', '=', 'driver_subs.driver_id')
    //                 ->whereDate('date', $date);
    //             })
    //             ->select(['routes.id as route_id',
    //                         'drivers.id as driver_id',
    //                         'sub_driver_id',
    //                         'firstName',
    //                         'driver_subs.date',
    //                     'lastName',
    //                     'routes.name as route_name']);


    //     $substitute_driverroute_subquery = DB::table('driver_route')
    //         ->leftJoin('driver_route_subs', function($join) use ($date) {
    //             $join->on('driver_route_subs.route_id', '=', 'driver_route.route_id')
    //             ->andOn('driver_route_subs.driver_id', '=', 'driver_route.driver_id')
    //             ->whereDate('date',$date);
    //         })p


    //         /*
    //     return DB::table('routes')
    //             ->leftJoin('driver_route', function($join) use ($weekday) {
    //                 $join->on('driver_route.route_id', '=', 'routes.id')
    //                 ->where('weekday', $weekday);
    //             })
    //             ->leftJoin('drivers', 'driver_route.driver_id', '=', 'drivers.id')
    //             ->leftJoin('people', 'drivers.person_id' ,'=','people.id')
    //             // ->leftJoin('driver_subs', 'drivers.id', '=', 'driver_subs.driver_id');
    //             ->leftJoin('driver_subs', function($join) use ($date) {
    //                 $join->on('drivers.id', '=', 'driver_subs.driver_id')
    //                 ->whereDate('date', $date);
    //             })
    //             ->select(['routes.id as route_id',
    //                         'drivers.id as driver_id',
    //                         'sub_driver_id',
    //                         'firstName',
    //                         'date',
    //                     'lastName',
    //                     'routes.name as route_name']);
    //                     */
    // }
}
