<?php

namespace App\Http\Controllers;

use App\Carbon\RkCarbon;
use App\Models\Role;
use App\Report\DriverReport;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct(DriverReport $report)
    {
        $this->report = $report;
    }
    public function handle(Request $request) {

        if (is_null(Auth::user()))
            return redirect()->route('login');

        if (Auth::user()->hasRole(Role::ADMIN))
            return redirect()->route('dashboard');

        else if (Auth::user()->hasRole(Role::DRIVER)) {
            return Inertia::render('Driver/Dashboard',
            [
                'data' => $this->report->data(['date' => RkCarbon::today(), 'driver_id' => Auth::user()->driver_id]),
            ]);
        }
        else
            throw new AuthorizationException("User class not recognized.", 403);
    }
}
