<?php

namespace App\Http\Controllers\Report;

use App\Report\DriverReport;
use App\Repository\DriverRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverReportController extends BaseReportController
{
    /**
     * DriverReportController constructor.
     */
    public function __construct(DriverReport $report, DriverRepository $repository)
    {
        // parent::__construct($report);
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
            ]
        );
    }

    public function data(Request $request)
    {
        $weekday = $request->input('weekday');
        return $this->report->new_data(
            $request->input('driver_id'),
            $request->input('date')
        );
    }
}
