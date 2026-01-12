<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);
        // Allow login by email or phone
        $user = User::where('email', $credentials['login'])
                    ->orWhere('phone_number', $credentials['login'])
                    ->first();

        // if (!$user || !Hash::check($credentials['password'], $user->password_hash)) {
        //     return back()->withErrors(['login' => 'The provided credentials do not match our records.'])->withInput();
        // }

        if (isset($user->is_active) && !$user->is_active) {
            return back()->withErrors(['email' => 'Your account is inactive.']);
        }

        Auth::login($user);

        // Regenerate session to prevent fixation
        $request->session()->regenerate();

        // Redirect based on user_type
        $type = $user->user_type ?? 'customer';
        if ($type === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
