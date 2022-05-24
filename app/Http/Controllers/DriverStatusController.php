<?php

namespace App\Http\Controllers;

use App\Models\DriverStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverStatusController extends Controller
{
    //
    public function index() {
        return Inertia::render('DriverStatus');
    }

    public function store(Request $request) {
        $request->whenHas(['driver_id','date_start','date_end'], function() use ($request) {
            DriverStatus::create($request->only(['driver_id','date_start','date_end']));
        });
    }
}
