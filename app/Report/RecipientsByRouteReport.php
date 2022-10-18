<?php

namespace App\Report;

use App\Models\DriverRoute;
use App\Models\Route;
use App\Repository\RouteRepository;

class RecipientsByRouteReport
{

    public function __construct(RouteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve report data.
     * 
     * @param RkCarbon $date
     * @return \Illuminate\Support\Collection
     */
    public function data($date)
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
                    // Include field indicating if recipient has an assigned driver
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
