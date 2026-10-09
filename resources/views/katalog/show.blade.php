<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->nama_produk }} - Marketqu</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
</head>

<body class="bg-gray-50 font-sans selection:bg-[#0088cc] selection:text-white min-h-screen flex flex-col">

    <!-- Panggil File Navbar -->
    @include('layouts.navbar')

    @php
        $fotos = $produk->foto_array;
        $mainFoto = count($fotos) > 0 ? $fotos[0] : null;
        $seedString = $produk->id . date('Y-m-d H');
        $hashValue = abs(crc32($seedString));
        $persenDiskon = ($hashValue % 66) + 10;
        $hargaNormal = $produk->harga / (1 - $persenDiskon / 100);
    @endphp

    <div class="max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-4">
        <nav class="text-sm font-medium text-gray-500">
            <a href="{{ route('katalog') }}" class="hover:text-[#0088cc]">Home</a> <span class="mx-2">&gt;</span>
            <a href="{{ route('katalog', ['kategori' => $produk->kategori]) }}"
                class="hover:text-[#0088cc]">{{ $produk->kategori }}</a> <span class="mx-2">&gt;</span>
            <span class="text-gray-800 truncate">{{ $produk->nama_produk }}</span>
        </nav>
    </div>

    <main class="flex-grow w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div
            class="bg-white rounded-none sm:rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col md:flex-row p-4 sm:p-8 gap-8 lg:gap-12">

            <div class="w-full md:w-5/12 flex flex-col items-center">
                <div
                    class="w-full aspect-square bg-gray-50 flex items-center justify-center rounded-xl border border-gray-100 p-4 mb-4 relative">
                    @if ($mainFoto)
                        <img src="{{ asset('storage/' . $mainFoto) }}" id="mainImage"
                            class="max-h-full max-w-full object-contain transition-transform duration-300 hover:scale-105">
                    @else
                        <i class="fa-solid fa-shirt text-8xl text-gray-300"></i>
                    @endif
                </div>

                @if (count($fotos) > 1)
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
                    {{ $produk->nama_produk }}</h1>

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
                        <i class="fa-solid fa-certificate text-[#0088cc] mr-1"></i> 100% Original &nbsp;&bull;&nbsp;
                        <i class="fa-solid fa-shield-halved text-[#0088cc] mr-1"></i> Proteksi Kerusakan
                    </div>
                </div>

                <!-- FORM KERANJANG -->
                <form action="{{ route('cart.store') }}" method="POST">
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
                        <span class="text-sm text-gray-500 font-medium ml-2">Tersedia <span
                                class="font-bold text-gray-800">{{ $produk->stok }}</span> barang</span>
                    </div>

                    @if (session('success'))
                        <div
                            class="mb-4 text-green-700 font-bold text-sm bg-green-50 p-4 rounded-xl border border-green-200">
                            <i class="fa-solid fa-check"></i> {{ session('success') }}</div>
                    @endif
                    @if (!Auth::check())
                        <div class="mb-4 text-red-600 font-bold text-sm bg-red-50 p-4 rounded-xl border border-red-200">
                            <i class="fa-solid fa-circle-exclamation"></i> Anda harus <a href="{{ route('login') }}"
                                class="underline hover:text-red-800">Login</a> untuk memasukkan barang ke keranjang.
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-auto border-t border-gray-100 pt-8">
                        <button type="submit" {{ !Auth::check() ? 'disabled' : '' }}
                            class="flex-1 bg-blue-50 border-2 border-[#0088cc] text-[#0088cc] font-extrabold py-3.5 px-6 hover:bg-blue-100 transition-colors rounded-xl flex items-center justify-center gap-2 disabled:opacity-50">
                            <i class="fa-solid fa-cart-plus"></i> Masukkan Keranjang
                        </button>
                        <button type="button"
                            class="flex-1 bg-gradient-to-r from-[#0088cc] to-[#006699] text-white font-extrabold py-3.5 px-6 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 rounded-xl">
                            Beli Sekarang
                        </button>
                    </div>
                </form>

                <div class="mt-8 flex flex-col gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div class="text-sm font-bold text-gray-800">Kode Produk <span
                            class="float-right font-medium text-gray-600 uppercase">{{ $produk->kode_produk }}</span>
                    </div>
                    <div class="w-full h-px bg-gray-200"></div>
                    <div class="text-sm font-bold text-gray-800">Kategori <span
                            class="float-right font-medium text-gray-600">{{ $produk->kategori }}</span></div>
                </div>
            </div>
        </div>
    </main>

    <!-- Panggil File Modal Logout -->
    @include('layouts.modal-logout')

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
    </script>
</body>

</html>
