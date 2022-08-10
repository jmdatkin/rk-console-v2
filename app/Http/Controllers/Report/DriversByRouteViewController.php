<?php

namespace App\Http\Controllers\Report;

use App\Carbon\RkCarbon;
use App\Report\DriversByRouteReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriversByRouteViewController extends BaseReportController
{
    /**
     * DriversByRouteViewController constructor.
     * 
     * @param DriversByRouteReport $report
     */
    public function __construct(DriversByRouteReport $report)
    {
        parent::__construct($report);
    }

    /**
     * Display the DriversByRoute view.
     */
    public function index()
    {
        return Inertia::render('Admin/DateSelectLanding',
    [
        'header' => 'Drivers by Route'
    ]);
    }

    /**
     * Display the DriversByRoute view.
     */
    public function report($date)
    {
        return Inertia::render('Admin/DriversByRoute',
        [
            'date' => $date,
            'data' => $this->report->data(['date' => RkCarbon::createFromFormat('m-d-Y', $date)])->get()
        ]);
    }

    /**
     * Retrieve the data for this report.
     */
    public function data(Request $request) {
        $date = RkCarbon::parseStd($request->input('date'));
        return $this->report->data(['date' => $date])->get();
    }
}
