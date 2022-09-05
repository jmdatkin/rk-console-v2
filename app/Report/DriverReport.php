<?php

namespace App\Report;

use App\Models\Route;
use App\Repository\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DriverReport
{

    public function __construct(DriverRepositoryInterface $repository, Stubs $stubs)
    {
        $this->repository = $repository;
        $this->stubs = $stubs;
    }

    public function new_data($driver_id, $date) {

        $weekday = $date->dayOfWeek;

        // $route_ids = $this->stubs->driverRouteWithSubs($date)
        $route_ids = DB::query()->fromSub(
            $this->stubs->driverRouteWithSubs($date),
            'driver_route_subs')
        ->where('driver_id', $driver_id)
        ->whereNull('driver_route_subs.sub_driver_id')
        ->orWhere(function($query) use ($driver_id) {
            $query->where('driver_route_subs.sub_driver_id', $driver_id);
        })
        ->join('routes','routes.id','=','route_id')
        ->get()->map(fn($r) => $r->route_id);

        return Route::with([
                'recipients' => function($q) use ($weekday) {
                    $q->where('weekday', $weekday);
                    $q->withPivot('driver_custom_order');
                    $q->orderBy('driver_custom_order');
                }
            ])->whereHas('recipients')
        ->whereIn('id', $route_ids)
        ->get();
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
