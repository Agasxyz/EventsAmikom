<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $org = $user->organization;

        if (!$org) {
            return redirect()->route('organizer.register');
        }

        // Jika status pending/suspended, akan dihadang middleware, namun sedia penanganan darurat
        if ($org->status !== 'active') {
            abort(403, 'Organisasi Anda berstatus: ' . strtoupper($org->status) . '. Silakan hubungi Superadmin.');
        }

        // Ambil ID event milik organisasi ini
        $eventIds = Event::where('organizer_id', $org->id)->pluck('id');

        // 1. Total Pendapatan
        $totalRevenue = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])
            ->sum('total_price');

        // 2. Tiket Terjual (Jumlah transaksi sukses)
        $ticketsSold = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])
            ->count();

        // 3. Event Aktif milik organisasi
        $activeEvents = Event::where('organizer_id', $org->id)
            ->where('date', '>=', now())
            ->count();

        // 4. Rata-rata Rating ulasan untuk seluruh event milik organisasi
        $avgRating = Review::whereIn('event_id', $eventIds)->avg('rating');
        $avgRating = $avgRating ? round($avgRating, 1) : 0;

        // 5. Riwayat 5 transaksi terakhir khusus event milik organisasi ini
        $recentTransactions = Transaction::with('event')
            ->whereIn('event_id', $eventIds)
            ->latest()
            ->take(5)
            ->get();

        return view('organizer.dashboard', compact(
            'org',
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'avgRating',
            'recentTransactions'
        ));
    }
}
