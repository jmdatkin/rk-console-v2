<?php

namespace App\Http\Controllers;

use App\Jobs\SchedulePendingJob;
use App\Models\DriverRoute;
use App\Models\RecipientRoute;
use App\Services\AssignmentService;
use Facades\App\Facade\Settings;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{

    public function __construct(AssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    /**
     * Create a Driver-Route relationship
     */
    public function assign_driver(Request $request)
    {
        $route_id = (int)$request->input('route_id');
        $driver_id = (int)$request->input('driver_id');
        $weekday = (int)$request->input('weekday');

        if (Settings::appIsLocked()) {
            SchedulePendingJob::dispatchSync(
                'driver',
                'assign',
                $driver_id,
                [(int)$route_id, (int)$weekday]
            );
        } else {
            $this->assignmentService->assign_driver(
                $route_id,
                $driver_id,
                $weekday
            );
        }
    }

    /**
     * Remove an existing Driver-Route relationship
     */
    public function deassign_driver(Request $request)
    {
        $route_id = (int)$request->input('route_id');
        $driver_id = (int)$request->input('driver_id');
        $weekday = (int)$request->input('weekday');

        if (Settings::appIsLocked()) {
            SchedulePendingJob::dispatchSync(
                'driver',
                'deassign',
                $driver_id,
                [$route_id, $weekday]
            );
        } else {
            $this->assignmentService->deassign_driver(
                $route_id,
                $driver_id,
                $weekday
            );
        }
    }

    /**
     * Create a Recipient-Route relationship
     */
    public function assign_recipient(Request $request)
    {
        $route_id = (int)$request->input('route_id');
        $recipient_id = (int)$request->input('recipient_id');
        $weekday = (int)$request->input('weekday');

        if (Settings::appIsLocked()) {
            SchedulePendingJob::dispatchSync(
                'recipient',
                'assign',
                $recipient_id,
                [$route_id, $weekday]
            );
        } else {
            $this->assignmentService->assign_recipient(
                $route_id,
                $recipient_id,
                $weekday
            );
        }
    }

    /**
     * Remove an existing Recipient-Route relationship
     */
    public function deassign_recipient(Request $request)
    {
        $route_id = (int)$request->input('route_id');
        $recipient_id = (int)$request->input('recipient_id');
        $weekday = (int)$request->input('weekday');

        if (Settings::appIsLocked()) {
            SchedulePendingJob::dispatchSync(
                'recipient',
                'deassign',
                $recipient_id,
                [$route_id, $weekday]
            );
        } else {
            $this->assignmentService->deassign_recipient(
                $route_id,
                $recipient_id,
                $weekday
            );
        }
    }

    public function reorder_recipient(Request $request)
    {
        $this->assignmentService->reorder_recipient(
            $request->input('route_id'),
            $request->input('recipient_id'),
            $request->input('weekday'),
            $request->input('new_index')
        );
    }
}
