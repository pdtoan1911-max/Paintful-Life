<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::where('user_type', 'customer')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(\App\Models\User $user)
    {
        $user->load('orders');
        return view('admin.users.show', compact('user'));
    }

    public function toggle(\App\Models\User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'User status updated.');
    }

    public function destroy(\App\Models\User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted.');
    }
}
