@extends('layouts.app')

@section('content')
    {{-- Tombol Kembali --}}
    <div class="max-w-7xl mx-auto px-6 pt-8">
        <a href="{{ route('home') }}"
            class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-semibold transition group">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-8 space-y-12">
        
        {{-- ── CARD HEADER / HERO PENYELENGGARA ── --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden relative">
            {{-- Gradient Banner --}}
            <div class="h-48 w-full bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-800 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-xl"></div>
                <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-purple-500/20 rounded-full blur-2xl"></div>
            </div>

            {{-- Info Profil --}}
            <div class="px-8 pb-8 pt-0 flex flex-col md:flex-row items-start gap-6 relative">
                {{-- Logo / Inisial (Overlap Banner) --}}
                <div class="-mt-16 w-32 h-32 bg-gradient-to-br {{ $organization->slug === 'amikomeventhub' ? 'from-indigo-400 to-indigo-600' : 'from-emerald-400 to-teal-500' }} rounded-3xl border-[6px] border-white shadow-2xl flex items-center justify-center text-white font-black text-4xl uppercase tracking-wider flex-shrink-0 z-10">
                    {{ strtoupper(substr($organization->name, 0, 2)) }}
                </div>

                <div class="flex-1 space-y-4 pt-4 md:pt-6">
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-3xl font-black text-slate-900 leading-tight">
                            {{ $organization->name }}
                        </h1>
                        <span class="inline-flex items-center gap-1 px-3 py-1 {{ $organization->slug === 'amikomeventhub' ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 'bg-emerald-50 border-emerald-200 text-emerald-700' }} border rounded-full text-xs font-bold uppercase tracking-wide">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ $organization->slug === 'amikomeventhub' ? 'Official Organizer' : 'Verified Organizer' }}
                        </span>
                    </div>

                    @if($organization->description)
                        <p class="text-slate-600 font-medium text-lg leading-relaxed max-w-4xl">
                            {{ $organization->description }}
                        </p>
                    @else
                        <p class="text-slate-400 italic">Penyelenggara belum menambahkan deskripsi profil.</p>
                    @endif

                    {{-- Info Kontak --}}
                    <div class="flex flex-wrap items-center gap-4 text-sm font-semibold text-slate-500">
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl border border-slate-100">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:{{ $organization->email }}" class="hover:text-indigo-600 transition">{{ $organization->email }}</a>
                        </div>
                        @if($organization->phone)
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl border border-slate-100">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span class="text-slate-600">{{ $organization->phone }}</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl border border-slate-100">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Terdaftar: {{ $organization->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── DUA KOLOM KONTEN UTAMA ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- KOLOM KIRI: STATISTIK PENILAIAN --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-6 sticky top-24">
                    <h3 class="font-extrabold text-xl text-slate-800 border-b pb-3">Rating Organizer</h3>
                    
                    {{-- Big score --}}
                    <div class="text-center bg-slate-50 rounded-2xl py-6 px-4">
                        <p class="text-6xl font-black text-slate-900">{{ number_format($avgRating, 1) }}</p>
                        <div class="flex justify-center gap-1 my-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($avgRating))
                                    <svg class="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-slate-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="text-sm text-slate-500 font-medium">Berdasarkan {{ $reviewCount }} Ulasan Acara</p>
                    </div>

                    {{-- Star distribution --}}
                    <div class="space-y-3">
                        @foreach($starCounts as $star => $count)
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-bold text-slate-600 w-3">{{ $star }}</span>
                                <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <div class="flex-1 h-3 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-400 rounded-full transition-all duration-500"
                                         style="width: {{ $reviewCount > 0 ? ($count / $reviewCount * 100) : 0 }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-slate-400 w-6 text-right">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Total Event Organized --}}
                    <div class="border-t pt-4 flex justify-between items-center text-sm font-semibold text-slate-500">
                        <span>Total Event Aktif & Selesai:</span>
                        <span class="text-indigo-600 font-bold text-lg">{{ $events->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: TABS & KONTEN DETAIL --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Tombol Navigasi Tab --}}
                <div class="flex border-b border-slate-200 gap-4">
                    <button id="tab-reviews-btn" onclick="switchTab('reviews')" class="pb-4 px-2 font-bold text-lg border-b-2 border-indigo-600 text-indigo-600 transition-all duration-150 cursor-pointer">
                        Ulasan ({{ $reviewCount }})
                    </button>
                    <button id="tab-events-btn" onclick="switchTab('events')" class="pb-4 px-2 font-bold text-lg border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all duration-150 cursor-pointer">
                        Event Tersedia ({{ $events->count() }})
                    </button>
                </div>

                {{-- KONTEN TAB 1:ULASAN --}}
                <div id="tab-reviews-content" class="space-y-6">
                    @if($reviewCount > 0)
                        @foreach($reviews as $review)
                            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 hover:shadow-md transition duration-300">
                                <div class="flex items-start gap-4">
                                    {{-- Avatar Reviewer --}}
                                    <div class="w-12 h-12 bg-indigo-50 border border-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-black text-xl flex-shrink-0">
                                        {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    
                                    <div class="flex-1 space-y-2 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 justify-between">
                                            <div>
                                                <h4 class="font-extrabold text-slate-800 text-base">{{ $review->user->name ?? 'Pengguna' }}</h4>
                                                {{-- Rating Bintang --}}
                                                <div class="flex gap-0.5 mt-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-400">
                                                {{ $review->created_at->diffForHumans() }}
                                            </span>
                                        </div>

                                        {{-- Testimony Comment --}}
                                        @if($review->comment)
                                            <p class="text-slate-600 leading-relaxed text-sm font-medium">
                                                "{{ $review->comment }}"
                                            </p>
                                        @else
                                            <p class="text-slate-300 italic text-sm">Tidak meninggalkan deskripsi ulasan.</p>
                                        @endif

                                        {{-- Link to related Event --}}
                                        @if($review->event)
                                            <div class="pt-2 border-t border-slate-50 flex items-center gap-1.5 text-xs font-bold text-slate-400">
                                                <span>Acara:</span>
                                                <a href="{{ route('events.show', $review->event->id) }}" class="text-indigo-600 hover:underline inline-flex items-center gap-0.5">
                                                    {{ $review->event->title }}
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Empty state --}}
                        <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200">
                            <h4 class="font-extrabold text-slate-800 text-lg">Belum Ada Ulasan</h4>
                            <p class="text-slate-400 text-sm mt-1 max-w-sm mx-auto">Calon pembeli akan melihat testimoni pengunjung di sini setelah ulasan pertama dikirimkan.</p>
                        </div>
                    @endif
                </div>

                {{-- KONTEN TAB 2: DAFTAR EVENT --}}
                <div id="tab-events-content" class="hidden space-y-6">
                    @if($events->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($events as $event)
                                <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between">
                                    <div class="relative overflow-hidden aspect-[3/2] bg-slate-50">
                                        <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path))
                                                 ? asset('storage/' . $event->poster_path)
                                                 : 'https://placehold.co/600x400' }}" alt="{{ $event->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        
                                        {{-- Category Badge --}}
                                        <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                                            {{ $event->category->name }}
                                        </div>

                                        {{-- Status Badge (Akan Datang vs Selesai) --}}
                                        <div class="absolute top-4 right-4">
                                            @if($event->date->isFuture())
                                                <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-xs font-bold uppercase tracking-wider shadow">Akan Datang</span>
                                            @else
                                                <span class="px-3 py-1 bg-slate-700 text-white rounded-lg text-xs font-bold uppercase tracking-wider shadow">Selesai</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                        <div>
                                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-indigo-600 transition line-clamp-1">
                                                {{ $event->title }}
                                            </h3>
                                            <div class="flex items-center gap-2 text-slate-400 text-xs font-semibold mt-1">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y H:i') }}</span>
                                            </div>
                                        </div>

                                        <div class="flex justify-between items-center pt-3 border-t border-slate-50">
                                            <span class="text-lg font-black text-indigo-600">
                                                @if($event->price > 0)
                                                    Rp {{ number_format($event->price, 0, ',', '.') }}
                                                @else
                                                    Gratis
                                                @endif
                                            </span>
                                            <a href="{{ route('events.show', $event->id) }}" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold text-sm hover:bg-indigo-600 hover:text-white transition duration-200">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty state --}}
                        <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200">
                            <div class="text-6xl mb-4">📅</div>
                            <h4 class="font-extrabold text-slate-800 text-lg">Belum Ada Event</h4>
                            <p class="text-slate-400 text-sm mt-1">Penyelenggara saat ini belum merilis daftar event.</p>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </main>

    {{-- SWITCH TAB SCRIPT --}}
    <script>
        function switchTab(tab) {
            const reviewsBtn = document.getElementById('tab-reviews-btn');
            const eventsBtn = document.getElementById('tab-events-btn');
            const reviewsContent = document.getElementById('tab-reviews-content');
            const eventsContent = document.getElementById('tab-events-content');

            if (tab === 'reviews') {
                reviewsBtn.className = "pb-4 px-2 font-bold text-lg border-b-2 border-indigo-600 text-indigo-600 transition-all duration-150 cursor-pointer";
                eventsBtn.className = "pb-4 px-2 font-bold text-lg border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all duration-150 cursor-pointer";

                reviewsContent.classList.remove('hidden');
                eventsContent.classList.add('hidden');
            } else {
                eventsBtn.className = "pb-4 px-2 font-bold text-lg border-b-2 border-indigo-600 text-indigo-600 transition-all duration-150 cursor-pointer";
                reviewsBtn.className = "pb-4 px-2 font-bold text-lg border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all duration-150 cursor-pointer";

                eventsContent.classList.remove('hidden');
                reviewsContent.classList.add('hidden');
            }
        }
    </script>
@endsection
