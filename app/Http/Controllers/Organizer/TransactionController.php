<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $org = Auth::user()->organization;

        if (!$org || $org->status !== 'active') {
            abort(403, 'Akses ditolak.');
        }

        // Ambil ID event milik organisasi ini
        $eventIds = Event::where('organizer_id', $org->id)->pluck('id');

        // Paginate transaksi yang berhubungan dengan event organisasi ini
        $transactions = Transaction::with('event')
            ->whereIn('event_id', $eventIds)
            ->latest()
            ->paginate(20);

        return view('organizer.transactions.index', compact('transactions'));
    }
}
