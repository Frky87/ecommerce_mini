@php
    $role = strtolower(Auth::user()->role);
    $isSuper = in_array($role, ['super admin', 'superadmin', 'super_admin']);
    $scope = request('scope');
@endphp

<!-- Backdrop Gelap (Muncul saat Sidebar dibuka di HP / Zoom Besar) -->
<div id="sidebarBackdrop" onclick="toggleSidebar()"
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0 lg:hidden">
</div>

<aside id="adminSidebar"
    class="fixed lg:relative inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-100 flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)] h-screen overflow-hidden transition-transform duration-300 ease-in-out transform -translate-x-full lg:translate-x-0 shrink-0">

    <!-- Logo & Tombol Tutup -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-gray-50 shrink-0">
        <a href="{{ route('katalog') }}"
            class="flex items-center gap-3 text-xl font-black text-gray-800 tracking-tight group">
            <div
                class="w-10 h-10 bg-gradient-to-br from-[#0088cc] to-blue-600 text-white rounded-full flex items-center justify-center shadow-md group-hover:rotate-12 transition-transform shrink-0">
                <i class="fa-solid fa-shirt text-lg"></i>
            </div>
            <span>MARKET<span class="text-[#0088cc]">QU</span></span>
        </a>

        <!-- Tombol Tutup Sidebar (Hanya terlihat di Mobile / Zoom 250%) -->
        <button type="button" onclick="toggleSidebar()"
            class="lg:hidden w-8 h-8 flex items-center justify-center rounded-xl bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition-colors shrink-0">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto custom-scroll">

        <!-- ========================================== -->
        <!-- MENU TOKO SAYA (Untuk Admin & Super Admin) -->
        <!-- ========================================== -->
        <div class="px-4 pb-2 pt-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">
            {{ $isSuper ? 'Toko Saya' : 'Menu Admin' }}
        </div>

        <a href="{{ route('admin.dashboard', $isSuper ? ['scope' => 'mine'] : []) }}"
            class="flex items-center gap-4 {{ request()->routeIs('admin.dashboard') && (!$isSuper || $scope == 'mine') ? 'bg-gradient-to-r from-[#0088cc] to-blue-600 text-white shadow-[0_4px_15px_rgba(0,136,204,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-blue-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group">
            <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                    class="fa-solid fa-gauge-high text-lg"></i></div>
            <span class="menu-text">{{ $isSuper ? 'Dashboard Tokoku' : 'Dashboard' }}</span>
        </a>

        <a href="{{ route('produk.index', $isSuper ? ['scope' => 'mine'] : []) }}"
            class="flex items-center gap-4 {{ request()->routeIs('produk.*') && (!$isSuper || $scope == 'mine') ? 'bg-gradient-to-r from-[#0088cc] to-blue-600 text-white shadow-[0_4px_15px_rgba(0,136,204,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-blue-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group">
            <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                    class="fa-solid fa-box-open text-lg"></i></div>
            <span class="menu-text">Produk Saya</span>
        </a>

        <a href="{{ route('admin.pesanan.index', $isSuper ? ['scope' => 'mine'] : []) }}"
            class="flex items-center gap-4 {{ request()->routeIs('admin.pesanan.*') && (!$isSuper || $scope == 'mine') ? 'bg-gradient-to-r from-[#0088cc] to-blue-600 text-white shadow-[0_4px_15px_rgba(0,136,204,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-[#0088cc] hover:bg-blue-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group">
            <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                    class="fa-solid fa-clipboard-list text-lg"></i></div>
            <span class="menu-text">Pesanan Masuk</span>
        </a>

        <!-- ========================================== -->
        <!-- MENU GLOBAL KHUSUS SUPER ADMIN             -->
        <!-- ========================================== -->
        @if ($isSuper)
            <div
                class="px-4 pt-6 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest border-t border-gray-100 mt-4">
                Akses Super Admin
            </div>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-4 {{ request()->routeIs('admin.dashboard') && $scope != 'mine' ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-[0_4px_15px_rgba(147,51,234,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-purple-600 hover:bg-purple-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group">
                <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                        class="fa-solid fa-globe text-lg"></i></div>
                <span class="menu-text">Dashboard Global</span>
            </a>

            <a href="{{ route('produk.index') }}"
                class="flex items-center gap-4 {{ request()->routeIs('produk.*') && $scope != 'mine' ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-[0_4px_15px_rgba(147,51,234,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-purple-600 hover:bg-purple-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group">
                <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                        class="fa-solid fa-boxes-stacked text-lg"></i></div>
                <span class="menu-text">Semua Produk</span>
            </a>

            <a href="{{ route('admin.pesanan.index') }}"
                class="flex items-center gap-4 {{ request()->routeIs('admin.pesanan.*') && $scope != 'mine' ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-[0_4px_15px_rgba(147,51,234,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-purple-600 hover:bg-purple-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group">
                <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                        class="fa-solid fa-file-invoice text-lg"></i></div>
                <span class="menu-text">Semua Pesanan</span>
            </a>

            <a href="{{ route('superadmin.admin_list') }}"
                class="flex items-center gap-4 {{ request()->routeIs('superadmin.*') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-[0_4px_15px_rgba(147,51,234,0.4)]' : 'bg-white border-2 border-transparent text-gray-500 hover:text-purple-600 hover:bg-purple-50 shadow-sm' }} px-4 py-3.5 rounded-xl font-bold transition-all hover:-translate-y-1 group">
                <div class="w-6 flex justify-center shrink-0 group-hover:scale-110 transition-transform"><i
                        class="fa-solid fa-users-gear text-lg"></i></div>
                <span class="menu-text">Kelola Admin</span>
            </a>
        @endif

        <div class="pb-10"></div>
    </nav>
</aside>

<!-- SCRIPT UNTUK MEMBUKA/MENUTUP SIDEBAR -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');

        if (sidebar.classList.contains('-translate-x-full')) {
            // BUKA SIDEBAR
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
            setTimeout(() => backdrop.classList.remove('opacity-0'), 10);
        } else {
            // TUTUP SIDEBAR
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('opacity-0');
            setTimeout(() => backdrop.classList.add('hidden'), 300);
        }
    }
</script>
