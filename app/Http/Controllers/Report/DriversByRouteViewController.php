<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Report\DriversByRouteReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriversByRouteViewController extends BaseReportController
{
    //
    public function __construct(DriversByRouteReport $report)
    {
        parent::__construct($report);
    }

    public function index()
    {
        return Inertia::render('RouteDriver/Index');
    }

    public function data(Request $request) {
        return $this->report->data($request->only(['date']));
    }
}
