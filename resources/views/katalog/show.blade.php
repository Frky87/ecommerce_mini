<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->nama_produk }} - Marketqu</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .custom-number-input::-webkit-inner-spin-button,
        .custom-number-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .custom-number-input {
            -moz-appearance: textfield;
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
    </style>
</head>

@php
    $isAdmin =
        Auth::check() &&
        in_array(strtolower(Auth::user()->role), ['admin', 'super admin', 'superadmin', 'super_admin']);
@endphp

<body
    class="bg-gray-50 font-sans selection:bg-[#0088cc] selection:text-white relative {{ $isAdmin ? 'h-screen overflow-hidden flex' : 'min-h-screen flex flex-col' }}">

    @if ($isAdmin)
        @include('layouts.admin-sidebar')
        <div class="flex-1 flex flex-col h-full overflow-hidden relative w-full bg-gray-50">
            @include('layouts.admin-topbar')
            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 w-full custom-scroll">
            @else
                @include('layouts.navbar')
                <div class="flex-1 overflow-y-auto w-full pb-12">
    @endif

    <!-- BREADCRUMB -->
    <div class="max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-4">
        <nav class="text-sm font-medium text-gray-500">
            <a href="{{ route('katalog') }}" class="hover:text-[#0088cc]">Katalog</a> <span class="mx-2">&gt;</span>
            <span class="hover:text-[#0088cc]">{{ $produk->kategori }}</span> <span class="mx-2">&gt;</span>
            <span class="text-gray-800 truncate">{{ $produk->nama_produk }}</span>
        </nav>
    </div>

    <!-- KONTEN UTAMA DETAIL PRODUK -->
    <main class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @if ($isAdmin)
            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl mb-6 shadow-sm flex items-start gap-3">
                <i class="fa-solid fa-shield-halved text-yellow-500 text-lg mt-0.5"></i>
                <div>
                    <p class="text-sm font-bold text-yellow-700">Pratinjau Mode Admin</p>
                    <p class="text-xs font-medium text-yellow-600 mt-0.5">Anda melihat detail produk ini dari sudut
                        pandang pembeli. Tombol beli telah dinonaktifkan.</p>
                </div>
            </div>
        @endif

        @php
            $fotos = is_string($produk->foto_array)
                ? json_decode($produk->foto_array, true)
                : (is_string($produk->foto)
                    ? json_decode($produk->foto, true)
                    : $produk->foto_array);
            $mainFoto = is_array($fotos) && count($fotos) > 0 ? $fotos[0] : null;
            $seedString = $produk->id . date('Y-m-d H');
            $hashValue = abs(crc32($seedString));
            $persenDiskon = ($hashValue % 66) + 10;
            $hargaNormal = $produk->harga / (1 - $persenDiskon / 100);
        @endphp

        <!-- BAGIAN 1: INFO PRODUK & BELI -->
        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col md:flex-row p-4 sm:p-8 gap-8 lg:gap-12 mb-6">
            <div class="w-full md:w-5/12 flex flex-col items-center">
                <div
                    class="w-full aspect-square bg-gray-50 flex items-center justify-center rounded-xl border border-gray-100 p-4 mb-4 relative overflow-hidden">
                    @if ($mainFoto)
                        <img src="{{ asset('storage/' . $mainFoto) }}" id="mainImage"
                            class="max-h-full max-w-full object-contain transition-transform duration-300 hover:scale-105">
                    @else
                        <i class="fa-solid fa-shirt text-8xl text-gray-300"></i>
                    @endif
                </div>

                @if (is_array($fotos) && count($fotos) > 1)
                    <div class="flex gap-3 w-full overflow-x-auto pb-2 justify-center hide-scroll">
                        @foreach ($fotos as $index => $ft)
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg p-1 cursor-pointer flex-shrink-0 bg-gray-50 transition-all duration-300 {{ $index === 0 ? 'border-2 border-[#0088cc] shadow-sm' : 'border border-gray-200 hover:border-gray-400' }} thumb-item"
                                onclick="changeImage('{{ asset('storage/' . $ft) }}', this)">
                                <img src="{{ asset('storage/' . $ft) }}" class="w-full h-full object-cover rounded-md">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="w-full md:w-7/12 flex flex-col justify-start pt-2">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight leading-tight mb-4">
                    {{ $produk->nama_produk }}
                </h1>

                <div
                    class="bg-gray-50 p-4 sm:p-5 rounded-xl border border-gray-100 mb-8 flex items-center flex-wrap gap-3">
                    <span class="text-[#0088cc] text-2xl sm:text-3xl font-black">Rp
                        {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    <span class="text-gray-400 text-sm sm:text-base font-semibold line-through">Rp
                        {{ number_format($hargaNormal, 0, ',', '.') }}</span>
                    <span
                        class="bg-blue-100 text-[#0088cc] border border-blue-200 text-xs font-bold px-2.5 py-1 rounded ml-2">{{ $persenDiskon }}%
                        OFF</span>
                </div>

                <div class="flex items-start gap-4 mb-8">
                    <span class="text-gray-500 font-bold whitespace-nowrap pt-1 w-24">Jaminan</span>
                    <div class="text-gray-800 font-medium text-sm sm:text-base leading-relaxed">
                        <i class="fa-solid fa-arrow-rotate-left text-[#0088cc] mr-1"></i> 15 Hari Pengembalian
                        &nbsp;&bull;&nbsp;
                        <i class="fa-solid fa-certificate text-[#0088cc] mr-1"></i> 100% Original
                    </div>
                </div>

                <form method="POST">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                    <div class="flex items-center gap-4 mb-10">
                        <span class="text-gray-500 font-bold whitespace-nowrap w-24">Kuantitas</span>
                        <div
                            class="flex items-center border-2 border-gray-200 rounded-lg overflow-hidden h-11 w-32 focus-within:border-[#0088cc] transition-colors">
                            <button type="button"
                                class="w-10 h-full bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-600 border-r border-gray-200"
                                onclick="decrementQty()"><i class="fa-solid fa-minus text-xs"></i></button>
                            <input type="number" name="kuantitas" id="qtyInput" value="1" min="1"
                                max="{{ $produk->stok }}"
                                class="w-full h-full text-center font-bold text-gray-800 outline-none custom-number-input">
                            <button type="button"
                                class="w-10 h-full bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-600 border-l border-gray-200"
                                onclick="incrementQty()"><i class="fa-solid fa-plus text-xs"></i></button>
                        </div>
                        <span class="text-sm text-gray-500 font-medium ml-2">Sisa <span
                                class="font-bold text-gray-800">{{ $produk->stok }}</span> barang</span>
                    </div>

                    @if (session('success'))
                        <div
                            class="mb-4 text-green-700 font-bold text-sm bg-green-50 p-4 rounded-xl border border-green-200">
                            <i class="fa-solid fa-check"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 text-red-700 font-bold text-sm bg-red-50 p-4 rounded-xl border border-red-200">
                            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if (!Auth::check())
                        <div class="mb-4 text-red-600 font-bold text-sm bg-red-50 p-4 rounded-xl border border-red-200">
                            <i class="fa-solid fa-circle-exclamation"></i> Anda harus <a href="{{ route('login') }}"
                                class="underline hover:text-red-800">Login</a> untuk belanja.
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-auto border-t border-gray-100 pt-8">
                        @if ($isAdmin)
                            <button type="button" disabled
                                class="flex-1 bg-gray-100 border-2 border-gray-200 text-gray-400 font-extrabold py-3.5 px-6 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed opacity-80">
                                <i class="fa-solid fa-ban"></i> Fitur Belanja Terkunci
                            </button>
                        @else
                            <button type="submit" formaction="{{ route('cart.store') ?? '#' }}"
                                {{ !Auth::check() ? 'disabled' : '' }}
                                class="flex-1 bg-blue-50 border-2 border-[#0088cc] text-[#0088cc] font-extrabold py-3.5 px-6 hover:bg-blue-100 transition-colors rounded-xl flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fa-solid fa-cart-plus"></i> Ke Keranjang
                            </button>
                            <button type="submit" formaction="{{ route('checkout.prepare_direct') ?? '#' }}"
                                {{ !Auth::check() ? 'disabled' : '' }}
                                class="flex-1 bg-gradient-to-r from-[#0088cc] to-[#006699] text-white font-extrabold py-3.5 px-6 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 rounded-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                Beli Sekarang
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- BAGIAN 2: PROFIL TOKO PENJUAL (DENGAN TOMBOL KLIK MODAL) -->
        @if ($produk->user)
            @php
                $uName = htmlspecialchars(trim($produk->user->nama_lengkap ?? 'Penjual'), ENT_QUOTES);
                $uEmail = htmlspecialchars(trim($produk->user->username ?? '-'), ENT_QUOTES);
                $uTelp = htmlspecialchars(trim($produk->user->no_telp ?? '-'), ENT_QUOTES);
                $uJk = htmlspecialchars(trim($produk->user->jenis_kelamin ?? '-'), ENT_QUOTES);
                $uAlamat = htmlspecialchars(
                    trim(preg_replace('/\s+/', ' ', $produk->user->alamat ?? 'Belum mengatur alamat.')),
                    ENT_QUOTES,
                );
                $uDesc = htmlspecialchars(
                    trim(preg_replace('/\s+/', ' ', $produk->user->deskripsi ?? 'Belum ada deskripsi.')),
                    ENT_QUOTES,
                );
                $uToko = htmlspecialchars(trim($produk->user->nama_toko ?? '-'), ENT_QUOTES);
            @endphp
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div
                        class="w-16 h-16 bg-blue-50 text-[#0088cc] rounded-full flex items-center justify-center text-2xl font-black shrink-0 border border-blue-100 shadow-sm">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-gray-900 tracking-tight">
                            {{ $produk->user->nama_toko ?? ($produk->user->nama_lengkap ?? 'Toko Tidak Diketahui') }}
                        </h3>
                        <p class="text-sm text-gray-500 font-medium mt-0.5"><i
                                class="fa-solid fa-map-location-dot mr-1 text-[#0088cc]"></i>
                            {{ $produk->user->alamat ?? 'Lokasi tidak diatur' }}</p>
                    </div>
                </div>
                <!-- TOMBOL KUNJUNGI TOKO: MEMBUKA MODAL PROFIL -->
                <button type="button"
                    onclick="openProfileModal('{{ $uName }}', '{{ $uEmail }}', '{{ $uTelp }}', '{{ $uJk }}', '{{ $uAlamat }}', '{{ $uDesc }}', '{{ $uToko }}')"
                    class="w-full sm:w-auto bg-white border-2 border-gray-200 text-gray-700 hover:text-[#0088cc] hover:border-[#0088cc] font-bold py-2.5 px-6 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-eye"></i> Kunjungi Toko
                </button>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6 mb-12">
            <!-- DESKRIPSI -->
            <div class="w-full lg:w-4/12 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 h-full">
                    <h2 class="text-lg font-extrabold text-gray-900 border-b-2 border-gray-100 pb-3 mb-4">
                        <i class="fa-solid fa-clipboard-list text-[#0088cc] mr-2"></i> Deskripsi Produk
                    </h2>
                    <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-wrap font-medium">
                        @if ($produk->deskripsi)
                            {!! nl2br(e($produk->deskripsi)) !!}
                        @else
                            <span class="italic text-gray-400">Penjual belum menambahkan deskripsi untuk produk
                                ini.</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- ULASAN -->
            @php
                $ulasanList = \App\Models\Ulasan::with('user')->where('produk_id', $produk->id)->latest()->get();
                $totalUlasan = $ulasanList->count();
                $avgRating = $totalUlasan > 0 ? round($ulasanList->avg('rating'), 1) : 0;
            @endphp

            <div class="w-full lg:w-8/12">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">
                    <h2
                        class="text-lg font-extrabold text-gray-900 border-b-2 border-gray-100 pb-3 mb-5 flex justify-between items-center">
                        <span><i class="fa-solid fa-star text-yellow-400 mr-2"></i> Ulasan Pembeli
                            ({{ $totalUlasan }})</span>
                        @if ($totalUlasan > 0)
                            <span class="text-[#0088cc] text-xl">{{ $avgRating }}<span
                                    class="text-sm text-gray-500">/5.0</span></span>
                        @endif
                    </h2>

                    @if ($totalUlasan > 0)
                        <div class="flex gap-2 overflow-x-auto hide-scroll mb-6 pb-2">
                            <button onclick="filterUlasan('all')" id="btnFilter-all"
                                class="filter-btn active bg-[#0088cc] text-white border-2 border-[#0088cc] px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-colors">Semua</button>
                            <button onclick="filterUlasan(5)" id="btnFilter-5"
                                class="filter-btn bg-white text-gray-600 border-2 border-gray-200 hover:border-[#0088cc] px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-colors">5
                                Bintang</button>
                            <button onclick="filterUlasan(4)" id="btnFilter-4"
                                class="filter-btn bg-white text-gray-600 border-2 border-gray-200 hover:border-[#0088cc] px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-colors">4
                                Bintang</button>
                            <button onclick="filterUlasan(3)" id="btnFilter-3"
                                class="filter-btn bg-white text-gray-600 border-2 border-gray-200 hover:border-[#0088cc] px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-colors">3
                                Bintang</button>
                            <button onclick="filterUlasan(2)" id="btnFilter-2"
                                class="filter-btn bg-white text-gray-600 border-2 border-gray-200 hover:border-[#0088cc] px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-colors">2
                                Bintang</button>
                            <button onclick="filterUlasan(1)" id="btnFilter-1"
                                class="filter-btn bg-white text-gray-600 border-2 border-gray-200 hover:border-[#0088cc] px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-colors">1
                                Bintang</button>
                        </div>
                    @endif

                    <div class="space-y-5" id="ulasanContainer">
                        @forelse($ulasanList as $u)
                            <div class="ulasan-item pb-5 border-b border-gray-100 last:border-0 last:pb-0"
                                data-rating="{{ $u->rating }}">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-10 h-10 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">
                                            {{ $u->user->nama_lengkap ?? 'Pembeli Rahasia' }}</p>
                                        <div class="flex items-center text-xs mt-0.5">
                                            <div class="text-yellow-400 flex mr-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="{{ $i <= $u->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                                @endfor
                                            </div>
                                            <span class="text-gray-400">{{ $u->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed font-medium mt-3">{{ $u->komentar }}
                                </p>

                                @if ($u->foto_review)
                                    <div class="mt-3">
                                        <img src="{{ asset('storage/' . $u->foto_review) }}"
                                            class="w-20 h-20 object-cover rounded-lg border border-gray-200 shadow-sm cursor-pointer hover:scale-105 transition-transform"
                                            onclick="window.open(this.src, '_blank')">
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-10 flex flex-col items-center justify-center text-gray-400">
                                <i class="fa-regular fa-comments text-5xl mb-3 text-gray-200"></i>
                                <p class="text-sm font-bold">Belum ada ulasan untuk produk ini.</p>
                            </div>
                        @endforelse

                        <div id="ulasanEmpty" class="hidden text-center py-8 text-gray-400 font-bold text-sm">
                            <i class="fa-solid fa-filter-circle-xmark text-4xl mb-2 text-gray-200 block"></i>
                            Tidak ada ulasan di rating bintang ini.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ========================================== -->
    <!-- MODAL PROFIL TOKO (ANIMASI KEKINIAN)       -->
    <!-- ========================================== -->
    <div id="profileModal"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 pointer-events-none opacity-0 transition-opacity duration-300 ease-out">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeProfileModal()"></div>

        <div id="profileModalContent"
            class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.3)] rounded-[2rem] max-w-md w-full relative transform scale-95 transition-transform duration-300 ease-out z-10 overflow-hidden">

            <div class="h-28 w-full bg-gradient-to-br from-[#0088cc] to-blue-700 relative">
                <button type="button" onclick="closeProfileModal()"
                    class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/20 text-white hover:bg-white hover:text-red-500 transition-colors backdrop-blur-md">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="px-6 pb-6 relative">
                <div class="flex flex-col items-center -mt-12 mb-5">
                    <div
                        class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-4xl mb-3 shadow-lg border-4 border-white overflow-hidden relative">
                        <div class="absolute inset-0 bg-blue-50 flex items-center justify-center text-[#0088cc]"><i
                                class="fa-solid fa-user-astronaut"></i></div>
                    </div>
                    <h4 class="text-xl font-black text-gray-800 text-center leading-tight" id="modalNama">Nama Toko
                    </h4>
                    <p class="text-sm font-semibold text-[#0088cc] text-center" id="modalEmail">email@domain.com</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-4">
                    <div class="flex items-center gap-3 border-b border-gray-200 pb-3" id="wrapNamaToko">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 text-[#0088cc] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-store"></i></div>
                        <div class="min-w-0">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Nama
                                Toko</span>
                            <span class="text-sm font-bold text-[#0088cc] truncate block" id="modalToko">-</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 border-b border-gray-200 pb-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 text-[#0088cc] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone"></i></div>
                        <div class="min-w-0">
                            <span
                                class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Telepon</span>
                            <span class="text-sm font-bold text-gray-800 truncate block" id="modalTelp">-</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 border-b border-gray-200 pb-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 text-[#0088cc] flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-quote-left"></i></div>
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Deskripsi
                                Toko</span>
                            <span class="text-sm font-medium text-gray-700 leading-snug block italic"
                                id="modalDeskripsi">-</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 text-[#0088cc] flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-map-location-dot"></i></div>
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Alamat
                                Toko</span>
                            <span class="text-sm font-bold text-gray-800 leading-snug block" id="modalAlamat">-</span>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="closeProfileModal()"
                    class="w-full mt-6 py-3.5 bg-gray-800 hover:bg-black text-white font-bold rounded-xl transition-all shadow-md hover:-translate-y-0.5">
                    Tutup Jendela
                </button>
            </div>
        </div>
    </div>

    <!-- PENUTUP SHELL -->
    @if ($isAdmin)
        </div>
        </div>
    @else
        </div>
    @endif

    @include('layouts.modal-logout')

    <!-- ========================================== -->
    <!-- JAVASCRIPT LOGIC                           -->
    <!-- ========================================== -->
    <script>
        const qtyInput = document.getElementById('qtyInput');
        const maxStock = {{ $produk->stok }};

        function incrementQty() {
            let val = parseInt(qtyInput.value) || 0;
            if (val < maxStock) qtyInput.value = val + 1;
        }

        function decrementQty() {
            let val = parseInt(qtyInput.value) || 0;
            if (val > 1) qtyInput.value = val - 1;
        }

        qtyInput.addEventListener('change', function() {
            let val = parseInt(this.value);
            if (isNaN(val) || val < 1) this.value = 1;
            if (val > maxStock) this.value = maxStock;
        });

        function changeImage(imageSrc, element) {
            document.getElementById('mainImage').src = imageSrc;
            document.querySelectorAll('.thumb-item').forEach(el => {
                el.classList.remove('border-[#0088cc]', 'border-2', 'shadow-sm');
                el.classList.add('border-gray-200', 'border');
            });
            element.classList.remove('border-gray-200', 'border');
            element.classList.add('border-[#0088cc]', 'border-2', 'shadow-sm');
        }

        function filterUlasan(rating) {
            const items = document.querySelectorAll('.ulasan-item');
            const emptyState = document.getElementById('ulasanEmpty');
            let visibleCount = 0;

            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-[#0088cc]', 'text-white', 'border-[#0088cc]');
                btn.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
            });

            const activeBtn = document.getElementById('btnFilter-' + rating);
            if (activeBtn) {
                activeBtn.classList.add('bg-[#0088cc]', 'text-white', 'border-[#0088cc]');
                activeBtn.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');
            }

            items.forEach(item => {
                if (rating === 'all' || item.getAttribute('data-rating') == rating) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (visibleCount === 0 && items.length > 0) {
                emptyState.classList.remove('hidden');
                emptyState.classList.add('block');
            } else {
                emptyState.classList.remove('block');
                emptyState.classList.add('hidden');
            }
        }

        // --- Logika Membuka / Menutup Modal Profil Toko ---
        function openProfileModal(nama, email, telp, jk, alamat, deskripsi, namaToko) {
            document.getElementById('modalNama').innerText = nama;
            document.getElementById('modalEmail').innerText = email;
            document.getElementById('modalTelp').innerText = telp ? telp : '-';
            document.getElementById('modalDeskripsi').innerText = deskripsi ? '"' + deskripsi + '"' :
            'Belum ada deskripsi.';
            document.getElementById('modalAlamat').innerText = alamat ? alamat : 'Belum mengatur alamat.';

            const txtNamaToko = document.getElementById('modalToko');
            const wrapNamaToko = document.getElementById('wrapNamaToko');

            if (namaToko && namaToko.trim() !== '' && namaToko !== '-') {
                txtNamaToko.innerText = namaToko;
                wrapNamaToko.classList.remove('hidden');
                wrapNamaToko.classList.add('flex');
            } else {
                wrapNamaToko.classList.remove('flex');
                wrapNamaToko.classList.add('hidden');
            }

            const modal = document.getElementById('profileModal');
            const modalContent = document.getElementById('profileModalContent');
            modal.classList.remove('pointer-events-none', 'opacity-0');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }

        function closeProfileModal() {
            const modal = document.getElementById('profileModal');
            const modalContent = document.getElementById('profileModalContent');
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
        }
    </script>
</body>

</html>
