<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6">Tambah Produk</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Kode Produk</label>
                <input type="text" name="kode_produk" value="{{ old('kode_produk') }}"
                    class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}"
                    class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}" class="w-full border p-2 rounded"
                    required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga') }}" class="w-full border p-2 rounded"
                        required>
                </div>
                <div>
                    <label class="block text-gray-700">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok') }}" class="w-full border p-2 rounded"
                        required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700">Foto Produk</label>
                <input type="file" name="foto" class="w-full border p-2 rounded" accept="image/*">
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('produk.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Produk</button>
            </div>
        </form>
    </div>
</body>

</html>
