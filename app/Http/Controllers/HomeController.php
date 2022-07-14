<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function handle(Request $request) {
        // if (Gate::allows('view-admin')) 
        if (is_null(Auth::user()))
            return;
        if (Auth::user()->hasRole(Role::ADMIN))
            return redirect()->route('dashboard');

        else if (Auth::user()->hasRole(Role::DRIVER))
            return Inertia::render('DriverTools/Index');

        else
            // return response('U R not admin!! >:(');
            return response(Auth::user()->roles);
    }
}
