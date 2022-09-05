<?php

namespace App\Http\Controllers;

use App\Services\AssignmentService;
use Illuminate\Http\Request;

class DriverSubController extends Controller
{
    //
    public function __construct(AssignmentService $assignmentService) {
        $this->assignmentService = $assignmentService;
    }

    public function store(Request $request)
    {
        $this->assignmentService->assign_driver_sub(
            $request->input('route_id'),
            $request->input('driver_id'),
            $request->input('sub_driver_id'),
            $request->input('date'),
        );
    }
}
