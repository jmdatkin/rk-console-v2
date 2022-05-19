<?php

namespace App\Report;

use App\Repository\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DriverReport extends BaseReport
{

    public function __construct(DriverRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function driver($driver_id, $weekday)
    {
        try {
            return $this->repository->find($driver_id)->routes()->wherePivot('weekday', $weekday)->get()
                // ->map(function ($route) use ($weekday) {
                //     return [
                //         'routeName' => $route->name,
                //         'recipients' => $route->recipients()->wherePivot('weekday', $weekday)->get()
                //     ];
                // });
                ->flatMap(function ($route) use ($weekday) {
                    // return [
                    //     'routeName' => $route->name,
                    //     'recipients' => $route->recipients()->wherePivot('weekday', $weekday)->get()
                    // ];
                    return $route->recipients()->wherePivot('weekday', $weekday)->get()
                    ->map(function($recipient) use ($route) {
                        return collect($recipient->toArray())->union(['routeName' => $route->name]);
                    });
                });
        } catch (ModelNotFoundException $e) {
            return collect();
        }
    }
}
