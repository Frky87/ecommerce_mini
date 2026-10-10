@extends('layouts.admin')
@section('title', 'Kelola Produk')

@section('content')
    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl sm:text-2xl font-extrabold text-gray-800 border-b-[3px] border-[#0088cc] pb-1">Data Produk
            </h2>
            <a href="{{ route('produk.create') }}"
                class="bg-[#0088cc] text-white px-5 py-2.5 rounded-lg hover:bg-blue-600 transition-all font-bold flex items-center gap-2"><i
                    class="fa-solid fa-plus"></i> Tambah Produk</a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 font-medium"><i class="fa-solid fa-check"></i>
                {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 font-medium"><i
                    class="fa-solid fa-triangle-exclamation"></i>
                {{ session('error') }}</div>
        @endif

        <div class="w-full overflow-x-auto border border-gray-200 rounded-xl">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase border-b">
                        <th class="p-4">Foto</th>
                        <th class="p-4">Kode</th>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Harga</th>
                        <th class="p-4">Stok</th> <!-- TAMBAHAN HEADER STOK -->
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($produk as $p)
                        <tr class="hover:bg-blue-50/50">
                            <td class="p-4">
                                @php $fotos = $p->foto_array; @endphp
                                @if (is_array($fotos) && count($fotos) > 0)
                                    <img src="{{ asset('storage/' . $fotos[0]) }}"
                                        class="w-14 h-14 object-cover rounded-lg shadow-sm border border-gray-200">
                                @else
                                    <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center"><i
                                            class="fa-solid fa-shirt"></i></div>
                                @endif
                            </td>
                            <td class="p-4 text-gray-500">{{ $p->kode_produk }}</td>
                            <td class="p-4 font-bold">
                                {{ $p->nama_produk }}
                                <!-- Jika ini Super Admin, tampilkan nama pemilik produknya -->
                                @if (isset($isSuper) && $isSuper && isset($scope) && $scope != 'mine')
                                    <div class="text-[10px] text-gray-400 font-normal mt-1"><i
                                            class="fa-solid fa-store"></i>
                                        {{ $p->user->nama_toko ?? ($p->user->nama_lengkap ?? 'Toko Tidak Diketahui') }}
                                    </div>
                                @endif
                            </td>
                            <td class="p-4"><span
                                    class="bg-blue-50 text-[#0088cc] px-3 py-1 rounded-lg text-xs font-bold">{{ $p->kategori }}</span>
                            </td>
                            <td class="p-4 font-extrabold">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>

                            <!-- TAMBAHAN DATA STOK -->
                            <td class="p-4 font-bold {{ $p->stok < 5 ? 'text-red-500' : 'text-green-600' }}">
                                {{ $p->stok }} Pcs
                            </td>

                            <td class="p-4 flex gap-2 justify-center">
                                <a href="{{ route('produk.edit', $p->id) }}"
                                    class="bg-yellow-400 text-white px-3 py-2 rounded-lg font-bold"><i
                                        class="fa-solid fa-pen"></i> Edit</a>
                                <form action="{{ route('produk.destroy', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus?')">@csrf @method('DELETE') <button
                                        class="bg-red-500 text-white px-3 py-2 rounded-lg font-bold"><i
                                            class="fa-solid fa-trash"></i> Hapus</button></form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400 font-medium">
                                <i class="fa-solid fa-box-open text-3xl mb-3 block text-gray-300"></i>
                                Belum ada produk yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
