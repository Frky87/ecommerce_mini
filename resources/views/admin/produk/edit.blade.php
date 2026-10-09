@extends('layouts.admin')
@section('title', 'Edit Produk')

@section('content')
    <div class="max-w-4xl mx-auto py-6">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('produk.index') }}"
                class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:bg-[#0088cc] hover:text-white transition-all shadow-sm"><i
                    class="fa-solid fa-arrow-left"></i></a>
            <h1 class="text-2xl font-extrabold text-gray-800">Edit Data Produk</h1>
        </div>

        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Kode Produk</label><input type="text"
                        name="kode_produk" value="{{ $produk->kode_produk }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/20">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/20">
                        @foreach (['Kaos', 'Celana', 'Sweater', 'Jaket', 'Topi', 'Kemeja', 'Sepatu', 'Aksesoris'] as $kat)
                            <option value="{{ $kat }}" {{ $produk->kategori == $kat ? 'selected' : '' }}>
                                {{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2"><label class="block text-sm font-bold text-gray-700 mb-2">Nama
                        Produk</label><input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc]"></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label><input type="number"
                        name="harga" value="{{ $produk->harga }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc]"></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Stok Tersedia</label><input type="number"
                        name="stok" value="{{ $produk->stok }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#0088cc]"></div>
            </div>

            <div class="mb-8 p-5 bg-blue-50/50 border border-blue-100 rounded-xl">
                <label class="block text-sm font-bold text-[#0088cc] mb-2">Ganti Foto Produk (Bisa Pilih Banyak)</label>
                <p class="text-xs text-gray-500 mb-3">Kosongkan jika tidak ingin mengganti foto saat ini.</p>
                <input type="file" name="foto[]" multiple accept="image/*" id="fotoUpload"
                    class="w-full px-4 py-3 bg-white border border-blue-200 rounded-xl cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#0088cc] file:text-white transition-all">

                <div id="previewImages" class="flex flex-wrap gap-2 mt-4">
                    <!-- Tampilkan Foto Lama Dulu -->
                    @foreach ($produk->foto_array as $ft)
                        <img src="{{ asset('storage/' . $ft) }}"
                            class="w-20 h-20 object-cover rounded border border-gray-300 shadow-sm opacity-60">
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end"><button type="submit"
                    class="bg-[#0088cc] text-white px-8 py-3.5 rounded-xl font-bold hover:bg-blue-600 flex items-center gap-2"><i
                        class="fa-solid fa-floppy-disk"></i> Update Produk</button></div>
        </form>
    </div>

    <script>
        document.getElementById('fotoUpload').addEventListener('change', function(e) {
            const preview = document.getElementById('previewImages');
            preview.innerHTML =
                '<p class="text-xs font-bold text-[#0088cc] w-full mb-1">Foto Baru yang Akan Disimpan:</p>';
            [...this.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className =
                        'w-20 h-20 object-cover rounded border-2 border-[#0088cc] shadow-sm';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
