<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penyelenggara - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Sidebar mobile overlay */
        #sidebar-overlay {
            transition: opacity 0.3s ease;
        }
        #organizer-sidebar {
            transition: transform 0.3s ease;
        }
        @media (max-width: 767px) {
            #organizer-sidebar {
                transform: translateX(-100%);
                position: fixed;
                top: 0; left: 0;
                z-index: 50;
                height: 100vh;
            }
            #organizer-sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex min-h-screen">

    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/50 z-40 md:hidden"></div>

    <!-- Sidebar -->
    <aside id="organizer-sidebar" class="w-64 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen shadow-xl z-50">
        {{-- Close button (mobile only) --}}
        <button id="sidebar-close" class="md:hidden absolute top-4 right-4 p-1.5 rounded-lg bg-indigo-800 hover:bg-indigo-700 transition">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-black text-xl shadow-md">
                AH
            </div>
            <div>
                <span class="text-lg font-black text-white block leading-tight">Hub Organizer</span>
                <span class="text-[10px] bg-indigo-700/50 text-indigo-300 px-2 py-0.5 rounded-full font-semibold uppercase tracking-wider">Organizer</span>
            </div>
        </div>

        <nav class="flex-1 space-y-2">
            <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-4 px-2">Menu Utama</p>

            <a href="{{ route('organizer.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Dashboard Ringkasan
            </a>

            <a href="{{ route('organizer.events.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.events.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Kelola Event Saya
            </a>

            <a href="{{ route('organizer.transactions.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.transactions.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                Laporan Pendapatan
            </a>
        </nav>

        {{-- Keluar / Ke Publik --}}
        <div class="pt-6 border-t border-indigo-800 space-y-2">
            <form action="{{ route('user.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 text-indigo-300 hover:text-white transition font-bold text-left text-sm">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 min-w-0 overflow-y-auto">

        {{-- Mobile Top Bar --}}
        <div class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-slate-100 shadow-sm sticky top-0 z-30">
            <button id="sidebar-open" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black text-sm">AH</div>
                <span class="font-black text-slate-800 text-sm">Hub Organizer</span>
            </div>
            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>

        <div class="p-4 sm:p-6 md:p-10">
            {{-- Header Info --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-slate-800">
                        @yield('page_title', 'Ringkasan Dashboard')
                    </h2>
                    <p class="text-slate-400 font-medium text-sm mt-1">Organisasi: <span
                            class="text-indigo-600 font-bold">{{ auth()->user()->organization->name ?? '-' }}</span></p>
                </div>

                <div class="hidden md:flex items-center gap-3 bg-white px-4 py-2.5 rounded-2xl border border-slate-100 shadow-sm">
                    <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Logged in as</p>
                        <p class="text-sm font-black text-slate-700">{{ auth()->user()->name }}</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-100 text-emerald-800 p-4 rounded-2xl mb-6 font-bold text-sm shadow-sm flex items-center gap-2">
                    <span>✓</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-100 text-rose-800 p-4 rounded-2xl mb-6 font-bold text-sm shadow-sm flex items-center gap-2">
                    <span>✗</span> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        const sidebarEl   = document.getElementById('organizer-sidebar');
        const overlay     = document.getElementById('sidebar-overlay');
        const openBtn     = document.getElementById('sidebar-open');
        const closeBtn    = document.getElementById('sidebar-close');

        function openSidebar() {
            sidebarEl.classList.add('open');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            sidebarEl.classList.remove('open');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        openBtn && openBtn.addEventListener('click', openSidebar);
        closeBtn && closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);
    </script>

</body>

</html>