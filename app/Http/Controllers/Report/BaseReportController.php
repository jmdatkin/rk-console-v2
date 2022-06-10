<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Report\ReportInterface;
use Illuminate\Http\Request;

class BaseReportController extends Controller
{
    //
    public function __construct(ReportInterface $report) {
        $this->report = $report;
    }

    public function data(Request $request) {
        $this->report->data($request);
    }
}
