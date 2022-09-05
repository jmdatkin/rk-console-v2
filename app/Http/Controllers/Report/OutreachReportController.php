<?php

namespace App\Http\Controllers\Report;

use App\Carbon\RkCarbon;
use App\Http\Controllers\Controller;
use App\Report\OutreachReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OutreachReportController extends Controller
{
    //
    public function __construct(OutreachReport $report) {
        $this->report = $report;
    }

    public function index() {
        // return Inertia::render('Admin/Reports/OutreachReport');
        return Inertia::render('Admin/DateSelectLanding', ['redirect_route' => 'report.outreach', 'header' => 'Outreach Report']);
    }

    public function report($date) {
        return Inertia::render('Admin/Reports/OutreachReport', ['date' => $date, 'data' => $this->report->data(RkCarbon::createFromFormat('m-d-Y', $date))]);
    }

    public function data(Request $request) {
        $date = RkCarbon::parse($request->input('date'));
        return $this->report->data($date);
    }
}
