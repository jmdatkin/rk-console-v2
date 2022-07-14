<?php

namespace App\Http\Controllers\Report;

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
        return Inertia::render('Admin/DriversByRoute');
    }

    /**
     * Retrieve the data for this report.
     */
    public function data(Request $request) {
        return $this->report->data($request->only(['date']))->get();
    }
}
