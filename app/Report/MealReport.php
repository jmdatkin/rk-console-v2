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

    public function data($weekday)
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
    }
}
