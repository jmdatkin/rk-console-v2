<?php

namespace App\Http\Controllers;

use App\Report\DashboardReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
    public function index(DashboardReport $report) {
        return Inertia::render('Dashboard/Index', ['data' => $report->data(Carbon::today())]);
    }
}
