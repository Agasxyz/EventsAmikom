<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScannerController extends Controller
{
    private function getOrganizer()
    {
        $org = Auth::user()->organization;
        if (!$org || $org->status !== 'active') {
            abort(403, 'Organisasi Anda tidak aktif / belum terdaftar.');
        }
        return $org;
    }

    /**
     * Show check-in scanner page.
     */
    public function index(Event $event)
    {
        $org = $this->getOrganizer();

        if ($event->organizer_id !== $org->id) {
            abort(403, 'Akses ditolak.');
        }

        return view('organizer.scanner.index', compact('event'));
    }

    /**
     * Process check-in scan.
     */
    public function checkIn(Request $request, Event $event)
    {
        $org = $this->getOrganizer();

        if ($event->organizer_id !== $org->id) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $request->validate([
            'order_id' => 'required|string'
        ]);

        $orderId = $request->input('order_id');

        $transaction = Transaction::where('event_id', $event->id)
            ->where('order_id', $orderId)
            ->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak valid / tidak terdaftar untuk event ini.'
            ], 404);
        }

        // Check payment status
        if (!in_array(strtolower($transaction->status), ['settlement', 'success'])) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket gagal digunakan karena pembayaran belum lunas (Status: ' . $transaction->status . ').'
            ], 400);
        }

        // Check if ticket is already scanned (used)
        if ($transaction->is_used) {
            $usedTime = $transaction->used_at 
                ? \Carbon\Carbon::parse($transaction->used_at)->format('d M Y, H:i') . ' WIB' 
                : 'waktu tidak diketahui';
            return response()->json([
                'success' => false,
                'message' => 'DOUBLE ENTRY DETECTED! Tiket ini sudah digunakan pada ' . $usedTime . '.'
            ], 400);
        }

        // Mark as used
        $transaction->update([
            'is_used' => true,
            'used_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in Berhasil! Selamat datang di acara.',
            'data' => [
                'name' => $transaction->customer_name,
                'email' => $transaction->customer_email,
                'phone' => $transaction->customer_phone,
                'order_id' => $transaction->order_id,
                'checked_in_at' => now()->format('d M Y, H:i') . ' WIB'
            ]
        ]);
    }
}
