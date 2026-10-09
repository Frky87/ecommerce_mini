<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketqu - Katalog Pakaian & Fashion</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans selection:bg-[#0088cc] selection:text-white min-h-screen flex flex-col">

    <!-- HEADER / NAVBAR -->
    <header class="border-b border-gray-200 py-4 bg-white sticky top-0 z-50 shadow-sm w-full">
        <!-- Dibatasi lebarnya dengan max-w-6xl agar tidak terlalu lebar di PC -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between flex-wrap gap-4">

            <!-- Logo -->
            <a href="{{ route('katalog') }}"
                class="flex items-center gap-2 sm:gap-3 text-[#0088cc] group w-max shrink-0">
                <div
                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-[#0088cc] flex items-center justify-center group-hover:bg-[#0088cc] group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-md group-hover:rotate-12">
                    <i class="fa-solid fa-shirt text-sm sm:text-xl"></i>
                </div>
                <span
                    class="text-lg sm:text-2xl font-extrabold tracking-wide text-gray-800 group-hover:text-[#0088cc] transition-colors duration-300">MARKETQU</span>
            </a>

            <!-- Search Bar (Lebih proporsional) -->
            <form action="{{ route('katalog') }}" method="GET"
                class="hidden lg:flex flex-1 max-w-xl mx-8 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 items-center transition-all duration-300 hover:shadow-md focus-within:bg-white focus-within:border-[#0088cc] focus-within:ring-2 focus-within:ring-[#0088cc]/20 focus-within:shadow-md">
                <i class="fa-solid fa-magnifying-glass text-gray-400 mr-3 transition-colors duration-300"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari kaos, jaket, topi..."
                    class="bg-transparent w-full outline-none text-sm text-gray-700 placeholder-gray-400">
                <button type="submit" class="hidden"></button>
                <i
                    class="fa-solid fa-list text-gray-400 ml-3 cursor-pointer hover:text-[#0088cc] transition-colors"></i>
            </form>

            <!-- Menu Kanan -->
            <div class="flex items-center gap-4 sm:gap-6 text-gray-600 text-xs sm:text-sm font-medium shrink-0">
                <a href="#" class="flex items-center gap-2 hover:text-[#0088cc] transition-colors group">
                    <i
                        class="fa-solid fa-cart-shopping text-base sm:text-lg text-[#0088cc] group-hover:scale-110 transition-transform"></i>
                    <span class="hidden sm:inline">Cart</span>
                </a>
                <div class="flex items-center gap-2 border-l border-gray-300 pl-4 sm:pl-6">
                    @auth
                        <i class="fa-regular fa-user text-base sm:text-lg text-[#0088cc]"></i>
                        <a href="{{ route('produk.index') }}"
                            class="hover:text-[#0088cc] transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[2px] after:bg-[#0088cc] hover:after:w-full after:transition-all after:duration-300">Dashboard</a>
                        <span class="text-gray-300">|</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-red-500 transition-colors">Logout</button>
                        </form>
                    @else
                        <i class="fa-regular fa-user text-base sm:text-lg text-[#0088cc]"></i>
                        <a href="{{ route('login') }}"
                            class="hover:text-[#0088cc] transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[2px] after:bg-[#0088cc] hover:after:w-full after:transition-all after:duration-300">Login</a>
                        <span class="hidden sm:inline text-gray-300">|</span>
                        <a href="#"
                            class="hidden sm:inline hover:text-[#0088cc] transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[2px] after:bg-[#0088cc] hover:after:w-full after:transition-all after:duration-300">Register</a>
                    @endauth
                </div>
            </div>

            <!-- Mobile Search Bar -->
            <form action="{{ route('katalog') }}" method="GET"
                class="flex lg:hidden w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 items-center mt-2">
                <i class="fa-solid fa-magnifying-glass text-gray-400 mr-2"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kaos..."
                    class="bg-transparent w-full outline-none text-xs text-gray-700">
            </form>
        </div>
    </header>

    <!-- MAIN KONTEN - Dibatasi max-w-6xl -->
    <main
        class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 flex-grow w-full overflow-hidden bg-white mt-4 sm:mt-6 rounded-2xl shadow-sm border border-gray-100 mb-8">

        <!-- HERO BANNER -->
        <section
            class="relative bg-slate-900 rounded-2xl overflow-hidden text-white mb-10 flex flex-col md:flex-row items-center min-h-[250px] md:min-h-[300px] shadow-lg group">

            <div
                class="px-6 py-10 md:pl-12 lg:pl-16 z-20 w-full md:w-3/5 transition-transform duration-700 group-hover:md:translate-x-2 relative">
                <p class="text-sm md:text-lg mb-2 text-blue-300 font-medium tracking-wide">Best Deal Online on Fashion
                </p>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4 drop-shadow-md leading-tight">TRENDY
                    APPAREL.</h1>
                <p
                    class="text-lg md:text-2xl font-bold text-gray-100 bg-[#0088cc] inline-block px-3 py-1 md:px-4 rounded-lg">
                    UP to 80% OFF</p>
            </div>

            <div
                class="absolute inset-0 md:relative md:inset-auto md:w-2/5 h-full flex justify-end opacity-20 md:opacity-100 z-10 pointer-events-none">
                <div
                    class="w-full h-full bg-gradient-to-l from-transparent to-slate-900 md:rounded-l-full relative flex items-center justify-center overflow-hidden">
                    <img src="https://via.placeholder.com/250x300.png?text=Model+Pakaian" alt="Model Pakaian"
                        class="h-full w-full md:w-auto object-cover mix-blend-screen opacity-90 transition-transform duration-1000 group-hover:scale-110 group-hover:rotate-1">
                </div>
            </div>

        </section>

        <!-- TOP CATEGORIES -->
        <section class="mb-10 w-full overflow-hidden">
            <div class="flex justify-between items-end border-b border-gray-200 pb-2 mb-6">
                <h2 class="text-lg sm:text-xl text-gray-600 font-semibold group cursor-default">Shop From <span
                        class="font-bold text-[#0088cc] border-b-2 border-[#0088cc] pb-2 inline-block transition-all duration-300 group-hover:border-b-4">Top
                        Categories</span></h2>
                <a href="#"
                    class="hidden sm:inline text-gray-500 hover:text-[#0088cc] hover:translate-x-1 text-xs sm:text-sm font-medium transition-all duration-300">View
                    All <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i></a>
            </div>

            <!-- Jarak (gap) dan justify-center disesuaikan agar tidak terlalu merenggang di layar PC -->
            <div
                class="flex flex-nowrap md:justify-center overflow-x-auto hide-scroll gap-4 md:gap-8 lg:gap-10 pb-6 pt-2 px-1 snap-x">
                @php
                    $categories = [
                        ['name' => 'Kaos', 'icon' => 'fa-shirt'],
                        ['name' => 'Sweater', 'icon' => 'fa-vest'],
                        ['name' => 'Jaket', 'icon' => 'fa-vest-patches'],
                        ['name' => 'Topi', 'icon' => 'fa-hat-cowboy'],
                        ['name' => 'Kemeja', 'icon' => 'fa-user-tie'],
                        ['name' => 'Sepatu', 'icon' => 'fa-shoe-prints'],
                        ['name' => 'Aksesoris', 'icon' => 'fa-glasses'],
                    ];
                @endphp

                @foreach ($categories as $cat)
                    <div
                        class="flex flex-col items-center min-w-[70px] sm:min-w-[90px] cursor-pointer group hover:-translate-y-2 transition-all duration-300 ease-out snap-start">
                        <div
                            class="w-16 h-16 sm:w-24 sm:h-24 rounded-full bg-gray-50 border border-gray-200 shadow-sm flex items-center justify-center mb-2 sm:mb-3 group-hover:border-[#0088cc] group-hover:bg-blue-50/40 group-hover:shadow-lg transition-all duration-300">
                            <i
                                class="fa-solid {{ $cat['icon'] }} text-xl sm:text-3xl text-gray-400 transition-transform duration-300 group-hover:scale-125 group-hover:-rotate-6 group-hover:text-[#0088cc]"></i>
                        </div>
                        <span
                            class="text-xs sm:text-sm text-gray-700 font-bold group-hover:text-[#0088cc] transition-colors">{{ $cat['name'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- PRODUCT GRID (Koleksi Pakaian) -->
        <section class="mb-8">
            <div class="flex justify-between items-end border-b border-gray-200 pb-2 mb-6">
                <h2 class="text-lg sm:text-xl text-gray-600 font-semibold group cursor-default">Grab the best deal on
                    <span
                        class="font-bold text-[#0088cc] border-b-2 border-[#0088cc] pb-2 inline-block transition-all duration-300 group-hover:border-b-4">Koleksi</span>
                </h2>
                <a href="#"
                    class="text-gray-500 hover:text-[#0088cc] hover:translate-x-1 text-xs sm:text-sm font-medium transition-all duration-300">View
                    All <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i></a>
            </div>

            <!-- Grid: maksimal 5 kolom di PC (lg dan xl) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-5 lg:gap-6">

                @forelse($produk as $p)
                    <div
                        class="bg-white border border-gray-200 rounded-xl overflow-hidden relative hover:shadow-xl hover:-translate-y-1.5 hover:border-[#0088cc]/50 transition-all duration-300 group cursor-pointer flex flex-col">
                        <div
                            class="absolute top-0 right-0 bg-[#0088cc] text-white text-[9px] sm:text-[10px] font-bold px-1.5 py-1 sm:px-2 sm:py-1 rounded-bl-lg text-center leading-tight z-10 shadow-sm group-hover:scale-110 group-hover:bg-blue-600 transition-all origin-top-right">
                            56%<br>OFF
                        </div>

                        <div
                            class="p-3 sm:p-4 flex justify-center bg-gray-50 h-36 sm:h-44 items-center relative overflow-hidden">
                            @if ($p->foto)
                                <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nama_produk }}"
                                    class="max-h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110">
                            @else
                                <i
                                    class="fa-solid fa-shirt text-4xl sm:text-5xl text-gray-300 transition-transform duration-500 group-hover:scale-125 group-hover:text-gray-400"></i>
                            @endif
                            <div
                                class="absolute inset-0 bg-[#0088cc] opacity-0 group-hover:opacity-5 transition-opacity duration-300">
                            </div>
                        </div>

                        <div class="p-3 sm:p-4 border-t border-gray-100 bg-white flex-1 flex flex-col justify-between">
                            <div>
                                <h3
                                    class="text-[11px] sm:text-xs font-semibold text-gray-800 mb-1 line-clamp-2 group-hover:text-[#0088cc] transition-colors">
                                    {{ $p->nama_produk }}</h3>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 mb-2">
                                    <span class="text-gray-900 font-bold text-xs sm:text-sm">Rp
                                        {{ number_format($p->harga, 0, ',', '.') }}</span>
                                    <span class="text-gray-400 text-[9px] sm:text-[10px] line-through">Rp
                                        {{ number_format($p->harga + 50000, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div
                                class="text-green-500 text-[10px] sm:text-[11px] font-medium pt-2 border-t border-gray-100 border-dashed group-hover:border-green-200 transition-colors mt-auto">
                                Save - Rp 50.000
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full text-center text-gray-500 py-10 border-2 border-dashed border-gray-200 rounded-lg bg-gray-50 mx-2">
                        Produk belum tersedia.
                    </div>
                @endforelse

            </div>
        </section>

    </main>

</body>

</html>
