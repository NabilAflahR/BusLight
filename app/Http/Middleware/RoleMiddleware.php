<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== $role) {
            // Jika bukan role yang sesuai, arahkan ke dashboard sesuai role
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/user/dashboard');
        }

        return $next($request);
    }
}
