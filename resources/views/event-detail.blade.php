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

    <main class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: Poster -->
        <div class="lg:col-span-1">
            <div class="sticky top-32">
            <img src="{{ ($event->poster_path && file_exists(public_path('storage/' . $event->poster_path)))
                  ? asset('storage/' . $event->poster_path)
                  : 'https://placehold.co/200x600' }}" alt="{{ $event->title }}" class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white object-cover aspect-[3/4]">

                <div class="mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                    <h4 class="font-bold mb-4">Penyelenggara</h4>
                    <div class="flex items-center gap-4">
                        @if($event->organization)
                            <a href="{{ route('organizers.show', $event->organization->slug) }}" class="flex items-center gap-4 group hover:opacity-90 transition w-full">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-extrabold text-lg group-hover:scale-105 transition-transform duration-200">
                                    {{ strtoupper(substr($event->organization->name, 0, 2)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors truncate">{{ $event->organization->name }}</p>
                                    <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Verified Organizer</p>
                                </div>
                                <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('organizers.show', 'amikomeventhub') }}" class="flex items-center gap-4 group hover:opacity-90 transition w-full">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-extrabold text-lg group-hover:scale-105 transition-transform duration-200">
                                    AH
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors truncate">AmikomEventHub</p>
                                    <p class="text-xs text-indigo-600 font-semibold uppercase tracking-wider">Official Organizer</p>
                                </div>
                                <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Details -->
        <div class="lg:col-span-2 space-y-12">
            <div class="space-y-4">
                <span
                    class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                    {{ $event->category->name }}
                </span>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    {{ $event->title }}
                </h1>

                <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>

                        <span>
                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>

                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>

            <div class="prose prose-slate max-w-none">
                <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>

                <p class="text-lg text-slate-600 leading-relaxed">
                    {{ $event->description }}
                </p>
            </div>

            <div
                class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">
                            Harga Tiket
                        </p>

                        <h2 class="text-5xl font-black">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                            <span class="text-lg font-medium text-indigo-200">/ orang</span>
                        </h2>

                        <p class="mt-4 text-indigo-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>

                            Sisa stok:
                            <span class="font-bold underline">
                                {{ $event->stock }} Tiket lagi!
                            </span>
                        </p>
                    </div>

                    <div>
                        @if($event->date->isPast())
                            <button disabled
                                class="inline-block px-10 py-5 bg-slate-100 text-slate-400 rounded-2xl font-black text-xl cursor-not-allowed shadow-inner opacity-75">
                                Event Selesai
                            </button>
                        @else
                            <a href="{{ url('checkout/'.$event->id) }}"
                                class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                                Pesan Sekarang
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Decoration -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold">Kebijakan Tiket</h3>

                <ul class="space-y-3 text-slate-500">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                    </li>

                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Tiket dapat discan di pintu masuk (Check-in).
                    </li>

                    <li class="flex items-start gap-2 text-rose-500">
                        <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Tiket yang sudah dibeli tidak dapat direfund.
                    </li>
                </ul>
            </div>

            {{-- ══════════════════════════════════════════════
                 SECTION: ULASAN & RATING
            ══════════════════════════════════════════════ --}}
            @php
                $reviews      = $event->reviews->sortByDesc('created_at');
                $reviewCount  = $reviews->count();
                $avgRating    = $reviewCount ? round($reviews->avg('rating'), 1) : null;
                $starCounts   = [];
                for ($s = 5; $s >= 1; $s--) {
                    $starCounts[$s] = $reviews->where('rating', $s)->count();
                }
            @endphp

            <div class="space-y-8 pt-4">

                {{-- ── Header section ── --}}
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-1 h-8 bg-indigo-600 rounded-full"></div>
                    <h3 class="text-2xl font-extrabold">Ulasan & Rating</h3>
                    @if($reviewCount > 0)
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold">
                            {{ $reviewCount }} ulasan
                        </span>
                    @endif
                </div>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-2xl">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-2xl">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <p class="text-red-600 font-semibold">{{ session('error') }}</p>
                    </div>
                @endif

                @if($reviewCount > 0)
                {{-- ── Rating Summary Card ── --}}
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col sm:flex-row gap-6">
                    {{-- Big number --}}
                    <div class="text-center flex-shrink-0">
                        <p class="text-7xl font-black text-slate-900">{{ $avgRating }}</p>
                        <div class="flex justify-center gap-0.5 my-2">
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
                        <p class="text-sm text-slate-500 font-medium">dari {{ $reviewCount }} ulasan</p>
                    </div>

                    {{-- Star distribution --}}
                    <div class="flex-1 space-y-2">
                        @foreach($starCounts as $star => $count)
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-bold text-slate-600 w-3">{{ $star }}</span>
                            <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full transition-all duration-500"
                                     style="width: {{ $reviewCount > 0 ? ($count / $reviewCount * 100) : 0 }}%"></div>
                            </div>
                            <span class="text-sm text-slate-400 w-6 text-right">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                {{-- Belum ada review --}}
                <div class="text-center py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <div class="text-5xl mb-3">⭐</div>
                    <p class="text-slate-500 font-medium">Belum ada ulasan untuk event ini.</p>
                    <p class="text-slate-400 text-sm mt-1">Jadilah yang pertama memberikan ulasan!</p>
                </div>
                @endif

                {{-- ── Form Tulis Ulasan ── --}}
                @if($canReview)
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl border border-indigo-100 p-6">
                    <h4 class="text-lg font-bold text-slate-800 mb-1">Tulis Ulasanmu</h4>
                    <p class="text-slate-500 text-sm mb-5">Bagikan pengalamanmu di acara ini untuk membantu pembeli berikutnya.</p>

                    <form action="{{ route('reviews.store', $event->id) }}" method="POST" id="review-form">
                        @csrf

                        {{-- Star Picker --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Penilaian Bintang *</label>
                            <div class="flex gap-2" id="star-picker">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button" data-value="{{ $i }}"
                                    class="star-btn text-4xl text-slate-200 hover:text-amber-400 transition-colors duration-150 cursor-pointer leading-none"
                                    aria-label="{{ $i }} bintang">★</button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="">
                            @error('rating')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Comment --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Ceritakan Pengalamanmu <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                            <textarea name="comment" rows="4" maxlength="1000"
                                class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium resize-none text-slate-700 placeholder:text-slate-300"
                                placeholder="Ceritakan suasana event, pelayanan, atau kesan yang paling berkesan...">{{ old('comment') }}</textarea>
                        </div>

                        <button type="submit" id="submit-review-btn"
                            class="px-8 py-3.5 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                            Kirim Ulasan
                        </button>
                    </form>
                </div>

                <script>
                    const stars     = document.querySelectorAll('.star-btn');
                    const ratingInput = document.getElementById('rating-input');
                    const submitBtn = document.getElementById('submit-review-btn');
                    let selected    = 0;

                    function paint(val) {
                        stars.forEach((s, idx) => {
                            s.classList.toggle('text-amber-400', idx < val);
                            s.classList.toggle('text-slate-200', idx >= val);
                        });
                    }

                    stars.forEach((btn, idx) => {
                        btn.addEventListener('mouseover', () => paint(idx + 1));
                        btn.addEventListener('mouseleave', () => paint(selected));
                        btn.addEventListener('click', () => {
                            selected = idx + 1;
                            ratingInput.value = selected;
                            submitBtn.disabled = false;
                            paint(selected);
                        });
                    });
                </script>

                @elseif($userReview)
                {{-- User sudah pernah review --}}
                <div class="bg-green-50 border border-green-200 rounded-3xl p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h4 class="font-bold text-green-800">Ulasan Anda</h4>
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $userReview->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    @if($userReview->comment)
                        <p class="text-slate-700">{{ $userReview->comment }}</p>
                    @else
                        <p class="text-slate-400 italic">Tidak ada komentar.</p>
                    @endif
                </div>

                @elseif(!Auth::check())
                {{-- Belum login --}}
                <div class="bg-slate-50 rounded-3xl border border-slate-200 p-6 text-center">
                    <p class="text-slate-600 mb-4 font-medium">Punya tiket event ini? Login untuk meninggalkan ulasan.</p>
                    <a href="{{ route('user.login') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        Login untuk Mengulas
                    </a>
                </div>
                @endif

                {{-- ── Daftar Ulasan ── --}}
                @if($reviewCount > 0)
                <div class="space-y-4">
                    <h4 class="font-bold text-slate-700 text-lg">Semua Ulasan</h4>
                    @foreach($reviews as $review)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 hover:shadow-md transition">
                        <div class="flex items-start gap-4">
                            {{-- Avatar --}}
                            <div class="w-11 h-11 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-lg flex-shrink-0">
                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="font-bold text-slate-800">{{ $review->user->name ?? 'Pengguna' }}</span>
                                    {{-- Bintang --}}
                                    <div class="flex gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-slate-400 ml-auto">
                                        {{ $review->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                @if($review->comment)
                                    <p class="text-slate-600 leading-relaxed text-sm">{{ $review->comment }}</p>
                                @else
                                    <p class="text-slate-300 italic text-sm">Tidak ada komentar.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

            </div>{{-- end review section --}}

        </div>
    </main>
@endsection