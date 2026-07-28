<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('MIDTRANS CALLBACK MASUK', $request->all());

        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Mencari ID transaksi tersebut di database lokal kita
        $transaction = Transaction::with('event')->where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Cegah proses berulang jika status sudah lunas/sukses
        if ($transaction->status === 'settlement' || $transaction->status === 'success') {
            return response()->json(['message' => 'Already processed']);
        }

        // Logika Penerjemahan Status Midtrans API
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->status = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->status = 'settlement';
            $this->processSuccess($transaction);
        } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'failed';
            $this->releaseStock($transaction);
        } else if ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        }

        $transaction->save();
        return response()->json(['message' => 'OK']);
    }

    private function processSuccess(Transaction $transaction)
    {
        // Mengirimkan email E-Ticket ke pelanggan (stok sudah dikurangi di awal saat checkout)
        try {
            \Illuminate\Support\Facades\Mail::to($transaction->customer_email)->send(new \App\Mail\EventTicketMail($transaction));
            Log::info('E-Ticket berhasil dikirimkan ke pelanggan: ' . $transaction->customer_email);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
        }
    }

    private function releaseStock(Transaction $transaction)
    {
        if ($transaction->event) {
            try {
                \Illuminate\Support\Facades\DB::transaction(function () use ($transaction) {
                    $event = \App\Models\Event::where('id', $transaction->event_id)->lockForUpdate()->first();
                    if ($event) {
                        $event->stock = $event->stock + 1;
                        $event->save();
                        Log::info('Stok tiket dilepas/dikembalikan (+1) untuk event ID: ' . $event->id . ' karena transaksi dibatalkan/expired. Order: ' . $transaction->order_id);
                    }
                });
            } catch (\Exception $e) {
                Log::error('Gagal melepaskan stok tiket: ' . $e->getMessage());
            }
        }
    }
}