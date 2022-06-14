<?php

namespace App\Report;

use Facades\App\Facade\DateAdapter;
use App\Models\Route;
use App\Repository\RouteRepositoryInterface;
use Carbon\Carbon;

class DashboardReport
{

    public function __construct(RouteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function routeDrivers($date)
    {
        // $weekday = strtolower(Carbon::createFromFormat("mdY",$date)->shortDayName);
        $carbon_date = DateAdapter::make($date);
        $weekday = strtolower($carbon_date->shortDayName);
        return Route::with([
            'drivers' => function ($query) use ($weekday) {
                return $query->where('weekday', $weekday);
            }
        ])
            ->whereHas('drivers', function ($query) use ($weekday) {
                return $query->where('weekday', $weekday);
            })

            ->get();
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
