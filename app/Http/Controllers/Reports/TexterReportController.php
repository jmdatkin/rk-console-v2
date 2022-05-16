<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Report\TexterReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TexterReportController extends Controller
{
    //
    public function __construct(TexterReport $report)
    {
       $this->report = $report; 
    }

    public function index(Request $request)
    {
        $weekday = $request->input('weekday');
        return Inertia::render(
            'Reports/TexterReport',
            [
                "data" => $this->report->report('mon')
            ]
        );
    }
}
