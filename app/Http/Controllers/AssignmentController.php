<?php

namespace App\Http\Controllers;

use App\Models\DriverRoute;
use App\Models\RecipientRoute;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
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
        $data = $request->only(['route_id', 'recipient_id', 'weekday']);
        $index = RecipientRoute::getNextOrderingIndex($data['route_id'], $data['weekday']);
        RecipientRoute::upsert($data, ['route_id', 'weekday', 'driver_id']);
    }

    /**
     * Remove an existing Recipient-Route relationship
     */
    public function deassign_recipient(Request $request)
    {
        $data = $request->only(['route_id', 'recipient_id', 'weekday']);
        RecipientRoute::where($data)->delete();
    }
}
