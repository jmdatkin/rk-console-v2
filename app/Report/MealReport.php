<?php

namespace App\Report;

use App\Carbon\RkCarbon;
use App\Models\Route;
use App\Repository\RecipientRepositoryInterface;
use App\Repository\RouteRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MealReport
{

    public function __construct(RecipientRepositoryInterface $repository, RouteRepositoryInterface $routeRepository)
    {
        $this->repository = $repository;
        $this->routeRepository = $routeRepository;
    }

    public function data2($date) {
        $weekday = RkCarbon::parse($date)->dayOfWeek;

        $sub = DB::table('routes')
                ->join('recipient_route', 'route_id','=','routes.id')
                ->join('recipients','recipients.id','=','recipient_id')
                ->where('recipients.paused', 0)
                ->select('route_id as agg_route_id')
                ->where('weekday',$weekday)
                ->groupBy('name')
                ->selectRaw('sum(numMeals) as agg_num_meals');

        return DB::table('routes')
                ->join('recipient_route', 'route_id','=','routes.id')
                ->join('recipients','recipients.id','=','recipient_id')
                ->where('recipients.paused', 0)
                ->join('people','people.id','=','person_id')
                ->where('weekday',$weekday)
                ->leftJoinSub($sub, 'agg', function($q) { $q->on('recipient_route.route_id','=','agg_route_id');})
                ->get();
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
