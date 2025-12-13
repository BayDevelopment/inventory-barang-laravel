<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function PageLogin()
    {
        $data = [
            'title' => 'Login | Inventory Barang',
        ];

        return view('auth.auth', $data);
    }

    public function AksiLogin(Request $request)
    {
        // 1. VALIDATION (Laravel style)
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. AUTH ATTEMPT + REMEMBER ME
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            // 3. CEK AKUN AKTIF
            if (! Auth::user()->is_active) {
                Auth::logout();

                return redirect('/auth/login')
                    ->with('error', 'Akun Anda tidak aktif.')
                    ->onlyInput('email');
            }

            // 4. REGENERATE SESSION
            $request->session()->regenerate();

            // 5. REDIRECT SESUAI ROLE
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.dashboard');
        }

        // 6. LOGIN GAGAL
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }
}
