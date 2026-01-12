<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check user_type === 'admin' or allow user_type 'admin' string
        if (isset($user->user_type) && $user->user_type === 'admin') {
            return $next($request);
        }

        // fallback: deny access
        abort(403, 'Unauthorized.');
    }
}
