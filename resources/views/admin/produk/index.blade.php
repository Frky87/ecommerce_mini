<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelola Produk - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Data Produk (Admin)</h2>
            <div class="flex gap-4">
                <a href="{{ route('katalog') }}" class="text-blue-500 underline mt-2 mr-4">Lihat Katalog</a>
                <a href="{{ route('produk.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Produk</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 border">Foto</th>
                    <th class="p-3 border">Kode</th>
                    <th class="p-3 border">Nama Produk</th>
                    <th class="p-3 border">Kategori</th>
                    <th class="p-3 border">Harga</th>
                    <th class="p-3 border">Stok</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $p)
                    <tr>
                        <td class="p-3 border">
                            @if ($p->foto)
                                <img src="{{ asset('storage/' . $p->foto) }}" class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-xs text-gray-500">No Image</span>
                            @endif
                        </td>
                        <td class="p-3 border">{{ $p->kode_produk }}</td>
                        <td class="p-3 border">{{ $p->nama_produk }}</td>
                        <td class="p-3 border">{{ $p->kategori }}</td>
                        <td class="p-3 border">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td class="p-3 border">{{ $p->stok }}</td>
                        <td class="p-3 border flex gap-2">
                            <a href="{{ route('produk.edit', $p->id) }}"
                                class="bg-yellow-400 text-white px-3 py-1 rounded text-sm">Edit</a>
                            <form action="{{ route('produk.destroy', $p->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
