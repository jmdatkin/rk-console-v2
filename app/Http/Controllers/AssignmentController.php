<?php

namespace App\Http\Controllers;

use App\Models\DriverRoute;
use App\Models\RecipientRoute;
use App\Services\AssignmentService;
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
        $data = $request->only(['route_id', 'driver_id', 'weekday']);

        $driver_route = DriverRoute::where($request->only(['route_id', 'weekday']))->first();

        if (isset($driver_route))
            $driver_route->driver_id = $request->input('driver_id');

        else
            $driver_route = new DriverRoute($data);

        $driver_route->save();
        // DriverRoute::upsert($data, ['route_id','weekday','driver_id']);
    }

    /**
     * Remove an existing Driver-Route relationship
     */
    public function deassign_driver(Request $request)
    {
        $data = $request->only(['route_id', 'driver_id', 'weekday']);
        DriverRoute::where($data)->delete();
    }

    /**
     * Create a Recipient-Route relationship
     */
    public function assign_recipient(Request $request)
    {
        // $data = $request->only(['route_id', 'recipient_id', 'weekday']);
        // $nextIndex = RecipientRoute::getNextOrderingIndex($data['route_id'], $data['weekday']);
        // // dd($nextIndex);
        // RecipientRoute::upsert(
        //     array_merge($data, ['driver_custom_order' => $nextIndex]),
        //     ['route_id', 'weekday', 'recipient_id']
        // );
        $this->assignmentService->assign_recipient(
            $request->input('route_id'),
            $request->input('recipient_id'),
            $request->input('weekday')
        );
    }

    /**
     * Remove an existing Recipient-Route relationship
     */
    public function deassign_recipient(Request $request)
    {
        // $data = $request->only(['route_id', 'recipient_id', 'weekday']);
        // RecipientRoute::where($data)->delete();
        $this->assignmentService->deassign_recipient(
            $request->input('route_id'),
            $request->input('recipient_id'),
            $request->input('weekday')
        );
    }

    public function reorder_recipient(Request $request) {
        $this->assignmentService->reorder_recipient(
            $request->input('route_id'),
            $request->input('recipient_id'),
            $request->input('weekday'),
            $request->input('new_index')
        );
    }
}
