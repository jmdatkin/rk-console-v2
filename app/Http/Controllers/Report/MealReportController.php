<?php

namespace App\Http\Controllers\Report;

use App\Carbon\RkCarbon;
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

    public function report($date) {
        return Inertia::render('Admin/Reports/MealsReport', ['date' => $date, 'data' => $this->report->data2(RkCarbon::createFromFormat('m-d-Y', $date))]);
    }


    public function index(Request $request)
    {
        return Inertia::render(
            'Admin/DateSelectLanding', ['header' => 'Meal Report']
        );
        // return Inertia::render(
        //     'Admin/Reports/MealsReport',
        // );
    }

    public function data(Request $request) {
        $date = $request->input('date');
        return $this->report->data2($date);
    }
}
