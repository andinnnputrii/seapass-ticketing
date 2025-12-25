<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session; // ✅ TAMBAHKAN INI (Import Facade)
use App\Models\Admin;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan splash screen
     */
    public function splash()
    {
        return view('auth.splash');
    }

    /**
     * Tampilkan form login
     */
    public function showLogin()
    {
        // Jika sudah login, redirect ke dashboard admin
        // PERBAIKAN: Gunakan Facade Session::has() agar VS Code tidak error 'null object'
        if (Session::has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        // Cari admin berdasarkan username dan status active
        $admin = Admin::where('username', $request->username)
                      ->where('status', 'active')
                      ->first();

        // Cek password
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Update last login
            $admin->update(['last_login' => now()]);

            // Simpan session
            session([
                'admin_id' => $admin->id,          // Kunci utama untuk middleware
                'admin_username' => $admin->username,
                'admin_name' => $admin->name,      // Opsional: nama lengkap/role
                'admin_role' => $admin->role ?? 'admin', // Opsional: jika ada role
            ]);

            return redirect()->route('admin.dashboard');
        }

        // Jika gagal
        return back()
            ->withInput($request->only('username'))
            ->withErrors(['login' => 'Username atau password salah / akun tidak aktif']);
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        // Hapus semua session
        $request->session()->flush();

        // Redirect ke halaman login
        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
