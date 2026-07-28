@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Ringkasan')

@section('content')

{{-- ── STAT CARDS ── --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5 mb-10">

    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition group">
        <div class="w-11 h-11 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Total Pendapatan</p>
        <h3 class="text-xl font-black text-slate-800 leading-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>

    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition group">
        <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
        </div>
        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Tiket Terjual</p>
        <h3 class="text-xl font-black text-slate-800">{{ number_format($ticketsSold) }}</h3>
    </div>

    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition group">
        <div class="w-11 h-11 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-amber-500 group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Event Aktif</p>
        <h3 class="text-xl font-black text-slate-800">{{ $activeEvents }} Event</h3>
    </div>

    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition group">
        <div class="w-11 h-11 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-rose-500 group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Pesanan Pending</p>
        <h3 class="text-xl font-black text-slate-800">{{ $pendingOrders }}</h3>
    </div>

    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition group">
        <div class="w-11 h-11 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5-2.236M9 20H4v-2a3 3 0 015-2.236m6-3.764a4 4 0 10-8 0 4 4 0 008 0z"/></svg>
        </div>
        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Penyelenggara Aktif</p>
        <h3 class="text-xl font-black text-slate-800">{{ $activePartners }} Partner</h3>
    </div>

    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition group">
        <div class="w-11 h-11 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-sky-600 group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Total Pengguna</p>
        <h3 class="text-xl font-black text-slate-800">{{ $totalUsers }} Akun</h3>
    </div>

</div>

{{-- ── GRAFIK PERTUMBUHAN & PENDAPATAN ── --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">

    {{-- Grafik Pertumbuhan (Line Chart) ── --}}
    <div class="xl:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-8 flex-wrap">
                <div class="flex items-start gap-3">
                    <div class="w-4 h-4 rounded-full border-2 border-indigo-600 flex items-center justify-center mt-0.5">
                        <div class="w-2 h-2 rounded-full bg-indigo-600"></div>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-indigo-900 block">Pengguna Baru</span>
                        <span class="text-[10px] font-semibold text-slate-400 block mt-0.5" id="growth-date-range-1">{{ $months[0] ?? '' }} - {{ end($months) }}</span>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-4 h-4 rounded-full border-2 border-sky-400 flex items-center justify-center mt-0.5">
                        <div class="w-2 h-2 rounded-full bg-sky-400"></div>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-slate-500 block">Event Dibuat</span>
                        <span class="text-[10px] font-semibold text-slate-400 block mt-0.5" id="growth-date-range-2">{{ $months[0] ?? '' }} - {{ end($months) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative h-72">
            <canvas id="growthChart"></canvas>
        </div>
    </div>

    {{-- Grafik Pendapatan Bulanan (Bar Chart) ── --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-2">
            <h3 class="font-black text-lg text-slate-800" id="revenue-title">Pendapatan Bulanan</h3>
            <div class="flex items-center gap-1.5 text-xs font-bold text-slate-400">
                <span id="revenue-date-range">{{ $months[0] ?? '' }} - {{ end($months) }}</span>
            </div>
        </div>
        <div class="flex items-center gap-4 text-xs font-bold mb-6">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-indigo-600 inline-block"></span><span id="revenue-legend-label">Pendapatan</span></span>
        </div>
        <div class="relative h-72">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

</div>

{{-- ── BARIS BAWAH: TOP EVENTS + TRANSAKSI TERAKHIR ── --}}
<div class="grid grid-cols-1 xl:grid-cols-5 gap-6 mb-8">

    {{-- Top 5 Event --}}
    <div class="xl:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-black text-lg text-slate-800 mb-5">Top 5 Event Terlaris</h3>
        <div class="space-y-4">
            @forelse($topEvents as $index => $ev)
                @php
                    $max = $topEvents->first()->transactions_count ?: 1;
                    $pct = $max > 0 ? ($ev->transactions_count / $max * 100) : 0;
                    $colors = ['bg-indigo-500','bg-emerald-500','bg-amber-500','bg-rose-500','bg-purple-500'];
                    $color  = $colors[$index] ?? 'bg-slate-400';
                @endphp
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-bold text-slate-700 truncate max-w-[65%]">{{ $ev->title }}</span>
                        <span class="text-xs font-black text-slate-500">{{ $ev->transactions_count }} tiket</span>
                    </div>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="{{ $color }} h-full rounded-full transition-all duration-700" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-sm text-center py-8">Belum ada data event.</p>
            @endforelse
        </div>
    </div>

    {{-- Transaksi Terakhir --}}
    <div class="xl:col-span-3 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center">
            <h3 class="font-black text-lg text-slate-800">Transaksi Terakhir</h3>
            <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 font-bold text-sm hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-6 py-3">Pembeli</th>
                        <th class="px-6 py-3">Event</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($recentTransactions as $trx)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-bold text-sm text-slate-800 truncate max-w-[120px]">{{ $trx->customer_name }}</p>
                            <p class="text-xs text-slate-400 truncate max-w-[120px]">{{ $trx->created_at->format('d M y') }}</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-sm text-slate-600 truncate max-w-[130px]">{{ $trx->event->title ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($trx->status === 'settlement' || $trx->status === 'success')
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-bold uppercase">Lunas</span>
                            @elseif($trx->status === 'pending')
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-lg text-[10px] font-bold uppercase">Pending</span>
                            @else
                                <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-lg text-[10px] font-bold uppercase">{{ $trx->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-black text-indigo-600 text-sm text-right whitespace-nowrap">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
   {{-- ── CHART.JS ── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const months        = @json($months);
    const userGrowth    = @json($userGrowth);
    const eventGrowth   = @json($eventGrowth);
    const revenueGrowth = @json($revenueGrowth);

    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

    const tooltipDefaults = {
        backgroundColor: '#1e293b',
        titleColor: '#94a3b8',
        bodyColor: '#f1f5f9',
        padding: 12,
        cornerRadius: 10,
        mode: 'index',
        intersect: false,
    };

    const xAxis = {
        grid: { display: false },
        ticks: { font: { size: 10, weight: '600' }, color: '#94a3b8', maxRotation: 30 }
    };

    // ── Grafik Line: Pengguna Baru & Event Dibuat ──
    const ctx1 = document.getElementById('growthChart').getContext('2d');
    const grad1 = ctx1.createLinearGradient(0, 0, 0, 300);
    grad1.addColorStop(0, 'rgba(79, 70, 229, 0.3)');
    grad1.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

    const grad2 = ctx1.createLinearGradient(0, 0, 0, 300);
    grad2.addColorStop(0, 'rgba(56, 189, 248, 0.3)');
    grad2.addColorStop(1, 'rgba(56, 189, 248, 0.0)');

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: months.map(m => m.split(' ')[0]),
            datasets: [
                {
                    label: 'Pengguna Baru',
                    data: userGrowth,
                    borderColor: '#4f46e5',
                    backgroundColor: grad1,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: 'Event Dibuat',
                    data: eventGrowth,
                    borderColor: '#38bdf8',
                    backgroundColor: grad2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#38bdf8',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: tooltipDefaults,
            },
            scales: {
                x: xAxis,
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 10, weight: '600' },
                        color: '#94a3b8',
                        precision: 0
                    }
                }
            }
        }
    });

    // ── Grafik Bar: Pendapatan Bulanan ──
    const ctx2 = document.getElementById('revenueChart').getContext('2d');
    const gradBar = ctx2.createLinearGradient(0, 0, 0, 300);
    gradBar.addColorStop(0, '#4f46e5');
    gradBar.addColorStop(1, '#818cf8');

    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: months.map(m => m.split(' ')[0]),
            datasets: [
                {
                    label: 'Pendapatan',
                    data: revenueGrowth,
                    backgroundColor: gradBar,
                    hoverBackgroundColor: '#4f46e5',
                    borderRadius: 6,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...tooltipDefaults,
                    callbacks: {
                        label: ctx => '  Rp ' + ctx.raw.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10, weight: '600' }, color: '#94a3b8' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 10, weight: '600' },
                        color: '#94a3b8',
                        callback: val => val >= 1000000
                            ? (val / 1000000).toFixed(1) + ' jt'
                            : val >= 1000
                                ? (val / 1000).toFixed(0) + ' rb'
                                : val
                    }
                }
            }
        }
    });
</script>
@endsection