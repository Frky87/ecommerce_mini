<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan - Marketqu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            word-wrap: break-word;
        }
    </style>
</head>

<body class="bg-[#ebebeb] font-sans selection:bg-[#0088cc] selection:text-white min-h-screen flex flex-col">

    @include('layouts.navbar')

    <main class="flex-grow w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <input type="hidden" name="total_harga" id="inputTotalHarga" value="{{ $totalHarga }}">
            <input type="hidden" name="ongkir" id="inputOngkir" value="{{ $ongkir }}">
            <input type="hidden" name="total_bayar" id="inputTotalBayar" value="{{ $totalBayar }}">

            <!-- Hidden input alamat asli untuk di-submit -->
            <input type="hidden" name="alamat" id="inputAlamat" value="{{ $user->alamat ?? '' }}" required>

            <!-- BOX 1: ALAMAT -->
            <div
                class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-start gap-4 sm:gap-8 mb-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#0088cc] to-blue-300"></div>
                <div class="w-full md:w-1/4 shrink-0">
                    <h3 class="text-[#0088cc] font-extrabold text-base sm:text-lg flex items-center gap-2"><i
                            class="fa-solid fa-map-location-dot"></i> Alamat Pengiriman</h3>
                </div>
                <div class="w-full md:flex-1">
                    <p id="displayAlamat"
                        class="text-sm font-bold text-gray-700 leading-relaxed border-l-4 border-gray-200 pl-4 py-1">
                        {{ $user->alamat ? $user->alamat : 'Belum ada alamat pengiriman. Silakan ubah dan tambahkan alamat Anda.' }}
                    </p>
                </div>
                <div class="w-full md:w-auto shrink-0 flex justify-end">
                    <button type="button" onclick="openAddressModal()"
                        class="bg-blue-50 text-[#0088cc] hover:bg-[#0088cc] hover:text-white px-5 py-2 rounded-lg font-bold text-sm transition-colors border border-blue-200 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square"></i> Ubah Alamat
                    </button>
                </div>
            </div>

            <!-- BOX 2: PRODUK & ONGKIR -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 mb-6">
                <!-- Header -->
                <div class="flex flex-col md:flex-row pb-4 border-b border-gray-100">
                    <div class="w-full md:w-1/2 font-extrabold text-gray-900 text-lg flex items-center gap-2"><i
                            class="fa-solid fa-box-open text-[#0088cc]"></i> Produk Di Pesan</div>
                    <div
                        class="hidden md:flex w-full md:w-1/2 justify-between items-center text-xs text-gray-400 uppercase tracking-widest font-bold">
                        <div class="w-1/3 text-center">Harga Satuan</div>
                        <div class="w-1/3 text-center">Kuantitas</div>
                        <div class="w-1/3 text-right">Total Harga</div>
                    </div>
                </div>

                <!-- List Produk -->
                @foreach ($items as $item)
                    <div
                        class="flex flex-col md:flex-row py-6 border-b border-gray-50 gap-4 md:gap-0 items-start md:items-center hover:bg-gray-50/50 transition-colors px-2 rounded-lg">
                        <div class="w-full md:w-1/2 flex items-center gap-4 shrink-0">
                            <div
                                class="w-20 h-20 bg-white border border-gray-200 rounded-lg p-1 flex-shrink-0 shadow-sm">
                                @if (count($item->produk->foto_array) > 0)
                                    <img src="{{ asset('storage/' . $item->produk->foto_array[0]) }}"
                                        class="w-full h-full object-contain mix-blend-multiply">
                                @else
                                    <i
                                        class="fa-solid fa-shirt text-3xl text-gray-300 w-full h-full flex items-center justify-center"></i>
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <h4 class="text-sm font-bold text-gray-900 leading-tight">
                                    {{ $item->produk->nama_produk }}</h4>
                                <p
                                    class="text-xs text-gray-500 mt-1 font-semibold bg-gray-100 w-max px-2 py-0.5 rounded">
                                    {{ $item->produk->kategori }}</p>
                            </div>
                        </div>

                        <div
                            class="w-full md:w-1/2 flex flex-wrap md:flex-nowrap justify-between items-center bg-gray-50 md:bg-transparent p-3 md:p-0 rounded-lg">
                            <div class="w-auto md:w-1/3 text-center text-sm font-bold text-gray-900">Rp
                                {{ number_format($item->produk->harga, 0, ',', '.') }}</div>
                            <div
                                class="w-auto md:w-1/3 flex justify-center text-sm font-extrabold text-[#0088cc] bg-blue-50 px-3 py-1 rounded-lg border border-blue-100">
                                {{ $item->kuantitas }} x
                            </div>
                            <div class="w-full md:w-1/3 text-right text-sm font-black text-[#0088cc] mt-2 md:mt-0">Rp
                                {{ number_format($item->produk->harga * $item->kuantitas, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach

                <!-- Biaya Ongkir -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-end sm:items-center mt-6 p-4 bg-[#f8fbff] border border-blue-100 rounded-xl">
                    <div class="text-sm font-extrabold text-gray-600 flex items-center gap-2 mb-2 sm:mb-0">
                        <i class="fa-solid fa-truck-fast text-[#0088cc] text-xl"></i> Biaya Pengiriman (Ongkir)
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-gray-900" id="displayOngkir">Rp
                        {{ number_format($ongkir, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- BOX 3: PEMBAYARAN & TOTAL -->
            <div
                class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">

                <div class="w-full lg:w-1/2 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
                    <span class="font-extrabold text-gray-900 text-base shrink-0 flex items-center gap-2"><i
                            class="fa-solid fa-wallet text-[#0088cc]"></i> Metode Pembayaran</span>
                    <div class="flex flex-col sm:flex-row gap-3 w-full">
                        <label
                            class="flex-1 flex items-center gap-3 cursor-pointer p-3 border border-gray-200 text-gray-600 font-bold rounded-xl transition-all hover:bg-gray-50 hover:border-gray-300">
                            <input type="radio" name="metode_pembayaran" value="Virtual Account"
                                class="w-4 h-4 accent-[#0088cc]"> Transfer VA
                        </label>
                    </div>
                </div>

                <div
                    class="w-full lg:w-1/2 flex flex-col sm:flex-row items-center justify-between lg:justify-end gap-6 border-t lg:border-t-0 pt-6 lg:pt-0 w-full">
                    <div class="text-center sm:text-right w-full sm:w-auto">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pembayaran</p>
                        <p class="text-3xl sm:text-4xl font-black text-[#0088cc] leading-none" id="displayTotalBayar">Rp
                            {{ number_format($totalBayar, 0, ',', '.') }}</p>
                    </div>
                    <button type="button" onclick="submitCheckout()"
                        class="w-full sm:w-auto bg-[#0088cc] hover:bg-blue-600 text-white px-8 py-4 text-base sm:text-lg rounded-xl font-bold shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center justify-center gap-2 shrink-0">
                        Buat Pesanan <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>

            </div>
        </form>
    </main>

    <!-- MODAL EDIT ALAMAT -->
    <div id="addressModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeAddressModal()"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg z-10 overflow-hidden transform transition-all">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-extrabold text-lg text-gray-800"><i
                        class="fa-solid fa-map-location-dot text-[#0088cc] mr-2"></i> Edit Alamat Pengiriman</h3>
                <button onclick="closeAddressModal()" class="text-gray-400 hover:text-red-500 transition-colors"><i
                        class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <div class="p-6">
                <p class="text-xs font-bold text-[#0088cc] mb-2 bg-blue-50 p-2 rounded border border-blue-100">
                    <i class="fa-solid fa-info-circle"></i> Info: Ongkir akan dihitung otomatis sesuai lokasi alamat
                    Anda (Misal: Singosari, Malang, Surabaya, Jakarta).
                </p>
                <textarea id="tempAlamat" rows="4"
                    class="w-full border-2 border-gray-200 rounded-xl p-4 text-sm font-bold text-gray-700 outline-none focus:border-[#0088cc] transition-colors resize-none"
                    placeholder="Ketik alamat lengkap beserta Kota/Kabupaten Anda di sini..."></textarea>
            </div>
            <div class="p-6 pt-0 flex justify-end gap-3">
                <button onclick="closeAddressModal()"
                    class="px-5 py-2.5 rounded-xl font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 transition-colors">Batal</button>
                <button onclick="saveAddress()"
                    class="px-5 py-2.5 rounded-xl font-bold text-white bg-[#0088cc] hover:bg-blue-600 shadow-md hover:shadow-lg transition-all flex items-center gap-2"><i
                        class="fa-solid fa-check"></i> Simpan & Cek Ongkir</button>
            </div>
        </div>
    </div>

    @include('layouts.modal-logout')

    <!-- SCRIPT INTERAKTIF ONGKIR & ALAMAT -->
    <script>
        const baseHarga = {{ $totalHarga }};

        function openAddressModal() {
            document.getElementById('tempAlamat').value = document.getElementById('inputAlamat').value;
            document.getElementById('addressModal').classList.remove('hidden');
        }

        function closeAddressModal() {
            document.getElementById('addressModal').classList.add('hidden');
        }

        function saveAddress() {
            const newAlamat = document.getElementById('tempAlamat').value;
            if (newAlamat.trim() === '') return alert('Alamat tidak boleh kosong!');

            // Update UI & Input Hidden Alamat
            document.getElementById('displayAlamat').innerText = newAlamat;
            document.getElementById('inputAlamat').value = newAlamat;

            // SIMULASI CEK ONGKIR JAVASCRIPT
            let ongkir = 30000; // Default Luar Kota
            let almtLower = newAlamat.toLowerCase();

            if (almtLower.includes('singosari')) ongkir = 5000;
            else if (almtLower.includes('malang')) ongkir = 10000;
            else if (almtLower.includes('surabaya') || almtLower.includes('sidoarjo')) ongkir = 20000;
            else if (almtLower.includes('jakarta')) ongkir = 40000;

            let totalBayar = baseHarga + ongkir;

            // Update Input Hidden Values
            document.getElementById('inputOngkir').value = ongkir;
            document.getElementById('inputTotalBayar').value = totalBayar;

            // Update UI Tampilan Harga
            document.getElementById('displayOngkir').innerText = 'Rp ' + ongkir.toLocaleString('id-ID');
            document.getElementById('displayTotalBayar').innerText = 'Rp ' + totalBayar.toLocaleString('id-ID');

            closeAddressModal();
        }

        function submitCheckout() {
            if (document.getElementById('inputAlamat').value.trim() === '') {
                alert('Tolong isi alamat pengiriman Anda terlebih dahulu!');
                openAddressModal();
                return;
            }
            document.getElementById('checkoutForm').submit();
        }

        // Efek Radio Button Pembayaran
        const radios = document.querySelectorAll('input[name="metode_pembayaran"]');
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                radios.forEach(r => {
                    r.parentElement.classList.remove('border-2', 'border-[#0088cc]', 'bg-blue-50',
                        'text-[#0088cc]');
                    r.parentElement.classList.add('border', 'border-gray-200', 'text-gray-600');
                });
                if (this.checked) {
                    this.parentElement.classList.remove('border', 'border-gray-200', 'text-gray-600');
                    this.parentElement.classList.add('border-2', 'border-[#0088cc]', 'bg-blue-50',
                        'text-[#0088cc]');
                }
            });
        });
    </script>
</body>

</html>
