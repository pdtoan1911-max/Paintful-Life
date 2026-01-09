<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $items = [];

        if (Auth::check()) {
            $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
            foreach ($cartItems as $ci) {
                $items[] = ['product' => $ci->product, 'quantity' => $ci->quantity, 'cart_item_id' => $ci->cart_item_id];
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

        return view('cart', compact('items'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|integer', 'quantity' => 'nullable|integer']);
        $productId = (int) $request->input('product_id');
        $qty = max(1, (int) $request->input('quantity', 1));

        if (Auth::check()) {
            $item = CartItem::where('user_id', Auth::id())->where('product_id', $productId)->first();
            if ($item) {
                $item->quantity += $qty;
                $item->save();
            } else {
                CartItem::create(['user_id' => Auth::id(), 'product_id' => $productId, 'quantity' => $qty, 'added_at' => now()]);
            }
            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId] = $cart[$productId] + $qty;
            } else {
                $cart[$productId] = $qty;
            }
            session(['cart' => $cart]);
            $cartCount = array_sum($cart);
        }

        return response()->json(['cartCount' => $cartCount]);
    }

    public function update(Request $request)
    {
        $request->validate(['product_id' => 'required|integer', 'quantity' => 'required|integer|min:0']);
        $productId = (int) $request->input('product_id');
        $qty = (int) $request->input('quantity');

        if (Auth::check()) {
            $item = CartItem::where('user_id', Auth::id())->where('product_id', $productId)->first();
            if ($item) {
                if ($qty <= 0) {
                    $item->delete();
                } else {
                    $item->quantity = $qty;
                    $item->save();
                }
            }
            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session('cart', []);
            if ($qty <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId] = $qty;
            }
            session(['cart' => $cart]);
            $cartCount = array_sum($cart);
        }

        return response()->json(['cartCount' => $cartCount]);
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required|integer']);
        $productId = (int) $request->input('product_id');

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->where('product_id', $productId)->delete();
            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session('cart', []);
            unset($cart[$productId]);
            session(['cart' => $cart]);
            $cartCount = array_sum($cart);
        }

        return response()->json(['cartCount' => $cartCount]);
    }
}
