<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Events\UserPresenceUpdated;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view("customer.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (Auth::guard("customer")->attempt($credentials)) {
            $customer = Auth::guard("customer")->user();
            $customer->is_online = true;
            $customer->save();

            event(new UserPresenceUpdated($customer, 'online'));

            $request->session()->regenerate();

            return redirect()->intended(route("customer.dashboard"));
        }

        return back()->withErrors([
            "email" => "The provided credentials do not match our records.",
        ]);
    }

    public function showRegistrationForm()
    {
        return view("customer.register");
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:customers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_online' => true,
        ]);

        event(new UserPresenceUpdated($customer, 'online'));

        Auth::guard('customer')->login($customer);
        return redirect()->route('customer.dashboard');
    }

    public function logout(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->is_online = false;
            $customer->save();
            event(new UserPresenceUpdated($customer, 'offline'));
        }

        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }

    public function dashboard()
    {
        return view("customer.dashboard");
    }
}
