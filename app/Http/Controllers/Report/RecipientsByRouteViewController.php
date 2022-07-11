<?php

namespace App\Http\Controllers\Report;

use App\Report\RecipientsByRouteReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipientsByRouteViewController extends BaseReportController
{
    /**
     * RecipientsByRouteViewController constructor.
     * 
     * @param RecipientsByRouteReport $report
     */
    public function __construct(RecipientsByRouteReport $report)
    {
        parent::__construct($report);
    }

    /**
     * Display the RecipientsByRoute view.
     */
    public function index()
    {
        return Inertia::render('RecipientsByRoute/Index');
    }

    /**
     * Retrieve the data for this report.
     */
    public function data(Request $request)
    {
        return $this->report->data($request->only(['date']));
    }
}
