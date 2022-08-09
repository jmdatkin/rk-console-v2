<?php

namespace App\Http\Controllers\Report;

use App\Carbon\RkCarbon;
use App\Http\Controllers\Controller;
use App\Report\RouteTotalsReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TotalsReportController extends Controller
{
    public function __construct(RouteTotalsReport $report) {
        $this->report = $report;
    }

    public function report($date) {
        return Inertia::render('Admin/Reports/TotalsReport',
        [
            'data' => $this->report->data(),
            'date' => $date
        ]
    );
    }

    public function index() {
        return Inertia::render('Admin/DateSelectLanding', ['header' => 'Totals Report']);
    }

    public function data(Request $request) {
        return $this->report->data();
    }
}
