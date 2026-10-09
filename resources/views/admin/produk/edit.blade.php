<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6">Edit Produk</h2>

        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Kode Produk</label>
                <input type="text" name="kode_produk" value="{{ $produk->kode_produk }}"
                    class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}"
                    class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                <input type="text" name="kategori" value="{{ $produk->kategori }}" class="w-full border p-2 rounded"
                    required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ $produk->harga }}" class="w-full border p-2 rounded"
                        required>
                </div>
                <div>
                    <label class="block text-gray-700">Stok</label>
                    <input type="number" name="stok" value="{{ $produk->stok }}" class="w-full border p-2 rounded"
                        required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700">Foto Produk (Biarkan kosong jika tidak ingin mengubah)</label>
                <input type="file" name="foto" class="w-full border p-2 rounded" accept="image/*">
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('produk.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Simpan</button>
            </div>
        </form>
    </div>
</body>

</html>
