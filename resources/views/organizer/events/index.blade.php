@extends('layouts.organizer')

@section('page_title', 'Kelola Event Saya')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('organizer.events.create') }}" 
        class="px-6 py-3.5 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
        + Tambah Event Baru
    </a>
</div>

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="px-8 py-6 bg-slate-50/50 border-b">
        <form action="{{ route('organizer.events.index') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari nama event..." 
                class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition font-medium">
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Cari
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Poster</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Harga / Stok</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($events as $index => $event)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">
                        {{ $events->firstItem() + $index }}
                    </td>
                    <td class="px-8 py-6">
                        <img src="{{ ($event->poster_path && file_exists(public_path('storage/' . $event->poster_path)))
                            ? asset('storage/' . $event->poster_path)
                            : 'https://placehold.co/160x200' }}" 
                            class="w-16 h-20 rounded-xl object-cover shadow-sm">
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800">{{ $event->title }}</p>
                        <p class="text-xs text-slate-400">
                            {{ $event->category->name ?? '-' }} • {{ $event->date->format('d M Y, H:i') }}
                        </p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-400">Stok: {{ $event->stock }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex gap-2">

                             {{-- Scanner Check-in Button --}}
                            <a href="{{ route('organizer.scanner.index', $event->id) }}"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition"
                                title="Scanner Check-in Tiket">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <!-- Top Left Finder -->
                                    <path d="M2 2h7v7H2V2zm1.5 1.5v4h4v-4h-4z"/>
                                    <path d="M4.5 4.5h2v2h-2v-2z"/>
                                    <!-- Top Right Finder -->
                                    <path d="M15 2h7v7h-7V2zm1.5 1.5v4h4v-4h-4z"/>
                                    <path d="M17.5 4.5h2v2h-2v-2z"/>
                                    <!-- Bottom Left Finder -->
                                    <path d="M2 15h7v7H2v-7zm1.5 1.5v4h4v-4h-4z"/>
                                    <path d="M4.5 17.5h2v2h-2v-2z"/>
                                    <!-- Data modules/pixels -->
                                    <rect x="11" y="2" width="2" height="2"/>
                                    <rect x="11" y="6" width="2" height="2"/>
                                    <rect x="11" y="10" width="2" height="2"/>
                                    <rect x="11" y="14" width="2" height="2"/>
                                    <rect x="11" y="18" width="2" height="2"/>
                                    <rect x="2" y="11" width="2" height="2"/>
                                    <rect x="6" y="11" width="2" height="2"/>
                                    <rect x="15" y="11" width="2" height="2"/>
                                    <rect x="19" y="11" width="2" height="2"/>
                                    <rect x="15" y="15" width="2" height="2"/>
                                    <rect x="17" y="17" width="2" height="2"/>
                                    <rect x="19" y="15" width="2" height="2"/>
                                    <rect x="21" y="17" width="2" height="2"/>
                                    <rect x="15" y="19" width="2" height="2"/>
                                    <rect x="17" y="21" width="2" height="2"/>
                                    <rect x="19" y="19" width="2" height="2"/>
                                    <rect x="21" y="21" width="2" height="2"/>
                                </svg>
                            </a>

                            <a href="{{ route('organizer.events.edit', $event->id) }}" 
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition"
                                title="Edit Event">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST" 
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition"
                                    title="Hapus Event">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-12 text-center text-slate-500 font-medium">Belum ada acara yang Anda tambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($events->hasPages())
    <div class="px-8 py-6 bg-slate-50/50 border-t">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection
