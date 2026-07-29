<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Event $event)
    {
        // 1. Harus login
        if (!Auth::check()) {
            return redirect()->route('user.login')
                ->with('error', 'Silakan login terlebih dahulu untuk memberikan ulasan.');
        }

        $user = Auth::user();

        // 2. Event harus sudah dimulai / selesai
        if (now()->lt($event->date)) {
            return back()->with('error', 'Ulasan hanya dapat diberikan setelah acara dimulai.');
        }

        // 3. User harus punya transaksi settled atau success untuk event ini (case-insensitive email)
        $hasTransaction = Transaction::where('event_id', $event->id)
            ->whereRaw('LOWER(customer_email) = ?', [strtolower($user->email)])
            ->whereIn('status', ['settlement', 'success'])
            ->exists();

        if (!$hasTransaction) {
            return back()->with('error', 'Anda hanya dapat mengulas event yang pernah Anda beli tiketnya.');
        }

        // 4. Satu review per user per event
        $alreadyReviewed = Review::where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk event ini.');
        }

        // 5. Validasi & simpan
        $validated = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        Review::create([
            'event_id' => $event->id,
            'user_id'  => $user->id,
            'rating'   => $validated['rating'],
            'comment'  => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}
