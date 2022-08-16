<?php

namespace App\Report;

use App\Models\Route;
use App\Repository\RouteRepositoryInterface;
use Carbon\Carbon;
use Error;
use Exception;
use Facades\App\Facade\DateAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriversByRouteReport implements ReportInterface
{

    public function __construct(RouteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 
     * Returns drivers grouped by route assignment, filtered by a given date.
     * 
     * @param array input
     * @return Collection
     */
    public function data($input)
    {
        $date = $input['date'];
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
            }])
            ->whereHas('drivers', function ($q) use ($weekday) {
                $q->where('weekday', $weekday);
            });
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
    //         });

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
