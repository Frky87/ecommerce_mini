<header
    class="h-20 bg-white shadow-sm flex items-center justify-between lg:justify-end px-4 sm:px-8 z-10 shrink-0 w-full relative">
    <button onclick="toggleSidebar()"
        class="lg:hidden w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-600 hover:bg-blue-50 hover:text-[#0088cc] shadow-sm transition-colors mr-4 shrink-0">
        <i class="fa-solid fa-bars-staggered"></i>
    </button>

    <div class="relative group border border-transparent hover:border-gray-100 p-2 rounded-lg shrink-0 z-50">
        <div
            class="flex items-center gap-2 sm:gap-3 text-gray-600 group-hover:text-[#0088cc] transition-colors cursor-pointer">
            <i class="fa-regular fa-user text-xl"></i>
            <span
                class="font-bold text-sm hidden sm:block truncate max-w-[100px]">{{ explode(' ', Auth::user()->nama_lengkap ?? 'Admin')[0] }}</span>
            <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
        </div>

        <div
            class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 overflow-hidden">
            <div class="p-3 border-b border-gray-100 bg-gray-50">
                <p class="text-xs text-gray-400 mb-0.5">Masuk sebagai Admin</p>
                <p class="font-bold text-gray-800 truncate">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</p>
            </div>
            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#0088cc] transition-colors font-semibold">
                <i class="fa-regular fa-id-card w-4 text-center"></i> Edit Profil
            </a>
            <button type="button" onclick="openLogoutModal()"
                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors text-left font-bold border-t border-gray-100">
                <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Logout
            </button>
        </div>
    </div>
</header>
