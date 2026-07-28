@extends('layouts.organizer')

@section('page_title', 'Ringkasan Analitik')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        {{-- Revenue --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-indigo-500/5 rounded-full group-hover:scale-150 transition-all duration-300"></div>
        </div>

        {{-- Tickets Sold --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Tiket Terjual</p>
            <h3 class="text-2xl font-black text-slate-800">{{ number_format($ticketsSold, 0, ',', '.') }} Tiket</h3>
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-blue-500/5 rounded-full group-hover:scale-150 transition-all duration-300"></div>
        </div>

        {{-- Active Events --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Event Aktif</p>
            <h3 class="text-2xl font-black text-slate-800">{{ $activeEvents }} Event</h3>
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-amber-500/5 rounded-full group-hover:scale-150 transition-all duration-300"></div>
        </div>

        {{-- Avg Review Rating --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.977-2.888a1 1 0 00-1.176 0l-3.977 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Rata-rata Rating</p>
            <h3 class="text-2xl font-black text-slate-800">
                {{ $avgRating > 0 ? $avgRating . ' / 5.0' : 'Belum Ada' }}
            </h3>
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-purple-500/5 rounded-full group-hover:scale-150 transition-all duration-300"></div>
        </div>
    </div>

    <!-- Latest Transactions table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b flex justify-between items-center">
            <h3 class="font-black text-xl text-slate-800">Transaksi Tiket Masuk</h3>
            <a href="{{ route('organizer.transactions.index') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4">Tgl Transaksi</th>
                        <th class="px-8 py-4">Pembeli</th>
                        <th class="px-8 py-4">Event</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4 text-right">Total Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse($recentTransactions as $trx)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-8 py-6 text-sm text-slate-600">
                            {{ $trx->created_at->format('d M y - H:i') }}<br>
                            <span class="text-xs text-slate-400">{{ $trx->order_id }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-bold uppercase tracking-wide text-sm truncate max-w-[150px]">{{ $trx->customer_name }}</p>
                            <p class="text-xs text-slate-400 truncate max-w-[150px]">{{ $trx->customer_email }}</p>
                        </td>
                        <td class="px-8 py-6 font-medium text-slate-600 max-w-xs truncate">{{ $trx->event->title ?? '-' }}</td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            @if($trx->status === 'settlement' || $trx->status === 'success')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">Success</span>
                            @elseif($trx->status === 'pending')
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase">Pending</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase">{{ $trx->status }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 font-black text-indigo-600 whitespace-nowrap text-right">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-slate-500">Belum ada transaksi pembelian tiket.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
