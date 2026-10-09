<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Marketqu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

@php
    $isAdmin =
        Auth::check() &&
        in_array(strtolower(Auth::user()->role), ['admin', 'super admin', 'superadmin', 'super_admin']);
@endphp

<body
    class="bg-gray-50 text-gray-800 font-sans selection:bg-[#0088cc] selection:text-white relative {{ $isAdmin ? 'h-screen overflow-hidden flex' : 'min-h-screen flex flex-col' }}">

    @if ($isAdmin)
        @include('layouts.admin-sidebar')
        <div class="flex-1 flex flex-col h-full overflow-hidden relative w-full bg-gray-50">
            @include('layouts.admin-topbar')
            <div class="flex-1 overflow-y-auto p-4 sm:p-6 w-full custom-scroll">
            @else
                @include('layouts.navbar')
                <div class="flex-1 overflow-y-auto w-full py-8 px-4 sm:px-6 lg:px-8">
    @endif

    <main class="max-w-4xl mx-auto w-full">

        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-black text-gray-800 flex items-center gap-3">
                <div class="w-10 h-10 bg-[#0088cc] text-white rounded-xl flex items-center justify-center shadow-md"><i
                        class="fa-solid fa-user-pen"></i></div>
                Pengaturan Profil
            </h1>
            <p class="text-gray-500 font-medium text-sm mt-2">Kelola informasi data diri dan pengaturan keamanan akun
                Anda.</p>
        </div>

        @if (session('success'))
            <div
                class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 font-bold flex items-center gap-3 border border-green-200 shadow-sm">
                <i class="fa-solid fa-circle-check text-xl"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('status') === 'password-updated')
            <div
                class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 font-bold flex items-center gap-3 border border-green-200 shadow-sm">
                <i class="fa-solid fa-shield-check text-xl"></i> Password berhasil diperbarui!
            </div>
        @endif
        @if ($errors->any())
            <div
                class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 font-bold flex items-start gap-3 border border-red-200 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-xl mt-0.5"></i>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-12">

            <div class="h-32 sm:h-40 bg-gradient-to-r from-[#0088cc] to-blue-800 relative">
                <div
                    class="absolute -bottom-10 left-6 sm:left-10 w-24 h-24 sm:w-28 sm:h-28 bg-white rounded-full p-1.5 shadow-lg border-2 border-white">
                    <div
                        class="w-full h-full bg-blue-50 rounded-full flex items-center justify-center text-4xl text-[#0088cc]">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
            </div>

            <div class="pt-16 pb-10 px-6 sm:px-10">

                <!-- ========================================== -->
                <!-- FORM 1: INFORMASI DASAR                    -->
                <!-- ========================================== -->
                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf @method('put')

                    <h2 class="text-lg font-extrabold text-gray-800 border-b border-gray-100 pb-2 mb-4"><i
                            class="fa-regular fa-id-card text-[#0088cc] mr-2"></i> Informasi Dasar</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama
                                Lengkap</label>
                            <input type="text" name="nama_lengkap"
                                value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 outline-none transition-colors"
                                required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email /
                                Username</label>
                            <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 outline-none transition-colors"
                                required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nomor
                                Telepon</label>
                            <input type="text" name="no_telp" value="{{ old('no_telp', Auth::user()->no_telp) }}"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 outline-none transition-colors"
                                required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Jenis
                                Kelamin</label>
                            <select name="jenis_kelamin"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 outline-none transition-colors">
                                <option value="Laki-Laki"
                                    {{ Auth::user()->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki
                                </option>
                                <option value="Perempuan"
                                    {{ Auth::user()->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>

                        <!-- Khusus Admin: Menampilkan Nama Toko -->
                        @if ($isAdmin)
                            <div class="col-span-1 sm:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama
                                    Toko</label>
                                <input type="text" name="nama_toko"
                                    value="{{ old('nama_toko', Auth::user()->nama_toko) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 outline-none transition-colors"
                                    required>
                            </div>
                        @endif

                        <!-- Deskripsi: Disesuaikan dengan Role -->
                        <div class="col-span-1 sm:col-span-2">
                            <label
                                class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">{{ $isAdmin ? 'Deskripsi Toko' : 'Deskripsi Diri' }}</label>
                            <textarea name="deskripsi" rows="2"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 outline-none transition-colors"
                                placeholder="{{ $isAdmin ? 'Ceritakan tentang produk dan toko Anda...' : 'Ceritakan sedikit tentang Anda...' }}">{{ old('deskripsi', Auth::user()->deskripsi) }}</textarea>
                        </div>
                        <div class="col-span-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Alamat
                                Utama</label>
                            <textarea name="alamat" rows="3"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 outline-none transition-colors">{{ old('alamat', Auth::user()->alamat) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="bg-gradient-to-r from-[#0088cc] to-blue-600 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all hover:-translate-y-1">Simpan
                            Profil</button>
                    </div>
                </form>

                <div class="w-full h-px bg-gray-200 my-10"></div>

                <!-- ========================================== -->
                <!-- FORM 2: GANTI PASSWORD                     -->
                <!-- ========================================== -->
                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf @method('put')

                    <h2 class="text-lg font-extrabold text-gray-800 border-b border-gray-100 pb-2 mb-4"><i
                            class="fa-solid fa-lock text-gray-500 mr-2"></i> Keamanan Akun</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Password
                                Baru</label>
                            <div class="relative">
                                <input type="password" name="password" id="inputPass"
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 pr-12 outline-none transition-colors"
                                    placeholder="Minimal 8 karakter">
                                <button type="button" onclick="togglePassword('inputPass', 'iconPass')"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#0088cc] transition-colors">
                                    <i class="fa-solid fa-eye-slash text-base" id="iconPass"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Konfirmasi
                                Password Baru</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="inputPassConf"
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 pr-12 outline-none transition-colors"
                                    placeholder="Ulangi password baru">
                                <button type="button" onclick="togglePassword('inputPassConf', 'iconPassConf')"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#0088cc] transition-colors">
                                    <i class="fa-solid fa-eye-slash text-base" id="iconPassConf"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="bg-gray-800 hover:bg-black text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all hover:-translate-y-1">Update
                            Password</button>
                    </div>
                </form>

                <div class="w-full h-px bg-gray-200 my-10"></div>

                <!-- ========================================== -->
                <!-- BLOK 3: PENGAJUAN BUKA TOKO                -->
                <!-- ========================================== -->
                <div class="space-y-4">
                    <h2 class="text-lg font-extrabold text-gray-800 border-b border-gray-100 pb-2 mb-4"><i
                            class="fa-solid fa-store text-[#0088cc] mr-2"></i> Pengajuan Buka Toko</h2>

                    @if ($isAdmin)
                        <div
                            class="bg-green-50 text-green-700 p-4 rounded-xl font-bold flex items-center gap-3 border border-green-200 shadow-sm">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-check-circle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-base">Toko Anda Sudah Aktif!</p>
                                <p class="text-xs font-medium text-green-600 mt-0.5">Anda memiliki hak akses Admin
                                    untuk mengelola produk.</p>
                            </div>
                        </div>
                    @elseif(Auth::user()->pengajuan_toko == 'pending')
                        <div
                            class="bg-yellow-50 text-yellow-700 p-4 rounded-xl font-bold flex items-center gap-3 border border-yellow-200 shadow-sm">
                            <div
                                class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-clock text-xl animate-pulse"></i>
                            </div>
                            <div>
                                <p class="text-base">Sedang Menunggu Persetujuan</p>
                                <p class="text-xs font-medium text-yellow-600 mt-0.5">Pengajuan Toko <span
                                        class="font-black">"{{ Auth::user()->nama_toko }}"</span> sedang ditinjau.</p>
                            </div>
                        </div>
                    @else
                        <!-- Form Ajukan Toko dengan Inputan Baru -->
                        <form method="POST" action="{{ route('profile.ajukan_toko') }}"
                            class="bg-blue-50 p-6 rounded-2xl border border-blue-200 shadow-sm space-y-5">
                            @csrf
                            <div class="flex items-center gap-4 mb-2">
                                <div
                                    class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-[#0088cc] shadow-sm shrink-0">
                                    <i class="fa-solid fa-shop text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-lg font-black text-gray-800">Ingin Mulai Berjualan?</p>
                                    <p class="text-sm font-medium text-gray-600 mt-0.5">Lengkapi identitas toko Anda di
                                        bawah ini untuk menjadi Admin.</p>
                                    @if (Auth::user()->pengajuan_toko == 'ditolak')
                                        <p class="text-xs font-bold text-red-500 mt-1"><i
                                                class="fa-solid fa-circle-xmark"></i> Pengajuan ditolak. Silakan
                                            perbaiki data dan ajukan ulang.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white p-5 rounded-xl border border-blue-100 space-y-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama
                                        Toko <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_toko"
                                        value="{{ old('nama_toko', Auth::user()->nama_toko) }}"
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 outline-none transition-colors"
                                        placeholder="Contoh: Marketqu Official Store" required>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Deskripsi
                                        Toko <span class="text-red-500">*</span></label>
                                    <textarea name="deskripsi" rows="3"
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm font-semibold rounded-xl focus:ring-[#0088cc] focus:border-[#0088cc] block p-3.5 outline-none transition-colors"
                                        placeholder="Ceritakan jenis produk yang Anda jual..." required>{{ old('deskripsi', Auth::user()->deskripsi) }}</textarea>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="w-full sm:w-auto bg-gradient-to-r from-[#0088cc] to-blue-600 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                    Kirim Pengajuan Toko <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </main>

    @if ($isAdmin)
        </div>
        </div>
    @else
        </div>
    @endif

    @include('layouts.modal-logout')

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>
</body>

</html>
