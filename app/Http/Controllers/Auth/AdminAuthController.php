<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        // Jika sudah login, redirect ke dashboard
        if (session()->has('admin_id')) {
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

        // Cari admin berdasarkan username
        $admin = Admin::where('username', $request->username)
                     ->where('status', 'active')
                     ->first();

        // Cek password
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Update last login
            $admin->update(['last_login' => now()]);

            // Simpan session dengan KEY yang BENAR
        session([
            'admin_id' => $admin->id,              // ✅ TAMBAHKAN INI (yang dicek middleware)
            'admin_username' => $admin->username,  // ✅ Tetap simpan untuk keperluan lain
            'admin_name' => $admin->name,          // ✅ Untuk tampilan di navbar
            'admin_email' => $admin->email,        // ✅ Optional
        ]);

            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['login' => 'Username atau password salah']);
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}