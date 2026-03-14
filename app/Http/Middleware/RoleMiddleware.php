<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Admin bisa akses semua
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Jika role tidak ada dalam daftar yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
