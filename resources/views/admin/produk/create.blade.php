@extends('layouts.admin')
@section('title', 'Tambah Produk')

@section('content')
    <div class="max-w-4xl mx-auto py-6">

        <!-- HEADER -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('produk.index') }}"
                class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:bg-[#0088cc] hover:text-white transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-extrabold text-gray-800">Tambah Produk Baru</h1>
        </div>

        <!-- BLOK NOTIFIKASI ERROR JIKA GAGAL SIMPAN -->
        @if (session('error'))
            <div
                class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 font-bold flex items-center gap-3 border border-red-200 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-xl shrink-0"></i>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div
                class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 font-bold flex items-start gap-3 border border-red-200 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-xl mt-0.5 shrink-0"></i>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM INPUT -->
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Kode Produk -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kode Produk</label>
                    <input type="text" name="kode_produk" value="{{ old('kode_produk') }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/20 transition-all">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/20 transition-all">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Kaos" {{ old('kategori') == 'Kaos' ? 'selected' : '' }}>Kaos</option>
                        <option value="Celana" {{ old('kategori') == 'Celana' ? 'selected' : '' }}>Celana</option>
                        <option value="Sweater" {{ old('kategori') == 'Sweater' ? 'selected' : '' }}>Sweater</option>
                        <option value="Jaket" {{ old('kategori') == 'Jaket' ? 'selected' : '' }}>Jaket</option>
                        <option value="Topi" {{ old('kategori') == 'Topi' ? 'selected' : '' }}>Topi</option>
                        <option value="Kemeja" {{ old('kategori') == 'Kemeja' ? 'selected' : '' }}>Kemeja</option>
                        <option value="Sepatu" {{ old('kategori') == 'Sepatu' ? 'selected' : '' }}>Sepatu</option>
                        <option value="Aksesoris" {{ old('kategori') == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                    </select>
                </div>

                <!-- Nama Produk -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/20 transition-all">
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga') }}" required min="0"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/20 transition-all">
                </div>

                <!-- Stok -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Stok Tersedia</label>
                    <input type="number" name="stok" value="{{ old('stok') }}" required min="0"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/20 transition-all">
                </div>

                <div class="md:col-span-2 mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Lengkap Produk</label>
                    <textarea name="deskripsi" rows="4" required placeholder="Jelaskan spesifikasi, bahan, ukuran, dll..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/20 transition-all">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <!-- Upload Foto -->
            <div class="mb-8 p-5 bg-blue-50/50 border border-blue-100 rounded-xl">
                <label class="block text-sm font-bold text-[#0088cc] mb-2">Upload Foto</label>
                <input type="file" name="foto[]" multiple accept="image/*" id="fotoUpload"
                    class="w-full px-4 py-3 bg-white border border-blue-200 rounded-xl cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#0088cc] file:text-white transition-all">
                <div id="previewImages" class="flex flex-wrap gap-2 mt-4"></div> <!-- Tempat Preview Gambar -->
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[#0088cc] text-white px-8 py-3.5 rounded-xl font-bold hover:bg-blue-600 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>

    <script>
        // Fitur Live Preview Gambar
        document.getElementById('fotoUpload').addEventListener('change', function(e) {
            const preview = document.getElementById('previewImages');
            preview.innerHTML = ''; // Bersihkan preview lama
            [...this.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-20 h-20 object-cover rounded border border-gray-300 shadow-sm';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
