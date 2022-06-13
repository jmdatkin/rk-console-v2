<?php

namespace App\Http\Controllers;

use App\Report\UserProfileReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    //
    public function __construct(UserProfileReport $report) {
        $this->report = $report;
    }

    public function index() {
        return Inertia::render('UserProfile', 
        [
            "data" => $this->report->data()
        ]);
    }
}
