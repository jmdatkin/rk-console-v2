<?php

namespace App\Http\Controllers;

use App\Carbon\RkCarbon;
use App\Models\DriverSub;
use Illuminate\Http\Request;

class DriverSubController extends Controller
{
    //

    public function store(Request $request)
    {
        $input = $request->only(['driver_id', 'sub_driver_id', 'date', 'route_id']);

        $driver_sub = DriverSub::where($request->only(['driver_id', 'date', 'route_id']))->first();

        if (!isset($driver_sub)) {
            $driver_sub = new DriverSub();
        }

        $driver_sub->route_id = $input['route_id'];
        $driver_sub->driver_id = $input['driver_id'];
        $driver_sub->date = RkCarbon::parse($input['date']);
        $driver_sub->sub_driver_id = $input['sub_driver_id'];

        $driver_sub->save();
    }
}
