<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Report\DashboardReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Load the view displaying the Dashboard.
     * 
     * @param DashboardReport $report
     */
    public function index(DashboardReport $report) {
        return Inertia::render('Admin/Dashboard',
        [
            'routeDriver_data' => $report->routeDrivers(Carbon::today()->format("mdY"))->get(),
            'routeRecipient_data' => $report->routeRecipients(Carbon::today()->format("mdY"))
        ]);
    }
}
