@extends('layouts.admin')
@section('title', 'Kelola Pesanan')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-800 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 bg-[#0088cc] text-white rounded-xl flex items-center justify-center shadow-md"><i
                        class="fa-solid fa-clipboard-list text-xl"></i></div>
                Kelola Pesanan
            </h1>
            <p class="text-sm text-gray-500 font-medium mt-2">Pantau pembayaran, kemas barang, dan kirim ke pembeli.</p>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- FILTER STATUS BERGAYA PILL (KAPSUL)        -->
    <!-- ========================================== -->
    <div class="mb-8">
        <div class="flex overflow-x-auto hide-scroll w-full gap-2 sm:gap-3 pb-2 snap-x">
            @php $curStat = request('status', ''); @endphp

            <a href="{{ route('admin.pesanan.index') }}"
                class="shrink-0 px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 snap-start border {{ $curStat == '' ? 'bg-[#0088cc] text-white border-[#0088cc] shadow-[0_4px_12px_rgba(0,136,204,0.3)]' : 'bg-white text-gray-500 border-gray-200 hover:bg-blue-50 hover:text-[#0088cc] hover:border-blue-200' }}">
                <i class="fa-solid fa-layer-group mr-1.5"></i> Semua Pesanan
            </a>
            <a href="{{ route('admin.pesanan.index', ['status' => 'Belum Dibayar']) }}"
                class="shrink-0 px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 snap-start border {{ $curStat == 'Belum Dibayar' ? 'bg-[#0088cc] text-white border-[#0088cc] shadow-[0_4px_12px_rgba(0,136,204,0.3)]' : 'bg-white text-gray-500 border-gray-200 hover:bg-blue-50 hover:text-[#0088cc] hover:border-blue-200' }}">
                <i class="fa-solid fa-clock mr-1.5"></i> Belum Dibayar
            </a>
            <a href="{{ route('admin.pesanan.index', ['status' => 'Sudah Dibayar']) }}"
                class="shrink-0 px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 snap-start border {{ $curStat == 'Sudah Dibayar' ? 'bg-[#0088cc] text-white border-[#0088cc] shadow-[0_4px_12px_rgba(0,136,204,0.3)]' : 'bg-white text-gray-500 border-gray-200 hover:bg-blue-50 hover:text-[#0088cc] hover:border-blue-200' }}">
                <i class="fa-solid fa-box-open mr-1.5"></i> Perlu Dikirim
            </a>
            <a href="{{ route('admin.pesanan.index', ['status' => 'Dikirim']) }}"
                class="shrink-0 px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 snap-start border {{ $curStat == 'Dikirim' ? 'bg-[#0088cc] text-white border-[#0088cc] shadow-[0_4px_12px_rgba(0,136,204,0.3)]' : 'bg-white text-gray-500 border-gray-200 hover:bg-blue-50 hover:text-[#0088cc] hover:border-blue-200' }}">
                <i class="fa-solid fa-truck-fast mr-1.5"></i> Dikirim
            </a>
            <a href="{{ route('admin.pesanan.index', ['status' => 'Selesai']) }}"
                class="shrink-0 px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 snap-start border {{ $curStat == 'Selesai' ? 'bg-[#0088cc] text-white border-[#0088cc] shadow-[0_4px_12px_rgba(0,136,204,0.3)]' : 'bg-white text-gray-500 border-gray-200 hover:bg-blue-50 hover:text-[#0088cc] hover:border-blue-200' }}">
                <i class="fa-solid fa-check-double mr-1.5"></i> Selesai
            </a>
        </div>
    </div>

    @if (session('success'))
        <div
            class="bg-green-50 text-green-700 p-4 rounded-2xl mb-6 font-bold flex items-center gap-3 shadow-sm border border-green-200">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0"><i
                    class="fa-solid fa-check text-green-600"></i></div>
            {{ session('success') }}
        </div>
    @endif

    <!-- DAFTAR PESANAN -->
    <div class="grid grid-cols-1 gap-6 pb-12">
        @forelse($pesanan as $p)
            <div
                class="bg-white rounded-3xl shadow-[0_2px_15px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden relative hover:shadow-[0_10px_25px_rgba(0,0,0,0.06)] transition-all duration-300">

                <div
                    class="bg-gray-50/80 px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <div class="flex items-center gap-4">
                        <div
                            class="bg-white px-3 py-1.5 rounded-lg border border-gray-200 font-black text-gray-800 text-sm shadow-sm flex items-center gap-2">
                            <i class="fa-solid fa-hashtag text-[#0088cc]"></i> {{ $p->kode_pesanan }}
                        </div>
                        <div class="text-xs font-semibold text-gray-500 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar"></i> {{ $p->created_at->format('d M Y - H:i') }}
                        </div>
                    </div>

                    <div
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black tracking-wide border shadow-sm shrink-0 w-max
                    {{ $p->status == 'Belum Dibayar'
                        ? 'bg-yellow-50 text-yellow-600 border-yellow-200'
                        : ($p->status == 'Sudah Dibayar'
                            ? 'bg-blue-50 text-[#0088cc] border-blue-200'
                            : ($p->status == 'Dikirim'
                                ? 'bg-purple-50 text-purple-600 border-purple-200'
                                : 'bg-green-50 text-green-600 border-green-200')) }}">
                        @if ($p->status == 'Belum Dibayar')
                            <i class="fa-solid fa-clock animate-pulse"></i>
                        @elseif($p->status == 'Sudah Dibayar')
                            <i class="fa-solid fa-box-open"></i>
                        @elseif($p->status == 'Dikirim')
                            <i class="fa-solid fa-truck-fast"></i>
                        @else
                            <i class="fa-solid fa-check-double"></i>
                        @endif

                        {{ $p->status == 'Sudah Dibayar' ? 'SIAP DIKIRIM' : strtoupper($p->status) }}
                    </div>
                </div>

                <div class="p-6 flex flex-col xl:flex-row gap-8">

                    <div class="w-full xl:w-[30%] flex flex-col gap-4 relative">
                        <div class="absolute right-0 top-0 bottom-0 w-px bg-gray-100 hidden xl:block"></div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1.5"><i
                                    class="fa-solid fa-user text-[#0088cc] mr-1"></i> Informasi Pembeli</p>
                            <p class="font-extrabold text-gray-800 text-base">
                                {{ $p->user->nama_lengkap ?? 'Akun Dihapus' }}</p>
                            @if ($p->user)
                                <p class="text-xs font-medium text-gray-500">{{ $p->user->username }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1.5"><i
                                    class="fa-solid fa-map-location-dot text-[#0088cc] mr-1"></i> Alamat Pengiriman</p>
                            <div
                                class="bg-blue-50/50 p-3 rounded-xl border border-blue-100 text-sm font-semibold text-gray-700 leading-relaxed shadow-inner">
                                {{ $p->alamat_pengiriman }}
                            </div>
                        </div>
                    </div>

                    <div class="w-full xl:w-[40%] relative">
                        <div class="absolute right-0 top-0 bottom-0 w-px bg-gray-100 hidden xl:block"></div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-3"><i
                                class="fa-solid fa-box text-[#0088cc] mr-1"></i> Barang Yang Dipesan
                            ({{ count($p->details) }})
                        </p>
                        <div class="flex flex-col gap-3 max-h-48 overflow-y-auto pr-2 hide-scroll">
                            @foreach ($p->details as $d)
                                <div
                                    class="flex items-center gap-4 bg-white border border-gray-100 p-2.5 rounded-2xl hover:shadow-md transition-shadow group">
                                    <div
                                        class="w-14 h-14 rounded-xl bg-gray-50 border border-gray-200 p-1 shrink-0 overflow-hidden">
                                        @if ($d->produk && count($d->produk->foto_array) > 0)
                                            <img src="{{ asset('storage/' . $d->produk->foto_array[0]) }}"
                                                class="w-full h-full object-contain group-hover:scale-110 transition-transform">
                                        @else
                                            <i
                                                class="fa-solid fa-shirt text-gray-300 w-full h-full flex items-center justify-center"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-extrabold text-gray-800 truncate mb-1">
                                            {{ $d->produk ? $d->produk->nama_produk : 'Produk Dihapus' }}</p>
                                        <div class="flex items-center justify-between">
                                            <p
                                                class="text-xs font-bold text-[#0088cc] bg-blue-50 px-2 py-0.5 rounded-md w-max">
                                                {{ $d->kuantitas }} x Rp
                                                {{ number_format($d->harga_satuan, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div
                        class="w-full xl:w-[30%] flex flex-col justify-between items-start xl:items-end text-left xl:text-right">
                        <div class="w-full bg-gray-50 p-4 rounded-2xl border border-gray-200 mb-6 xl:mb-0">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-bold text-gray-500">Metode Bayar</span>
                                <span
                                    class="text-xs font-black text-gray-800 bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">{{ $p->metode_pembayaran }}</span>
                            </div>
                            <div class="w-full h-px bg-gray-200 my-3"></div>
                            <p class="text-xs font-bold text-gray-500 mb-1">Total Pendapatan</p>
                            <p class="text-3xl font-black text-[#0088cc] leading-none">Rp
                                {{ number_format($p->total_bayar, 0, ',', '.') }}</p>
                        </div>

                        <!-- TOMBOL AKSI ADMIN MEMANGGIL CUSTOM MODAL -->
                        <div class="w-full mt-auto">
                            @if ($p->status == 'Belum Dibayar')
                                <div
                                    class="w-full bg-yellow-50 text-yellow-600 text-center font-bold text-sm py-3.5 rounded-2xl border border-yellow-200 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-hourglass-half animate-spin-slow"></i> Menunggu User Membayar
                                </div>
                            @elseif($p->status == 'Sudah Dibayar')
                                <!-- Tombol ini memanggil fungsi JavaScript Modal -->
                                <button type="button"
                                    onclick="openActionModal('{{ route('admin.pesanan.update_status', $p->id) }}', 'Dikirim', '{{ $p->kode_pesanan }}')"
                                    class="w-full bg-gradient-to-r from-[#0088cc] to-blue-600 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3.5 px-4 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center justify-center gap-2 group">
                                    <i class="fa-solid fa-truck-fast group-hover:translate-x-1 transition-transform"></i>
                                    Konfirmasi Kirim Barang
                                </button>
                            @elseif($p->status == 'Dikirim')
                                <!-- Tombol ini memanggil fungsi JavaScript Modal -->
                                <button type="button"
                                    onclick="openActionModal('{{ route('admin.pesanan.update_status', $p->id) }}', 'Selesai', '{{ $p->kode_pesanan }}')"
                                    class="w-full bg-purple-100 hover:bg-purple-200 border-2 border-purple-200 text-purple-700 font-bold py-3 px-4 rounded-2xl transition-all flex items-center justify-center gap-2 group hover:-translate-y-0.5">
                                    <i class="fa-solid fa-check-double group-hover:scale-110 transition-transform"></i>
                                    Selesaikan Manual
                                </button>
                            @elseif($p->status == 'Selesai')
                                <div
                                    class="w-full bg-green-50 text-green-600 text-center font-bold text-sm py-3.5 rounded-2xl border border-green-200 flex items-center justify-center gap-2 shadow-inner">
                                    <i class="fa-solid fa-circle-check text-lg"></i> Transaksi Telah Tuntas
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center flex flex-col items-center">
                <div
                    class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center text-5xl text-gray-300 mb-6 shadow-inner">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="text-2xl font-extrabold text-gray-800 mb-2">Tidak ada pesanan.</h3>
                <p class="text-base text-gray-500 font-medium">Saat ini belum ada pesanan dengan status yang Anda cari.</p>
            </div>
        @endforelse

        <div class="mt-6">{{ $pesanan->links('pagination::tailwind') }}</div>
    </div>

    <!-- ========================================== -->
    <!-- CUSTOM MODAL AKSI PESANAN (KIRIM/SELESAI)  -->
    <!-- ========================================== -->
    <div id="actionModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden p-4">
        <!-- Latar Belakang Gelap dengan Efek Blur -->
        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm transition-opacity" onclick="closeActionModal()">
        </div>

        <!-- Konten Modal -->
        <div id="actionModalContent"
            class="bg-white border border-white shadow-2xl rounded-3xl max-w-sm w-full relative transform scale-95 opacity-0 transition-all duration-300 ease-out z-10 overflow-hidden">
            <div id="modalHeaderColor" class="h-2 w-full bg-gradient-to-r from-[#0088cc] to-blue-600"></div>
            <div class="p-6 sm:p-8 text-center relative">

                <div id="modalIconContainer"
                    class="w-16 h-16 sm:w-20 sm:h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 relative group">
                    <div class="absolute inset-0 rounded-full border-2 border-blue-200 animate-ping opacity-30"></div>
                    <i id="modalIcon" class="fa-solid fa-truck-fast text-2xl sm:text-3xl text-[#0088cc] z-10"></i>
                </div>

                <h3 id="modalTitle" class="text-xl sm:text-2xl font-black text-gray-800 mb-2">Konfirmasi Kirim?</h3>
                <p class="text-xs sm:text-sm text-gray-500 mb-6 font-medium">Anda akan mengubah status pesanan <span
                        id="modalKodePesanan" class="font-extrabold text-gray-800 border-b-2 border-[#0088cc]"></span>.
                    Lanjutkan?</p>

                <!-- Form Tersembunyi (Akan dieksekusi modal) -->
                <form id="actionForm" method="POST" class="flex flex-col gap-2 sm:gap-3">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" id="modalInputStatus">

                    <button type="submit" id="modalBtnConfirm"
                        class="w-full px-4 py-3 sm:py-3.5 bg-gradient-to-r from-[#0088cc] to-blue-600 text-white font-bold rounded-xl sm:rounded-2xl shadow-md hover:-translate-y-1 transition-all flex justify-center gap-2">
                        Ya, Lanjutkan <i class="fa-solid fa-check mt-0.5"></i>
                    </button>
                    <button type="button" onclick="closeActionModal()"
                        class="w-full px-4 py-3 sm:py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl sm:rounded-2xl transition-colors">
                        Batal
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPT UNTUK MODAL AKSI PESANAN -->
    <script>
        function openActionModal(url, status, kode) {
            // Set Data ke Modal
            document.getElementById('actionForm').action = url;
            document.getElementById('modalInputStatus').value = status;
            document.getElementById('modalKodePesanan').innerText = kode;

            // Sesuaikan Tampilan (Warna, Teks, Ikon) berdasarkan Status
            const title = document.getElementById('modalTitle');
            const icon = document.getElementById('modalIcon');
            const iconContainer = document.getElementById('modalIconContainer');
            const headerColor = document.getElementById('modalHeaderColor');
            const btnConfirm = document.getElementById('modalBtnConfirm');

            if (status === 'Dikirim') {
                title.innerText = 'Kirim Pesanan?';
                icon.className = 'fa-solid fa-truck-fast text-2xl sm:text-3xl text-[#0088cc] z-10';
                iconContainer.className =
                    'w-16 h-16 sm:w-20 sm:h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 relative group';
                headerColor.className = 'h-2 w-full bg-gradient-to-r from-[#0088cc] to-blue-600';
                btnConfirm.className =
                    'w-full px-4 py-3 sm:py-3.5 bg-gradient-to-r from-[#0088cc] to-blue-600 text-white font-bold rounded-xl sm:rounded-2xl shadow-md hover:-translate-y-1 transition-all flex justify-center gap-2';
            } else {
                title.innerText = 'Selesai Manual?';
                icon.className = 'fa-solid fa-check-double text-2xl sm:text-3xl text-purple-600 z-10';
                iconContainer.className =
                    'w-16 h-16 sm:w-20 sm:h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 relative group';
                headerColor.className = 'h-2 w-full bg-gradient-to-r from-purple-500 to-purple-700';
                btnConfirm.className =
                    'w-full px-4 py-3 sm:py-3.5 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-bold rounded-xl sm:rounded-2xl shadow-md hover:-translate-y-1 transition-all flex justify-center gap-2';
            }

            // Tampilkan Modal
            const modal = document.getElementById('actionModal');
            const content = document.getElementById('actionModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.replace('scale-95', 'scale-100');
                content.classList.replace('opacity-0', 'opacity-100');
            }, 10);
        }

        function closeActionModal() {
            const modal = document.getElementById('actionModal');
            const content = document.getElementById('actionModalContent');
            content.classList.replace('scale-100', 'scale-95');
            content.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>

    <style>
        .animate-spin-slow {
            animation: spin 3s linear infinite;
        }
    </style>
@endsection
