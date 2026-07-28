<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penyelenggara - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-indigo-900 text-slate-900 min-h-screen flex items-center justify-center p-6 md:py-16">

    <div class="max-w-2xl w-full bg-white rounded-[2.5rem] p-8 md:p-12 shadow-2xl border border-slate-100">
        
        {{-- Header --}}
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4 shadow-lg shadow-indigo-200">
                AH
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight">Daftar sebagai Penyelenggara</h1>
            <p class="text-slate-500 mt-2">Buat akun organisasi / kepanitiaan Anda dan mulai kelola event secara profesional.</p>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-indigo-50 border border-indigo-200 text-indigo-700 p-6 rounded-2xl mb-8 font-semibold text-center shadow-sm">
                {{ session('success') }}
                @auth
                    @if(auth()->user()->organization && auth()->user()->organization->status === 'pending')
                        <div class="mt-4 text-sm text-slate-500 font-medium">
                            Status saat ini: <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full font-bold text-xs uppercase">PENDING</span>
                        </div>
                    @endif
                @endauth
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="text-indigo-600 hover:underline text-sm font-bold">Kembali ke Beranda →</a>
                </div>
            </div>
        @elseif(auth()->check() && auth()->user()->organization)
            @php
                $org = auth()->user()->organization;
            @endphp
            <div class="bg-slate-50 border border-slate-200 rounded-3xl p-8 text-center space-y-6">
                <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full shadow-md
                    @if($org->status === 'active') bg-emerald-100 text-emerald-600
                    @elseif($org->status === 'pending') bg-amber-100 text-amber-600
                    @else bg-rose-100 text-rose-600 @endif">
                    @if($org->status === 'active')
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @elseif($org->status === 'pending')
                        <svg class="w-10 h-10 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    @endif
                </div>

                <div class="space-y-2">
                    <h3 class="text-xl font-extrabold text-slate-800">{{ $org->name }}</h3>
                    <p class="text-sm text-slate-500 font-medium">Email: {{ $org->email }} | WhatsApp: {{ $org->phone ?? '-' }}</p>
                </div>

                <div class="inline-block px-4 py-2 rounded-full font-bold text-xs uppercase tracking-wider
                    @if($org->status === 'active') bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200
                    @elseif($org->status === 'pending') bg-amber-100 text-amber-700 ring-1 ring-amber-200
                    @else bg-rose-100 text-rose-700 ring-1 ring-rose-200 @endif">
                    Status: {{ strtoupper($org->status) }}
                </div>

                <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                    @if($org->status === 'active')
                        Selamat! Organisasi Anda telah disetujui. Anda dapat mulai mengelola event Anda sendiri sekarang.
                    @elseif($org->status === 'pending')
                        Pendaftaran organisasi Anda sedang ditinjau oleh tim Superadmin kami. Proses ini biasanya memakan waktu 1-2 hari kerja. Silakan hubungi kami jika Anda memiliki pertanyaan.
                    @else
                        Akses organisasi Anda telah dinonaktifkan sementara oleh Admin karena melanggar pedoman komunitas kami.
                    @endif
                </p>

                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row gap-4 justify-center">
                    @if($org->status === 'active')
                        <a href="{{ route('organizer.dashboard') }}"
                            class="px-8 py-3.5 bg-indigo-600 text-white rounded-2xl font-bold shadow-md hover:bg-indigo-700 transition">
                            Masuk ke Dashboard
                        </a>
                    @endif
                    <a href="{{ route('home') }}"
                        class="px-8 py-3.5 bg-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-300 transition">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        @else

        <form action="{{ route('organizer.register.post') }}" method="POST" class="space-y-8">
            @csrf

            @if(!auth()->check())
            {{-- ── Data Organisasi (Belum Login) ── --}}
            <div class="space-y-5">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 border-b pb-2">
                    Informasi Akun Organisasi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Organisasi / Kepanitiaan</label>
                        <input type="text" name="org_name" value="{{ old('org_name') }}" required
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            placeholder="Contoh: HIMA Informatika Amikom">
                        @error('org_name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Organisasi</label>
                        <input type="email" name="org_email" value="{{ old('org_email') }}" required
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            placeholder="hima@amikom.ac.id">
                        @error('org_email') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="org_phone" value="{{ old('org_phone') }}"
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            placeholder="Contoh: 081234567890">
                        @error('org_phone') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            placeholder="Minimal 8 karakter">
                        @error('password') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            placeholder="Ulangi password">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Singkat</label>
                        <textarea name="org_desc" rows="4"
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium resize-none"
                            placeholder="Jelaskan secara singkat mengenai organisasi/kepanitiaan Anda...">{{ old('org_desc') }}</textarea>
                        @error('org_desc') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            @else
            {{-- ── Data Organisasi (Sudah Login) ── --}}
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold">Mendaftar dengan Akun: {{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="space-y-5">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 border-b pb-2">
                    <span class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs text-slate-500 font-black">1</span>
                    Informasi Organisasi / Kepanitiaan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Organisasi / Kepanitiaan</label>
                        <input type="text" name="org_name" value="{{ old('org_name') }}" required
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            placeholder="Contoh: HIMA Informatika Amikom">
                        @error('org_name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Organisasi</label>
                        <input type="email" name="org_email" value="{{ old('org_email') }}" required
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            placeholder="hima@amikom.ac.id">
                        @error('org_email') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="org_phone" value="{{ old('org_phone') }}"
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            placeholder="Contoh: 081234567890">
                        @error('org_phone') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Singkat</label>
                        <textarea name="org_desc" rows="4"
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium resize-none"
                            placeholder="Jelaskan secara singkat mengenai organisasi/kepanitiaan Anda...">{{ old('org_desc') }}</textarea>
                        @error('org_desc') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            @endif

            <button type="submit"
                class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition duration-200">
                Kirim Pendaftaran
            </button>
        </form>
        @endif

        {{-- Footer link --}}
        <div class="text-center mt-8 border-t pt-6">
            <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-indigo-600 transition font-semibold">
                ← Kembali ke Beranda
            </a>
        </div>

    </div>

</body>
</html>
