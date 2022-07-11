<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Report\DriverReport;
use App\Repository\DriverRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverReportController extends BaseReportController
{
    /**
     * DriverReportController constructor.
     */
    public function __construct(DriverReport $report, DriverRepositoryInterface $repository)
    {
        parent::__construct($report);
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

    public function data(Request $request)
    {
        // $driver_id = $request->input('driver_id');
        // $weekday = $request->input('weekday');
        return $this->report->data($request->only(['driver_id', 'weekday']));
    }
}
