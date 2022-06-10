<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Report\RecipientsByRouteReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipientsByRouteViewController extends BaseReportController
{
    //
    public function __construct(RecipientsByRouteReport $report) {
        // $this->report = $report;
        parent::__construct($report);
    }
    
    public function index() {
        return Inertia::render('RecipientsByRoute/Index');
    }

    public function data(Request $request) {
        return $this->report->data($request->only(['date']));
    }
}
