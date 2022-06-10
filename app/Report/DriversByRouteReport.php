<?php

namespace App\Report;

use App\Models\Route;
use App\Repository\RouteRepositoryInterface;
use Carbon\Carbon;
use Error;
use Exception;

class DriversByRouteReport
{

    public function __construct(RouteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function data($date)
    {
        $carbon_date = Carbon::createFromFormat("mdY", $date);
        if ($carbon_date->isBefore(Carbon::today()->startOfWeek())) {
            return Route::with(
                [
                    'driverHistory' => function ($query) use ($carbon_date) {
                        return $query->where('date', $carbon_date)->with('exceptions');
                    }
                ]
            )->get();
        } else {
            try {
                $weekday = strtolower($carbon_date->shortDayName);
                return Route::with(
                    [
                        'drivers' => function ($query) use ($weekday) {
                            return $query->where('weekday', $weekday)->with('exceptions');
                        }
                    ]
                )->get();
            } catch (Error | Exception $e) {
                error_log($e);
            }
        }
        // return Route::with('driversOnDay', $date);
    }
}
