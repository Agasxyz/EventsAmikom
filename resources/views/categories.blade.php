@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-16">
    <div class="max-w-7xl mx-auto px-6">
        
        <!-- Header Section -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider mb-4">
                Kategori Event
            </span>
            <h1 class="text-4xl font-extrabold text-slate-800 leading-tight mb-4">
                Jelajahi Berbagai Pilihan Kategori Event
            </h1>
            <p class="text-lg text-slate-500 leading-relaxed">
                Temukan acara menarik yang sesuai dengan minat dan kebutuhan Anda. Pilih kategori di bawah ini untuk melihat daftar event aktif yang tersedia.
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categoriesList as $cat)
            <div class="group bg-white rounded-3xl border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition">
                        {{ $cat->name }}
                    </h3>
                    
                    <p class="text-sm text-slate-400 font-semibold uppercase tracking-wider mb-6">
                        {{ $cat->events_count }} Event Aktif
                    </p>
                </div>
                
                <div>
                    <a href="/?category={{ $cat->slug }}" class="w-full inline-flex items-center justify-center px-6 py-3.5 bg-indigo-50 text-indigo-600 font-bold rounded-2xl hover:bg-indigo-600 hover:text-white transition duration-300">
                        Lihat Semua Event
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
