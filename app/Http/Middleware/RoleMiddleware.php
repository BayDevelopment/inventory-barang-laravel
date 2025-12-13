<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('auth/login');
        }

        if (! $user->is_active) {
            Auth::logout();

            return redirect('/auth/login')->with('error', 'Akun tidak aktif.');
        }

        // if (! in_array($user->role, $roles)) {
        //     abort(403, 'Akses ditolak.');
        // }
        // role tidak sesuai → lempar ke dashboard masing-masing
        if (! in_array($user->role, $roles)) {
            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}
