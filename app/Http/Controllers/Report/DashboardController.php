<?php

namespace App\Http\Controllers\Report;

use App\Carbon\RkCarbon;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Person;
use App\Models\Recipient;
use App\Report\DashboardReport;
use App\Report\Stats;
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
    public function index(DashboardReport $report)
    {
        $today = RkCarbon::today();

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
                'routeDriver_data' => $report->routeDrivers($today)->get(),
                'routeRecipient_data' => $report->routeRecipients($today),
                'messages' => $messages,
                'stats' => [
                    'recipients' => (new Stats(Recipient::first()))->data(),
                    'drivers' => (new Stats(Driver::first()))->data(),
                    'person' => (new Stats(Person::first()))->data()
                ]
            ]
        );
    }
}
