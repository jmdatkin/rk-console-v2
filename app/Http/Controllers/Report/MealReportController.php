<?php

namespace App\Http\Controllers\Report;

use App\Carbon\RkCarbon;
use App\Http\Controllers\Controller;
use App\Report\MealReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MealReportController extends Controller
{

    public function __construct(MealReport $report)
    {
       $this->report = $report; 
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
