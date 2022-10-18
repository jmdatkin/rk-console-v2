<?php

namespace App\Http\Controllers\Report;

use App\Carbon\RkCarbon;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Person;
use App\Models\Recipient;
use App\Models\Role;
use App\Report\DashboardReport;
use App\Report\DriverReport;
use App\Report\Stats;
use Facades\App\Facade\Settings;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Load the view displaying the Dashboard.
     * 
     * @param DashboardReport $report
     */
    public function index(DashboardReport $report, DriverReport $driverReport)
    {
        if (Auth::user()->hasRole(Role::ADMIN)) {
        $today = RkCarbon::now();

        $routeRecipient_data = $report->routeRecipients($today);

        $messages = [];

        $unassociated_drivers_exist = !$routeRecipient_data->every(function ($recip, $key) {
            return $recip['has_driver_associated'];
        });

        if ($unassociated_drivers_exist) {
            array_push(
                $messages,
                [
                    'severity' => 'warn',
                    'content' => 'There are recipients assigned to routes without an associated driver.'
                ]
            );
        }

        // dd($messages);

        return Inertia::render(
            'Admin/Dashboard',
            [
                // 'routeDriver_data' => $report->routeDrivers($today)->get(),
                'routeDriver_data' => $report->routeDrivers($today),
                'routeRecipient_data' => $report->routeRecipients($today),
                'messages' => $messages,
                'lockOut' => [
                    'time' => Settings::get('lock_out_time'),
                    'day' => Settings::get('lock_out_day')
                ],
                'lockIn' => [
                    'time' => Settings::get('lock_in_time'),
                    'day' => Settings::get('lock_in_day')
                ],
                'stats' => [
                    'isAppLocked' => Settings::appIsLocked(),
                    'recipients' => (new Stats(Recipient::first()))->data(),
                    'drivers' => (new Stats(Driver::first()))->data(),
                    'person' => (new Stats(Person::first()))->data()
                ]
            ]
        );

        }
        else if (Auth::user()->hasRole(Role::DRIVER)) {
            return Inertia::render('Driver/Dashboard',
            [
                // 'data' => $this->report->data(['date' => RkCarbon::today(), 'driver_id' => Auth::user()->driver_id]),
                'data' => $driverReport->new_data(
                    Auth::user()->driver_id,
                    RkCarbon::now()
                )
            ]);
        }
    }
}
