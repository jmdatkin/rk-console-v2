<?php

namespace App\Report;

use Facades\App\Facade\DateAdapter;
use App\Models\Route;
use App\Repository\RouteRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecipientsByRouteReport implements ReportInterface
{

    public function __construct(RouteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve report data.
     * 
     * @param array $input
     * @return \Illuminate\Support\Collection
     */
    public function data($input)
    {
        $date = $input['date'];
        return Route::with(['recipients' => function ($query) use ($date) {
            // return $query->where('weekday', $date->lowercaseDayName());
            return $query->where('weekday', $date->dayOfWeek);
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
