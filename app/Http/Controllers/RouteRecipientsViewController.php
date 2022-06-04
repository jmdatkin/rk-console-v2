<?php

namespace App\Http\Controllers;

use App\Report\RouteRecipients;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RouteRecipientsViewController extends Controller
{
    //
    public function __construct(RouteRecipients $report) {
        $this->report = $report;
    }
    
    public function index() {
        return Inertia::render('RouteRecipients/Index');
    }

    public function data(Request $request) {
        $date = $request->input('date');
        return $this->report->data($date);
    }
}
