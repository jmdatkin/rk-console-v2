<?php

namespace App\Report;

use App\Models\DriverRoute;
use App\Models\Route;
use App\Repository\RouteRepository;

class DashboardReport
{

    /**
     * DashboardReport constructor.
     * 
     * @param RouteRepository $repository
     * @param DriversByRouteReport $driversByRouteReport
     */
    public function __construct(RouteRepository $repository, DriversByRouteReport $driversByRouteReport)
    {
        $this->repository = $repository;
        $this->driversByRouteReport = $driversByRouteReport;
    }


    /**
     * Retrieve data for the Dashboard's Driver display
     * 
     * @param \App\Carbon\RkCarbon $date
     * @return Builder
     */
    public function routeDrivers($date)
    {
        // return $this->driversByRouteReport->data($date)
        //     ->whereHas('drivers', function ($query) use ($date) {
        //         $query->where('weekday', $date->dayOfWeek);
        //     });
        return $this->driversByRouteReport->new_new_data($date, true);
    }


    /**
     * Retrieve data for the Dashboard's Recipient display
     * 
     * @param \App\Carbon\RkCarbon $date
     * @return \Illuminate\Support\Collection
     */
    public function routeRecipients($date)
    {

        $weekday = $date->dayOfWeek;

        return Route::with([
            'recipients' => function ($query) use ($date) {
                return $query->where('weekday', $date->dayOfWeek);
            },
        ])
            ->get()
            ->flatMap(function ($route) use ($weekday) {
                return $route->recipients->map(function ($recipient) use ($route, $weekday) {
                    // return collect($recipient->toArray())->union([
                    //     'routeName' => $route->name,
                    // ]);
                    $driver_associated = DriverRoute::where(['weekday' => $weekday, 'route_id' => $route->id])->exists();
                    return array_merge($recipient->toArray(),
                        [
                            'routeName' => $route->name,
                            'has_driver_associated' => $driver_associated
                        ]
                        );
                });
            })->values();
    }
}
