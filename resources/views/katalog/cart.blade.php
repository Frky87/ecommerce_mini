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

        * {
            word-wrap: break-word;
        }
    </style>
</head>

<body class="bg-[#ebebeb] font-sans selection:bg-[#0088cc] selection:text-white min-h-screen flex flex-col">

    <!-- Panggil File Navbar -->
    @include('layouts.navbar')

    <main class="flex-grow w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        <!-- Peringatan Sukses/Error -->
        @if (session('success'))
            <div
                class="bg-green-50 text-green-700 border border-green-200 p-4 rounded-xl mb-6 font-bold flex items-center gap-3 shadow-sm text-sm sm:text-base">
                <i class="fa-solid fa-circle-check text-xl shrink-0"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="bg-red-50 text-red-700 border border-red-200 p-4 rounded-xl mb-6 font-bold flex items-center gap-3 shadow-sm text-sm sm:text-base">
                <i class="fa-solid fa-triangle-exclamation text-xl shrink-0"></i> {{ session('error') }}
            </div>
        @endif

        @if (count($cartItems) > 0)
            <!-- HEADER TABEL -->
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

                    <div
                        class="p-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center last:border-b-0 hover:bg-gray-50 transition-colors gap-4">

                        <div class="flex flex-1 items-start md:items-center gap-3 sm:gap-4">
                            <div class="pt-2 md:pt-0 shrink-0">
                                <input type="checkbox" class="item-checkbox w-4 h-4 cursor-pointer accent-[#0088cc]"
                                    data-price="{{ $totalHargaItem }}" data-id="{{ $item->id }}">
                            </div>

                            <div
                                class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-50 border border-gray-200 rounded-lg p-1.5 shrink-0 relative">
                                @if (count($item->produk->foto_array) > 0)
                                    <img src="{{ asset('storage/' . $item->produk->foto_array[0]) }}"
                                        class="w-full h-full object-contain mix-blend-multiply">
                                @else
                                    <i
                                        class="fa-solid fa-shirt text-3xl text-gray-300 w-full h-full flex items-center justify-center"></i>
                                @endif
                                <div
                                    class="md:hidden absolute -top-2 -right-2 bg-[#0088cc] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border border-white">
                                    {{ $item->kuantitas }}x
                                </div>
                            </div>

                            <div class="flex flex-col flex-1 min-w-0">
                                <span
                                    class="text-sm font-bold text-gray-800 line-clamp-2 leading-tight">{{ $item->produk->nama_produk }}</span>
                                <span class="text-xs text-gray-500 mt-1 mb-2">Kategori:
                                    {{ $item->produk->kategori }}</span>
                                <span class="md:hidden text-sm font-bold text-gray-800 mt-auto">Rp
                                    {{ number_format($item->produk->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div
                            class="flex flex-row flex-wrap md:flex-nowrap items-center justify-between md:justify-end gap-3 md:gap-0 pl-7 md:pl-0 mt-2 md:mt-0 w-full md:w-auto">

                            <div class="hidden md:block w-28 text-center shrink-0">
                                <span class="text-sm font-bold text-gray-800">Rp
                                    {{ number_format($item->produk->harga, 0, ',', '.') }}</span>
                            </div>

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

                            <div class="flex items-center justify-end gap-3 flex-1 md:flex-none">
                                <div
                                    class="w-auto md:w-32 text-right text-[#0088cc] font-extrabold text-sm sm:text-base shrink-0">
                                    Rp {{ number_format($totalHargaItem, 0, ',', '.') }}
                                </div>
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

            <!-- CHECKOUT BAR BAWAH -->
            <div
                class="bg-white p-3 sm:p-4 rounded-t-2xl sm:rounded-xl shadow-[0_-4px_15px_rgba(0,0,0,0.05)] flex flex-col sm:flex-row justify-between items-center fixed sm:sticky bottom-0 sm:bottom-4 left-0 sm:right-auto w-full max-w-6xl mx-auto z-50 border-t sm:border border-gray-200 gap-3 sm:gap-0">

                <div class="flex items-center justify-between sm:justify-start w-full sm:w-auto gap-4">
                    <label
                        class="flex items-center gap-2 cursor-pointer bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                        <input type="checkbox" id="selectAllBottom" class="w-4 h-4 accent-[#0088cc]">
                        <span class="text-xs sm:text-sm font-bold text-gray-700 whitespace-nowrap">Semua (<span
                                id="countSelected">0</span>)</span>
                    </label>

                    <form id="bulkDeleteForm" action="{{ route('cart.destroy_multiple') }}" method="POST"
                        class="hidden">
                        @csrf @method('DELETE')
                        <div id="bulkDeleteInputs"></div>
                    </form>
                    <!-- Mengubah onclick untuk memanggil custom modal Hapus Massal -->
                    <button type="button" id="btnBulkDelete" onclick="openBulkDeleteModal()" disabled
                        class="bg-white border border-red-200 hover:bg-red-50 text-red-500 px-3 py-1.5 rounded-lg text-xs sm:text-sm font-bold shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-1.5 transition-colors">
                        <i class="fa-solid fa-trash-can"></i> <span class="hidden sm:inline">Hapus</span>
                    </button>
                </div>

                <div
                    class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-3 sm:gap-6 border-t sm:border-t-0 border-gray-100 pt-3 sm:pt-0">
                    <div class="text-left sm:text-right">
                        <div class="text-[10px] sm:text-xs text-gray-500 font-bold uppercase tracking-wider mb-0.5">
                            Total Harga:</div>
                        <div class="text-lg sm:text-2xl font-black text-[#0088cc] leading-none" id="totalPriceUI">Rp 0
                        </div>
                    </div>

                    <form id="checkoutForm" action="{{ route('checkout.prepare_cart') }}" method="POST"
                        class="hidden">
                        @csrf
                        <div id="checkoutInputs"></div>
                    </form>
                    <button type="button" onclick="submitCheckout()"
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

    <!-- ========================================== -->
    <!-- CUSTOM MODAL HAPUS MASSAL                  -->
    <!-- ========================================== -->
    <div id="bulkDeleteModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity"
            onclick="closeBulkDeleteModal()"></div>
        <div id="bulkDeleteModalContent"
            class="bg-white/95 backdrop-blur-xl border border-white shadow-2xl rounded-3xl max-w-sm w-full relative transform scale-95 opacity-0 transition-all duration-300 ease-out z-10 overflow-hidden">
            <div class="h-2 w-full bg-gradient-to-r from-red-500 via-pink-500 to-orange-400"></div>
            <div class="p-6 sm:p-8 text-center relative">
                <div
                    class="w-16 h-16 sm:w-20 sm:h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 shadow-[0_0_30px_rgba(239,68,68,0.3)] relative group">
                    <div class="absolute inset-0 rounded-full border-2 border-red-200 animate-ping opacity-30"></div>
                    <i
                        class="fa-solid fa-trash-can text-2xl sm:text-3xl text-red-500 z-10 group-hover:scale-110 transition-transform"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-gray-800 mb-2">Hapus Produk?</h3>
                <p class="text-xs sm:text-sm text-gray-500 mb-6 font-medium">Yakin ingin menghapus <span
                        id="deleteItemCount" class="font-extrabold text-red-500 text-base"></span> produk terpilih
                    dari keranjang?</p>
                <div class="flex flex-col gap-2 sm:gap-3">
                    <button type="button" onclick="confirmBulkDelete()"
                        class="w-full px-4 py-3 sm:py-3.5 bg-gradient-to-r from-red-500 to-pink-500 text-white font-bold rounded-xl sm:rounded-2xl shadow-md hover:-translate-y-1 transition-all flex justify-center gap-2">
                        Ya, Hapus <i class="fa-solid fa-trash-can mt-0.5"></i>
                    </button>
                    <button type="button" onclick="closeBulkDeleteModal()"
                        class="w-full px-4 py-3 sm:py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl sm:rounded-2xl transition-colors">Batal
                        & Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Panggil File Modal Logout -->
    @include('layouts.modal-logout')

    <script>
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const selectAllTop = document.getElementById('selectAllTop');
        const selectAllBottom = document.getElementById('selectAllBottom');
        const countSelected = document.getElementById('countSelected');
        const totalPriceUI = document.getElementById('totalPriceUI');
        const btnBulkDelete = document.getElementById('btnBulkDelete');

        // Kalkulasi Total & Status Tombol
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

            // Aktifkan / Nonaktifkan Tombol Hapus Massal
            if (btnBulkDelete) {
                btnBulkDelete.disabled = count === 0;
            }
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

        // Script Eksekusi Tombol Checkout
        function submitCheckout() {
            const checked = document.querySelectorAll('.item-checkbox:checked');
            if (checked.length === 0) return alert('Silakan centang minimal 1 produk untuk di-checkout!');

            const container = document.getElementById('checkoutInputs');
            container.innerHTML = '';
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cart_ids[]';
                input.value = cb.getAttribute('data-id');
                container.appendChild(input);
            });
            document.getElementById('checkoutForm').submit();
        }

        // ==========================================
        // SCRIPT MODAL HAPUS MASSAL
        // ==========================================
        function openBulkDeleteModal() {
            const checked = document.querySelectorAll('.item-checkbox:checked');
            if (checked.length === 0) return;

            // Masukkan jumlah produk ke dalam teks pop-up
            document.getElementById('deleteItemCount').innerText = checked.length;

            // Munculkan Modal dengan Animasi
            const modal = document.getElementById('bulkDeleteModal');
            const modalContent = document.getElementById('bulkDeleteModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.replace('scale-95', 'scale-100');
                modalContent.classList.replace('opacity-0', 'opacity-100');
            }, 10);
        }

        function closeBulkDeleteModal() {
            const modal = document.getElementById('bulkDeleteModal');
            const modalContent = document.getElementById('bulkDeleteModalContent');
            modalContent.classList.replace('scale-100', 'scale-95');
            modalContent.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function confirmBulkDelete() {
            const checked = document.querySelectorAll('.item-checkbox:checked');
            const container = document.getElementById('bulkDeleteInputs');
            container.innerHTML = '';

            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cart_ids[]';
                input.value = cb.getAttribute('data-id');
                container.appendChild(input);
            });

            // Eksekusi Hapus Massal ke Backend
            document.getElementById('bulkDeleteForm').submit();
        }
    </script>
</body>

</html>
