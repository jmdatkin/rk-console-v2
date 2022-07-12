<?php

namespace App\Report;

use Facades\App\Facade\DateAdapter;
use App\Models\Route;
use App\Repository\RouteRepositoryInterface;
use Carbon\Carbon;

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
     * @param $date
     */
    public function routeDrivers($date)
    {
        return $this->driversByRouteReport->data(['date' => $date])
            ->whereHas('drivers', function ($query) use ($date) {
                $query->where('weekday', strtolower(Carbon::createFromFormat("mdY", $date)->shortDayName));
            });
    }


    /**
     * Retrieve data for the Dashboard's Recipient display
     * 
     * @param $date
     */
    public function routeRecipients($date)
    {
        $carbon_date = DateAdapter::make($date);
        $weekday = strtolower($carbon_date->shortDayName);
        return Route::with([
            'recipients' => function ($query) use ($weekday) {
                return $query->where('weekday', $weekday);
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
