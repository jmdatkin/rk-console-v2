<?php

namespace App\Report;

use App\Models\Route;
use App\Repository\DriverRepositoryInterface;
use App\Repository\RecipientRepositoryInterface;
use App\Repository\RouteRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TexterReport extends BaseReport
{

    public function __construct(RecipientRepositoryInterface $repository, RouteRepositoryInterface $routeRepository)
    {
        $this->repository = $repository;
        $this->routeRepository = $routeRepository;
    }

    public function report($weekday)
    {
        // return Route::has('recipients')
        // ->with(['recipients' => function($query) use ($weekday) {
        //     return $query->wherePivot('weekday', $weekday);
        // }])->get();

        return Route::whereHas('recipients', function ($query) use ($weekday) {
            return $query->where('weekday', $weekday);
        })->with(['recipients' => function ($query) use ($weekday) {
                return $query->wherePivot('weekday', $weekday);
            }])->get()

            ->flatMap(function($route) {
                // return $value->recipients->union(['route' => $value->name]);
                // return collect($value->recipients)->merge(['route' => $value->name]);
                return $route->recipients->map(function($recipient) use ($route) {
                    return collect($recipient)->union(["routeName" => $route->name]);
                    // return $recipient;
                });
                // return $value->recipients;
            });
            
            // ->reduce(function($carry, $route) {
            //     return $carry->union(
            //         // $route->recipients->map(function($recipient) use ($route) {
            //         //     return $recipient->union(['routeName' => $route->name]);
            //         // })
            //         $route
            //     );
            // }, collect());
        // return $this->routeRepository->all()->load('recipients')->wherePivot('weekday', $weekday)->get();

        // return Route::with('recipients')->wherePivot('weekday', $weekday)->get();

        // return $this->routeRepository->all()
        // ->map(function($r) use ($weekday) {
        //     return $r->recipientsOnDay($weekday);
        // });


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
