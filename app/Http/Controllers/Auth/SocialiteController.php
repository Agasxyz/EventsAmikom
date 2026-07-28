<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect pengguna ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Terima callback dari Google dan proses login/registrasi otomatis.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('user.login')
                ->with('error', 'Login Google gagal. Silakan coba lagi.');
        }

        // Cari user yang sudah pernah login via Google
        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            // Coba cari berdasarkan email (user mungkin punya akun lama)
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Update user yang sudah ada dengan google_id
                $user->update(['google_id' => $googleUser->id]);
            } else {
                // Buat user baru dari data Google
                $user = User::create([
                    'name'       => $googleUser->name,
                    'email'      => $googleUser->email,
                    'google_id'  => $googleUser->id,
                    'password'   => null,
                    'role'       => 'user',
                ]);
            }
        }

        // Login user (remember session)
        Auth::login($user, true);

        // Redirect ke halaman yang dimaksud atau ke home
        $intended = session()->pull('url.intended', route('home'));
        return redirect($intended);
    }
}
