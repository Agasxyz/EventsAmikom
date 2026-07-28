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
            overflow-x: hidden;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
        /* Mobile menu slide-in */
        #mobile-menu {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        #mobile-menu.hidden {
            transform: translateY(-10px);
            opacity: 0;
            pointer-events: none;
        }
        #mobile-menu.open {
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    <!-- Navigation -->
    <nav class="glass sticky top-4 z-40 mx-4 mt-4 px-4 sm:px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex justify-between items-center">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                AH
            </div>
            <span class="text-lg font-bold tracking-tight">AmikomEventHub</span>
        </a>

        {{-- Desktop Nav Links + Auth (grouped right) --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}#events" class="font-medium hover:text-indigo-600 transition">Jelajahi</a>
            <a href="{{ route('categories') }}" class="font-medium hover:text-indigo-600 transition">Kategori</a>
            <a href="{{ route('about') }}" class="font-medium hover:text-indigo-600 transition">Tentang Kami</a>

            <div class="flex items-center gap-3">
            @auth
                <div class="flex items-center gap-3">
                    @if(auth()->user()->isOrganizer() && auth()->user()->organization && auth()->user()->organization->status === 'active')
                        <a href="{{ route('organizer.dashboard') }}" class="px-4 py-2 text-sm bg-indigo-100 text-indigo-700 rounded-xl font-bold hover:bg-indigo-200 transition">
                            Dashboard Partner
                        </a>
                    @endif
                    <div class="flex items-center gap-2 px-3 py-2 bg-indigo-50 rounded-xl">
                        <div class="w-7 h-7 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-semibold text-slate-700 max-w-[100px] truncate">
                            {{ auth()->user()->name }}
                        </span>
                    </div>
                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition border border-slate-200">
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('user.login') }}" class="px-5 py-2 bg-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all duration-200">
                    Login
                </a>
            @endauth
            </div>{{-- end auth --}}
        </div>{{-- end right group --}}

        {{-- Mobile: Right side (avatar or login + hamburger) --}}
        <div class="flex md:hidden items-center gap-2">
            @auth
                <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @else
                <a href="{{ route('user.login') }}" class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold">
                    Login
                </a>
            @endauth

            {{-- Hamburger --}}
            <button id="hamburger-btn" class="p-2 rounded-xl hover:bg-slate-100 transition" aria-label="Toggle menu">
                <svg id="icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </nav>

    {{-- Mobile Dropdown Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-100 shadow-lg z-30 px-4 py-4 space-y-1">
        <a href="{{ route('home') }}#events" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
            🎯 Jelajahi Event
        </a>
        <a href="{{ route('categories') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
            📂 Kategori
        </a>
        <a href="{{ route('about') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
            ℹ️ Tentang Kami
        </a>

        @auth
            <div class="border-t border-slate-100 mt-2 pt-2 space-y-1">
                <div class="flex items-center gap-3 px-4 py-2">
                    <div class="w-9 h-9 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                @if(auth()->user()->isOrganizer() && auth()->user()->organization && auth()->user()->organization->status === 'active')
                    <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition">
                        🏠 Dashboard Partner
                    </a>
                @endif
                <form method="POST" action="{{ route('user.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-rose-600 hover:bg-rose-50 transition text-left">
                        🚪 Keluar
                    </button>
                </form>
            </div>
        @endauth
    </div>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-indigo-900 text-indigo-100 py-16 px-6 mt-16">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-5 gap-8 md:gap-12">
            <div class="space-y-4 col-span-2">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
                    <span class="text-xl font-bold text-white">AmikomEventHub</span>
                </div>
                <p class="max-w-xs text-indigo-300 text-sm">Platform reservasi tiket event online terbaik untuk mahasiswa dan penyelenggara profesional.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Kategori</h4>
                <ul class="space-y-3 text-sm">
                    @foreach ($categories as $cat)
                    <li><a href="/?category={{ $cat->slug }}" class="hover:text-white transition"> {{ $cat->name }} </a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Navigasi</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                    <li><a href="{{ route('categories') }}" class="hover:text-white transition">Kategori</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm">
                    <li>support@eventtiket.com</li>
                    <li>+62 812 3456 7890</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto pt-10 mt-10 border-t border-indigo-800 text-center text-indigo-400 text-sm">
            &copy; 2024 AmikomEventHub. Built with Laravel & Tailwind CSS.
        </div>
    </footer>

    <script>
        const btn = document.getElementById('hamburger-btn');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        btn.addEventListener('click', () => {
            const isOpen = menu.classList.contains('open');
            if (isOpen) {
                menu.classList.remove('open');
                menu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            } else {
                menu.classList.remove('hidden');
                menu.classList.add('open');
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
            }
        });
    </script>

</body>

</html>