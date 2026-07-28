<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login user publik.
     */
    public function showLogin()
    {
        // Jika sudah login, arahkan ke home
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.user-login');
    }

    /**
     * Proses logout user publik.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Anda berhasil keluar.');
    }
}
