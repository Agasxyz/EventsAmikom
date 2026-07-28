@extends('layouts.app')

@section('title', strtolower($transaction->status) === 'success' ? 'Pembayaran Berhasil' : (strtolower($transaction->status) === 'pending' ? 'Menunggu Pembayaran' : 'Pembayaran Gagal'))

@section('content')
<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">
        
        @if(strtolower($transaction->status) === 'success')
            {{-- Status Sukses / Lunas --}}
            <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black mb-4">Terima Kasih!</h2>
            <p class="text-slate-500 mb-8 leading-relaxed">
                Pembayaran untuk pesanan <strong>{{ $transaction->order_id }}</strong> telah berhasil diverifikasi. 
                E-Ticket resmi telah dikirim ke email Anda (<strong>{{ $transaction->customer_email }}</strong>).
            </p>
            <a href="{{ route('home') }}" class="inline-block w-full py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Kembali ke Beranda
            </a>

        @elseif(strtolower($transaction->status) === 'pending')
            {{-- Status Pending / Menunggu Pembayaran --}}
            <div class="w-24 h-24 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black mb-4">Menunggu Pembayaran</h2>
            <p class="text-slate-500 mb-8 leading-relaxed">
                Pemesanan tiket Anda dengan kode <strong>{{ $transaction->order_id }}</strong> berhasil dibuat, namun belum ada pembayaran yang diterima.
                Segera selesaikan pembayaran Anda agar e-ticket dapat dikirimkan.
            </p>
            <div class="space-y-3">
                <a href="{{ route('checkout.payment', $transaction->order_id) }}" class="inline-block w-full py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                    Selesaikan Pembayaran Sekarang
                </a>
                <a href="{{ route('home') }}" class="inline-block w-full py-4 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">
                    Kembali ke Beranda
                </a>
            </div>

        @else
            {{-- Status Gagal / Expired / Deny --}}
            <div class="w-24 h-24 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black mb-4">Pembayaran Gagal</h2>
            <p class="text-slate-500 mb-8 leading-relaxed">
                Transaksi Anda dengan kode <strong>{{ $transaction->order_id }}</strong> telah kedaluwarsa atau ditolak oleh sistem pembayaran.
                Silakan lakukan pemesanan ulang.
            </p>
            <a href="{{ route('home') }}" class="inline-block w-full py-4 bg-rose-600 text-white rounded-xl font-bold hover:bg-rose-700 transition">
                Kembali ke Beranda
            </a>
        @endif

    </div>
</main>
@endsection
