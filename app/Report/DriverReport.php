<?php

namespace App\Report;

use App\Repository\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DriverReport implements ReportInterface
{

    public function __construct(DriverRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function data($input) {
        $driver_id = $input['driver_id'];
        $date = $input['date'];
        $weekday = $date->dayOfWeek;

        try {
            return $this->repository->find($driver_id)
            ->routes()->wherePivot('weekday', $weekday)
            ->with([
                'recipients' => function($q) use ($weekday) {
                    $q->where('weekday', $weekday);
                    $q->withPivot('driver_custom_order');
                    $q->orderBy('driver_custom_order');
                }
            ])->whereHas('recipients')->get();
        } catch (ModelNotFoundException $e) {
            return collect();
        }

    }

    // public function data($input)
    // {
    //     $driver_id = $input['driver_id'];
    //     $weekday = $input['weekday'];
    //     try {
    //         return $this->repository->find($driver_id)->routes()->wherePivot('weekday', $weekday)->get()
    //             ->flatMap(function ($route) use ($weekday) {
    //                 return $route->recipients()->wherePivot('weekday', $weekday)->get()
    //                     ->map(function ($recipient) use ($route) {
    //                         return collect($recipient->toArray())->union(['routeName' => $route->name]);
    //                     });
    //             });
    //     } catch (ModelNotFoundException $e) {
    //         return collect();
    //     }
    // }

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
                        ->map(function ($recipient) use ($route) {
                            return collect($recipient->toArray())->union(['routeName' => $route->name]);
                        });
                });
        } catch (ModelNotFoundException $e) {
            return collect();
        }
    }
}
