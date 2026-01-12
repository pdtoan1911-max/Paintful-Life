<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with simple stats.
     */
    public function index(Request $request)
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount') ?? 0;
        $ordersToday = Order::whereDate('created_at', now()->toDateString())->count();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue', 'ordersToday'));
    }
}
