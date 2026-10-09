<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketqu - Katalog Pakaian & Fashion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body
    class="bg-gray-50 text-gray-800 font-sans selection:bg-[#0088cc] selection:text-white min-h-screen flex flex-col relative">

    <!-- Panggil File Navbar -->
    @include('layouts.navbar')

    <main
        class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 flex-grow w-full overflow-hidden bg-white mt-4 sm:mt-6 rounded-2xl shadow-sm border border-gray-100 mb-8">

        <!-- HERO BANNER -->
        <section
            class="relative bg-slate-900 rounded-2xl overflow-hidden text-white mb-10 flex flex-col md:flex-row items-center min-h-[250px] md:min-h-[300px] shadow-lg group">
            @if (isset($produkTerbaru) && $produkTerbaru)
                <div class="px-6 py-10 md:pl-12 lg:pl-16 z-20 w-full md:w-3/5 relative">
                    <p class="text-sm md:text-lg mb-2 text-blue-300 font-medium tracking-wide">Produk Koleksi Terbaru
                        Kami</p>
                    <h1
                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4 drop-shadow-md leading-tight line-clamp-2 uppercase">
                        {{ $produkTerbaru->nama_produk }}</h1>
                    <span
                        class="text-lg md:text-xl font-bold text-gray-100 bg-[#0088cc] inline-block px-3 py-1 md:px-4 rounded-lg shadow-sm">Baru
                        Dirilis!</span>
                </div>
                <div
                    class="absolute inset-0 md:relative md:inset-auto md:w-2/5 h-full flex justify-end opacity-20 md:opacity-100 z-10 pointer-events-none">
                    <div
                        class="w-full h-full bg-gradient-to-l from-transparent to-slate-900 md:rounded-l-full relative flex items-center justify-center overflow-hidden">
                        @php $heroFotos = $produkTerbaru->foto_array; @endphp
                        @if (count($heroFotos) > 0)
                            <img src="{{ asset('storage/' . $heroFotos[0]) }}"
                                class="h-full w-full md:w-auto object-cover mix-blend-screen opacity-90 transition-transform duration-1000 group-hover:scale-110">
                        @else
                            <i class="fa-solid fa-shirt text-9xl text-slate-700 opacity-50"></i>
                        @endif
                    </div>
                </div>
            @endif
        </section>

        <!-- TOP CATEGORIES -->
        <section class="mb-10 w-full overflow-hidden">
            <div
                class="flex flex-nowrap md:justify-center overflow-x-auto hide-scroll gap-4 md:gap-6 lg:gap-8 pb-6 pt-2 px-1 snap-x">
                @php
                    $categories = [
                        ['name' => 'Semua', 'icon' => 'fa-border-all', 'val' => ''],
                        ['name' => 'Kaos', 'icon' => 'fa-shirt', 'val' => 'Kaos'],
                        ['name' => 'Celana', 'icon' => 'fa-tag', 'val' => 'Celana'],
                        ['name' => 'Sweater', 'icon' => 'fa-vest', 'val' => 'Sweater'],
                        ['name' => 'Jaket', 'icon' => 'fa-vest-patches', 'val' => 'Jaket'],
                        ['name' => 'Topi', 'icon' => 'fa-hat-cowboy', 'val' => 'Topi'],
                        ['name' => 'Kemeja', 'icon' => 'fa-user-tie', 'val' => 'Kemeja'],
                        ['name' => 'Sepatu', 'icon' => 'fa-shoe-prints', 'val' => 'Sepatu'],
                        ['name' => 'Aksesoris', 'icon' => 'fa-glasses', 'val' => 'Aksesoris'],
                    ];
                @endphp
                @foreach ($categories as $cat)
                    @php
                        $isActive =
                            request('kategori') == $cat['val'] || (request('kategori') == '' && $cat['val'] == '');
                        $filterQuery = array_merge(request()->query(), ['kategori' => $cat['val']]);
                    @endphp
                    <a href="{{ route('katalog', $filterQuery) }}"
                        class="flex flex-col items-center min-w-[70px] sm:min-w-[85px] cursor-pointer group {{ $isActive ? '' : 'hover:-translate-y-2' }} transition-all duration-300 ease-out snap-start">
                        <div
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border {{ $isActive ? 'bg-blue-50 border-[#0088cc] border-2 shadow-md' : 'bg-gray-50 border-gray-200 shadow-sm' }} flex items-center justify-center mb-2 sm:mb-3 group-hover:border-[#0088cc] group-hover:bg-blue-50/40 transition-all">
                            <i
                                class="fa-solid {{ $cat['icon'] }} text-xl sm:text-2xl {{ $isActive ? 'text-[#0088cc]' : 'text-gray-400' }} transition-transform duration-300 group-hover:scale-125 group-hover:text-[#0088cc]"></i>
                        </div>
                        <span
                            class="text-xs sm:text-sm font-bold {{ $isActive ? 'text-[#0088cc]' : 'text-gray-700' }}">{{ $cat['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- PRODUK GRID & FORM PENGURUTAN -->
        <section class="mb-8" id="koleksi-produk">
            <div
                class="flex flex-col sm:flex-row justify-between items-start sm:items-end border-b border-gray-200 pb-3 mb-6 gap-4">
                <div>
                    <h2 class="text-lg sm:text-xl text-gray-600 font-semibold">Grab the best deal on <span
                            class="font-bold text-[#0088cc] border-b-2 border-[#0088cc] pb-2 inline-block uppercase">{{ request('kategori') ? 'KATEGORI ' . request('kategori') : 'KOLEKSI KAMI' }}</span>
                    </h2>
                    @if (request('kategori') || request('search') || request('sort'))
                        <a href="{{ route('katalog') }}"
                            class="text-red-500 hover:text-red-700 text-xs sm:text-sm font-bold transition-all bg-red-50 px-3 py-1 rounded-full mt-2 inline-block"><i
                                class="fa-solid fa-xmark mr-1"></i> Reset Filter</a>
                    @endif
                </div>

                <form action="{{ route('katalog') }}" method="GET" class="flex items-center gap-2">
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if (request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <label class="text-xs sm:text-sm font-semibold text-gray-500 hidden sm:block"><i
                            class="fa-solid fa-filter"></i> Urutkan:</label>
                    <select name="sort" onchange="this.form.submit()"
                        class="pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-[#0088cc] text-xs sm:text-sm font-medium text-gray-700 cursor-pointer hover:border-gray-300 w-full sm:w-auto">
                        <option value="">Rilisan Terbaru</option>
                        <option value="terendah" {{ request('sort') == 'terendah' ? 'selected' : '' }}>Harga Terendah
                        </option>
                        <option value="tertinggi" {{ request('sort') == 'tertinggi' ? 'selected' : '' }}>Harga
                            Tertinggi</option>
                    </select>
                </form>
            </div>

            <!-- GRID PRODUK -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-5 lg:gap-6">
                @forelse($produk as $p)
                    @php
                        $seedString = $p->id . date('Y-m-d H');
                        $hashValue = abs(crc32($seedString));
                        $persenDiskon = ($hashValue % 66) + 10;
                        $hargaNormal = $p->harga / (1 - $persenDiskon / 100);
                    @endphp
                    <a href="{{ route('katalog.show', $p->id) }}"
                        class="block bg-white border border-gray-200 rounded-xl overflow-hidden relative hover:shadow-xl hover:-translate-y-1.5 hover:border-[#0088cc]/50 transition-all duration-300 group cursor-pointer flex flex-col h-full">
                        <div
                            class="absolute top-0 right-0 bg-[#0088cc] text-white text-[9px] sm:text-[10px] font-bold px-1.5 py-1 rounded-bl-lg text-center z-10">
                            {{ $persenDiskon }}%<br>OFF</div>
                        <div
                            class="p-3 sm:p-4 flex justify-center bg-gray-50 h-36 sm:h-44 items-center relative overflow-hidden">
                            @if (count($p->foto_array) > 0)
                                <img src="{{ asset('storage/' . $p->foto_array[0]) }}"
                                    class="max-h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110">
                            @else
                                <i class="fa-solid fa-shirt text-4xl text-gray-300"></i>
                            @endif
                        </div>
                        <div class="p-3 sm:p-4 border-t border-gray-100 bg-white flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-[11px] sm:text-xs font-semibold text-gray-800 mb-1 line-clamp-2">
                                    {{ $p->nama_produk }}</h3>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 mb-2">
                                    <span class="text-gray-900 font-bold text-xs sm:text-sm">Rp
                                        {{ number_format($p->harga, 0, ',', '.') }}</span>
                                    <span class="text-gray-400 text-[9px] sm:text-[10px] line-through">Rp
                                        {{ number_format($hargaNormal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div
                        class="col-span-full text-center text-gray-500 py-10 border-2 border-dashed border-gray-200 rounded-lg bg-gray-50">
                        <i class="fa-solid fa-face-frown-open text-4xl mb-3"></i>
                        <p class="font-medium">Produk belum tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- PAGINATION: Selalu Tampil Meskipun Hanya 1 Halaman -->
            <div
                class="mt-8 flex flex-col sm:flex-row items-center justify-between border-t border-gray-200 pt-6 gap-4">
                <div
                    class="text-sm text-gray-500 font-medium bg-gray-50 px-4 py-2 rounded-lg border border-gray-100 shadow-sm">
                    Halaman <span class="font-bold text-[#0088cc]">{{ $produk->currentPage() }}</span> / <span
                        class="font-bold text-gray-800">{{ $produk->lastPage() }}</span>
                </div>
                <div class="flex items-center gap-2">
                    @if ($produk->onFirstPage())
                        <span
                            class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed text-xs sm:text-sm font-bold border border-gray-200">Prev</span>
                    @else
                        <a href="{{ $produk->previousPageUrl() }}"
                            class="px-4 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-[#0088cc] hover:text-white rounded-lg text-xs sm:text-sm font-bold shadow-sm">Prev</a>
                    @endif

                    @if ($produk->hasMorePages())
                        <a href="{{ $produk->nextPageUrl() }}"
                            class="px-4 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-[#0088cc] hover:text-white rounded-lg text-xs sm:text-sm font-bold shadow-sm">Next</a>
                    @else
                        <span
                            class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed text-xs sm:text-sm font-bold border border-gray-200">Next</span>
                    @endif
                </div>
            </div>

        </section>
    </main>

    <!-- Panggil File Modal Logout -->
    @include('layouts.modal-logout')
</body>

</html>
