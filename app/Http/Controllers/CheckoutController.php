<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        if ($event->organizer_id) {
            $org = $event->organization;
            if (!$org || $org->status !== 'active') {
                abort(404, 'Event tidak tersedia untuk pemesanan.');
            }
        }

        if ($event->date->isPast()) {
            return redirect()->route('events.show', $event->id)->with('error', 'Event ini sudah selesai dan tidak dapat dipesan lagi.');
        }

        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        if ($event->organizer_id) {
            $org = $event->organization;
            if (!$org || $org->status !== 'active') {
                abort(404, 'Event tidak tersedia untuk pemesanan.');
            }
        }

        if ($event->date->isPast()) {
            return redirect()->route('events.show', $event->id)->with('error', 'Event ini sudah selesai dan tidak dapat dipesan lagi.');
        }

        // 1. Validasi Input Kredensial Pelanggan
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        $orderId = 'TRX-' . time() . '-' . Str::random(5);
        $totalPrice = $event->price;

        try {
            $transaction = \Illuminate\Support\Facades\DB::transaction(function () use ($request, $event, $orderId, $totalPrice) {
                // Kunci baris data event untuk mencegah race condition (lock for update)
                $lockedEvent = Event::where('id', $event->id)->lockForUpdate()->first();

                // 2. Cegah Check-out Jika Tiket Habis
                if ($lockedEvent->stock <= 0) {
                    throw new \Exception('Mohon maaf, tiket untuk acara ini sudah habis.');
                }

                // 3. Kurangi stok langsung (Reserved)
                $lockedEvent->stock = $lockedEvent->stock - 1;
                $lockedEvent->save();

                // 4. Merekam Transaksi ke Database
                return Transaction::create([
                    'event_id' => $event->id,
                    'order_id' => $orderId,
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'total_price' => $totalPrice,
                    'status' => 'Pending', // Status Awal
                    'reserved_at' => now(), // Catat waktu penahanan stok
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        // --- INTEGRASI SNAP MIDTRANS ---

        // Konfigurasi Kredensial Environment Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false; // Mode Sandbox!
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Susun Paket Array Data Transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ];

        try {
            // Perintah Tembak Generate Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update rekaman kita bahwa transaksi terkait sudah memiliki id token pelunasan
            $transaction->update(['snap_token' => $snapToken]);

            // Redirect ke halaman antarmuka pembayaran final pelanggan
            return redirect()->route('checkout.payment', $transaction->order_id);
        } catch (\Exception $e) {
            // Jika midtrans gagal, kembalikan stok
            try {
                \Illuminate\Support\Facades\DB::transaction(function () use ($event) {
                    $lockedEvent = Event::where('id', $event->id)->lockForUpdate()->first();
                    $lockedEvent->stock = $lockedEvent->stock + 1;
                    $lockedEvent->save();
                });
            } catch (\Exception $ex) {
                Log::error('Gagal memulihkan stok saat error midtrans: ' . $ex->getMessage());
            }

            return back()->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
    }

    public function payment($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        
        // Konfigurasi Midtrans untuk mengecek status transaksi langsung ke API
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            // Mengecek status pesanan secara mandiri (Bypass)
            $status = \Midtrans\Transaction::status($order_id);
            
            if ($status) {
                // Mengambil nilai status transaksi
                $trx_status = is_array($status) ? ($status['transaction_status'] ?? '') : ($status->transaction_status ?? '');
                
                // Jika API Midtrans mengonfirmasi bahwa transaksi telah berhasil (settlement / capture)
                if (in_array($trx_status, ['settlement', 'capture'])) {
                    // Hanya lakukan update jika status di database lokal masih 'pending' (indikasi Webhook tidak masuk)
                    if (strtolower($transaction->status) === 'pending') {
                        $transaction->update(['status' => 'success']);
                        
                        try {
                            \Illuminate\Support\Facades\Mail::to($transaction->customer_email)
                                ->send(new \App\Mail\EventTicketMail($transaction));
                        } catch (\Exception $e) {
                            Log::error('Gagal mengirim email E-Ticket secara manual (Bypass): ' . $e->getMessage());
                        }
                    }
                } elseif (in_array($trx_status, ['deny', 'expire', 'cancel'])) {
                    if (strtolower($transaction->status) === 'pending') {
                        $transaction->update(['status' => 'failed']);
                    }
                }
            }
        } catch (\Exception $e) {
            // Jika terjadi error dari API Midtrans (transaksi tidak valid), kembalikan ke beranda
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }

}
