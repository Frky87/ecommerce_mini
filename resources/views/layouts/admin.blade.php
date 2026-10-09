<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Marketqu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body
    class="bg-[#ebebeb] font-sans h-screen overflow-hidden flex text-gray-800 selection:bg-[#0088cc] selection:text-white relative">

    <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden transition-opacity"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed lg:relative inset-y-0 left-0 w-72 bg-white flex flex-col shadow-2xl lg:shadow-lg z-30 transition-all duration-300 -translate-x-full lg:translate-x-0 h-full">
        <div class="h-20 flex items-center justify-between px-5 border-b border-gray-100 shrink-0">
            <a href="{{ route('katalog') }}"
                class="flex items-center gap-3 text-[#0088cc] hover:scale-105 transition-transform w-max">
                <div
                    class="w-10 h-10 rounded-full border-2 border-[#0088cc] flex items-center justify-center shadow-sm shrink-0">
                    <i class="fa-solid fa-shirt text-lg"></i>
                </div>
                <span id="logoText" class="text-2xl font-extrabold tracking-wide">MARKETQU</span>
            </a>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-4 overflow-y-auto hide-scroll">
            <a href="{{ route('produk.index') }}"
                class="flex items-center gap-4 bg-[#0088cc] text-white px-4 py-3.5 rounded-xl font-bold shadow-[0_4px_15px_rgba(0,136,204,0.4)] transition-transform hover:-translate-y-1">
                <div class="w-6 flex justify-center shrink-0"><i class="fa-solid fa-box text-lg"></i></div>
                <span class="menu-text">Produk</span>
            </a>
            <!-- Tambahkan link sidebar admin lain di sini jika ada -->
        </nav>
        <div class="px-4 pb-6 shrink-0 border-t border-gray-50 pt-4">
            <button type="button" onclick="openLogoutModal()"
                class="w-full bg-[#ff0000] text-white px-4 py-3 rounded-xl font-bold hover:bg-red-700 transition-all flex items-center gap-4 group">
                <div class="w-6 flex justify-center shrink-0"><i class="fa-solid fa-power-off text-lg"></i></div>
                <span class="menu-text">Log Out</span>
            </button>
        </div>
    </aside>

    <!-- CONTENT AREA -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative w-full">
        <!-- TOPBAR -->
        <header
            class="h-20 bg-white shadow-sm flex items-center justify-end px-4 sm:px-8 z-10 shrink-0 w-full relative">
            <div class="relative group border border-transparent hover:border-gray-100 p-2 rounded-lg shrink-0 z-50">
                <div class="flex items-center gap-3 text-gray-600 cursor-pointer">
                    <i class="fa-regular fa-user text-xl"></i>
                    <span
                        class="font-bold text-sm hidden sm:block">{{ explode(' ', Auth::user()->nama_lengkap ?? 'Admin')[0] }}</span>
                </div>
                <div
                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                    <div class="p-3 border-b border-gray-100 bg-gray-50">
                        <p class="font-bold text-gray-800 truncate">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#0088cc] font-semibold"><i
                            class="fa-regular fa-id-card w-4"></i> Edit Profil</a>
                    <button type="button" onclick="openLogoutModal()"
                        class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 text-left font-bold border-t"><i
                            class="fa-solid fa-arrow-right-from-bracket w-4"></i> Logout</button>
                </div>
            </div>
        </header>

        <!-- MAIN YIELD -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 w-full">
            @yield('content')
        </div>
    </main>

    <!-- Modal Logout -->
    <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    <script>
        function openLogoutModal() {
            if (confirm('Yakin ingin keluar?')) document.getElementById('logoutForm').submit();
        }
    </script>
</body>

</html>
