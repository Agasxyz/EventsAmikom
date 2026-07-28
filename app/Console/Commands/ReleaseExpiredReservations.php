<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReleaseExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:release-expired-reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release ticket stock for pending reservations that have expired (older than 15 minutes)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredTime = now()->subMinutes(15);

        // Ambil transaksi pending yang sudah kadaluarsa (reserved_at < 15 menit yang lalu)
        $expiredTransactions = Transaction::where('status', 'Pending')
            ->whereNotNull('reserved_at')
            ->where('reserved_at', '<', $expiredTime)
            ->get();

        if ($expiredTransactions->isEmpty()) {
            $this->info('No expired reservations found.');
            return 0;
        }

        $releasedCount = 0;

        foreach ($expiredTransactions as $transaction) {
            try {
                DB::transaction(function () use ($transaction, &$releasedCount) {
                    // Kunci baris event untuk menghindari race condition
                    $event = Event::where('id', $transaction->event_id)->lockForUpdate()->first();
                    
                    if ($event) {
                        // Kembalikan stok tiket (+1)
                        $event->stock = $event->stock + 1;
                        $event->save();

                        // Ubah status transaksi menjadi failed (expired)
                        $transaction->status = 'failed';
                        $transaction->save();

                        $releasedCount++;
                        $this->info("Released ticket for Order: {$transaction->order_id} (Event: {$event->title})");
                        Log::info("Auto-released stock for Order: {$transaction->order_id} due to 15-minute payment timeout.");
                    }
                });
            } catch (\Exception $e) {
                $this->error("Failed to release reservation for Order: {$transaction->order_id}. Error: " . $e->getMessage());
                Log::error("Failed to auto-release stock for Order: {$transaction->order_id}. Error: " . $e->getMessage());
            }
        }

        $this->info("Successfully released {$releasedCount} expired reservations.");
        return 0;
    }
}
