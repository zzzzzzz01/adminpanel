<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Foydalanuvchi kirmagan bo'lsa
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Foydalanuvchi o'qituvchi emas bo'lsa
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Sahifaga kirish taqiqlangana');
        }

        return $next($request);
    }
}
