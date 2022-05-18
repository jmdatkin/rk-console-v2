<?php

namespace App\Report;

use App\Models\Route;
use App\Repository\RecipientRepositoryInterface;
use App\Repository\RouteRepositoryInterface;
use Illuminate\Support\Facades\Log;

class MealReport extends BaseReport
{

    public function __construct(RecipientRepositoryInterface $repository, RouteRepositoryInterface $routeRepository)
    {
        $this->repository = $repository;
        $this->routeRepository = $routeRepository;
    }

    public function data()
    {
    }

    public function meals($weekday)
    {

        return Route::whereHas('recipients', function ($query) use ($weekday) {
            return $query->where('weekday', $weekday);
        })->with(['recipients' => function ($query) use ($weekday) {
            return $query->wherePivot('weekday', $weekday);
        }])->get()

            ->map(function ($route) {
                return [
                    "routeName" => $route->name,
                    "aggNumMeals" =>
                    $route->recipients->reduce(function ($carry, $recipient) {
                        return $carry + $recipient->numMeals;
                    }, 0)
                ];
            });
        // return $this->routeRepository->all()
        // ->filter(function($route) use ($weekday) {
        //     return !$route->recipients()->wherePivot('weekday',$weekday)->get()->isEmpty();
        // })
        // ->values()->map(function($route) use ($weekday) {
        //     $aggNumMeals = $route->recipients->reduce(function($carry, $item) {
        //         return $carry + $item->numMeals;
        //     }, 0);
        //     return [
        //         'routeName' => $route->name,
        //         'aggNumMeals' => $aggNumMeals
        //     ];
        //     // return $route;
        // });



        // return $this->repository->all()
        // ->filter(function($recipient) use ($weekday) {
        //     return !$recipient->routes()->wherePivot('weekday', $weekday)->get()->isEmpty();
        // })
        // ->reduce(function($recipient) {
        //     return $carry + $recipient->numMeals;  
        // })

        // return $this->routeRepository->all()
        // ->load('recipients')
        // ->filter(function($r) use ($weekday) {
        //     return $r->recipients
        // })

        // return Route::with(['recipients' => function($query) use ($weekday) {
        //     return $query->wherePivot('weekday', $weekday);
        // }])->get();


        // ->map(function($route) use ($weekday) {
        //    $aggNumMeals = $route->recipients->reduce(function($carry, $item) {
        //        return $carry + $item->numMeals;
        //    });
        //    return $route->union(['aggNumMeals' => $aggNumMeals]);
        // });
        // ->map(function($r) use ($weekday) {
        //     // return $r->union($r->recipients()->wherePivot('weekday',$weekday)->get());
        // })->filter(function($c) { return !$c->isEmpty(); });
    }
}
