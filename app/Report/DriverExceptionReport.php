<?php

namespace App\Report;

use App\Models\Route;
use App\Repository\RouteRepositoryInterface;
use Carbon\Carbon;
use Error;
use Exception;

class DriverExceptionReport
{

    public function __construct(RouteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function data($date)
    {
        try {
            $weekday = strtolower(Carbon::createFromFormat("mdY", $date)->shortDayName);
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
}
