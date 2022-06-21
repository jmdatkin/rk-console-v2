<?php

namespace App\Report;

use Facades\App\Facade\DateAdapter;
use App\Models\Route;
use App\Repository\RouteRepositoryInterface;
use Carbon\Carbon;

class DashboardReport
{

    public function __construct(RouteRepositoryInterface $repository, DriversByRouteReport $driversByRouteReport)
    {
        $this->repository = $repository;
        $this->driversByRouteReport = $driversByRouteReport;
    }

    // public function routeDrivers($date)
    // {
    //     // $weekday = strtolower(Carbon::createFromFormat("mdY",$date)->shortDayName);
    //     $carbon_date = DateAdapter::make($date);
    //     $weekday = strtolower($carbon_date->shortDayName);
    //     return Route::with([
    //         'drivers' => function ($query) use ($weekday) {
    //             return $query->where('weekday', $weekday);
    //         }
    //     ])
    //         ->whereHas('drivers', function ($query) use ($weekday) {
    //             return $query->where('weekday', $weekday);
    //         })

    //         ->get();
    // }
    public function routeDrivers($date)
    {
        return $this->driversByRouteReport->data(['date' => $date])
        ->whereHas('drivers', function($query) use ($date) {
            $query->where('weekday', strtolower(Carbon::createFromFormat("mdY", $date)->shortDayName));
        });
        // ->filter(function($row) { return $row->drivers()->get()->isNotEmpty(); })->values();
        // dd($this->driversByRouteReport->data(['date' => $date])
        // ->filter(function($row) { return $row->drivers()->exists(); }));
    }

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
