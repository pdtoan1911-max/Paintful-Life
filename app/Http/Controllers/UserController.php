<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return view('dashboard.index');
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
