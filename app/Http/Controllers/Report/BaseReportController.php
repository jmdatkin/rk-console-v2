<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Report\ReportInterface;
use Illuminate\Http\Request;

class BaseReportController extends Controller
{
    /**
     * BaseReportController constructor.
     * 
     * @param $report
     */
    public function __construct($report) {
        $this->report = $report;
    }


    /**
     * Retrieve the data from the loaded Report class.
     * 
     * @param Request $request
     */
    public function data(Request $request) {
        $this->report->data($request);
    }
}
