<?php

namespace App\Report;

use App\Models\DriverRoute;
use App\Models\Route;
use App\Repository\RouteRepositoryInterface;

class DashboardReport
{

    /**
     * DashboardReport constructor.
     * 
     * @param RouteRepositoryInterface $repository
     * @param DriversByRouteReport $driversByRouteReport
     */
    public function __construct(RouteRepositoryInterface $repository, DriversByRouteReport $driversByRouteReport)
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
        return $this->driversByRouteReport->data(['date' => $date])
            ->whereHas('drivers', function ($query) use ($date) {
                // $query->where('weekday', $date->lowercaseDayName());
                $query->where('weekday', $date->dayOfWeek);
            });
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
