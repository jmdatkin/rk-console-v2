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
    // public function data($input) {
    //     $date = $input['date'];

    //     return Route::with(['drivers' => function($q) use ($date) {
    //         $q->where('weekday', $date->lowercaseDayName())
    //         ->with(['exceptions' => function($q2) use ($date) {
    //             $q2->where('date_start', '<=', $date)
    //             ->where('date_end', '>', $date)
    //             ->with(['substitutes' => function($q3) use ($date) {
    //                 $q3->whereDate('date', $date);
    //             }]);
    //         }]);
    //     }]);
    // }

    /**
     * 
     * Returns drivers grouped by route assignment, filtered by a given date.
     * 
     * @param array input
     * @return Collection
     */
    public function data($input) {
        $date = $input['date'];
        $weekday = $date->lowercaseDayName();

        // return DB::table('driver_route')
        //         ->where('weekday', $weekday)
        //         ->rightJoin('routes', 'route_id', '=', 'routes.id')
        //         ->join('drivers', 'driver_id', '=', 'drivers.id')
        //         ->join('people', 'drivers.person_id' ,'=','people.id');
        return DB::table('routes')
                ->leftJoin('driver_route', function($join) use ($weekday) {
                    $join->on('driver_route.route_id', '=', 'routes.id')
                    ->where('weekday', $weekday);
                })
                ->leftJoin('drivers', 'driver_route.driver_id', '=', 'drivers.id')
                ->leftJoin('people', 'drivers.person_id' ,'=','people.id')
                // ->leftJoin('driver_subs', 'drivers.id', '=', 'driver_subs.driver_id');
                ->leftJoin('driver_subs', function($join) use ($date) {
                    $join->on('drivers.id', '=', 'driver_subs.driver_id')
                    ->whereDate('date', $date);
                })
                ->select(['routes.id as route_id',
                            'drivers.id as driver_id',
                            'sub_driver_id',
                            'firstName',
                            'date',
                        'lastName',
                        'routes.name as route_name']);
    }
}
