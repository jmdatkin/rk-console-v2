<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function handle(Request $request) {

        if (is_null(Auth::user()))
            return redirect()->route('login');

        if (Auth::user()->hasRole(Role::ADMIN))
            return redirect()->route('dashboard');

        else if (Auth::user()->hasRole(Role::DRIVER))
            return Inertia::render('Driver/DriverTools');

        else
            throw new AuthorizationException("User class not recognized.", 403);
    }
}
