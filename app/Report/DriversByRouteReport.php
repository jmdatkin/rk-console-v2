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
    public function data($input) {
        $date = DateAdapter::make($input['date']);
        $weekday = DateAdapter::weekday($date);

        return Route::with(['drivers' => function($q) use ($date, $weekday) {
            $q->where('weekday', $weekday)
            ->with(['exceptions' => function($q2) use ($date) {
                $q2->where('date_start', '<=', $date)
                ->where('date_end', '>', $date)
                ->with(['substitutes' => function($q3) use ($date) {
                    $q3->whereDate('date', $date);
                }]);
            }]);
        }]);

    }
}
