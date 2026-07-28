@extends('layouts.organizer')

@section('page_title')
    Check-in Scanner: {{ $event->title }}
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Panduan Cepat & Info Acara -->
    <div class="bg-gradient-to-r from-indigo-900 to-indigo-700 text-white rounded-3xl p-6 md:p-8 shadow-xl relative overflow-hidden">
        <div class="absolute right-0 top-0 translate-x-12 -translate-y-12 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="relative z-10 space-y-4">
            <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-bold uppercase tracking-wider">Aplikasi Registrasi Hari-H</span>
            <h3 class="text-2xl md:text-3xl font-black">{{ $event->title }}</h3>
            <div class="flex flex-wrap gap-4 text-sm text-indigo-100">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }} WIB
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $event->location }}
                </span>
            </div>
        </div>
    </div>

    <!-- Layout Grid Utama (Scanner & Status/Manual Input) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Kolom Scanner -->
        <div class="lg:col-span-7 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-6 flex flex-col items-center">
            <div class="w-full flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-rose-500 rounded-full animate-ping"></span>
                    <h4 class="font-bold text-slate-800 text-lg">Scan QR Code Tiket</h4>
                </div>
                {{-- Tombol Flip Kamera --}}
                <button id="btn-flip-camera" onclick="flipCamera()" title="Ganti Kamera"
                    class="hidden items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-xl text-xs font-bold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Balik Kamera
                </button>
            </div>

            <!-- Kamera Box Area -->
            <div id="camera-box" style="width:100%; max-width:360px; height:360px; background:#0f172a; border-radius:1rem; overflow:hidden; position:relative; border:4px solid #e0e7ff;">
                
                <!-- Animasi Laser Line Scan (hanya tampil saat aktif) -->
                <div id="laser-line" class="hidden" style="position:absolute; left:0; right:0; height:2px; background:rgba(99,102,241,0.8); box-shadow:0 0 12px #6366f1; top:0; z-index:20; pointer-events:none; animation:scanner-laser 3s ease-in-out infinite;"></div>

                <!-- Pemutar Kamera HTML5 QR -->
                <div id="reader" style="width:100%; height:100%;"></div>

                <!-- Overlay Placeholder Kamera Belum Aktif -->
                <div id="scanner-placeholder" style="position:absolute; inset:0; background:rgba(2,6,23,0.9); display:flex; flex-direction:column; align-items:center; justify-content:center; padding:1.5rem; text-align:center; gap:1rem; z-index:10; transition:opacity 0.3s;">
                    <div class="w-16 h-16 bg-indigo-900/50 rounded-full flex items-center justify-center text-indigo-400">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                            <!-- Top Left Finder -->
                            <path d="M2 2h7v7H2V2zm1.5 1.5v4h4v-4h-4z"/>
                            <path d="M4.5 4.5h2v2h-2v-2z"/>
                            <!-- Top Right Finder -->
                            <path d="M15 2h7v7h-7V2zm1.5 1.5v4h4v-4h-4z"/>
                            <path d="M17.5 4.5h2v2h-2v-2z"/>
                            <!-- Bottom Left Finder -->
                            <path d="M2 15h7v7H2v-7zm1.5 1.5v4h4v-4h-4z"/>
                            <path d="M4.5 17.5h2v2h-2v-2z"/>
                            <!-- Data modules/pixels -->
                            <rect x="11" y="2" width="2" height="2"/>
                            <rect x="11" y="6" width="2" height="2"/>
                            <rect x="11" y="10" width="2" height="2"/>
                            <rect x="11" y="14" width="2" height="2"/>
                            <rect x="11" y="18" width="2" height="2"/>
                            <rect x="2" y="11" width="2" height="2"/>
                            <rect x="6" y="11" width="2" height="2"/>
                            <rect x="15" y="11" width="2" height="2"/>
                            <rect x="19" y="11" width="2" height="2"/>
                            <rect x="15" y="15" width="2" height="2"/>
                            <rect x="17" y="17" width="2" height="2"/>
                            <rect x="19" y="15" width="2" height="2"/>
                            <rect x="21" y="17" width="2" height="2"/>
                            <rect x="15" y="19" width="2" height="2"/>
                            <rect x="17" y="21" width="2" height="2"/>
                            <rect x="19" y="19" width="2" height="2"/>
                            <rect x="21" y="21" width="2" height="2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-300">Kamera Belum Aktif</p>
                        <p class="text-xs text-slate-500 mt-1">Izinkan akses kamera dan klik tombol di bawah untuk memulai.</p>
                    </div>
                    <button onclick="startScanning()" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-indigo-900/20 flex items-center gap-1.5 mx-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Aktifkan Kamera
                    </button>
                </div>
            </div>

            <!-- Tombol Kontrol Scanner -->
            <div class="w-full flex justify-center gap-3">
                <button id="btn-stop-scan" onclick="stopScanning()" disabled
                    class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 disabled:opacity-50 disabled:cursor-not-allowed text-slate-700 rounded-xl text-xs font-bold transition">
                    Hentikan Scanner
                </button>
            </div>
        </div>

        <!-- Kolom Status & Pencarian Manual -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Pencarian / Input Manual -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h4 class="font-bold text-slate-800 text-lg">Input Manual Order ID</h4>
                <p class="text-xs text-slate-400">Gunakan kolom ini apabila kode QR rusak, kamera kotor, atau tidak dapat fokus.</p>
                <form id="manual-checkin-form" onsubmit="handleManualSubmit(event)" class="flex gap-2">
                    <input type="text" id="manual-order-id" placeholder="Contoh: ORDER-12345678" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white placeholder:text-slate-400 uppercase">
                    <button type="submit" class="px-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition flex items-center justify-center">
                        Proses
                    </button>
                </form>
            </div>

            <!-- Hasil / Response Umpan Balik -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm min-h-[300px] flex flex-col justify-center relative overflow-hidden">
                
                <!-- Status default (Belum memindai) -->
                <div id="status-default" class="text-center p-6 space-y-3">
                    <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center text-slate-400 mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <h5 class="font-bold text-slate-700 text-sm">Menunggu Tiket Dipindai</h5>
                        <p class="text-xs text-slate-400 mt-1">Status tiket yang terdaftar akan ditampilkan di sini setelah dipindai.</p>
                    </div>
                </div>

                <!-- Status Berhasil -->
                <div id="status-success" class="hidden space-y-6">
                    <div class="text-center">
                        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-xl font-bold mb-3 shadow-md shadow-emerald-100">
                            ✓
                        </div>
                        <h5 id="success-heading" class="font-black text-emerald-600 text-lg">Check-in Berhasil!</h5>
                        <p class="text-xs text-slate-400 mt-1">Tiket asli & sah. Status tiket kini menjadi <span class="bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full font-bold">USED</span>.</p>
                    </div>

                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-xs space-y-3 font-semibold">
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-400">NAMA PESERTA</span>
                            <span id="success-name" class="text-slate-800 font-bold">Bagas Pamungkas</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-400">EMAIL</span>
                            <span id="success-email" class="text-slate-800 font-bold">bagas@example.com</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-400">TELEPON</span>
                            <span id="success-phone" class="text-slate-800 font-bold">081234567890</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100 text-mono">
                            <span class="text-slate-400">ORDER ID</span>
                            <span id="success-order" class="text-indigo-600 font-bold uppercase">ORDER-10023412</span>
                        </div>
                        <div class="flex justify-between py-1.5">
                            <span class="text-slate-400">WAKTU CHECK-IN</span>
                            <span id="success-time" class="text-slate-800 font-bold">27 Jul 2026, 16:30 WIB</span>
                        </div>
                    </div>
                </div>

                <!-- Status Gagal / Double Entry -->
                <div id="status-error" class="hidden space-y-6">
                    <div class="text-center">
                        <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto text-xl font-bold mb-3 shadow-md shadow-rose-100">
                            ✗
                        </div>
                        <h5 class="font-black text-rose-600 text-lg">Check-in Gagal!</h5>
                        <p id="error-message" class="text-xs text-rose-500 font-semibold px-4 mt-1">Tiket ini sudah digunakan sebelumnya (Double Entry).</p>
                    </div>

                    <div class="border border-rose-100 bg-rose-50/50 rounded-2xl p-4 text-center">
                        <p class="text-xs text-rose-600 font-semibold leading-relaxed">
                            Peringatan: Jangan ijinkan peserta ini masuk sebelum verifikasi bukti identitas fisik di meja bantuan.
                        </p>
                    </div>
                </div>

                <!-- Loading Spinner Overlay -->
                <div id="loading-overlay" class="hidden absolute inset-0 bg-white/80 flex items-center justify-center z-30">
                    <div class="w-10 h-10 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- CSS Tambahan untuk Scanner -->
