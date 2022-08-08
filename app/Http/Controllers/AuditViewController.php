<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditViewController extends Controller
{
    //
    public function index(Request $request) {
        // dd(Audit::get()->load('user'));
        return Inertia::render('Admin/Audits',
        [
            // 'data' => Audit::all()->flatMap(fn ($a) => $a->separateAttributes())
            // 'data' => Audit::all()->map(fn ($a) => $a->separateAttributes())
            'data' => Audit::with('user')->get()
            // 'data' => 'hi'
        ]);
    }
}
