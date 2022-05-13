<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Report\DriverReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverReportController extends Controller
{
    //
    public function __construct(DriverReport $report)
    {
       $this->report = $report; 
    }

    public function index(Request $request)
    {
        $driver_id = $request->input('did');
        return Inertia::render(
            'Reports/DriverReport',
            [
                "data" => $this->report->driver($driver_id)
            ]
        );
    }
}
