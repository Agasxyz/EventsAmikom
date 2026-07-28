<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function show(\App\Models\Event $event)
    {
        // Jika event memiliki organizer, pastikan status organisasinya aktif
        if ($event->organizer_id) {
            $org = $event->organization;
            if (!$org || $org->status !== 'active') {
                abort(404, 'Event tidak ditemukan atau penyelenggara sedang dinonaktifkan.');
            }
        }

        $categories = \App\Models\Category::all();

        // Eager-load reviews beserta data user-nya (avatar / nama)
        $event->load(['reviews.user', 'organization']);

        // Cek apakah user yang sedang login boleh memberikan review
        $canReview   = false;
        $userReview  = null;

        if (Auth::check()) {
            $user = Auth::user();

            // Sudah pernah review?
            $userReview = Review::where('event_id', $event->id)
                ->where('user_id', $user->id)
                ->first();

            if (!$userReview) {
                // Event harus sudah selesai minimal 1 hari
                $eventEnded = now()->gte($event->date->addDay());

                // Harus punya transaksi settlement atau success
                $hasTicket = Transaction::where('event_id', $event->id)
                    ->where('customer_email', $user->email)
                    ->whereIn('status', ['settlement', 'success'])
                    ->exists();

                $canReview = $eventEnded && $hasTicket;
            }
        }

        return view('event-detail', compact('categories', 'event', 'canReview', 'userReview'));
    }

    function checkout()
    {
        return view('checkout');
    }

    function ticket()
    {
        return view('ticket');
    }
}

