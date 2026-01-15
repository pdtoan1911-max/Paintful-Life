<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $items = [];
        if ($user) {
            $cartItems = CartItem::with('product')->where('user_id', $user->user_id)->get();
            foreach ($cartItems as $ci) {
                $items[] = ['product' => $ci->product, 'quantity' => $ci->quantity];
            }
        } else {
            $sessionCart = session('cart', []);
            $ids = array_keys($sessionCart);
            if (!empty($ids)) {
                $products = Product::whereIn('product_id', $ids)->get()->keyBy('product_id');
                foreach ($sessionCart as $pid => $qty) {
                    $product = $products->get($pid);
                    if ($product) {
                        $items[] = ['product' => $product, 'quantity' => $qty];
                    }
                }
            }
        }

        return view('checkout', compact('user', 'items'));
    }

    public function place(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'phone_number' => 'required|string',
            'shipping_address' => 'required|string',
            'city' => 'required|string'
        ]);

        $user = Auth::user();

        $items = [];
        if ($user) {
            $cartItems = CartItem::with('product')->where('user_id', $user->user_id)->get();
            foreach ($cartItems as $ci) {
                $items[] = ['product' => $ci->product, 'quantity' => $ci->quantity];
            }
        } else {
            $sessionCart = session('cart', []);
            $ids = array_keys($sessionCart);
            if (!empty($ids)) {
                $products = Product::whereIn('product_id', $ids)->get()->keyBy('product_id');
                foreach ($sessionCart as $pid => $qty) {
                    $product = $products->get($pid);
                    if ($product) {
                        $items[] = ['product' => $product, 'quantity' => $qty];
                    }
                }
            }
        }

        $subtotal = 0;
        foreach ($items as $it) {
            $subtotal += ($it['product']->price * $it['quantity']);
        }

        $shippingFee = 0; // COD default
        $total = $subtotal + $shippingFee;

        $order = Order::create([
            'user_id' => $user ? $user->user_id : 1,
            'order_code' => 'ORD' . time(),
            'customer_name' => $request->input('customer_name'),
            'phone_number' => $request->input('phone_number'),
            'shipping_address' => $request->input('shipping_address'),
            'city' => $request->input('city'),
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total_amount' => $total,
            'payment_method' => 'COD',
            'payment_status' => 'pending',
            'order_status' => 'new',
            'note' => $request->input('note')
        ]);

        foreach ($items as $it) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $it['product']->product_id,
                'quantity' => $it['quantity'],
                'unit_price' => $it['product']->price,
                'total_price' => $it['product']->price * $it['quantity']
            ]);
        }

        // Clear cart
        if ($user) {
            CartItem::where('user_id', $user->user_id)->delete();
        } else {
            session()->forget('cart');
        }

        return view('checkout')->with('success', true)->with('order', $order);
    }
}
