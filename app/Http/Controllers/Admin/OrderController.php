<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(\App\Models\Order $order)
    {
        $order->load('orderItems.product');
        return view('admin.orders.show', compact('order'));
    }

    public function confirm(\App\Models\Order $order)
    {
        $order->order_status = 'confirmed';
        $order->save();
        return redirect()->back()->with('success', 'Order confirmed.');
    }

    public function cancel(\App\Models\Order $order)
    {
        $order->order_status = 'cancelled';
        $order->save();
        return redirect()->back()->with('success', 'Order cancelled.');
    }
}
