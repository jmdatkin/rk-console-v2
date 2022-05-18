<?php

namespace App\Report;

use App\Models\Route;
use App\Repository\RecipientRepositoryInterface;
use App\Repository\RouteRepositoryInterface;

class TexterReport extends BaseReport
{

    public function __construct(RecipientRepositoryInterface $repository, RouteRepositoryInterface $routeRepository)
    {
        $this->repository = $repository;
        $this->routeRepository = $routeRepository;
    }

    public function report($weekday)
    {
        return Route::whereHas('recipients', function ($query) use ($weekday) {
            return $query->where('weekday', $weekday);
        })->with(['recipients' => function ($query) use ($weekday) {
            return $query->wherePivot('weekday', $weekday);
        }])->get()

            ->flatMap(function ($route) {
                return $route->recipients->map(function ($recipient) use ($route) {
                    return collect($recipient)->union(["routeName" => $route->name]);
                });
            });

        /*
        return $this->routeRepository->all()
            ->filter(function ($route) use ($weekday) {
                return !$route->recipients()->wherePivot('weekday', $weekday)->get()->isEmpty();
            })->values()
            // ->map(function($route) use ($weekday) {
            //     return $route->recipients->union([
            //         'routeName' => $route->name
            //     ]);
            // })->values();
            ->reduce(function ($carry, $item) {
                return $carry->concat(      //Stack recipients in same array level
                    $item->recipients->map(function ($recipient) use ($item) {
                        // return $recipient->union([
                        //     'routeName' => $item->name
                        // ]);
                        return $recipient;
                    })
                );
            }, collect());*/

        // return $this->repository->all()
        // ->filter(function($recipient) use ($weekday) {
        //     return !$recipient->routes()->wherePivot('weekday', $weekday)->get()->isEmpty();
        // })->values()
        // ->map(function($recipient) use ($weekday) {

        // });

        // return array_values($this->repository->all()
        // ->filter(function($recipient) use ($weekday) {      //Filter route assignments to chosen weekday
        //     return !$recipient->routes()->wherePivot('weekday', $weekday)->get()->isEmpty();
        // });
        // ->map(function($recipient) {        //Append route name for grouping within DataTable
        //     return collect($recipient->toArray())->union(
        //     [
        //         'routeName' => $recipient->routes->first()->name
        //     ]);
        //     // return $recipient;
        // })->toArray());
    }
}
