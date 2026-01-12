<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:15',
        ]);

        // Create the user
        $user = \App\Models\User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password_hash' => \Illuminate\Support\Facades\Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'user_type' => 'customer',
            'is_active' => true,
        ]);

        // Log the user in
        Auth::login($user);
        $request->session()->regenerate();
        // Redirect to dashboard or intended page
        return redirect()->intended('dashboard');
    }
}
