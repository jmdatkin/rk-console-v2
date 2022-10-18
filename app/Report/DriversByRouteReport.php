<?php

namespace App\Report;

use App\Repository\RouteRepository;

class DriversByRouteReport
{

    public function __construct(RouteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve Routes and their associated Drivers
     */
    public function data($date, $exclude_empty = false)
    {
        $data = $this->data($date)
        ->select('*', 'routes.id as route_id', 'routes.name as route_name');

        $data = $data->get();

        $num_subs = 4;

        return $data
        ->filter(fn($r) => !$exclude_empty || count($r->drivers) > 0)
        ->map(function ($route) use ($num_subs) {
            $flat_subs = [];

            $subs = $route->subs;

            for ($i = 0; $i < $num_subs; $i++) {
                $flat_subs = array_merge($flat_subs, [
                    'sub_driver_' . $i . '_id' => $subs[$i]->id ?? null,
                    'sub_driver_' . $i . '_firstName' => $subs[$i]->person->firstName ?? null,
                    'sub_driver_' . $i . '_lastName' => $subs[$i]->person->lastName ?? null
                ]);
            }


            return collect($route->toArray())
                ->union(collect([
                    'driver_id' => $route->drivers[0]->id ?? null,
                    'driver_firstName' => $route->drivers[0]->person->firstName ?? null,
                    'driver_lastName' => $route->drivers[0]->person->lastName ?? null,
                ]))
                ->union(collect($flat_subs));
        });
    }
}