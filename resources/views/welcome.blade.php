@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-12 md:py-20 flex flex-col md:flex-row items-center gap-10 md:gap-12 overflow-hidden">
    <div class="flex-1 space-y-6 text-center md:text-left">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1 Event Platform</span>
        <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold leading-tight text-center md:text-left">
            Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
        </h1>
        <p class="text-base sm:text-lg text-slate-500 max-w-lg leading-relaxed mx-auto md:mx-0 text-center md:text-left">
            Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan
            Midtrans.
        </p>
        <div class="flex flex-wrap gap-3 justify-center md:justify-start">
            <a href="#events" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold text-base shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                Mulai Jelajah
            </a>
            <a href="#" class="px-6 py-3 border-2 border-slate-200 rounded-2xl font-bold text-base hover:border-indigo-600 hover:text-indigo-600 transition">
                Cara Pesan
            </a>
        </div>
    </div>
    <div class="flex-1 relative w-full max-w-sm mx-auto md:max-w-none mt-10 md:mt-0 overflow-hidden md:overflow-visible">
        {{-- Blobs: hidden on mobile to prevent overflow --}}
        <div class="hidden md:block absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="hidden md:block absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <img src="assets/concert.png" alt="Concert" class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">
        {{-- Badge: inside on mobile, protruding on desktop --}}
        <div class="absolute bottom-4 left-4 right-4 sm:bottom-4 sm:left-4 sm:right-4 md:-bottom-6 md:-left-6 md:right-auto glass p-4 rounded-2xl shadow-xl z-20 border border-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                    <p class="font-bold text-sm">Pembayaran Aman via Midtrans</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Grid -->
<section id="events" class="max-w-7xl mx-auto px-4 sm:px-6 py-12 md:py-20">
    <div class="mb-8 md:mb-12">
        <div class="mb-6">
            <h2 class="text-2xl sm:text-3xl font-extrabold mb-2">Event Terdekat</h2>
            <p class="text-slate-500 font-medium text-sm sm:text-base">Jangan sampai ketinggalan acara seru minggu ini!</p>
        </div>

        <!-- Blok Navigasi Filter Kategori -->
        <div id="categories" class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
            <a href="/" class="flex-shrink-0 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-full text-black text-sm font-semibold transition">
                Semua
            </a>
            @foreach($categories as $cat)
            <a href="/?category={{ $cat->slug }}" class="flex-shrink-0 px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-full text-sm font-semibold shadow-sm transition">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($events as $event)
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="relative overflow-hidden aspect-[3/4]">
            <img src="{{ ($event->poster_path && file_exists(public_path('storage/' . $event->poster_path)))
                     ? asset('storage/' . $event->poster_path)
                     : 'https://placehold.co/200x600' }}" alt="{{ $event->title }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">



                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                    {{ $event->category->name }}
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t">
                    <span class="text-2xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                    <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach

</section>

<!-- Partners Section -->
<section class="max-w-7xl mx-auto px-6 py-24">

    <div class="text-center mb-16">
        <h2 class="text-5xl font-extrabold text-slate-800 mb-4">
            Partner Kami
        </h2>

        <p class="text-slate-500 text-lg font-medium">
            Didukung oleh berbagai perusahaan dan komunitas terpercaya.
        </p>
    </div>

    <div class="flex flex-wrap justify-center items-center gap-24">

        @foreach($partners as $partner)
        <div class="w-40 h-24 flex items-center justify-center">
            <div class="w-full h-full flex items-center justify-center">
                <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="max-h-14 max-w-full object-contain transition duration-300 hover:scale-110">
            </div>
        </div>
        @endforeach

    </div>

</section>
@endsection