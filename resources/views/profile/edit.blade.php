<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil - Marketqu</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Memastikan teks yang sangat panjang tidak merusak form saat di-zoom 250% */
        * {
            word-wrap: break-word;
        }

        /* Menyesuaikan scrollbar agar tetap terlihat rapi dan tidak disembunyikan */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>

<body
    class="bg-[#ebebeb] font-sans selection:bg-[#0088cc] selection:text-white relative {{ Auth::user()->role === 'admin' ? 'h-screen overflow-hidden flex' : 'min-h-screen flex flex-col' }}">

    @if (Auth::user()->role === 'admin')
        <!-- ========================================================= -->
        <!-- SHELL 1: TAMPILAN KHUSUS ADMIN (SIDEBAR & TOPBAR)         -->
        <!-- ========================================================= -->
        <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden transition-opacity"></div>

        <aside id="sidebar"
            class="fixed lg:relative inset-y-0 left-0 w-72 bg-white flex flex-col shadow-2xl lg:shadow-lg z-30 transition-all duration-300 -translate-x-full lg:translate-x-0 h-full">
            <div class="h-20 flex items-center justify-between px-5 border-b border-gray-100 shrink-0">
                <a href="{{ route('katalog') }}"
                    class="flex items-center gap-3 text-[#0088cc] hover:scale-105 transition-transform duration-300 w-max"
                    id="logoContainer">
                    <div
                        class="w-10 h-10 rounded-full border-2 border-[#0088cc] flex items-center justify-center shadow-sm shrink-0">
                        <i class="fa-solid fa-shirt text-lg"></i>
                    </div>
                    <span id="logoText"
                        class="text-xl sm:text-2xl font-extrabold tracking-wide whitespace-nowrap transition-opacity duration-300">MARKETQU</span>
                </a>
                <button id="toggleSidebar"
                    class="w-8 h-8 rounded-full border border-[#0088cc] flex items-center justify-center text-[#0088cc] hover:bg-[#0088cc] hover:text-white transition-all shadow-sm shrink-0 cursor-pointer hidden lg:flex">
                    <i id="toggleIcon" class="fa-solid fa-chevron-left text-sm transition-transform duration-300"></i>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-4 overflow-y-auto custom-scroll">
                <a href="{{ route('produk.index') }}"
                    class="flex items-center gap-4 bg-white border-2 border-[#0088cc] text-[#0088cc] px-4 py-3.5 rounded-xl font-bold hover:bg-blue-50 transition-all shadow-sm group">
                    <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                            class="fa-solid fa-box text-lg"></i></div>
                    <span class="menu-text">Produk</span>
                </a>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-4 bg-[#0088cc] text-white px-4 py-3.5 rounded-xl font-bold shadow-[0_4px_15px_rgba(0,136,204,0.4)] transition-transform hover:-translate-y-1 group">
                    <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                            class="fa-solid fa-user-pen text-lg"></i></div>
                    <span class="menu-text">Edit Profil</span>
                </a>
            </nav>

            <div class="px-4 pb-6 shrink-0 border-t border-gray-50 pt-4">
                <button type="button" onclick="openLogoutModal()"
                    class="w-full bg-[#ff0000] text-white px-4 py-3 rounded-xl font-bold shadow-md hover:bg-red-700 transition-all flex items-center gap-4 group hover:-translate-y-0.5">
                    <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                            class="fa-solid fa-power-off text-lg"></i></div>
                    <span class="menu-text">Log Out</span>
                </button>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-full overflow-hidden relative w-full">
            <header
                class="h-20 bg-white shadow-sm flex items-center justify-between lg:justify-end px-4 sm:px-8 z-10 shrink-0 w-full relative">
                <button id="openMobileSidebar"
                    class="lg:hidden w-10 h-10 rounded-lg bg-blue-50 text-[#0088cc] flex items-center justify-center hover:bg-[#0088cc] hover:text-white transition-colors shrink-0">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>

                <div
                    class="relative group border border-transparent hover:border-gray-100 p-2 rounded-lg shrink-0 z-50">
                    <div
                        class="flex items-center gap-2 sm:gap-3 text-gray-600 group-hover:text-[#0088cc] transition-colors cursor-pointer">
                        <!-- Ikon Profil Default (Sama dengan Katalog) -->
                        <i class="fa-regular fa-user text-xl"></i>
                        <span
                            class="font-bold text-sm hidden sm:block truncate max-w-[100px]">{{ explode(' ', $user->nama_lengkap)[0] }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
                    </div>

                    <div
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 overflow-hidden">
                        <div class="p-3 border-b border-gray-100 bg-gray-50">
                            <p class="text-xs text-gray-400 mb-0.5">Masuk sebagai Admin</p>
                            <p class="font-bold text-gray-800 truncate">{{ $user->nama_lengkap }}</p>
                        </div>
                        <button type="button" onclick="openLogoutModal()"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors text-left font-bold">
                            <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Logout
                        </button>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 w-full custom-scroll">
                <div class="max-w-5xl mx-auto w-full">
                @else
                    <!-- ========================================================= -->
                    <!-- SHELL 2: TAMPILAN KHUSUS USER BIASA (NAVBAR KATALOG)      -->
                    <!-- ========================================================= -->
                    <header class="border-b border-gray-200 py-3 sm:py-4 bg-white sticky top-0 z-40 shadow-sm w-full">
                        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between flex-wrap gap-y-2">

                            <a href="{{ route('katalog') }}"
                                class="flex items-center gap-2 text-[#0088cc] group shrink-0">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-[#0088cc] flex items-center justify-center group-hover:bg-[#0088cc] group-hover:text-white transition-all shadow-sm">
                                    <i class="fa-solid fa-shirt text-sm sm:text-xl"></i>
                                </div>
                                <span
                                    class="text-lg sm:text-2xl font-extrabold tracking-wide text-gray-800 group-hover:text-[#0088cc] transition-colors">MARKETQU</span>
                            </a>

                            <form action="{{ route('katalog') }}" method="GET"
                                class="hidden lg:flex flex-1 max-w-xl mx-8 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 items-center transition-all duration-300 hover:shadow-md focus-within:bg-white focus-within:border-[#0088cc] focus-within:ring-2 focus-within:ring-[#0088cc]/20">
                                <i class="fa-solid fa-magnifying-glass text-gray-400 mr-3"></i>
                                <input type="text" name="search" placeholder="Cari pakaian..."
                                    class="bg-transparent w-full outline-none text-sm text-gray-700">
                                <button type="submit" class="hidden"></button>
                            </form>

                            <div
                                class="flex items-center gap-4 sm:gap-6 text-gray-600 text-xs sm:text-sm font-medium shrink-0 ml-auto">
                                <a href="#"
                                    class="flex items-center gap-2 hover:text-[#0088cc] transition-colors group">
                                    <i
                                        class="fa-solid fa-cart-shopping text-base sm:text-lg text-[#0088cc] group-hover:scale-110 transition-transform"></i>
                                    <span class="hidden sm:inline">Cart</span>
                                </a>
                                <a href="#"
                                    class="flex items-center gap-2 hover:text-[#0088cc] transition-colors group">
                                    <i
                                        class="fa-solid fa-file-invoice text-base sm:text-lg text-[#0088cc] group-hover:scale-110 transition-transform"></i>
                                    <span class="hidden sm:inline">Pesanan</span>
                                </a>

                                <div class="relative group border-l border-gray-300 pl-4 sm:pl-6 z-50">
                                    <div
                                        class="flex items-center gap-2 cursor-pointer py-2 hover:text-[#0088cc] transition-colors">
                                        <!-- Ikon Profil Default (Sama dengan Katalog) -->
                                        <i class="fa-regular fa-user text-base sm:text-lg text-[#0088cc]"></i>
                                        <span
                                            class="font-bold hidden sm:inline truncate max-w-[80px]">{{ explode(' ', $user->nama_lengkap)[0] }}</span>
                                    </div>

                                    <div
                                        class="absolute right-0 mt-1 w-48 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 overflow-hidden">
                                        <div class="p-3 border-b border-gray-100 bg-gray-50">
                                            <p class="text-xs text-gray-400 mb-0.5">Masuk sebagai</p>
                                            <p class="font-bold text-gray-800 truncate">{{ $user->nama_lengkap }}</p>
                                        </div>
                                        <button type="button" onclick="openLogoutModal()"
                                            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors text-left font-bold">
                                            <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Logout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>

                    <main class="flex-grow w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                        <div class="max-w-5xl mx-auto w-full">
    @endif

    <!-- ========================================================= -->
    <!-- CORE CONTENT: FORM EDIT PROFIL (SHARED UNTUK ADMIN & USER)-->
    <!-- ========================================================= -->

    <div class="flex flex-col lg:flex-row gap-6 items-start w-full">

        <!-- KARTU PROFIL KIRI -->
        <!-- Dihapus 'sticky' agar bisa di-scroll dengan aman saat di-zoom 250% -->
        <div class="w-full lg:w-[35%] bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden shrink-0">
            <div class="h-28 sm:h-32 bg-gradient-to-br from-[#0088cc] to-blue-900 relative">
                <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0]">
                    <svg class="relative block w-full h-[40px]" data-name="Layer 1"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                        <path
                            d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C-1,95.8,73.1,105,145.1,105,217.1,105,282.8,80.1,321.4,56.4Z"
                            fill="#ffffff"></path>
                    </svg>
                </div>
            </div>

            <div class="px-4 sm:px-6 pb-6 text-center relative -mt-14 sm:-mt-16">
                <div class="relative inline-block group cursor-pointer">
                    <!-- Ikon Profil Besar Bawaan (Agar sama dengan katalog & bebas link luar) -->
                    <div
                        class="w-24 h-24 sm:w-32 sm:h-32 rounded-full border-4 border-white shadow-lg bg-[#0088cc] flex items-center justify-center text-white text-4xl sm:text-5xl group-hover:scale-105 transition-transform duration-300">
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>

                <h2 class="mt-3 sm:mt-4 text-lg sm:text-xl font-extrabold text-gray-800 tracking-tight capitalize break-words"
                    id="previewName">{{ $user->nama_lengkap }}</h2>
                <p class="text-xs sm:text-sm text-gray-500 font-medium mb-4 break-words">{{ $user->username }}</p>

                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-[#0088cc] rounded-lg border border-blue-100 text-xs font-bold uppercase tracking-wider mb-4 sm:mb-6">
                    <i class="fa-solid {{ $user->role === 'admin' ? 'fa-user-shield' : 'fa-user-check' }}"></i>
                    {{ $user->role }}
                </div>

                <div class="grid grid-cols-2 gap-2 sm:gap-4 border-t border-gray-100 pt-4 sm:pt-6">
                    <div class="text-center">
                        <p class="text-[9px] sm:text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">
                            Bergabung</p>
                        <p class="text-xs sm:text-sm font-semibold text-gray-800">
                            {{ $user->created_at->format('M Y') }}</p>
                    </div>
                    <div class="text-center border-l border-gray-100">
                        <p class="text-[9px] sm:text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">
                            Status</p>
                        <p class="text-xs sm:text-sm font-semibold text-green-500"><i
                                class="fa-solid fa-circle-check"></i> Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORM EDIT KANAN -->
        <div class="w-full lg:w-[65%] bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden shrink-0">

            <div
                class="border-b border-gray-100 px-4 sm:px-8 py-4 sm:py-5 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-base sm:text-lg font-extrabold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-[#0088cc]"></i> Pengaturan Akun
                </h3>
            </div>

            <div class="p-4 sm:p-8">
                @if (session('success'))
                    <div
                        class="bg-green-50 border-l-4 border-green-500 p-3 sm:p-4 rounded-r-lg mb-6 sm:mb-8 flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-circle-check text-green-500 text-lg sm:text-xl mt-0.5 shrink-0"></i>
                        <div>
                            <h4 class="text-green-800 font-bold text-sm">Berhasil!</h4>
                            <p class="text-green-700 text-xs sm:text-sm mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-r-lg mb-6 sm:mb-8 shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-triangle-exclamation text-red-500 shrink-0"></i>
                            <h4 class="text-red-800 font-bold text-sm">Oops! Ada kesalahan:</h4>
                        </div>
                        <ul class="list-disc pl-5 space-y-1 text-xs sm:text-sm text-red-600 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                    @csrf @method('PUT')

                    <h4
                        class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">
                        Informasi Pribadi</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">

                        <div class="relative group">
                            <label
                                class="absolute -top-2.5 left-3 bg-white px-1 text-[10px] sm:text-[11px] font-bold text-gray-500 z-10">Nama
                                Lengkap</label>
                            <div class="relative">
                                <i
                                    class="fa-regular fa-id-badge absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="nama_lengkap" id="inputName"
                                    value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                    class="w-full pl-10 pr-4 py-2.5 sm:py-3 border-2 border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-0 text-sm font-medium bg-gray-50 hover:bg-white focus:bg-white transition-colors"
                                    required>
                            </div>
                        </div>

                        <div class="relative group">
                            <label
                                class="absolute -top-2.5 left-3 bg-white px-1 text-[10px] sm:text-[11px] font-bold text-gray-500 z-10">Alamat
                                Email</label>
                            <div class="relative">
                                <i
                                    class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="email" name="username" value="{{ old('username', $user->username) }}"
                                    class="w-full pl-10 pr-4 py-2.5 sm:py-3 border-2 border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-0 text-sm font-medium bg-gray-50 hover:bg-white focus:bg-white transition-colors"
                                    required>
                            </div>
                        </div>

                        <div class="relative group">
                            <label
                                class="absolute -top-2.5 left-3 bg-white px-1 text-[10px] sm:text-[11px] font-bold text-gray-500 z-10">Nomor
                                Telepon</label>
                            <div class="relative">
                                <i
                                    class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="tel" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}"
                                    class="w-full pl-10 pr-4 py-2.5 sm:py-3 border-2 border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-0 text-sm font-medium bg-gray-50 hover:bg-white focus:bg-white transition-colors"
                                    required>
                            </div>
                        </div>

                        <div class="relative group">
                            <label
                                class="absolute -top-2.5 left-3 bg-white px-1 text-[10px] sm:text-[11px] font-bold text-gray-500 z-10">Jenis
                                Kelamin</label>
                            <div class="relative">
                                <i
                                    class="fa-solid fa-venus-mars absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <select name="jenis_kelamin"
                                    class="w-full pl-10 pr-10 py-2.5 sm:py-3 border-2 border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-0 text-sm font-medium bg-gray-50 hover:bg-white focus:bg-white appearance-none cursor-pointer"
                                    required>
                                    <option value="Laki-Laki"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>
                                        Laki - Laki</option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                <i
                                    class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- KOLOM ALAMAT -->
                        <div class="relative group sm:col-span-2">
                            <label
                                class="absolute -top-2.5 left-3 bg-white px-1 text-[10px] sm:text-[11px] font-bold text-gray-500 z-10">Alamat
                                Lengkap</label>
                            <div class="relative">
                                <i class="fa-solid fa-map-location-dot absolute left-4 top-3.5 text-gray-400"></i>
                                <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap pengiriman Anda..."
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-0 text-sm font-medium bg-gray-50 hover:bg-white focus:bg-white transition-colors resize-none custom-scroll">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                        </div>

                    </div>

                    <h4
                        class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">
                        Keamanan Akun</h4>

                    <div
                        class="bg-blue-50/50 rounded-xl p-3 sm:p-4 mb-4 sm:mb-6 border border-blue-100 flex gap-2 sm:gap-3">
                        <i class="fa-solid fa-circle-info text-[#0088cc] mt-0.5 shrink-0"></i>
                        <p class="text-[11px] sm:text-sm text-gray-600 font-medium leading-relaxed">Kosongkan kolom
                            password di bawah ini jika <span class="font-bold text-gray-800">tidak ingin</span>
                            mengubah password.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
                        <div class="relative group">
                            <label
                                class="absolute -top-2.5 left-3 bg-white px-1 text-[10px] sm:text-[11px] font-bold text-gray-500 z-10">Password
                                Baru</label>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="password" id="pass1"
                                    placeholder="Minimal 8 karakter..."
                                    class="w-full pl-10 pr-12 py-2.5 sm:py-3 border-2 border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-0 text-sm font-medium bg-gray-50 hover:bg-white focus:bg-white tracking-wider">
                                <button type="button" onclick="togglePass('pass1', 'eye1')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#0088cc] focus:outline-none shrink-0">
                                    <i class="fa-solid fa-eye-slash" id="eye1"></i>
                                </button>
                            </div>
                        </div>

                        <div class="relative group">
                            <label
                                class="absolute -top-2.5 left-3 bg-white px-1 text-[10px] sm:text-[11px] font-bold text-gray-500 z-10">Konfirmasi
                                Password Baru</label>
                            <div class="relative">
                                <i
                                    class="fa-solid fa-shield-check absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="password_confirmation" id="pass2"
                                    placeholder="Ulangi password..."
                                    class="w-full pl-10 pr-12 py-2.5 sm:py-3 border-2 border-gray-200 rounded-xl focus:border-[#0088cc] focus:ring-0 text-sm font-medium bg-gray-50 hover:bg-white focus:bg-white tracking-wider">
                                <button type="button" onclick="togglePass('pass2', 'eye2')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#0088cc] focus:outline-none shrink-0">
                                    <i class="fa-solid fa-eye-slash" id="eye2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 sm:gap-4 pt-6 border-t border-gray-100">
                        <button type="reset"
                            class="w-full sm:w-auto px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors text-center">
                            Batal
                        </button>
                        <button type="submit" id="btnSubmit"
                            class="w-full sm:w-auto bg-gradient-to-r from-[#0088cc] to-[#006699] text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 group">
                            <i class="fa-solid fa-floppy-disk group-hover:scale-110 transition-transform"
                                id="submitIcon"></i>
                            <span id="submitText">Simpan Perubahan</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    @if (Auth::user()->role === 'admin')
        </div>
        </main>
    @else
        </div>
        </main>
    @endif

    <!-- MODAL LOGOUT -->
    <div id="logoutModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity"
            onclick="closeLogoutModal()"></div>
        <div id="logoutModalContent"
            class="bg-white/95 backdrop-blur-xl border border-white shadow-2xl rounded-3xl max-w-sm w-full relative transform scale-95 opacity-0 transition-all duration-300 ease-out z-10 overflow-hidden">
            <div class="h-2 w-full bg-gradient-to-r from-red-500 via-pink-500 to-orange-400"></div>
            <div class="p-6 sm:p-8 text-center relative">
                <div
                    class="w-16 h-16 sm:w-20 sm:h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 shadow-[0_0_30px_rgba(239,68,68,0.3)] relative">
                    <div class="absolute inset-0 rounded-full border-2 border-red-200 animate-ping opacity-30"></div>
                    <i class="fa-solid fa-power-off text-2xl sm:text-3xl text-red-500 z-10"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-gray-800 mb-2">Keluar Sekarang?</h3>
                <p class="text-xs sm:text-sm text-gray-500 mb-6 font-medium">Sesi Anda akan diakhiri. Pastikan
                    pekerjaan Anda sudah tersimpan!</p>
                <div class="flex flex-col gap-2 sm:gap-3">
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-3 sm:py-3.5 bg-gradient-to-r from-red-500 to-pink-500 text-white font-bold rounded-xl sm:rounded-2xl shadow-md hover:-translate-y-1 transition-all flex justify-center gap-2">
                            Ya, Logout <i class="fa-solid fa-arrow-right-from-bracket mt-0.5"></i>
                        </button>
                    </form>
                    <button type="button" onclick="closeLogoutModal()"
                        class="w-full px-4 py-3 sm:py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl sm:rounded-2xl transition-colors">Batal
                        & Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
                icon.classList.add('text-[#0088cc]');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
                icon.classList.remove('text-[#0088cc]');
            }
        }

        const inputName = document.getElementById('inputName');
        const previewName = document.getElementById('previewName');
        if (inputName && previewName) {
            inputName.addEventListener('input', function() {
                previewName.textContent = this.value || 'Nama Anda';
            });
        }

        const profileForm = document.getElementById('profileForm');
        if (profileForm) {
            profileForm.addEventListener('submit', function() {
                document.getElementById('submitIcon').className = 'fa-solid fa-circle-notch fa-spin';
                document.getElementById('submitText').textContent = 'Menyimpan...';
                document.getElementById('btnSubmit').classList.add('opacity-80', 'cursor-not-allowed');
            });
        }

        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            const toggleBtn = document.getElementById('toggleSidebar');
            const openMobileSidebarBtn = document.getElementById('openMobileSidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    const isCollapsed = sidebar.classList.contains('w-72');
                    if (isCollapsed) {
                        sidebar.classList.replace('w-72', 'w-[88px]');
                        document.getElementById('logoText').classList.add('hidden');
                        document.querySelectorAll('.menu-text').forEach(t => t.classList.add('hidden'));
                        document.getElementById('toggleIcon').classList.add('rotate-180');
                    } else {
                        sidebar.classList.replace('w-[88px]', 'w-72');
                        document.getElementById('logoText').classList.remove('hidden');
                        document.querySelectorAll('.menu-text').forEach(t => t.classList.remove('hidden'));
                        document.getElementById('toggleIcon').classList.remove('rotate-180');
                    }
                });
            }

            if (openMobileSidebarBtn) {
                openMobileSidebarBtn.addEventListener('click', () => {
                    sidebar.classList.remove('-translate-x-full');
                    mobileOverlay.classList.remove('hidden');
                });
            }

            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                });
            }
        }

        const logoutModal = document.getElementById('logoutModal');
        const logoutModalContent = document.getElementById('logoutModalContent');

        function openLogoutModal() {
            logoutModal.classList.remove('hidden');
            setTimeout(() => {
                logoutModalContent.classList.replace('scale-95', 'scale-100');
                logoutModalContent.classList.replace('opacity-0', 'opacity-100');
            }, 10);
        }

        function closeLogoutModal() {
            logoutModalContent.classList.replace('scale-100', 'scale-95');
            logoutModalContent.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                logoutModal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>

</html>
