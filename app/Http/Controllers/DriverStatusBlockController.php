<?php

namespace App\Http\Controllers;

use App\Models\DriverStatusBlock;
use Illuminate\Http\Request;

class DriverStatusBlockController extends Controller
{
    //
    public function store(Request $request) {
        $request->whenHas(['driver_id','date_start','date_end'], function() use ($request) {
            DriverStatusBlock::create($request->only(['driver_id','date_start','date_end']));
        });
    }
}
