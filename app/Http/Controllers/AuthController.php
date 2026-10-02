<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLogin()
    {
        // Kalau sudah login, tidak perlu lihat form login lagi
        if (Auth::check()) {
            return redirect()->route('admin.publikasi.index');
        }

        return view('auth.login');
    }

    /**
     * Memproses percobaan login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Auth::attempt otomatis membandingkan password dengan hash di database
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Wajib: mencegah session fixation attack
            $request->session()->regenerate();

            // intended() = kembali ke halaman yang tadi dituju sebelum ditendang ke login
            return redirect()->intended(route('admin.publikasi.index'));
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah logout.');
    }
}