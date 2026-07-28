@extends('layouts.app')
@section('title', 'Pembayaran - ' . $transaction->event->title)
@section('content')
<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">
        @if(strtolower($transaction->status) === 'failed')
            <div class="w-20 h-20 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-black mb-2 text-rose-600">Pembayaran Kedaluwarsa</h2>
            <p class="text-slate-500 mb-8">Batas waktu pembayaran 15 menit telah habis. Stok tiket telah dilepas kembali. Silakan lakukan pemesanan ulang.</p>
            <a href="{{ route('home') }}" class="w-full block py-4 bg-slate-800 text-white rounded-2xl font-black text-lg hover:bg-slate-900 transition">
                Kembali ke Beranda
            </a>
        @elseif(strtolower($transaction->status) === 'success' || strtolower($transaction->status) === 'settlement')
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-black mb-2 text-emerald-600">Pembayaran Berhasil</h2>
            <p class="text-slate-500 mb-8">Terima kasih, pembayaran tiket Anda telah terverifikasi sukses.</p>
            <a href="{{ route('home') }}" class="w-full block py-4 bg-slate-800 text-white rounded-2xl font-black text-lg hover:bg-slate-900 transition">
                Kembali ke Beranda
            </a>
        @else
            <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-black mb-2">Selesaikan Pembayaran</h2>
            <p class="text-slate-500 mb-8">Mohon selesaikan pembayaran tiket Anda untuk event <strong>{{ $transaction->event->title }}</strong>.</p>

            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 mb-8">
                <p class="text-sm text-slate-400 font-bold uppercase tracking-wider mb-1">Total Tagihan</p>
                <h3 class="text-4xl font-extrabold text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-400 mt-2">Order ID: {{ $transaction->order_id }}</p>
            </div>

            <button id="pay-button" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition animate-bounce-in">
                Bayar Sekarang
            </button>
        @endif
    </div>
</main>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    if (payButton) {
        payButton.onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $transaction->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
                },
                // Optional
                onPending: function(result) {
                    window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
                },
                // Optional
                onError: function(result) {
                    alert("Pembayaran Gagal!");
                }
            });
        };

        // Auto trigger
        window.onload = function() {
            payButton.click();
        }
    }
</script>

<style>
    @keyframes bounce-in {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }

        70% {
            transform: scale(1.05);
            opacity: 1;
        }

        100% {
            transform: scale(1);
        }
    }

    .animate-bounce-in {
        animation: bounce-in 0.4s ease-out forwards;
    }
</style>
@endsection