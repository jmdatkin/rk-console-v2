<?php

namespace App\Report;

use App\Models\Route;
use App\Repository\RouteRepositoryInterface;
use Carbon\Carbon;
use Facades\App\Facade\DateHandler;

class RecipientsByRouteReport extends BaseReport
{

    public function __construct(RouteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function data($date)
    {
        $carbon_date = DateHandler::intakeDate($date);
        $weekday = strtolower($carbon_date->shortDayName);
        return Route::with(['recipients' => function ($query) use ($weekday) {
            return $query->where('weekday', $weekday);
        }])
            ->get()
            ->flatMap(function ($route) {
                return $route->recipients->map(function ($recipient) use ($route) {
                    return collect($recipient->toArray())->union([
                        'routeName' => $route->name
                    ]);
                });
            })->values();
    }
}
