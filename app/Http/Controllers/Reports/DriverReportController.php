<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverReportController extends Controller
{
    //
    public function index()
    {
        return Inertia::render(
            'Reports/DriverReport',
            [
                "data" => "ABC"
            ]
        );
    }
}
