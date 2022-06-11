<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:people',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $person = Person::create([
            'email' => $request->email,
            'firstName' => $request->name,
        ]);

        $user = User::create([
            'person_id' => $person->id,
            // 'name' => $request->name,
            // 'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // $user = new User([
        //     'password' => Hash::make($request->password),
        // ]);

        // $user->person()->associate($person);
        // $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
