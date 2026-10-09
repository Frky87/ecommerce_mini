<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Marketqu</title>
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

        /* Memastikan elemen tidak terpotong saat zoom besar */
        * {
            word-wrap: break-word;
        }
    </style>
</head>

<body class="bg-[#ebebeb] font-sans selection:bg-[#0088cc] selection:text-white min-h-screen flex flex-col">

    <!-- Panggil File Navbar -->
    @include('layouts.navbar')

    <main class="flex-grow w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        <!-- Peringatan Sukses -->
        @if (session('success'))
            <div
                class="bg-green-50 text-green-700 border border-green-200 p-4 rounded-xl mb-6 font-bold flex items-center gap-3 shadow-sm text-sm sm:text-base">
                <i class="fa-solid fa-circle-check text-xl shrink-0"></i> {{ session('success') }}
            </div>
        @endif

        @if (count($cartItems) > 0)
            <!-- HEADER TABEL (Hanya Tampil di Layar Lebar) -->
            <div
                class="hidden md:flex bg-white p-4 rounded-t-xl shadow-sm items-center border-b border-gray-100 text-sm font-bold text-gray-600">
                <div class="w-8 shrink-0 flex justify-center"><input type="checkbox" id="selectAllTop"
                        class="w-4 h-4 cursor-pointer accent-[#0088cc]"></div>
                <div class="flex-1">Produk</div>
                <div class="w-28 text-center shrink-0">Harga</div>
                <div class="w-32 text-center shrink-0">Kuantitas</div>
                <div class="w-32 text-right shrink-0">Total Harga</div>
                <div class="w-20 text-center shrink-0 ml-4">Aksi</div>
            </div>

            <!-- LIST PRODUK -->
            <div class="bg-white md:rounded-b-xl rounded-xl shadow-sm mb-6 sm:mb-24 flex flex-col gap-0 md:gap-0">
                @foreach ($cartItems as $item)
                    @php $totalHargaItem = $item->produk->harga * $item->kuantitas; @endphp

                    <!-- KOTAK PRODUK (Responsif: Stack di layar kecil, Berjejer di layar besar) -->
                    <div
                        class="p-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center last:border-b-0 hover:bg-gray-50 transition-colors gap-4">

                        <!-- Area Kiri: Checkbox, Gambar, Nama -->
                        <div class="flex flex-1 items-start md:items-center gap-3 sm:gap-4">
                            <!-- Checkbox -->
                            <div class="pt-2 md:pt-0 shrink-0">
                                <input type="checkbox" class="item-checkbox w-4 h-4 cursor-pointer accent-[#0088cc]"
                                    data-price="{{ $totalHargaItem }}" data-id="{{ $item->id }}">
                            </div>

                            <!-- Gambar -->
                            <div
                                class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-50 border border-gray-200 rounded-lg p-1.5 shrink-0 relative">
                                @if (count($item->produk->foto_array) > 0)
                                    <img src="{{ asset('storage/' . $item->produk->foto_array[0]) }}"
                                        class="w-full h-full object-contain mix-blend-multiply">
                                @else
                                    <i
                                        class="fa-solid fa-shirt text-3xl text-gray-300 w-full h-full flex items-center justify-center"></i>
                                @endif
                                <!-- Badge Kuantitas di Layar Kecil (Menempel pada gambar) -->
                                <div
                                    class="md:hidden absolute -top-2 -right-2 bg-[#0088cc] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border border-white">
                                    {{ $item->kuantitas }}x
                                </div>
                            </div>

                            <!-- Nama Produk & Harga Satuan Mobile -->
                            <div class="flex flex-col flex-1 min-w-0">
                                <span
                                    class="text-sm font-bold text-gray-800 line-clamp-2 leading-tight">{{ $item->produk->nama_produk }}</span>
                                <span class="text-xs text-gray-500 mt-1 mb-2">Kategori:
                                    {{ $item->produk->kategori }}</span>
                                <!-- Harga Satuan hanya muncul di Mobile -->
                                <span class="md:hidden text-sm font-bold text-gray-800 mt-auto">Rp
                                    {{ number_format($item->produk->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Area Kanan: Harga, Kuantitas, Total, Aksi -->
                        <div
                            class="flex flex-row flex-wrap md:flex-nowrap items-center justify-between md:justify-end gap-3 md:gap-0 pl-7 md:pl-0 mt-2 md:mt-0 w-full md:w-auto">

                            <!-- Harga Satuan Desktop -->
                            <div class="hidden md:block w-28 text-center shrink-0">
                                <span class="text-sm font-bold text-gray-800">Rp
                                    {{ number_format($item->produk->harga, 0, ',', '.') }}</span>
                            </div>

                            <!-- Input Kuantitas (+/-) -->
                            <div class="w-auto md:w-32 flex justify-center shrink-0">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                    class="flex items-center border border-gray-300 rounded-lg h-8 sm:h-9 w-24 sm:w-28 overflow-hidden bg-white">
                                    @csrf @method('PUT')
                                    <button type="button"
                                        onclick="this.nextElementSibling.stepDown(); this.parentNode.submit();"
                                        class="w-8 h-full bg-gray-50 hover:bg-gray-200 border-r border-gray-300 text-gray-600 focus:outline-none"><i
                                            class="fa-solid fa-minus text-[10px]"></i></button>

                                    <input type="number" name="kuantitas" value="{{ $item->kuantitas }}"
                                        min="1" max="{{ $item->produk->stok }}"
                                        class="w-full h-full text-center text-xs sm:text-sm font-bold text-gray-800 outline-none custom-number-input bg-transparent"
                                        onchange="this.form.submit()">

                                    <button type="button"
                                        onclick="this.previousElementSibling.stepUp(); this.parentNode.submit();"
                                        class="w-8 h-full bg-gray-50 hover:bg-gray-200 border-l border-gray-300 text-gray-600 focus:outline-none"><i
                                            class="fa-solid fa-plus text-[10px]"></i></button>
                                </form>
                            </div>

                            <!-- Total Harga & Aksi Hapus (Mobile berjejer, Desktop terpisah) -->
                            <div class="flex items-center justify-end gap-3 flex-1 md:flex-none">
                                <!-- Total Harga -->
                                <div
                                    class="w-auto md:w-32 text-right text-[#0088cc] font-extrabold text-sm sm:text-base shrink-0">
                                    Rp {{ number_format($totalHargaItem, 0, ',', '.') }}
                                </div>

                                <!-- Aksi Hapus -->
                                <div class="w-auto md:w-20 md:ml-4 text-right shrink-0">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 w-8 h-8 sm:w-9 sm:h-9 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center justify-center group"
                                            title="Hapus dari keranjang">
                                            <i
                                                class="fa-solid fa-trash-can group-hover:scale-110 transition-transform"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- CHECKOUT BAR BAWAH (Mengambang / Sticky Bottom) -->
            <div
                class="bg-white p-3 sm:p-4 rounded-t-2xl sm:rounded-xl shadow-[0_-4px_15px_rgba(0,0,0,0.05)] flex flex-col sm:flex-row justify-between items-center fixed sm:sticky bottom-0 sm:bottom-4 left-0 sm:left-auto right-0 sm:right-auto w-full max-w-6xl mx-auto z-50 border-t sm:border border-gray-200 gap-3 sm:gap-0">

                <!-- Area Kiri Bawah (Pilih Semua) -->
                <div class="flex items-center justify-between sm:justify-start w-full sm:w-auto gap-4">
                    <label
                        class="flex items-center gap-2 cursor-pointer bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                        <input type="checkbox" id="selectAllBottom" class="w-4 h-4 accent-[#0088cc]">
                        <span class="text-xs sm:text-sm font-bold text-gray-700 whitespace-nowrap">Semua (<span
                                id="countSelected">0</span>)</span>
                    </label>
                    <button
                        class="bg-white border border-red-200 hover:bg-red-50 text-red-500 px-3 py-1.5 rounded-lg text-xs sm:text-sm font-bold shadow-sm disabled:opacity-50 flex items-center gap-1.5 transition-colors">
                        <i class="fa-solid fa-trash-can"></i> <span class="hidden sm:inline">Hapus</span>
                    </button>
                </div>

                <!-- Area Kanan Bawah (Total & Checkout) -->
                <div
                    class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-3 sm:gap-6 border-t sm:border-t-0 border-gray-100 pt-3 sm:pt-0">
                    <div class="text-left sm:text-right">
                        <div class="text-[10px] sm:text-xs text-gray-500 font-bold uppercase tracking-wider mb-0.5">
                            Total Harga:</div>
                        <div class="text-lg sm:text-2xl font-black text-[#0088cc] leading-none" id="totalPriceUI">Rp 0
                        </div>
                    </div>
                    <button
                        class="bg-[#0088cc] hover:bg-blue-600 text-white px-6 sm:px-10 py-2.5 sm:py-3 rounded-xl font-bold shadow-md hover:-translate-y-0.5 transition-all text-sm sm:text-base whitespace-nowrap flex-shrink-0 flex items-center gap-2">
                        Checkout <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        @else
            <!-- JIKA KERANJANG KOSONG -->
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-16 flex flex-col items-center justify-center text-center mx-4 sm:mx-0">
                <div
                    class="w-24 h-24 sm:w-32 sm:h-32 bg-gray-100 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <i class="fa-solid fa-cart-shopping text-5xl sm:text-6xl text-gray-300"></i>
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-800 mb-2">Keranjang Belanja Kosong</h2>
                <p class="text-sm sm:text-base text-gray-500 mb-8 max-w-md">Wah, keranjang belanjamu masih kosong. Yuk
                    temukan outfit terbaikmu dan isi keranjang ini!</p>
                <a href="{{ route('katalog') }}"
                    class="bg-[#0088cc] text-white px-6 sm:px-8 py-3 rounded-xl font-bold hover:bg-blue-600 shadow-md transition-all hover:-translate-y-1 flex items-center gap-2">
                    <i class="fa-solid fa-store"></i> Mulai Belanja
                </a>
            </div>
        @endif
    </main>

    <!-- Panggil File Modal Logout -->
    @include('layouts.modal-logout')

    <!-- Script Kalkulasi Otomatis -->
    <script>
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const selectAllTop = document.getElementById('selectAllTop');
        const selectAllBottom = document.getElementById('selectAllBottom');
        const countSelected = document.getElementById('countSelected');
        const totalPriceUI = document.getElementById('totalPriceUI');

        function calculateTotal() {
            let total = 0,
                count = 0,
                allChecked = true;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseInt(cb.getAttribute('data-price'));
                    count++;
                } else {
                    allChecked = false;
                }
            });
            if (checkboxes.length === 0) allChecked = false;
            if (selectAllTop) selectAllTop.checked = allChecked;
            if (selectAllBottom) selectAllBottom.checked = allChecked;
            if (countSelected) countSelected.innerText = count;
            if (totalPriceUI) totalPriceUI.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        if (selectAllTop && selectAllBottom) {
            selectAllTop.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                calculateTotal();
            });
            selectAllBottom.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                calculateTotal();
            });
            checkboxes.forEach(cb => {
                cb.addEventListener('change', calculateTotal);
            });
        }
    </script>
</body>

</html>
