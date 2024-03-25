<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\CurrencyType;
use App\Models\Position;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'positions' => Position::whereNot('id', 1)->get(),
            'roles' => tenant() ? Role::whereNot('id', 1)->get() : Role::where('id', 1)->get(),
            'businesses' => tenant() ? Business::get() : [],
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', 'min:8'], //Rules\Password::defaults()
            'address' => 'required|string',
            'phone' => 'required',
            'position_id' => 'required',
            'role_id' => 'required',
            'business_id' => tenant() ? 'required' : '',
        ],[
            'password.confirmed' => 'Confirmation does not match.',
            'password.min' => 'Must be at least :min characters.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'position_id' => $request->position_id,
            'role_id' => 2, //user
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return redirect(RouteServiceProvider::HOME)->with('register_success', 'You have successfully registered! Please wait for admin approval.');
    }
}
