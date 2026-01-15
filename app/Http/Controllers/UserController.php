<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        return view('dashboard.index');
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'full_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
        ]);

        $user->fill($data);
        $user->save();

        return back()->with('success', 'Thông tin tài khoản đã được cập nhật.');
    }

    public function showChangePassword()
    {
        return view('dashboard.changepass');
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->input('current_password'), $user->password_hash)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->password_hash = Hash::make($request->input('new_password'));
        $user->save();

        // Re-login user to refresh session while keeping them logged in
        Auth::login($user);

        return redirect()->route('profile')->with('success', 'Mật khẩu đã được thay đổi.');
    }

    public function orders()
    {
        $orders = auth()->user()
            ->orders()
            ->latest()
            ->paginate(5);

        return view('dashboard.orders', compact('orders'));
    }
}