<style>
    @keyframes scanner-laser {
        0%, 100% { top: 0%; }
        50%       { top: 100%; }
    }

    /* CSS minimal untuk menghias container html5-qrcode */
    #reader {
        width: 100%;
        height: 100% !important;
        border: none !important;
    }
    #reader video {
        object-fit: cover !important;
        border-radius: 0.75rem;
        width: 100% !important;
        height: 100% !important;
    }
    /* Sembunyikan tombol dan label bawaan yang tidak rapi */
    #reader__scan_region img {
        display: none !important;
    }
    #reader__dashboard {
        display: none !important;
    }
</style>

<!-- JS Dependencies: html5-qrcode & fetch AJAX -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    let html5QrCode = null;
    let cameras = [];
    let currentCameraIndex = 0;
    
    const scannerPlaceholder = document.getElementById('scanner-placeholder');
    const btnStopScan = document.getElementById('btn-stop-scan');
    const btnFlipCamera = document.getElementById('btn-flip-camera');

    window.addEventListener('DOMContentLoaded', () => {});

    function updateCameraList() {}

    function startScanning() {
        // Sembunyikan placeholder dengan fade out
        scannerPlaceholder.style.opacity = '0';
        setTimeout(() => { scannerPlaceholder.style.display = 'none'; }, 300);

        // Ambil daftar kamera fisik terlebih dahulu
        Html5Qrcode.getCameras().then(devices => {
            cameras = devices;
            if (!cameras || cameras.length === 0) {
                alert("Tidak ada kamera yang terdeteksi.");
                resetScannerUI();
                return;
            }

            html5QrCode = new Html5Qrcode("reader");

            const config = {
                fps: 15,
                aspectRatio: 1.0,
                qrbox: function(width, height) {
                    const minEdge = Math.min(width, height);
                    const qrboxSize = Math.floor(minEdge * 0.7);
                    return { width: qrboxSize, height: qrboxSize };
                },
                videoConstraints: {
                    width: { ideal: 720 },
                    height: { ideal: 720 },
                    aspectRatio: { ideal: 1.0 }
                },
                experimentalFeatures: {
                    useBarCodeDetectorIfSupported: false
                }
            };

            // Cari kamera belakang (back/rear/belakang) secara default
            let backCamIndex = cameras.findIndex(cam => {
                const label = cam.label.toLowerCase();
                return label.includes('back') || label.includes('rear') || label.includes('environment') || label.includes('belakang') || label.includes('main');
            });

            // Gunakan kamera belakang jika ada, jika tidak ada gunakan kamera pertama (indeks 0)
            if (backCamIndex !== -1) {
                currentCameraIndex = backCamIndex;
            } else {
                currentCameraIndex = 0;
            }

            const targetCameraId = cameras[currentCameraIndex].id;

            html5QrCode.start(
                targetCameraId,
                config,
                (decodedText, decodedResult) => {
                    stopScanning();
                    processCheckIn(decodedText);
                },
                (errorMessage) => {}
            ).then(() => {
                btnStopScan.disabled = false;
                document.getElementById('laser-line').classList.remove('hidden');
                
                // Tampilkan tombol flip jika terdeteksi lebih dari satu kamera
                if (cameras.length > 1) {
                    btnFlipCamera.classList.remove('hidden');
                    btnFlipCamera.classList.add('flex');
                } else {
                    btnFlipCamera.classList.add('hidden');
                    btnFlipCamera.classList.remove('flex');
                }
            }).catch(err => {
                console.error("Gagal menjalankan kamera: ", err);
                alert("Gagal mengaktifkan kamera. Pastikan izin kamera sudah diberikan.");
                resetScannerUI();
            });

        }).catch(err => {
            console.error("Gagal mendapatkan daftar kamera: ", err);
            alert("Gagal mengakses kamera. Mohon berikan izin kamera pada browser Anda (klik ikon gembok di sebelah alamat URL).");
            resetScannerUI();
        });
    }

    async function flipCamera() {
        if (!cameras || cameras.length <= 1) return;

        btnFlipCamera.disabled = true;
        btnFlipCamera.innerHTML = `<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Mengganti...`;
        
        try {
            // Stop stream kamera saat ini
            await html5QrCode.stop();
            html5QrCode = null;
            document.getElementById('laser-line').classList.add('hidden');
            
            // Pilih indeks kamera berikutnya
            currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
            const nextCameraId = cameras[currentCameraIndex].id;

            // Inisialisasi ulang scanner dengan device ID baru
            html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 15,
                aspectRatio: 1.0,
                qrbox: function(width, height) {
                    const minEdge = Math.min(width, height);
                    const qrboxSize = Math.floor(minEdge * 0.7);
                    return { width: qrboxSize, height: qrboxSize };
                },
                videoConstraints: {
                    width: { ideal: 720 },
                    height: { ideal: 720 },
                    aspectRatio: { ideal: 1.0 }
                }
            };

            await html5QrCode.start(
                nextCameraId,
                config,
                (decodedText, decodedResult) => {
                    stopScanning();
                    processCheckIn(decodedText);
                },
                (errorMessage) => {}
            );

            document.getElementById('laser-line').classList.remove('hidden');
        } catch(e) {
            console.error('Gagal ganti kamera:', e);
            alert("Gagal beralih ke kamera berikutnya.");
            resetScannerUI();
        } finally {
            btnFlipCamera.disabled = false;
            btnFlipCamera.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Balik Kamera`;
        }
    }

    function stopScanning() {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                resetScannerUI();
            }).catch(err => {
                console.error("Gagal menghentikan scanner: ", err);
            });
        }
    }

    function resetScannerUI() {
        document.getElementById('laser-line').classList.add('hidden');
        const ph = document.getElementById('scanner-placeholder');
        ph.style.display = 'flex';
        ph.style.opacity = '0';
        setTimeout(() => { ph.style.opacity = '1'; }, 50);
        btnStopScan.disabled = true;
        // Sembunyikan tombol flip
        btnFlipCamera.classList.add('hidden');
        btnFlipCamera.classList.remove('flex');
    }

    function showStatus(type) {
        document.getElementById('status-default').classList.add('hidden');
        document.getElementById('status-success').classList.add('hidden');
        document.getElementById('status-error').classList.add('hidden');

        if (type === 'success') {
            document.getElementById('status-success').classList.remove('hidden');
        } else if (type === 'error') {
            document.getElementById('status-error').classList.remove('hidden');
        } else {
            document.getElementById('status-default').classList.remove('hidden');
        }
    }

    // Ajax request checkin
    function processCheckIn(orderId) {
        const loadingOverlay = document.getElementById('loading-overlay');
        loadingOverlay.classList.remove('hidden');

        fetch("{{ route('organizer.scanner.checkin', $event) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order_id: orderId })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(res => {
            loadingOverlay.classList.add('hidden');
            
            if (res.status === 200 && res.body.success) {
                // Sukses
                document.getElementById('success-heading').innerText = res.body.message;
                document.getElementById('success-name').innerText = res.body.data.name;
                document.getElementById('success-email').innerText = res.body.data.email;
                document.getElementById('success-phone').innerText = res.body.data.phone;
                document.getElementById('success-order').innerText = res.body.data.order_id;
                document.getElementById('success-time').innerText = res.body.data.checked_in_at;
                showStatus('success');

                // Mainkan suara sukses jika didukung browser
                try {
                    let audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    let osc = audioCtx.createOscillator();
                    let gain = audioCtx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(880, audioCtx.currentTime); // A5
                    osc.connect(gain);
                    gain.connect(audioCtx.destination);
                    gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
                    osc.start();
                    osc.stop(audioCtx.currentTime + 0.15);
                } catch(e){}

                // Getarkan handphone
                if (navigator.vibrate) {
                    navigator.vibrate([100, 50, 100]);
                }
            } else {
                // Gagal
                document.getElementById('error-message').innerText = res.body.message || 'Terjadi kesalahan sistem.';
                showStatus('error');

                // Mainkan suara gagal
                try {
                    let audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    let osc = audioCtx.createOscillator();
                    let gain = audioCtx.createGain();
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(220, audioCtx.currentTime); // A3
                    osc.connect(gain);
                    gain.connect(audioCtx.destination);
                    gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
                    osc.start();
                    osc.stop(audioCtx.currentTime + 0.3);
                } catch(e){}

                if (navigator.vibrate) {
                    navigator.vibrate(300);
                }
            }
        })
        .catch(err => {
            loadingOverlay.classList.add('hidden');
            console.error(err);
            document.getElementById('error-message').innerText = 'Koneksi gagal atau terjadi kesalahan jaringan.';
            showStatus('error');
        });
    }

    function handleManualSubmit(e) {
        e.preventDefault();
        const orderIdInput = document.getElementById('manual-order-id');
        const orderId = orderIdInput.value.trim();
        
        if (!orderId) {
            alert('Masukkan Order ID terlebih dahulu.');
            return;
        }

        processCheckIn(orderId);
        orderIdInput.value = '';
    }
</script>
@endsection
