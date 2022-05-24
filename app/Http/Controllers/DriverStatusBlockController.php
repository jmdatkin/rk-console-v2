<?php

namespace App\Http\Controllers;

use App\Models\DriverStatusBlock;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverStatusBlockController extends Controller
{
    //
    public function index() {
        return Inertia::render('DriverStatus');
    }

    public function store(Request $request) {
        $request->whenHas(['driver_id','date_start','date_end'], function() use ($request) {
            DriverStatusBlock::create($request->only(['driver_id','date_start','date_end']));
        });
    }
}
