<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        #admin-sidebar {
            transition: transform 0.3s ease;
        }
        @media (max-width: 767px) {
            #admin-sidebar {
                transform: translateX(-100%);
                position: fixed;
                top: 0; left: 0;
                z-index: 50;
                height: 100vh;
            }
            #admin-sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex min-h-screen">

    {{-- Mobile Overlay --}}
    <div id="admin-overlay" class="hidden fixed inset-0 bg-black/50 z-40 md:hidden"></div>

    <!-- Sidebar -->
    <aside id="admin-sidebar" class="w-64 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen shadow-xl z-50">

        {{-- Close button (mobile only) --}}
        <button id="admin-sidebar-close" class="md:hidden absolute top-4 right-4 p-1.5 rounded-lg bg-indigo-800 hover:bg-indigo-700 transition">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
            <span class="text-xl font-bold text-white tracking-tight">AmikomEventHub</span>
        </div>

        <nav class="flex-1 space-y-2">
            <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-4 px-2">Main Menu</p>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-300' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.events.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.events.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.events.*') ? 'text-indigo-300' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Kelola Event
            </a>

            <a href="{{ url('/admin/partners') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->is('admin/partners*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                <svg class="w-5 h-5 {{ request()->is('admin/partners*') ? 'text-indigo-300' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5-2.236M9 20H4v-2a3 3 0 015-2.236m6-3.764a4 4 0 10-8 0 4 4 0 008 0z"></path>
                </svg>
                Kelola Partner
            </a>

            <a href="{{ route('admin.organizations.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.organizations.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.organizations.*') ? 'text-indigo-300' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Kelola Penyelenggara
            </a>

            <a href="{{ url('/admin/categories') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->is('admin/categories*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                <svg class="w-5 h-5 {{ request()->is('admin/categories*') ? 'text-indigo-300' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M3 7l8-4 8 4v6l-8 4-8-4V7z"/>
                </svg>
                Kelola Category
            </a>

            <a href="{{ route('admin.transactions.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.transactions.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.transactions.*') ? 'text-indigo-300' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Laporan Transaksi
            </a>
        </nav>

        <div class="pt-6 border-t border-indigo-800">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-indigo-300 hover:text-white transition font-medium text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 min-w-0 overflow-y-auto">

        {{-- Mobile Top Bar --}}
        <div class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-slate-100 shadow-sm sticky top-0 z-30">
            <button id="admin-sidebar-open" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black text-sm">AH</div>
                <span class="font-black text-slate-800 text-sm">Admin Panel</span>
            </div>
            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-sm">
                A
            </div>
        </div>

        <div class="p-4 sm:p-6 md:p-10">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        const adminSidebar  = document.getElementById('admin-sidebar');
        const adminOverlay  = document.getElementById('admin-overlay');
        const adminOpenBtn  = document.getElementById('admin-sidebar-open');
        const adminCloseBtn = document.getElementById('admin-sidebar-close');

        function openAdminSidebar() {
            adminSidebar.classList.add('open');
            adminOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeAdminSidebar() {
            adminSidebar.classList.remove('open');
            adminOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        adminOpenBtn  && adminOpenBtn.addEventListener('click', openAdminSidebar);
        adminCloseBtn && adminCloseBtn.addEventListener('click', closeAdminSidebar);
        adminOverlay.addEventListener('click', closeAdminSidebar);
    </script>

</body>

</html>