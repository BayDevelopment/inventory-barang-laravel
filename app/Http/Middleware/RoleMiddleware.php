<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // 1️⃣ Guest coba akses route yang butuh login (kecuali login page)
        if (!$user && ! $request->routeIs('page.login')) {
            return redirect()->route('page.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2️⃣ User sudah login tapi akun tidak aktif → logout paksa
        if ($user && !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('page.login')->with('error', 'Akun tidak aktif.');
        }

        // 3️⃣ Role tidak sesuai → redirect ke dashboard masing-masing
        if ($user && !empty($roles) && !in_array($user->role, $roles)) {
            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.dashboard');
        }

        // 4️⃣ Jika sudah login & akses halaman login → redirect ke dashboard
        if ($user && $request->routeIs('page.login')) {
            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}
