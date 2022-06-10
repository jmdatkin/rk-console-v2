<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Report\RecipientsByRouteReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipientsByRouteViewController extends Controller
{
    //
    public function __construct(RecipientsByRouteReport $report) {
        $this->report = $report;
    }
    
    public function index() {
        return Inertia::render('RecipientsByRoute/Index');
    }

    public function data(Request $request) {
        $date = $request->input('date');
        return $this->report->data($date);
    }
}
