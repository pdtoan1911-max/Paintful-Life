<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
            } else {
                $cart = session('cart', []);
                // session cart can be [product_id => quantity] or array of ['product_id'=>..,'quantity'=>..]
                if (is_array($cart)) {
                    $sum = 0;
                    foreach ($cart as $k => $v) {
                        if (is_array($v) && isset($v['quantity'])) {
                            $sum += (int) $v['quantity'];
                        } else {
                            $sum += (int) $v;
                        }
                    }
                    $cartCount = $sum;
                }
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
