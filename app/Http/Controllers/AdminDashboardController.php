<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    //
    public function index()
    {
        $data = [
            'title' => 'Dashboard | Inventory Barang',
            'navlink' => 'Dashboard',
        ];

        return view('admin.dashboard', $data);
    }

    public function Settings()
    {
        $data = [
            'title' => 'Pengaturan | Inventory Barang',
            'navlink' => 'Pengaturan',
        ];

        return view('settings.page-pengaturan-all', $data);
    }
    public function settingsProfileAksi(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();


        // Validasi input
        $validated = $request->validate(
            [
                'name'  => ['required', 'string', 'max:50'],
                'email' => ['required', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            ],
            [
                'name.required'  => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Format email tidak valid.',
                'email.unique'   => 'Email sudah digunakan.',
            ]
        );

        // Jika email diganti, reset verifikasi
        if ($request->email !== $user->email) {
            $user->email_verified_at = null;
        }

        // Update user
        $user->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function settingsPasswordAksi(Request $request)
{
    /** @var User $user */
    $user = Auth::user();

    // Validasi input
    $validated = $request->validate(
        [
            'current_password'      => ['required'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'], // confirmed = harus ada field password_confirmation
        ],
        [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password minimal 8 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak sama.',
        ]
    );

    // Cek password lama
    if (!Hash::check($validated['current_password'], $user->password)) {
        return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
    }

    // Update password
    $user->password = Hash::make($validated['password']);
    $user->save();

    return redirect()->back()->with('success', 'Password berhasil diperbarui.');
}
}
