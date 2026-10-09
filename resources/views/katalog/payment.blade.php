<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Marketqu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            word-wrap: break-word;
        }
    </style>
</head>

<body class="bg-[#ebebeb] font-sans selection:bg-[#0088cc] selection:text-white min-h-screen flex flex-col">

    <!-- Panggil File Navbar -->
    @include('layouts.navbar')

    <main class="flex-grow w-full max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">

            <!-- Header Gradien -->
            <div class="bg-gradient-to-r from-[#0088cc] to-blue-800 p-8 text-center relative overflow-hidden">
                <i
                    class="fa-solid fa-money-check-dollar absolute -right-4 -bottom-4 text-9xl text-white opacity-10"></i>
                <h2 class="text-2xl sm:text-3xl font-black text-white mb-2 relative z-10 drop-shadow-md">Selesaikan
                    Pembayaran</h2>
                <p class="text-blue-100 font-medium relative z-10">Kode Pesanan: <span
                        class="font-bold text-white bg-black/20 px-2 py-0.5 rounded tracking-wider">{{ $pesanan->kode_pesanan }}</span>
                </p>
            </div>

            <div class="p-6 sm:p-10 text-center">

                <!-- TIMER HITUNG MUNDUR -->
                <div class="mb-8" id="timerContainer">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Sisa Waktu Pembayaran</p>
                    <div id="countdown" class="flex justify-center gap-3 sm:gap-4 text-gray-800">
                        <div class="bg-red-50 border border-red-100 rounded-xl p-3 sm:p-4 w-16 sm:w-20 shadow-sm">
                            <span id="hours"
                                class="text-2xl sm:text-3xl font-black text-red-600 block leading-none">23</span>
                            <span
                                class="text-[9px] sm:text-[10px] font-bold text-red-400 uppercase mt-1 block">Jam</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-gray-300 self-center pb-4">:</div>
                        <div class="bg-red-50 border border-red-100 rounded-xl p-3 sm:p-4 w-16 sm:w-20 shadow-sm">
                            <span id="minutes"
                                class="text-2xl sm:text-3xl font-black text-red-600 block leading-none">59</span>
                            <span
                                class="text-[9px] sm:text-[10px] font-bold text-red-400 uppercase mt-1 block">Menit</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-gray-300 self-center pb-4">:</div>
                        <div class="bg-red-50 border border-red-100 rounded-xl p-3 sm:p-4 w-16 sm:w-20 shadow-sm">
                            <span id="seconds"
                                class="text-2xl sm:text-3xl font-black text-red-600 block leading-none">59</span>
                            <span
                                class="text-[9px] sm:text-[10px] font-bold text-red-400 uppercase mt-1 block">Detik</span>
                        </div>
                    </div>

                    <!-- Pesan Batal Muncul Saat Waktu Habis -->
                    <div id="processingCancel"
                        class="hidden mt-4 text-red-600 font-black text-lg bg-red-50 py-3 rounded-lg border border-red-200 shadow-sm">
                        <i class="fa-solid fa-spinner fa-spin"></i> Waktu Habis! Membatalkan pesanan...
                    </div>
                </div>

                <!-- BOX TOTAL & METODE -->
                <div
                    class="bg-gray-50 border border-gray-200 rounded-2xl p-6 sm:p-8 mb-8 text-left inline-block w-full max-w-sm shadow-sm relative">
                    <div
                        class="absolute -top-3 left-1/2 -translate-x-1/2 bg-blue-100 text-[#0088cc] border border-blue-200 px-3 py-1 rounded-full text-xs font-black shadow-sm flex items-center gap-1">
                        <i class="fa-solid fa-lock"></i> Aman
                    </div>

                    <p class="text-sm font-bold text-gray-500 mb-1 text-center">Total Tagihan:</p>
                    <p class="text-4xl sm:text-5xl font-black text-[#0088cc] mb-8 text-center drop-shadow-sm">Rp
                        {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>

                    <div class="w-full h-px bg-gray-200 mb-6"></div>

                    <p class="text-sm font-bold text-gray-500 mb-1 text-center">Metode Pembayaran:</p>
                    <p
                        class="text-lg font-black text-gray-800 mb-6 text-center uppercase tracking-widest bg-white py-2 rounded-lg border border-gray-200 shadow-sm">
                        {{ $pesanan->metode_pembayaran }}</p>

                    @if ($pesanan->metode_pembayaran == 'QRIS')
                        <div
                            class="flex justify-center mb-4 bg-white p-6 rounded-xl border-2 border-gray-200 shadow-sm w-max mx-auto">
                            <i class="fa-solid fa-qrcode text-8xl text-gray-900"></i>
                        </div>
                        <p
                            class="text-xs text-center font-bold text-gray-500 bg-white py-2 px-3 border border-gray-200 rounded-lg">
                            <i class="fa-solid fa-mobile-screen-button text-[#0088cc]"></i> Scan QR Code ini lewat
                            aplikasi m-Banking atau E-Wallet Anda.
                        </p>
                    @else
                        <div
                            class="bg-white p-5 rounded-xl border-2 border-[#0088cc] text-center mb-2 shadow-sm relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 bg-[#0088cc] text-white text-[9px] font-bold px-2 py-1 rounded-bl-lg">
                                <i class="fa-solid fa-building-columns"></i> BCA
                            </div>
                            <p class="text-xs font-bold text-gray-500 mb-2 mt-1">Nomor Virtual Account</p>
                            <p class="text-2xl font-black text-gray-800 tracking-widest">8077 <span
                                    class="text-[#0088cc]">0812 3456</span></p>
                        </div>
                        <p class="text-xs text-center font-bold text-gray-500 mt-3"><i
                                class="fa-regular fa-copy text-[#0088cc]"></i> Salin nomor di atas untuk transfer.</p>
                    @endif
                </div>

                <!-- Tombol Konfirmasi Pembayaran -->
                <form action="{{ route('checkout.confirm', $pesanan->id) }}" method="POST" id="confirmForm">
                    @csrf
                    <button type="submit" id="btnConfirm"
                        class="bg-gradient-to-r from-[#0088cc] to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 mx-auto w-full max-w-sm text-base sm:text-lg group hover:-translate-y-1">
                        <i class="fa-solid fa-circle-check group-hover:scale-110 transition-transform"></i> Saya Sudah
                        Membayar
                    </button>
                </form>

                <!-- FORM BATAL OTOMATIS (Dieksekusi JS saat waktu habis) -->
                <form action="{{ route('checkout.cancel', $pesanan->id) }}" method="POST" id="autoCancelForm"
                    class="hidden">
                    @csrf
                </form>

            </div>
        </div>
    </main>

    <!-- Panggil File Modal Logout -->
    @include('layouts.modal-logout')

    <!-- SCRIPT TIMER HITUNG MUNDUR 24 JAM (FIX ZONA WAKTU) -->
    <script>
        // Mengubah waktu pembuatan dari database menjadi Milidetik Universal (Unix Timestamp)
        // Ini memastikan hitungan tetap akurat 24 Jam penuh terlepas dari timezone (WIB/UTC)
        const orderTimeMs = {{ $pesanan->created_at->timestamp * 1000 }};
        const endTime = orderTimeMs + (24 * 60 * 60 * 1000); // Ditambah 24 Jam

        const x = setInterval(function() {
            const now = new Date().getTime();
            const distance = endTime - now;

            // Kalkulasi Jam, Menit, dan Detik
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Cetak ke layar (Tambah angka "0" di depan jika satuan)
            document.getElementById("hours").innerHTML = hours < 10 ? "0" + hours : hours;
            document.getElementById("minutes").innerHTML = minutes < 10 ? "0" + minutes : minutes;
            document.getElementById("seconds").innerHTML = seconds < 10 ? "0" + seconds : seconds;

            // JIKA WAKTU HABIS (Mencapai Angka 0)
            if (distance < 0) {
                clearInterval(x);

                // Ubah Tampilan menjadi Indikator Loading Batal
                document.getElementById("countdown").classList.add("hidden");
                document.getElementById("processingCancel").classList.remove("hidden");

                // Matikan & Abu-abukan tombol Konfirmasi
                const btn = document.getElementById("btnConfirm");
                btn.disabled = true;
                btn.classList.replace("from-[#0088cc]", "bg-gray-400");
                btn.classList.replace("to-blue-700", "bg-gray-400");
                btn.classList.remove("hover:-translate-y-1", "hover:from-blue-600", "hover:to-blue-800",
                    "hover:shadow-xl");
                btn.classList.add("cursor-not-allowed");

                // Eksekusi Form Batal Otomatis ke Controller (Stok dikembalikan ke Database)
                document.getElementById("autoCancelForm").submit();
            }
        }, 1000);
    </script>
</body>

</html>
