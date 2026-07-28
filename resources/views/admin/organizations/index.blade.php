@extends('layouts.admin')

@section('title', 'Kelola Penyelenggara - Admin')
@section('page_title', 'Kelola Penyelenggara')

@section('content')
    <header class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800">Kelola Penyelenggara</h1>
            <p class="text-slate-500 font-medium">Tinjau, aktifkan, dan bekukan akun organisasi penyelenggara event.</p>
        </div>
    </header>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4">No</th>
                        <th class="px-8 py-4">Nama Organisasi</th>
                        <th class="px-8 py-4">Pendaftar / Owner</th>
                        <th class="px-8 py-4">Kontak / Email</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse($organizations as $index => $org)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6 font-bold text-slate-400">
                                {{ $organizations->firstItem() + $index }}
                            </td>
                            <td class="px-8 py-6">
                                <p class="font-black text-slate-800">{{ $org->name }}</p>
                                @if($org->description)
                                    <p class="text-xs text-slate-400 mt-1 max-w-sm truncate">{{ $org->description }}</p>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <p class="font-semibold text-slate-700 text-sm">{{ $org->user->name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-400">Owner ID: #{{ $org->user_id }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm font-medium text-slate-700">{{ $org->email }}</p>
                                @if($org->phone)
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $org->phone }}</p>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                @if($org->status === 'active')
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">Active</span>
                                @elseif($org->status === 'pending')
                                    <span
                                        class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold uppercase ring-1 ring-amber-200">Pending</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase ring-1 ring-rose-200">Suspended</span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex gap-2">
                                    @if($org->status !== 'active')
                                        <form action="{{ route('admin.organizations.approve', $org->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-3.5 py-2 bg-green-50 text-green-700 rounded-xl hover:bg-green-600 hover:text-white transition text-xs font-bold">
                                                Setujui
                                            </button>
                                        </form>
                                    @endif

                                    @if($org->status === 'active')
                                        <form action="{{ route('admin.organizations.suspend', $org->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan organisasi ini? Semua event mereka tidak akan bisa diatur.');">
                                            @csrf
                                            <button type="submit"
                                                class="px-3.5 py-2 bg-rose-50 text-rose-700 rounded-xl hover:bg-rose-600 hover:text-white transition text-xs font-bold">
                                                Bekukan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center text-slate-500 font-medium">Belum ada penyelenggara
                                terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($organizations->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t">
                {{ $organizations->links() }}
            </div>
        @endif
    </div>
@endsection