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
     * @param array $input
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
    //     $date = $input['date'];
    //     return Route::with(['recipients' => function ($query) use ($date) {
    //         // return $query->where('weekday', $date->lowercaseDayName());
    //         return $query->where('weekday', $date->dayOfWeek);
    //     }])
    //         ->get()
    //         ->flatMap(function ($route) {
    //             return $route->recipients->map(function ($recipient) use ($route) {
    //                 return collect($recipient->toArray())->union([
    //                     'routeName' => $route->name
    //                 ]);
    //             });
    //         })->values();
    // }
}
