<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan Saya - Marketqu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            word-wrap: break-word;
        }

        .hide-scroll::-webkit-scrollbar {
            display: none;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* SISTEM BINTANG RATING MURNI CSS */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 0.25rem;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #e2e8f0;
            font-size: 2.75rem;
            /* Bintang sedikit lebih besar */
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #f59e0b;
            transform: scale(1.1);
            /* Efek membesar saat di-hover */
        }
    </style>
</head>

<body class="bg-[#ebebeb] font-sans selection:bg-[#0088cc] selection:text-white min-h-screen flex flex-col">

    <!-- Panggil File Navbar -->
    @include('layouts.navbar')

    <main class="flex-grow w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

        <!-- HEADER HALAMAN -->
        <div class="flex items-center gap-3 mb-6 sm:mb-8">
            <div
                class="w-10 h-10 sm:w-12 sm:h-12 bg-[#0088cc] text-white rounded-xl flex items-center justify-center shadow-md shrink-0">
                <i class="fa-solid fa-clipboard-list text-lg sm:text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-gray-800 leading-tight">Pesanan Saya</h1>
                <p class="text-xs sm:text-sm text-gray-500 font-medium">Lacak dan kelola semua riwayat belanja Anda.</p>
            </div>
        </div>

        @if (session('success'))
            <div
                class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 font-bold flex items-center gap-3 shadow-sm border border-green-200">
                <i class="fa-solid fa-circle-check text-xl shrink-0"></i> {{ session('success') }}
            </div>
        @endif

        <!-- ========================================== -->
        <!-- TAB MENU FILTER STATUS (DITENGAHKAN)       -->
        <!-- ========================================== -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 mb-6 sm:mb-8 overflow-hidden">
            <!-- Penambahan md:justify-center agar menu ada di tengah layar besar -->
            <div class="flex overflow-x-auto hide-scroll w-full border-b border-gray-100 md:justify-center">
                @php
                    $currentStatus = request('status', '');
                    $isDinilai = request('dinilai', 0);
                @endphp
                <a href="{{ route('pesanan.index') }}"
                    class="shrink-0 text-center py-3 sm:py-4 px-4 sm:px-6 text-xs sm:text-sm font-bold transition-all border-b-2 {{ $currentStatus == '' ? 'border-[#0088cc] text-[#0088cc] bg-blue-50/30' : 'border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-gray-50' }}">Semua</a>

                <a href="{{ route('pesanan.index', ['status' => 'Belum Dibayar']) }}"
                    class="shrink-0 text-center py-3 sm:py-4 px-4 sm:px-6 text-xs sm:text-sm font-bold transition-all border-b-2 {{ $currentStatus == 'Belum Dibayar' ? 'border-[#0088cc] text-[#0088cc] bg-blue-50/30' : 'border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-gray-50' }}">Belum
                    Dibayar</a>

                <a href="{{ route('pesanan.index', ['status' => 'Sudah Dibayar']) }}"
                    class="shrink-0 text-center py-3 sm:py-4 px-4 sm:px-6 text-xs sm:text-sm font-bold transition-all border-b-2 {{ $currentStatus == 'Sudah Dibayar' ? 'border-[#0088cc] text-[#0088cc] bg-blue-50/30' : 'border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-gray-50' }}">Sedang
                    Dikemas</a>

                <a href="{{ route('pesanan.index', ['status' => 'Dikirim']) }}"
                    class="shrink-0 text-center py-3 sm:py-4 px-4 sm:px-6 text-xs sm:text-sm font-bold transition-all border-b-2 {{ $currentStatus == 'Dikirim' ? 'border-[#0088cc] text-[#0088cc] bg-blue-50/30' : 'border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-gray-50' }}">Dikirim</a>

                <a href="{{ route('pesanan.index', ['status' => 'Selesai']) }}"
                    class="shrink-0 text-center py-3 sm:py-4 px-4 sm:px-6 text-xs sm:text-sm font-bold transition-all border-b-2 {{ $currentStatus == 'Selesai' && $isDinilai == 0 ? 'border-[#0088cc] text-[#0088cc] bg-blue-50/30' : 'border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-gray-50' }}">Tiba
                    di Lokasi</a>

                <a href="{{ route('pesanan.index', ['status' => 'Selesai', 'dinilai' => 1]) }}"
                    class="shrink-0 text-center py-3 sm:py-4 px-4 sm:px-6 text-xs sm:text-sm font-bold transition-all border-b-2 {{ $currentStatus == 'Selesai' && $isDinilai == 1 ? 'border-[#0088cc] text-[#0088cc] bg-blue-50/30' : 'border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-gray-50' }}">Pesanan
                    Selesai <i class="fa-solid fa-check-double ml-1"></i></a>
            </div>
        </div>

        @php
            $filteredPesanan = $pesanan;
            if ($currentStatus == 'Selesai') {
                if ($isDinilai == 1) {
                    $filteredPesanan = $pesanan->filter(function ($p) {
                        return \App\Models\Ulasan::where('pesanan_id', $p->id)->exists();
                    });
                } else {
                    $filteredPesanan = $pesanan->filter(function ($p) {
                        return !\App\Models\Ulasan::where('pesanan_id', $p->id)->exists();
                    });
                }
            } elseif ($currentStatus != '') {
                $filteredPesanan = $pesanan->filter(function ($p) use ($currentStatus) {
                    return $p->status == $currentStatus;
                });
            }
        @endphp

        @if (count($filteredPesanan) > 0)
            <div class="flex flex-col gap-6">
                @foreach ($filteredPesanan as $p)
                    @php
                        $statusLabel = $p->status;
                        $statusStyle = 'bg-gray-50 border-gray-200 text-gray-600';
                        $statusIcon = 'fa-circle-info';

                        $sudahDinilai = \App\Models\Ulasan::where('pesanan_id', $p->id)->exists();

                        if ($p->status == 'Belum Dibayar') {
                            $statusLabel = 'Menunggu Pembayaran';
                            $statusStyle = 'bg-yellow-50 border-yellow-200 text-yellow-600';
                            $statusIcon = 'fa-clock';
                        } elseif ($p->status == 'Sudah Dibayar') {
                            $statusLabel = 'Sedang Dikemas';
                            $statusStyle = 'bg-blue-50 border-blue-200 text-[#0088cc]';
                            $statusIcon = 'fa-box-open';
                        } elseif ($p->status == 'Dikirim') {
                            $statusLabel = 'Sedang Dikirim';
                            $statusStyle = 'bg-purple-50 border-purple-200 text-purple-600';
                            $statusIcon = 'fa-truck-fast';
                        } elseif ($p->status == 'Selesai') {
                            if ($sudahDinilai) {
                                $statusLabel = 'Pesanan Selesai';
                                $statusStyle = 'bg-green-50 border-green-200 text-green-600';
                                $statusIcon = 'fa-check-double';
                            } else {
                                $statusLabel = 'Tiba di Lokasi';
                                $statusStyle = 'bg-green-50 border-green-200 text-green-600';
                                $statusIcon = 'fa-house-circle-check';
                            }
                        }
                    @endphp

                    <!-- KARTU PESANAN -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition-all">
                        <div
                            class="bg-gray-50/50 border-b border-gray-100 p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs sm:text-sm">
                                <span class="font-extrabold text-gray-800 flex items-center gap-1.5"><i
                                        class="fa-solid fa-hashtag text-[#0088cc]"></i> {{ $p->kode_pesanan }}</span>
                                <span class="text-gray-300 hidden sm:inline">|</span>
                                <span class="font-medium text-gray-500"><i class="fa-regular fa-calendar mr-1"></i>
                                    {{ $p->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border font-bold text-xs sm:text-sm shrink-0 w-max {{ $statusStyle }}">
                                <i class="fa-solid {{ $statusIcon }}"></i> {{ $statusLabel }}
                            </div>
                        </div>

                        <div class="p-4 sm:p-5 flex flex-col gap-4">
                            @foreach ($p->details as $detail)
                                <div class="flex flex-col sm:flex-row gap-4 sm:items-center">
                                    <div
                                        class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-50 border border-gray-200 rounded-lg p-1.5 shrink-0 hover:border-[#0088cc] transition-colors">
                                        @if ($detail->produk && count($detail->produk->foto_array) > 0)
                                            <img src="{{ asset('storage/' . $detail->produk->foto_array[0]) }}"
                                                class="w-full h-full object-contain mix-blend-multiply">
                                        @else
                                            <i
                                                class="fa-solid fa-shirt text-2xl text-gray-300 w-full h-full flex items-center justify-center"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm sm:text-base font-bold text-gray-800 leading-tight mb-1">
                                            {{ $detail->produk ? $detail->produk->nama_produk : 'Produk telah dihapus' }}
                                        </h4>
                                        <p class="text-xs font-semibold text-gray-500">Kuantitas: <span
                                                class="text-gray-800 bg-gray-100 px-2 py-0.5 rounded ml-1">{{ $detail->kuantitas }}
                                                x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span></p>
                                    </div>
                                    <div class="hidden sm:block text-right shrink-0">
                                        <p class="text-xs font-bold text-gray-400 mb-0.5">Subtotal</p>
                                        <p class="text-sm font-extrabold text-gray-800">Rp
                                            {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div
                            class="bg-gray-50 border-t border-gray-100 p-4 sm:p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex flex-col text-sm">
                                <span class="font-bold text-gray-500 mb-1">Total Belanja (Termasuk Ongkir)</span>
                                <span class="text-lg sm:text-xl font-black text-[#0088cc]">Rp
                                    {{ number_format($p->total_bayar, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                                @if ($p->status == 'Belum Dibayar')
                                    <a href="{{ route('checkout.payment', $p->id) }}"
                                        class="flex-1 md:flex-none text-center bg-gradient-to-r from-[#0088cc] to-blue-600 hover:from-blue-600 hover:to-blue-800 text-white px-6 py-2.5 rounded-xl font-bold shadow-sm hover:shadow-md transition-all text-sm sm:text-base">
                                        Bayar Sekarang <i class="fa-solid fa-arrow-right ml-1"></i>
                                    </a>
                                @elseif($p->status == 'Sudah Dibayar')
                                    <span
                                        class="flex-1 md:flex-none text-center bg-gray-200 text-gray-500 px-6 py-2.5 rounded-xl font-bold text-sm sm:text-base cursor-not-allowed border border-gray-300">Menunggu
                                        Penjual</span>
                                @elseif($p->status == 'Dikirim')
                                    <button
                                        onclick="openResiModal('{{ $p->no_resi ?? 'MKT-' . rand(10000, 99999) }}', 'JNE Express')"
                                        class="flex-1 md:flex-none bg-purple-50 text-purple-600 border border-purple-300 hover:bg-purple-100 px-6 py-2.5 rounded-xl font-bold transition-all text-sm sm:text-base">
                                        <i class="fa-solid fa-magnifying-glass-location"></i> Lacak Resi
                                    </button>
                                    <button onclick="openTerimaModal('{{ route('pesanan.selesai', $p->id) }}')"
                                        class="flex-1 md:flex-none bg-green-500 hover:bg-green-600 text-white px-6 py-2.5 rounded-xl font-bold shadow-sm transition-all text-sm sm:text-base shadow-[0_4px_15px_rgba(34,197,94,0.4)]">
                                        <i class="fa-solid fa-check-double"></i> Pesanan Diterima
                                    </button>
                                @elseif($p->status == 'Selesai')
                                    @if (!$sudahDinilai)
                                        <button
                                            onclick="openReviewModal('{{ route('pesanan.review', $p->id) }}', '{{ $p->kode_pesanan }}')"
                                            class="flex-1 md:flex-none bg-gradient-to-r from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-600 text-white px-6 py-2.5 rounded-xl font-bold transition-all text-sm sm:text-base shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                            <i class="fa-solid fa-star text-white/90"></i> Beri Penilaian Produk
                                        </button>
                                    @else
                                        <button disabled
                                            class="flex-1 md:flex-none bg-gray-100 text-gray-400 border border-gray-200 px-6 py-2.5 rounded-xl font-bold text-sm sm:text-base cursor-not-allowed flex justify-center items-center gap-2">
                                            <i class="fa-solid fa-star text-yellow-400"></i> Penilaian Anda Terkirim
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- TAMPILAN JIKA KOSONG -->
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-16 flex flex-col items-center justify-center text-center">
                <div
                    class="w-24 h-24 sm:w-32 sm:h-32 bg-gray-100 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <i class="fa-solid fa-receipt text-5xl sm:text-6xl text-gray-300"></i>
                </div>

                @php
                    $pesanKosong = 'Tidak Ada Pesanan';
                    if ($currentStatus == 'Selesai' && $isDinilai == 0) {
                        $pesanKosong = 'Belum Ada Pesanan yang Tiba di Lokasi';
                    }
                    if ($currentStatus == 'Selesai' && $isDinilai == 1) {
                        $pesanKosong = 'Belum Ada Pesanan yang Selesai Direview';
                    }
                @endphp

                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-800 mb-2">{{ $pesanKosong }}</h2>
                <a href="{{ route('katalog') }}"
                    class="bg-[#0088cc] text-white px-6 sm:px-8 py-3 rounded-xl font-bold hover:bg-blue-600 shadow-md transition-all hover:-translate-y-1 flex items-center gap-2 mt-4">
                    <i class="fa-solid fa-store"></i> Belanja Sekarang
                </a>
            </div>
        @endif
    </main>

    <!-- ========================================== -->
    <!-- MODAL 1: LACAK RESI                        -->
    <!-- ========================================== -->
    <div id="resiModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
            onclick="closeModal('resiModal')"></div>
        <div
            class="bg-white border border-white shadow-2xl rounded-3xl max-w-sm w-full relative transform z-10 overflow-hidden scale-100 transition-all duration-300">
            <div class="h-2 w-full bg-gradient-to-r from-purple-500 to-indigo-600"></div>
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-black text-gray-800"><i
                            class="fa-solid fa-box-open text-purple-600 mr-2"></i> Lacak Paket</h3>
                    <button onclick="closeModal('resiModal')" class="text-gray-400 hover:text-red-500"><i
                            class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-6">
                    <p class="text-xs font-bold text-gray-500 mb-1">Nomor Resi / Kurir</p>
                    <p class="font-extrabold text-lg text-gray-800" id="resiNumberDisplay"></p>
                    <p class="text-sm font-semibold text-[#0088cc] mt-1" id="kurirDisplay"></p>
                </div>
                <!-- Timeline Estetik -->
                <div class="relative pl-4 border-l-2 border-gray-200 space-y-6">
                    <div class="relative">
                        <div
                            class="absolute -left-[21px] top-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white">
                        </div>
                        <p class="text-sm font-bold text-gray-800">Paket sedang diantar kurir ke alamat tujuan</p>
                        <p class="text-xs text-gray-500 mt-1">Hari ini</p>
                    </div>
                    <div class="relative">
                        <div
                            class="absolute -left-[21px] top-1 w-3 h-3 bg-gray-300 rounded-full border-2 border-white">
                        </div>
                        <p class="text-sm font-bold text-gray-500">Paket telah tiba di fasilitas logistik kota tujuan
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Kemarin</p>
                    </div>
                </div>
                <button onclick="closeModal('resiModal')"
                    class="w-full mt-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors">Tutup</button>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL 2: KONFIRMASI PESANAN DITERIMA       -->
    <!-- ========================================== -->
    <div id="terimaModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
            onclick="closeModal('terimaModal')"></div>
        <div
            class="bg-white border border-white shadow-2xl rounded-3xl max-w-sm w-full relative transform z-10 overflow-hidden">
            <div class="h-2 w-full bg-gradient-to-r from-green-400 to-green-600"></div>
            <div class="p-6 sm:p-8 text-center relative">
                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                    <div class="absolute inset-0 rounded-full border-2 border-green-200 animate-ping opacity-30"></div>
                    <i class="fa-solid fa-box-check text-4xl text-green-500 z-10"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-800 mb-2">Paket Sudah Tiba?</h3>
                <p class="text-sm text-gray-500 mb-6 font-medium">Pastikan Anda telah menerima produk dengan kondisi
                    baik sebelum menekan tombol Selesai.</p>
                <form id="terimaForm" method="POST" class="flex flex-col gap-3">
                    @csrf @method('PUT')
                    <button type="submit"
                        class="w-full py-3.5 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-md transition-all flex justify-center items-center gap-2">
                        Ya, Pesanan Diterima
                    </button>
                    <button type="button" onclick="closeModal('terimaModal')"
                        class="w-full py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors">
                        Batal
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL 3: BERI PENILAIAN (PREMIUM DESIGN)   -->
    <!-- ========================================== -->
    <div id="reviewModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden p-4">
        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm transition-opacity"
            onclick="closeModal('reviewModal')"></div>
        <div
            class="bg-white shadow-2xl rounded-[2rem] max-w-md w-full relative z-10 overflow-hidden max-h-[95vh] flex flex-col">
            <div class="bg-white px-6 py-5 border-b border-gray-100 flex justify-between items-center shrink-0">
                <h3 class="text-xl font-black text-gray-800"><i class="fa-solid fa-star text-orange-400 mr-2"></i>
                    Beri Penilaian</h3>
                <button type="button" onclick="closeModal('reviewModal')"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition-colors"><i
                        class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form id="reviewForm" method="POST" enctype="multipart/form-data"
                class="overflow-y-auto p-6 flex flex-col gap-6 custom-scroll">
                @csrf
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-center">
                    <p class="text-xs font-bold text-[#0088cc]">Penilaian untuk pesanan <span id="reviewKodePesanan"
                            class="font-black bg-white px-2 py-0.5 rounded shadow-sm ml-1"></span></p>
                </div>

                <!-- BINTANG RATING INTERAKTIF PURE CSS -->
                <div class="text-center">
                    <label class="block text-sm font-extrabold text-gray-800 mb-2">Seberapa Puas Anda?</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" required />
                        <label for="star5" title="5 Bintang - Sangat Bagus"><i
                                class="fa-solid fa-star"></i></label>

                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4" title="4 Bintang - Bagus"><i class="fa-solid fa-star"></i></label>

                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3" title="3 Bintang - Cukup"><i class="fa-solid fa-star"></i></label>

                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2" title="2 Bintang - Kurang"><i class="fa-solid fa-star"></i></label>

                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1" title="1 Bintang - Sangat Buruk"><i
                                class="fa-solid fa-star"></i></label>
                    </div>
                </div>

                <!-- PREVIEW UPLOAD FOTO FULL VIEW -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Foto Produk
                        (Opsional)</label>
                    <div class="flex items-center justify-center w-full relative">
                        <label id="uploadArea"
                            class="flex flex-col items-center justify-center w-full min-h-[8rem] border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all overflow-hidden relative group">

                            <!-- Area Teks Upload -->
                            <div id="uploadText" class="flex flex-col items-center justify-center py-6 text-center">
                                <div
                                    class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-camera text-xl text-[#0088cc]"></i>
                                </div>
                                <p class="text-sm text-gray-600 font-medium"><span
                                        class="font-bold text-[#0088cc]">Klik di sini</span> untuk upload foto</p>
                                <p class="text-[10px] text-gray-400 mt-1 font-semibold uppercase tracking-wider">
                                    Format: JPG, PNG (Max 2MB)</p>
                            </div>

                            <!-- Area Preview Gambar Full Ukuran -->
                            <div id="imagePreviewContainer"
                                class="hidden w-full p-2 bg-gray-100 items-center justify-center relative z-10">
                                <img id="imagePreview" src=""
                                    class="max-w-full max-h-64 object-contain rounded-lg shadow-sm border border-gray-200">
                            </div>

                            <input id="fotoInput" name="foto_review" type="file" class="hidden" accept="image/*"
                                onchange="previewImage(this)">
                        </label>
                    </div>
                    <!-- Tombol hapus foto -->
                    <button type="button" id="btnRemovePhoto" onclick="removePhoto()"
                        class="hidden text-xs font-bold text-red-500 mt-3 text-center w-full hover:underline bg-red-50 py-2 rounded-lg border border-red-100 transition-colors"><i
                            class="fa-solid fa-trash-can mr-1"></i> Hapus & Ganti Foto</button>
                </div>

                <!-- Komentar -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tulis Ulasan
                        Anda</label>
                    <textarea name="komentar" rows="4"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-4 outline-none transition-colors resize-none"
                        placeholder="Bagaimana kualitas bahan, jahitan, atau ukuran produk ini? Ceritakan pengalaman Anda..." required></textarea>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-600 text-white font-black text-base rounded-xl shadow-[0_4px_15px_rgba(249,115,22,0.3)] transition-all hover:-translate-y-0.5">
                    Kirim Penilaian <i class="fa-solid fa-paper-plane ml-1"></i>
                </button>
            </form>
        </div>
    </div>

    @include('layouts.modal-logout')

    <script>
        function openResiModal(resi, kurir) {
            document.getElementById('resiNumberDisplay').innerText = resi;
            document.getElementById('kurirDisplay').innerText = kurir;
            document.getElementById('resiModal').classList.remove('hidden');
        }

        function openTerimaModal(actionUrl) {
            document.getElementById('terimaForm').action = actionUrl;
            document.getElementById('terimaModal').classList.remove('hidden');
        }

        function openReviewModal(actionUrl, kodePesanan) {
            document.getElementById('reviewForm').action = actionUrl;
            document.getElementById('reviewKodePesanan').innerText = kodePesanan;

            // Reset form input & bintang saat modal dibuka
            document.getElementById('reviewForm').reset();
            removePhoto();

            document.getElementById('reviewModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // FUNGSI PREVIEW FOTO FULL TANPA CROP
        function previewImage(input) {
            const previewContainer = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('imagePreview');
            const uploadText = document.getElementById('uploadText');
            const btnRemove = document.getElementById('btnRemovePhoto');
            const uploadArea = document.getElementById('uploadArea');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;

                    // Mainkan CSS agar foto full tampil
                    previewContainer.classList.remove('hidden');
                    previewContainer.classList.add('flex');
                    uploadText.classList.add('hidden');
                    btnRemove.classList.remove('hidden');

                    // Hilangkan garis putus-putus
                    uploadArea.classList.remove('border-dashed', 'border-gray-300');
                    uploadArea.classList.add('border-solid', 'border-[#0088cc]');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removePhoto() {
            document.getElementById('fotoInput').value = "";
            document.getElementById('imagePreview').src = "";

            // Kembalikan ke mode awal upload
            const previewContainer = document.getElementById('imagePreviewContainer');
            previewContainer.classList.add('hidden');
            previewContainer.classList.remove('flex');

            document.getElementById('uploadText').classList.remove('hidden');
            document.getElementById('btnRemovePhoto').classList.add('hidden');

            // Kembalikan garis putus-putus
            const uploadArea = document.getElementById('uploadArea');
            uploadArea.classList.add('border-dashed', 'border-gray-300');
            uploadArea.classList.remove('border-solid', 'border-[#0088cc]');
        }
    </script>
</body>

</html>
