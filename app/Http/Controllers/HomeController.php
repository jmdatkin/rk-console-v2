<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function handle(Request $request) {
        if (Auth::user()->hasRole(Role::ADMIN))
            return redirect()->route('dashboard');

        else if (Auth::user()->hasRole(Role::DRIVER))
            return Inertia::render('DriverTools/Index');

        else
            // return response('U R not admin!! >:(');
            return response(Auth::user()->roles);
    }
}
