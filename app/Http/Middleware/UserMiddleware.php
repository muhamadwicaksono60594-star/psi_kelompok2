<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 🔹 penting
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan role-nya user
        if (Auth::check() && Auth::user()->role === 'user') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Akses hanya untuk user!');
    }
}
