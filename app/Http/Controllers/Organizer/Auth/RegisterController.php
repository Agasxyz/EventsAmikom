<?php

namespace App\Http\Controllers\Organizer\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            $org = Auth::user()->organization;
            if ($org && $org->status === 'active') {
                return redirect('/organizer/dashboard');
            }
        }
        return view('organizer.auth.register');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            // User sudah login, hanya buat organisasi
            $request->validate([
                'org_name'  => 'required|string|max:255',
                'org_email' => 'required|email|max:255|unique:organizations,email',
                'org_phone' => 'nullable|string|max:20',
                'org_desc'  => 'nullable|string',
            ]);

            $user = Auth::user();
            
            // Ubah role user menjadi organizer
            $user->update(['role' => 'organizer']);

            Organization::create([
                'user_id'     => $user->id,
                'name'        => $request->org_name,
                'slug'        => Str::slug($request->org_name) . '-' . time(),
                'email'       => $request->org_email,
                'phone'       => $request->org_phone,
                'description' => $request->org_desc,
                'status'      => 'pending', // Menunggu approval superadmin
            ]);

            return redirect()->route('organizer.register')
                ->with('success', 'Pendaftaran organisasi berhasil dikirim! Menunggu persetujuan Superadmin.');
        } else {
            // User belum login, buat user baru dan organisasi baru menggunakan informasi organisasi langsung
            $request->validate([
                'org_name'  => 'required|string|max:255',
                'org_email' => 'required|email|max:255|unique:users,email|unique:organizations,email',
                'password'  => 'required|string|min:8|confirmed',
                'org_phone' => 'nullable|string|max:20',
                'org_desc'  => 'nullable|string',
            ]);

            $user = User::create([
                'name'     => $request->org_name,
                'email'    => $request->org_email,
                'password' => Hash::make($request->password),
                'role'     => 'organizer',
            ]);

            Organization::create([
                'user_id'     => $user->id,
                'name'        => $request->org_name,
                'slug'        => Str::slug($request->org_name) . '-' . time(),
                'email'       => $request->org_email,
                'phone'       => $request->org_phone,
                'description' => $request->org_desc,
                'status'      => 'pending',
            ]);

            Auth::login($user);

            return redirect()->route('organizer.register')
                ->with('success', 'Registrasi berhasil! Organisasi Anda saat ini berstatus PENDING menunggu persetujuan Superadmin.');
        }
    }
}
