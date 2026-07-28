<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AmikomEventHub</title>
    <meta name="description" content="Masuk ke AmikomEventHub untuk memesan tiket event impianmu.">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .google-btn {
            transition: all 0.2s ease;
        }
        .google-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-indigo-900 text-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-white text-slate-900 rounded-[2rem] p-8 shadow-2xl">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">
                AH
            </div>
            <h1 class="text-2xl font-black">Masuk</h1>
            <p class="text-slate-500">AmikomEventHub — Pesan tiket impianmu</p>
        </div>

        {{-- Flash Messages --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-600 p-4 rounded-xl mb-6 font-bold text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        @error('email')
            <div class="bg-red-100 text-red-600 p-4 rounded-xl mb-6 font-bold text-sm text-center">
                {{ $message }}
            </div>
        @enderror


        {{-- ── Form Email & Password ── --}}
        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                    placeholder="email@example.com"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                    placeholder="••••••••"
                    required
                >
            </div>

            <button
                type="submit"
                class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition"
            >
                Masuk
            </button>
        </form>

        {{-- Divider --}}
        <div class="flex items-center gap-4 mt-6">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span class="text-slate-400 text-sm font-medium">atau</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        {{-- ── Tombol Google SSO ── --}}
        <a href="{{ route('auth.google') }}"
            id="btn-google-login"
            class="google-btn mt-4 w-full flex items-center justify-center gap-3 py-3.5 px-5 bg-white border-2 border-slate-200 text-slate-700 rounded-2xl font-bold text-base hover:border-indigo-400 hover:text-indigo-700">

            {{-- Google Logo --}}
            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>

            Continue with Google
        </a>

        {{-- Back to home --}}
        <div class="text-center mt-6 space-y-3">
            <div>
                <span class="text-sm text-slate-400 font-medium">Belum punya akun?</span>
                <a href="{{ route('user.register') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-bold ml-1 transition">
                    Daftar sekarang
                </a>
            </div>
            <div>
                <span class="text-sm text-slate-400 font-medium">Ingin menyelenggarakan event?</span>
                <a href="{{ route('organizer.register') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-bold ml-1 transition">
                    Daftar Penyelenggara
                </a>
            </div>
            <div>
                <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-indigo-600 transition font-medium">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>

</body>
</html>
