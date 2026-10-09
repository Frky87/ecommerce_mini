@extends('layouts.admin')
@section('title', 'Kelola Admin & Pengajuan')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-black text-gray-800 tracking-tight flex items-center gap-3">
            <div class="w-10 h-10 bg-[#0088cc] text-white rounded-xl flex items-center justify-center shadow-md"><i
                    class="fa-solid fa-users-gear text-xl"></i></div>
            Kelola Akses Admin
        </h1>
        <p class="text-sm text-gray-500 font-medium mt-2">Setujui permintaan buka toko dan pantau daftar admin aktif.</p>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <div
            class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 font-bold flex items-center gap-3 border border-green-200 shadow-sm">
            <i class="fa-solid fa-check-circle text-xl"></i> {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div
            class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 font-bold flex items-center gap-3 border border-red-200 shadow-sm">
            <i class="fa-solid fa-circle-xmark text-xl"></i> {{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

        <!-- KOLOM KIRI: MENUNGGU PERSETUJUAN -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 border-b border-gray-100 p-5 flex items-center justify-between">
                <h2 class="font-extrabold text-gray-800 text-lg"><i class="fa-solid fa-bell text-yellow-500 mr-2"></i>
                    Menunggu Persetujuan</h2>
                <span
                    class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-black">{{ count($pendingRequests) }}
                    Pengajuan</span>
            </div>

            <div class="p-5 flex flex-col gap-4 max-h-[500px] overflow-y-auto custom-scroll">
                @forelse($pendingRequests as $req)
                    @php
                        $descClean = htmlspecialchars(trim(preg_replace('/\s+/', ' ', $req->deskripsi)), ENT_QUOTES);
                        $alamatClean = htmlspecialchars(trim(preg_replace('/\s+/', ' ', $req->alamat)), ENT_QUOTES);
                        $namaTokoClean = htmlspecialchars(trim($req->nama_toko), ENT_QUOTES);
                    @endphp
                    <div
                        class="border border-gray-200 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white hover:border-[#0088cc] hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div
                                class="w-10 h-10 bg-blue-50 text-[#0088cc] rounded-full flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-user"></i></div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800 text-sm truncate">{{ $req->nama_lengkap }}</p>
                                <p class="text-xs font-medium text-[#0088cc] truncate"><i
                                        class="fa-solid fa-store mr-1"></i> {{ $req->nama_toko }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <!-- Tombol Lihat Profil -->
                            <button type="button"
                                onclick="openProfileModal('{{ $req->nama_lengkap }}', '{{ $req->username }}', '{{ $req->no_telp }}', '{{ $req->jenis_kelamin }}', '{{ $alamatClean }}', '{{ $descClean }}', '{{ $namaTokoClean }}')"
                                class="w-9 h-9 rounded-xl bg-gray-100 text-gray-600 hover:bg-[#0088cc] hover:text-white flex items-center justify-center transition-colors shadow-sm"
                                title="Lihat Profil">
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            <!-- Tombol Tolak -->
                            <button type="button"
                                onclick="openRejectModal('{{ $req->nama_lengkap }}', '{{ route('superadmin.reject', $req->id) }}')"
                                class="w-9 h-9 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors shadow-sm"
                                title="Tolak">
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                            <!-- Tombol Setujui -->
                            <button type="button"
                                onclick="openApproveModal('{{ $req->nama_lengkap }}', '{{ route('superadmin.approve', $req->id) }}')"
                                class="px-4 h-9 rounded-xl bg-gradient-to-r from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white text-xs font-bold transition-all shadow-sm flex items-center gap-2 hover:-translate-y-0.5">
                                <i class="fa-solid fa-check"></i> Setujui
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-400 flex flex-col items-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-3"><i
                                class="fa-solid fa-mug-hot text-4xl text-gray-300"></i></div>
                        <p class="font-bold text-gray-500 text-sm">Belum ada pengajuan toko baru.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- KOLOM KANAN: DAFTAR ADMIN AKTIF -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 border-b border-gray-100 p-5 flex items-center justify-between">
                <h2 class="font-extrabold text-gray-800 text-lg"><i class="fa-solid fa-user-shield text-[#0088cc] mr-2"></i>
                    Daftar Admin Aktif</h2>
                <span class="bg-blue-100 text-[#0088cc] px-3 py-1 rounded-full text-xs font-black">{{ count($admins) }}
                    Admin</span>
            </div>

            <div class="p-5 flex flex-col gap-4 max-h-[500px] overflow-y-auto custom-scroll">
                @forelse($admins as $adm)
                    @php
                        $descClean = htmlspecialchars(trim(preg_replace('/\s+/', ' ', $adm->deskripsi)), ENT_QUOTES);
                        $alamatClean = htmlspecialchars(trim(preg_replace('/\s+/', ' ', $adm->alamat)), ENT_QUOTES);
                        $namaTokoClean = htmlspecialchars(trim($adm->nama_toko), ENT_QUOTES);
                    @endphp
                    <div
                        class="border border-gray-100 rounded-2xl p-4 flex items-center justify-between gap-4 bg-gray-50/50 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-4 min-w-0">
                            <div
                                class="w-10 h-10 bg-blue-100 text-[#0088cc] rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user-tie"></i></div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800 text-sm truncate">{{ $adm->nama_lengkap }}</p>
                                <p class="text-xs font-medium text-[#0088cc] truncate"><i
                                        class="fa-solid fa-store mr-1"></i> {{ $adm->nama_toko }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <!-- Tombol Lihat Profil Admin -->
                            <button type="button"
                                onclick="openProfileModal('{{ $adm->nama_lengkap }}', '{{ $adm->username }}', '{{ $adm->no_telp }}', '{{ $adm->jenis_kelamin }}', '{{ $alamatClean }}', '{{ $descClean }}', '{{ $namaTokoClean }}')"
                                class="w-8 h-8 rounded-lg bg-white border border-gray-200 text-gray-500 hover:bg-[#0088cc] hover:text-white hover:border-[#0088cc] flex items-center justify-center transition-colors shadow-sm"
                                title="Lihat Profil Admin">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-400 flex flex-col items-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-3"><i
                                class="fa-solid fa-ghost text-4xl text-gray-300"></i></div>
                        <p class="font-bold text-gray-500 text-sm">Belum ada admin yang terdaftar.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL APPROVE & REJECT & PROFIL            -->
    <!-- ========================================== -->

    <!-- Modal Approve -->
    <div id="approveModal"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 pointer-events-none opacity-0 transition-opacity duration-300 ease-out">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeApproveModal()"></div>
        <div id="approveModalContent"
            class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.3)] rounded-3xl max-w-sm w-full relative transform scale-95 transition-transform duration-300 ease-out z-10 overflow-hidden">
            <div class="p-6 text-center">
                <div
                    class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner">
                    <i class="fa-solid fa-check-circle"></i></div>
                <h3 class="text-xl font-black text-gray-800 mb-2">Setujui Pengajuan?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin menjadikan <span id="approveName"
                        class="font-bold text-gray-800"></span> sebagai Admin Toko?</p>
                <form id="approveForm" method="POST" class="flex gap-3">
                    @csrf @method('PUT')
                    <button type="button" onclick="closeApproveModal()"
                        class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors">Batal</button>
                    <button type="submit"
                        class="flex-1 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition-colors shadow-md">Ya,
                        Setujui</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Reject -->
    <div id="rejectModal"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 pointer-events-none opacity-0 transition-opacity duration-300 ease-out">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeRejectModal()"></div>
        <div id="rejectModalContent"
            class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.3)] rounded-3xl max-w-sm w-full relative transform scale-95 transition-transform duration-300 ease-out z-10 overflow-hidden">
            <div class="p-6 text-center">
                <div
                    class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner">
                    <i class="fa-solid fa-circle-xmark"></i></div>
                <h3 class="text-xl font-black text-gray-800 mb-2">Tolak Pengajuan?</h3>
                <p class="text-sm text-gray-500 mb-6">Yakin ingin menolak pengajuan buka toko dari <span id="rejectName"
                        class="font-bold text-gray-800"></span>?</p>
                <form id="rejectForm" method="POST" class="flex gap-3">
                    @csrf @method('PUT')
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors">Batal</button>
                    <button type="submit"
                        class="flex-1 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition-colors shadow-md">Ya,
                        Tolak</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Profil (Dengan Nama Toko) -->
    <div id="profileModal"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 pointer-events-none opacity-0 transition-opacity duration-300 ease-out">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeProfileModal()"></div>
        <div id="profileModalContent"
            class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.3)] rounded-[2rem] max-w-md w-full relative transform scale-95 transition-transform duration-300 ease-out z-10 overflow-hidden">

            <div class="h-28 w-full bg-gradient-to-br from-[#0088cc] to-blue-700 relative">
                <button type="button" onclick="closeProfileModal()"
                    class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/20 text-white hover:bg-white hover:text-red-500 transition-colors backdrop-blur-md">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="px-6 pb-6 relative">
                <div class="flex flex-col items-center -mt-12 mb-5">
                    <div
                        class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-4xl mb-3 shadow-lg border-4 border-white overflow-hidden relative">
                        <div class="absolute inset-0 bg-blue-50 flex items-center justify-center text-[#0088cc]"><i
                                class="fa-solid fa-user-astronaut"></i></div>
                    </div>
                    <h4 class="text-xl font-black text-gray-800 text-center leading-tight" id="modalNama">Nama Lengkap
                    </h4>
                    <p class="text-sm font-semibold text-gray-500 text-center" id="modalEmail">email@domain.com</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-4">

                    <!-- Nama Toko -->
                    <div class="flex items-center gap-3 border-b border-gray-200 pb-3" id="wrapNamaToko">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 text-[#0088cc] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-store"></i></div>
                        <div class="min-w-0">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Nama
                                Toko</span>
                            <span class="text-sm font-bold text-[#0088cc] truncate block" id="modalNamaToko">-</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 border-b border-gray-200 pb-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 text-[#0088cc] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone"></i></div>
                        <div class="min-w-0">
                            <span
                                class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Telepon</span>
                            <span class="text-sm font-bold text-gray-800 truncate block" id="modalTelp">-</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 border-b border-gray-200 pb-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 text-[#0088cc] flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-quote-left"></i></div>
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Deskripsi
                                Toko/Diri</span>
                            <span class="text-sm font-medium text-gray-700 leading-snug block italic"
                                id="modalDeskripsi">-</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 text-[#0088cc] flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-map-location-dot"></i></div>
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Alamat
                                Utama</span>
                            <span class="text-sm font-bold text-gray-800 leading-snug block" id="modalAlamat">-</span>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="closeProfileModal()"
                    class="w-full mt-6 py-3.5 bg-gray-800 hover:bg-black text-white font-bold rounded-xl transition-all shadow-md hover:-translate-y-0.5">Tutup
                    Jendela</button>
            </div>
        </div>
    </div>

    <script>
        function openProfileModal(nama, email, telp, jk, alamat, deskripsi, namaToko) {
            document.getElementById('modalNama').innerText = nama;
            document.getElementById('modalEmail').innerText = email;
            document.getElementById('modalTelp').innerText = telp ? telp : '-';
            document.getElementById('modalDeskripsi').innerText = deskripsi ? '"' + deskripsi + '"' :
            'Belum ada deskripsi.';
            document.getElementById('modalAlamat').innerText = alamat ? alamat : 'Belum mengatur alamat.';

            const txtNamaToko = document.getElementById('modalNamaToko');
            const wrapNamaToko = document.getElementById('wrapNamaToko');

            // Cek jika ada nama toko, tampilkan, jika tidak sembunyikan kotak nama toko
            if (namaToko && namaToko.trim() !== '') {
                txtNamaToko.innerText = namaToko;
                wrapNamaToko.classList.remove('hidden');
                wrapNamaToko.classList.add('flex');
            } else {
                wrapNamaToko.classList.remove('flex');
                wrapNamaToko.classList.add('hidden');
            }

            const modal = document.getElementById('profileModal');
            const modalContent = document.getElementById('profileModalContent');
            modal.classList.remove('pointer-events-none', 'opacity-0');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }

        function closeProfileModal() {
            const modal = document.getElementById('profileModal');
            const modalContent = document.getElementById('profileModalContent');
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
        }

        function openApproveModal(nama, actionUrl) {
            document.getElementById('approveName').innerText = nama;
            document.getElementById('approveForm').action = actionUrl;
            const modal = document.getElementById('approveModal');
            const modalContent = document.getElementById('approveModalContent');
            modal.classList.remove('pointer-events-none', 'opacity-0');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }

        function closeApproveModal() {
            const modal = document.getElementById('approveModal');
            const modalContent = document.getElementById('approveModalContent');
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
        }

        function openRejectModal(nama, actionUrl) {
            document.getElementById('rejectName').innerText = nama;
            document.getElementById('rejectForm').action = actionUrl;
            const modal = document.getElementById('rejectModal');
            const modalContent = document.getElementById('rejectModalContent');
            modal.classList.remove('pointer-events-none', 'opacity-0');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            const modalContent = document.getElementById('rejectModalContent');
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
        }
    </script>
@endsection
