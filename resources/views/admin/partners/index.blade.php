@extends('layouts.admin')

@section('content')

<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Kelola Partners</h1>
        <p class="text-slate-500 font-medium">
            Kelola daftar partner yang bekerja sama dengan event Anda.
        </p>
    </div>

    <a href="/admin/partners/create" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
        + Tambah Partner Baru
    </a>
</header>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

    {{-- HEADER TABLE --}}
    <div class="px-8 py-6 bg-slate-50/50 border-b flex gap-4">

        <input type="text" placeholder="Cari nama partner..." class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">

    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">

            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Logo</th>
                    <th class="px-8 py-4">Nama Partner</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y border-t">

                @foreach($partners as $index => $partner)

                <tr class="hover:bg-slate-50/50 transition">

                    {{-- NO --}}
                    <td class="px-8 py-6 font-bold text-slate-400">
                        {{ $index + 1 }}
                    </td>

                    {{-- LOGO --}}
                    <td class="px-8 py-6">
                        <img src="{{ $partner->logo_url }}" class="w-14 h-14 rounded-xl object-cover shadow-sm">
                    </td>

                    {{-- NAME --}}
                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800">
                            {{ $partner->name }}
                        </p>

                        <p class="text-xs text-slate-400">
                            ID: {{ $partner->id }}
                        </p>
                    </td>

                    {{-- ACTION --}}
                    <td class="px-8 py-6">

                        <div class="flex gap-2">

                            {{-- EDIT --}}
                            <a href="#" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>

                            </a>

                            {{-- DELETE --}}
                            <form action="#" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">

                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>

                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection