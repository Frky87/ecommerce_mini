@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
    <!-- HEADER -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-800 tracking-tight flex items-center gap-2">
                Halo, {{ explode(' ', Auth::user()->nama_lengkap)[0] }}! <span
                    class="animate-waving-hand inline-block">👋</span>
            </h1>
            <p class="text-sm sm:text-base text-gray-500 font-medium mt-1">Ini adalah ringkasan performa toko <span
                    class="font-bold text-[#0088cc]">Marketqu</span> Anda hari ini.</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3 w-max">
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
            <span class="text-xs font-bold text-gray-600 uppercase tracking-widest">Sistem Aktif</span>
        </div>
    </div>

    <!-- KARTU STATISTIK GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-8">

        <!-- Kartu Total Omzet (Super VIP) -->
        <div
            class="bg-gradient-to-br from-[#0088cc] via-blue-600 to-blue-800 p-6 sm:p-8 rounded-3xl shadow-[0_8px_30px_rgba(0,136,204,0.3)] relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10 group-hover:bg-white/20 transition-all">
            </div>
            <i
                class="fa-solid fa-wallet absolute -right-4 -bottom-4 text-7xl sm:text-8xl text-white opacity-20 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500"></i>

            <p class="text-blue-100 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2 relative z-10">Total
                Pendapatan</p>
            <h3 class="text-3xl sm:text-4xl font-black text-white relative z-10 drop-shadow-md">Rp
                {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>

        <!-- Kartu Siap Dikirim -->
        <div
            class="bg-white border border-gray-100 p-6 sm:p-8 rounded-3xl shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group cursor-pointer">
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-50 text-[#0088cc] rounded-2xl flex items-center justify-center text-xl sm:text-2xl absolute top-6 right-6 group-hover:bg-[#0088cc] group-hover:text-white transition-colors duration-300">
                <i class="fa-solid fa-box-open group-hover:animate-bounce"></i>
            </div>
            <p class="text-gray-400 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2">Siap Dikirim</p>
            <div class="flex items-baseline gap-2">
                <h3 class="text-3xl sm:text-4xl font-black text-gray-800">{{ $siapDikirim }}</h3>
                <span class="text-sm font-bold text-gray-400">Order</span>
            </div>
        </div>

        <!-- Kartu Menunggu Pembayaran -->
        <div
            class="bg-white border border-gray-100 p-6 sm:p-8 rounded-3xl shadow-sm hover:shadow-xl hover:border-yellow-200 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group cursor-pointer">
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 bg-yellow-50 text-yellow-500 rounded-2xl flex items-center justify-center text-xl sm:text-2xl absolute top-6 right-6 group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300">
                <i class="fa-solid fa-clock group-hover:rotate-180 transition-transform duration-700"></i>
            </div>
            <p class="text-gray-400 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2">Belum Dibayar</p>
            <div class="flex items-baseline gap-2">
                <h3 class="text-3xl sm:text-4xl font-black text-gray-800">{{ $pesananBaru }}</h3>
                <span class="text-sm font-bold text-gray-400">Order</span>
            </div>
        </div>

        <!-- Kartu Total Pesanan -->
        <div
            class="bg-white border border-gray-100 p-6 sm:p-8 rounded-3xl shadow-sm hover:shadow-xl hover:border-green-200 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group cursor-pointer">
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center text-xl sm:text-2xl absolute top-6 right-6 group-hover:bg-green-500 group-hover:text-white transition-colors duration-300">
                <i
                    class="fa-solid fa-chart-line group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>
            </div>
            <p class="text-gray-400 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2">Total Transaksi</p>
            <div class="flex items-baseline gap-2">
                <h3 class="text-3xl sm:text-4xl font-black text-gray-800">{{ $totalPesanan }}</h3>
                <span class="text-sm font-bold text-gray-400">Order</span>
            </div>
        </div>
    </div>

    <!-- PREVIEW PESANAN TERBARU -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white sticky top-0 z-10">
            <h2 class="text-base sm:text-lg font-extrabold text-gray-800 flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center"><i
                        class="fa-solid fa-bolt"></i></div>
                Pesanan Masuk Terbaru
            </h2>
            <a href="{{ route('admin.pesanan.index') }}"
                class="text-xs sm:text-sm font-bold text-[#0088cc] bg-blue-50 px-4 py-2 rounded-xl hover:bg-[#0088cc] hover:text-white transition-colors">Lihat
                Semua <i class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[700px]">
                <thead>
                    <tr
                        class="text-[10px] sm:text-xs text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50/50">
                        <th class="px-6 py-4 font-bold">Detail Pesanan</th>
                        <th class="px-6 py-4 font-bold">Pelanggan</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-right">Total Tagihan</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($pesananTerbaru as $pt)
                        <tr class="border-b border-gray-50 hover:bg-blue-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="font-extrabold text-gray-800 group-hover:text-[#0088cc] transition-colors">
                                    {{ $pt->kode_pesanan }}</div>
                                <div class="text-xs text-gray-500 mt-1 font-medium"><i
                                        class="fa-regular fa-calendar mr-1"></i> {{ $pt->created_at->format('d M Y, H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center shrink-0 border border-gray-200">
                                        <i class="fa-solid fa-user text-xs"></i>
                                    </div>
                                    <div class="font-bold text-gray-800">{{ $pt->user->nama_lengkap ?? 'User Dihapus' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] sm:text-xs font-bold tracking-wide
                            {{ $pt->status == 'Belum Dibayar'
                                ? 'bg-yellow-50 text-yellow-600 border border-yellow-100'
                                : ($pt->status == 'Sudah Dibayar'
                                    ? 'bg-blue-50 text-[#0088cc] border border-blue-100 shadow-[0_2px_10px_rgba(0,136,204,0.15)]'
                                    : ($pt->status == 'Dikirim'
                                        ? 'bg-purple-50 text-purple-600 border border-purple-100'
                                        : 'bg-green-50 text-green-600 border border-green-100')) }}">
                                    @if ($pt->status == 'Belum Dibayar')
                                        <i class="fa-solid fa-clock"></i>
                                    @elseif($pt->status == 'Sudah Dibayar')
                                        <i class="fa-solid fa-box-open"></i>
                                    @elseif($pt->status == 'Dikirim')
                                        <i class="fa-solid fa-truck-fast"></i>
                                    @else
                                        <i class="fa-solid fa-check-double"></i>
                                    @endif

                                    {{ $pt->status == 'Sudah Dibayar' ? 'SIAP DIKIRIM' : strtoupper($pt->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 font-black text-[#0088cc] text-right text-base">
                                Rp {{ number_format($pt->total_bayar, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12">
                                <div
                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fa-solid fa-receipt text-2xl text-gray-300"></i></div>
                                <p class="text-gray-500 font-bold">Belum ada pesanan terbaru hari ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        @keyframes waving-hand {
            0% {
                transform: rotate(0.0deg)
            }

            10% {
                transform: rotate(14.0deg)
            }

            20% {
                transform: rotate(-8.0deg)
            }

            30% {
                transform: rotate(14.0deg)
            }

            40% {
                transform: rotate(-4.0deg)
            }

            50% {
                transform: rotate(10.0deg)
            }

            60% {
                transform: rotate(0.0deg)
            }

            100% {
                transform: rotate(0.0deg)
            }
        }

        .animate-waving-hand {
            animation: waving-hand 2.5s infinite;
            transform-origin: 70% 70%;
        }
    </style>
@endsection
