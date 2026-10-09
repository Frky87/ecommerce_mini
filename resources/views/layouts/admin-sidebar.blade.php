<div id="mobileOverlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-20 hidden lg:hidden transition-opacity">
</div>
<aside id="sidebar"
    class="fixed lg:relative inset-y-0 left-0 w-72 bg-white flex flex-col shadow-2xl lg:shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-30 transition-all duration-300 -translate-x-full lg:translate-x-0 h-full overflow-y-auto border-r border-gray-100">

    <!-- HEADER & LOGO -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-gray-50 shrink-0">
        <a href="{{ route('katalog') }}"
            class="flex items-center gap-3 text-[#0088cc] hover:scale-105 transition-transform duration-300 w-max"
            id="logoContainer">
            <!-- LOGO ASLI (Ikon Baju Bulat) -->
            <div
                class="w-10 h-10 rounded-full border-2 border-[#0088cc] flex items-center justify-center shadow-sm shrink-0 bg-white text-[#0088cc]">
                <i class="fa-solid fa-shirt text-lg"></i>
            </div>
            <span id="logoText"
                class="text-xl sm:text-2xl font-extrabold tracking-wide whitespace-nowrap transition-opacity duration-300">MARKETQU</span>
        </a>

        <!-- TOMBOL LIPAT SIDEBAR (Khusus Layar Besar) -->
        <button id="toggleSidebar"
            class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-[#0088cc] hover:bg-[#0088cc] hover:text-white transition-all shadow-sm shrink-0 cursor-pointer hidden lg:flex">
            <i id="toggleIcon" class="fa-solid fa-chevron-left text-sm transition-transform duration-300"></i>
        </button>
    </div>

    <!-- MENU UTAMA -->
    <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto hide-scroll">

        <!-- DASHBOARD -->
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-4 {{ request()->routeIs('admin.dashboard') ? 'bg-[#0088cc] text-white shadow-[0_4px_15px_rgba(0,136,204,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-blue-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group">
            <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                    class="fa-solid fa-gauge-high text-lg"></i></div>
            <span class="menu-text">Dashboard</span>
        </a>

        <!-- PRODUK -->
        <a href="{{ route('produk.index') }}"
            class="flex items-center gap-4 {{ request()->routeIs('produk.*') ? 'bg-[#0088cc] text-white shadow-[0_4px_15px_rgba(0,136,204,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-blue-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group">
            <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                    class="fa-solid fa-box text-lg"></i></div>
            <span class="menu-text">Produk</span>
        </a>

        <!-- PESANAN -->
        <a href="{{ route('admin.pesanan.index') }}"
            class="flex items-center gap-4 {{ request()->routeIs('admin.pesanan.*') ? 'bg-[#0088cc] text-white shadow-[0_4px_15px_rgba(0,136,204,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-blue-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group">
            <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                    class="fa-solid fa-clipboard-list text-lg"></i></div>
            <span class="menu-text">Pesanan</span>
        </a>

        <!-- MENU KHUSUS SUPER ADMIN -->
        @if (in_array(strtolower(Auth::user()->role), ['super admin', 'superadmin', 'super_admin']))
            <a href="{{ route('superadmin.admin_list') }}"
                class="flex items-center gap-4 {{ request()->routeIs('superadmin.*') ? 'bg-gradient-to-r from-[#0088cc] to-blue-600 text-white shadow-[0_4px_15px_rgba(0,136,204,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-blue-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group mt-4">
                <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                        class="fa-solid fa-users-gear text-lg"></i></div>
                <span class="menu-text">Kelola Admin</span>
            </a>
        @endif

    </nav>

    <!-- TOMBOL LOGOUT MEMANGGIL MODAL -->
    <div class="px-4 pb-6 shrink-0 border-t border-gray-50 pt-4">
        <button type="button" onclick="openLogoutModal()"
            class="w-full bg-red-50 text-red-600 border border-red-100 px-4 py-3 rounded-xl font-bold hover:bg-red-500 hover:text-white transition-all flex items-center gap-4 group hover:-translate-y-1 shadow-sm hover:shadow-md">
            <div class="w-6 flex justify-center shrink-0 group-hover:-translate-x-1 transition-transform"><i
                    class="fa-solid fa-arrow-right-from-bracket text-lg"></i></div>
            <span class="menu-text">Logout</span>
        </button>
    </div>
</aside>

<!-- SCRIPT INTERAKTIF SIDEBAR (Lipat, Buka, Tutup) -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const openMobileSidebarBtn = document.getElementById('openMobileSidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');

        if (sidebar && toggleBtn) {
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
        if (sidebar && openMobileSidebarBtn) {
            openMobileSidebarBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                if (mobileOverlay) mobileOverlay.classList.remove('hidden');
            });
        }
        if (sidebar && mobileOverlay) {
            mobileOverlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('hidden');
            });
        }
    });
</script>
