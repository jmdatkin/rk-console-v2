<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditViewController extends Controller
{
    public function index(Request $request) {
        return Inertia::render('Admin/Audits',
        [
            'data' => Audit::with('user')->get()
        ]);
    }
}
