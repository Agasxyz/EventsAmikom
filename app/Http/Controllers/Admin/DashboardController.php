<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total pendapatan transaksi lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');

        // 2. Total tiket terjual
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();

        // 3. Event aktif mendatang
        $activeEvents = Event::where('date', '>=', now())->count();

        // 4. Pesanan pending
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 5. Partner penyelenggara aktif
        $activePartners = Organization::where('status', 'active')->count();

        // 6. Total pengguna terdaftar
        $totalUsers = User::where('role', 'user')->count();

        // 7. Riwayat 5 transaksi terbaru
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        // ── DATA GRAFIK 12 BULAN TERAKHIR (MONTHLY) ──────────────────────────
        $months      = [];
        $userGrowth  = [];
        $eventGrowth = [];
        $revenueGrowth = [];

        for ($i = 11; $i >= 0; $i--) {
            $date  = Carbon::now()->subMonths($i);
            $year  = $date->year;
            $month = $date->month;

            $months[] = $date->format('M Y');

            $userGrowth[] = User::where('role', 'user')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();

            $eventGrowth[] = Event::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();

            $revenueGrowth[] = (int) Transaction::whereIn('status', ['settlement', 'success'])
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('total_price');
        }

        // Top 5 event berdasarkan jumlah tiket terjual
        $topEvents = Event::withCount(['transactions' => function ($q) {
                $q->whereIn('status', ['settlement', 'success']);
            }])
            ->orderByDesc('transactions_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'ticketsSold', 'activeEvents', 'pendingOrders',
            'activePartners', 'totalUsers', 'recentTransactions',
            'months', 'userGrowth', 'eventGrowth', 'revenueGrowth',
            'topEvents'
        ));
    }
}