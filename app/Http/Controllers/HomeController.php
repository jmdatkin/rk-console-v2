<?php

namespace App\Http\Controllers;

use App\Report\DriverReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(DriverReport $report)
    {
        $this->report = $report;
    }
    public function handle(Request $request)
    {

        if (is_null(Auth::user()))
            return redirect()->route('login');

        return redirect()->route('dashboard');
    }
}
