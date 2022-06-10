<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Report\DriverReport;
use App\Report\MealReport;
use App\Repository\DriverRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MealReportController extends Controller
{
    //
    public function __construct(MealReport $report, DriverRepositoryInterface $repository)
    {
       $this->report = $report; 
       $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return Inertia::render(
            'Reports/MealReport',
        );
    }

    public function data(Request $request) {
        $weekday = $request->input('weekday');
        return $this->report->data($weekday);
    }
}
