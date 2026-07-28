@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-16">
    <div class="max-w-7xl mx-auto px-6">
        
        <!-- Header Section -->
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider mb-4">
                Tentang Kami
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 leading-tight mb-6">
                Membawa Event Terbaik Lebih Dekat dengan Anda
            </h1>
            <p class="text-lg text-slate-500 leading-relaxed">
                AmikomEventHub adalah platform manajemen dan reservasi tiket event online terdepan di Universitas Amikom Yogyakarta yang menghubungkan penyelenggara acara dengan audiens secara praktis, aman, dan inovatif.
            </p>
        </div>

        <!-- Main Info -->
        <div class="flex flex-col lg:flex-row items-center gap-16 mb-24">
            <div class="flex-1 space-y-6">
                <h2 class="text-3xl font-bold text-slate-800">
                    Visi & Misi Kami
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Kami percaya bahwa setiap acara,baik itu seminar akademis, workshop teknologi, hingga festival musik, layak mendapatkan manajemen terbaik dan akses yang mudah bagi semua orang. Misi kami adalah menghilangkan hambatan dalam pemesanan tiket dan mempermudah penyelenggara mengelola peserta secara real-time.
                </p>
                <div class="space-y-6 pt-4">
                    <div>
                        <h4 class="font-bold text-slate-800 text-lg">Ekosistem Digital Terintegrasi</h4>
                        <p class="text-sm text-slate-500 mt-1">Dari pemasaran event, pembayaran instan, hingga sistem check-in tiket di lokasi.</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-lg">Keamanan Transaksi & Kehadiran</h4>
                        <p class="text-sm text-slate-500 mt-1">Setiap tiket dilengkapi QR Code unik yang terverifikasi aman demi kenyamanan Anda.</p>
                    </div>
                </div>
            </div>
            
            <div class="flex-1 w-full">
                <div class="bg-gradient-to-tr from-indigo-600 to-indigo-900 text-white p-10 rounded-[2.5rem] shadow-2xl space-y-8">
                    <h3 class="text-2xl font-bold">Mengapa AmikomEventHub?</h3>
                    <div class="space-y-4">
                        <div class="bg-white/10 p-5 rounded-2xl backdrop-blur-sm">
                            <h5 class="font-bold text-white text-base">Mudah & Instan</h5>
                            <p class="text-xs text-indigo-100 mt-1">Pendaftaran organizer mudah, persetujuan cepat, dan langsung aktif.</p>
                        </div>
                        <div class="bg-white/10 p-5 rounded-2xl backdrop-blur-sm">
                            <h5 class="font-bold text-white text-base">Midtrans Payment Gateway</h5>
                            <p class="text-xs text-indigo-100 mt-1">Mendukung berbagai metode pembayaran otomatis yang aman dan terverifikasi cepat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="bg-white border border-slate-100 rounded-3xl p-12 shadow-sm text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <p class="text-5xl font-black text-indigo-600">10k+</p>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Tiket Terjual</p>
                </div>
                <div class="space-y-2 border-y md:border-y-0 md:border-x border-slate-100 py-6 md:py-0">
                    <p class="text-5xl font-black text-indigo-600">100+</p>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Event Sukses</p>
                </div>
                <div class="space-y-2">
                    <p class="text-5xl font-black text-indigo-600">50+</p>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Mitra Organisasi</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
