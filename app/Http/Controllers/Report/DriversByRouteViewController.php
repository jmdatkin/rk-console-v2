<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Report\DriversByRouteReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriversByRouteViewController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('RouteDriver/Index', [
        ]);
    }

    public function data(Request $request, DriversByRouteReport $report)
    {
        return $report->data($request->input('date'));
    }
}
