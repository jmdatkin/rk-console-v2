<?php

namespace App\Report;

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
                $query->where('weekday', $date->lowercaseDayName());
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
        return Route::with([
            'recipients' => function ($query) use ($date) {
                return $query->where('weekday', $date->lowercaseDayName());
            },
        ])
            ->get()
            ->flatMap(function ($route) {
                return $route->recipients->map(function ($recipient) use ($route) {
                    return collect($recipient->toArray())->union([
                        'routeName' => $route->name,
                    ]);
                });
            })->values();
    }
}
