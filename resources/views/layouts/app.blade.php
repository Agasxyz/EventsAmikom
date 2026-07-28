<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmikomEventHub - Temukan Event Seru!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    <!-- Navigation -->
    <nav
        class="glass sticky top-8 z-40 mx-4 mt-4 px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex justify-between items-center">
        {{-- Logo --}}
        <div class="flex items-center gap-2">
            <div
                class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                AH</div>
            <span class="text-xl font-bold tracking-tight">AmikomEventHub</span>
        </div>

        {{-- Nav Links + Tombol Login (semua di kanan) --}}
        <div class="flex items-center gap-8">
            <div class="hidden md:flex gap-8 font-medium items-center">
                <a href="{{ route('home') }}#events" class="hover:text-indigo-600 transition">Jelajahi</a>
                <a href="{{ route('categories') }}" class="hover:text-indigo-600 transition">Kategori</a>
                <a href="{{ route('about') }}" class="hover:text-indigo-600 transition">Tentang Kami</a>
            </div>

            @auth
                {{-- User sudah login --}}
                <div class="flex items-center gap-3">
                    @if(auth()->user()->isOrganizer() && auth()->user()->organization && auth()->user()->organization->status === 'active')
                        <a href="{{ route('organizer.dashboard') }}" class="px-4 py-2 text-sm bg-indigo-100 text-indigo-700 rounded-xl font-bold hover:bg-indigo-200 transition">
                            Dashboard Partner
                        </a>
                    @endif

                    <div class="flex items-center gap-2 px-4 py-2 bg-indigo-50 rounded-xl">
                        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-semibold text-slate-700 max-w-[120px] truncate">
                            {{ auth()->user()->name }}
                        </span>
                    </div>
                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 text-sm rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition border border-slate-200">
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                {{-- Guest / belum login --}}
                <a href="{{ route('user.login') }}"
                    class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:scale-105 transition-all duration-200">
                    Login
                </a>
            @endauth
        </div>
    </nav>


    @yield('content')
    
    <!-- Footer -->
    <footer class="bg-indigo-900 text-indigo-100 py-20 px-6 mt-20">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-12">
            <div class="space-y-4 col-span-2">
                <div class="flex items-center gap-2">
                    <div
                        class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">
                        AH</div>
                    <span class="text-2xl font-bold text-white">AmikomEventHub</span>
                </div>
                <p class="max-w-xs text-indigo-300">Platform reservasi tiket event online terbaik untuk mahasiswa dan
                    penyelenggara profesional.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6">Kategori</h4>
                <ul class="space-y-4">
                    @foreach ($categories as $cat)
                    <li><a href="/?category={{ $cat->slug }}" class="hover:text-white transition"> {{ $cat->name }} </a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6">Navigasi</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                    <li><a href="{{ route('categories') }}" class="hover:text-white transition">Kategori</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6">Hubungi Kami</h4>
                <ul class="space-y-4">
                    <li>support@eventtiket.com</li>
                    <li>+62 812 3456 7890</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto pt-12 mt-12 border-t border-indigo-800 text-center text-indigo-400 text-sm">
            &copy; 2024 AmikomEventHub. Built with Laravel & Tailwind CSS.
        </div>
    </footer>

</body>

</html>