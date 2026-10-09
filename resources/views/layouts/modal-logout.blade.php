<div id="logoutModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity" onclick="closeLogoutModal()"></div>
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
            <p class="text-xs sm:text-sm text-gray-500 mb-6 font-medium">Sesi Anda akan diakhiri. Pastikan pekerjaan
                Anda sudah tersimpan!</p>
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

<script>
    const logoutModal = document.getElementById('logoutModal');
    const logoutModalContent = document.getElementById('logoutModalContent');

    function openLogoutModal() {
        if (logoutModal) {
            logoutModal.classList.remove('hidden');
            setTimeout(() => {
                logoutModalContent.classList.replace('scale-95', 'scale-100');
                logoutModalContent.classList.replace('opacity-0', 'opacity-100');
            }, 10);
        }
    }

    function closeLogoutModal() {
        if (logoutModalContent) {
            logoutModalContent.classList.replace('scale-100', 'scale-95');
            logoutModalContent.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                logoutModal.classList.add('hidden');
            }, 300);
        }
    }
</script>
