<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Report\DriverReport;
use App\Repository\DriverRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverReportController extends Controller
{
    //
    public function __construct(DriverReport $report, DriverRepositoryInterface $repository)
    {
       $this->report = $report; 
       $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $driver_id = $request->input('did');
        return Inertia::render(
            'Reports/DriverReport',
            [
                "driverData" => $this->repository->find($driver_id),
                // "data" => $this->report->driver($driver_id)
            ]
        );
    }

    public function data(Request $request) {
        $driver_id = $request->input('driver_id');
        $weekday = $request->input('weekday');
        return $this->report->driver($driver_id, $weekday);
    }
}
