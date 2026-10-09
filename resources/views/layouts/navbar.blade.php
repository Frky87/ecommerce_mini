<header class="border-b border-gray-200 py-3 sm:py-4 bg-white sticky top-0 z-40 shadow-sm w-full">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between flex-wrap gap-y-2">

        <!-- Logo -->
        <a href="{{ route('katalog') }}" class="flex items-center gap-2 sm:gap-3 text-[#0088cc] group w-max shrink-0">
            <div
                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-[#0088cc] flex items-center justify-center group-hover:bg-[#0088cc] group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fa-solid fa-shirt text-sm sm:text-xl"></i>
            </div>
            <span
                class="text-lg sm:text-2xl font-extrabold tracking-wide text-gray-800 group-hover:text-[#0088cc] transition-colors duration-300">MARKETQU</span>
        </a>

        <!-- Search Bar (Desktop) -->
        <form action="{{ route('katalog') }}" method="GET"
            class="hidden lg:flex flex-1 max-w-xl mx-8 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 items-center transition-all duration-300 hover:shadow-md focus-within:bg-white focus-within:border-[#0088cc] focus-within:ring-2 focus-within:ring-[#0088cc]/20 focus-within:shadow-md">
            @if (request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <i class="fa-solid fa-magnifying-glass text-gray-400 mr-3"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pakaian..."
                class="bg-transparent w-full outline-none text-sm text-gray-700 placeholder-gray-400">
            <button type="submit" class="hidden"></button>
        </form>

        <div
            class="flex items-center gap-4 sm:gap-6 text-gray-600 text-xs sm:text-sm font-medium shrink-0 ml-auto lg:ml-0">
            @if (Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('produk.index') }}"
                    class="flex items-center gap-2 bg-[#0088cc] text-white px-4 py-2.5 rounded-lg shadow-sm hover:bg-blue-600 font-bold group">
                    <i class="fa-solid fa-gauge-high group-hover:scale-110 transition-transform"></i> <span
                        class="hidden sm:inline">Dashboard Admin</span>
                </a>
            @else
                <!-- BADGE KERANJANG -->
                @php
                    $cartCount = Auth::check() ? \App\Models\Keranjang::where('user_id', Auth::id())->count() : 0;
                    $badgeText = $cartCount > 99 ? '99+' : $cartCount;
                @endphp
                <a href="{{ route('cart.index') }}"
                    class="flex items-center gap-2 hover:text-[#0088cc] transition-colors group relative">
                    <i
                        class="fa-solid fa-cart-shopping text-base sm:text-lg text-[#0088cc] group-hover:scale-110 transition-transform"></i>
                    <span class="hidden sm:inline">Cart</span>
                    @if ($cartCount > 0)
                        <span
                            class="absolute -top-2.5 -left-2 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full border border-white">{{ $badgeText }}</span>
                    @endif
                </a>

                @auth
                    <a href="{{ route('pesanan.index') }}"
                        class="flex items-center gap-2 {{ request()->routeIs('pesanan.*') ? 'text-[#0088cc]' : 'hover:text-[#0088cc] text-gray-600' }} transition-colors group">
                        <i
                            class="fa-solid fa-file-invoice text-base sm:text-lg text-[#0088cc] group-hover:scale-110 transition-transform"></i>
                        <span class="hidden sm:inline">Pesanan</span>
                    </a>
                @endauth
            @endif

            @auth
                <!-- Dropdown Profil -->
                <div class="relative group border-l border-gray-300 pl-4 sm:pl-6 z-50">
                    <div
                        class="flex items-center gap-2 cursor-pointer py-2 hover:text-[#0088cc] transition-colors text-[#0088cc]">
                        <i class="fa-regular fa-user text-base sm:text-lg"></i>
                        <span
                            class="font-bold hidden sm:inline truncate max-w-[80px]">{{ explode(' ', Auth::user()->nama_lengkap)[0] }}</span>
                    </div>

                    <div
                        class="absolute right-0 mt-1 w-48 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 overflow-hidden">
                        <div class="p-3 border-b border-gray-100 bg-gray-50">
                            <p class="text-xs text-gray-400 mb-0.5">Masuk sebagai</p>
                            <p class="font-bold text-gray-800 truncate">{{ Auth::user()->nama_lengkap }}</p>
                            @if (Auth::user()->role === 'admin')
                                <span
                                    class="inline-block mt-1 bg-red-100 text-red-600 text-[10px] font-black px-2 py-0.5 rounded-full tracking-wider">ADMIN</span>
                            @endif
                        </div>
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#0088cc] transition-colors font-semibold mt-1">
                            <i class="fa-regular fa-id-card w-4 text-center"></i> Edit Profil
                        </a>
                        <button type="button" onclick="openLogoutModal()"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors text-left font-bold border-t border-gray-100">
                            <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Logout
                        </button>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-2 border-l border-gray-300 pl-4 sm:pl-6">
                    <i class="fa-regular fa-user text-base sm:text-lg text-[#0088cc]"></i>
                    <a href="{{ route('login') }}" class="font-bold hover:text-[#0088cc] transition-colors">Login</a>
                    <span class="hidden sm:inline text-gray-300">|</span>
                    <a href="{{ route('register') }}"
                        class="font-bold hidden sm:inline hover:text-[#0088cc] transition-colors">Register</a>
                </div>
            @endauth
        </div>

        <!-- Search Bar (Mobile) -->
        <form action="{{ route('katalog') }}" method="GET"
            class="flex lg:hidden w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 items-center mt-2">
            @if (request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            <i class="fa-solid fa-magnifying-glass text-gray-400 mr-2"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..."
                class="bg-transparent w-full outline-none text-xs text-gray-700">
        </form>
    </div>
</header>
