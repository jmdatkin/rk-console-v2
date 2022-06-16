<?php

namespace App\Report;

use App\Models\Route;
use App\Repository\RouteRepositoryInterface;
use Carbon\Carbon;
use Error;
use Exception;
use Facades\App\Facade\DateAdapter;
use Illuminate\Http\Request;

class DriversByRouteReport implements ReportInterface
{

    public function __construct(RouteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 
     * Returns drivers grouped by route assignment, filtered by a given date.
     * 
     * @param input
     * @return Collection
     */
    public function data($input)
    {
        $date = $input['date'];
        // $carbon_date = Carbon::createFromFormat("mdY", $date);
        $carbon_date = DateAdapter::make($date);
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
