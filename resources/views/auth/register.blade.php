<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Marketqu</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes float-a {

            0%,
            100% {
                transform: translateY(0) rotate(-4deg);
            }

            50% {
                transform: translateY(-12px) rotate(-2deg);
            }
        }

        @keyframes float-b {

            0%,
            100% {
                transform: translateY(0) rotate(4deg);
            }

            50% {
                transform: translateY(-15px) rotate(2deg);
            }
        }

        .animate-float-a {
            animation: float-a 5s ease-in-out infinite;
        }

        .animate-float-b {
            animation: float-b 6s ease-in-out infinite;
        }

        .polaroid-card:hover {
            animation-play-state: paused;
            transform: scale(1.1) rotate(0deg) translateY(-10px) !important;
            z-index: 50;
        }
    </style>
</head>

<body class="bg-white font-sans min-h-screen flex flex-col lg:flex-row selection:bg-[#0088cc] selection:text-white">

    <!-- BAGIAN KIRI (Form Register) -->
    <div class="w-full lg:w-1/2 flex flex-col px-6 sm:px-12 md:px-24 lg:px-32 relative bg-white min-h-screen">

        <!-- Logo -->
        <div class="pt-8 pb-4 lg:pt-12">
            <a href="{{ route('katalog') }}" class="flex items-center gap-3 text-[#0088cc] group w-max">
                <div
                    class="w-10 h-10 rounded-full border-2 border-[#0088cc] flex items-center justify-center group-hover:bg-[#0088cc] group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-md group-hover:rotate-12">
                    <i class="fa-solid fa-shirt text-xl"></i>
                </div>
                <span
                    class="text-2xl font-extrabold tracking-wide text-gray-800 group-hover:text-[#0088cc] transition-colors duration-300">MARKETQU</span>
            </a>
        </div>

        <div class="flex-grow flex flex-col justify-center w-full max-w-sm mx-auto py-8">
            <h2 class="text-xl font-extrabold mb-8 text-gray-800">Sign Up</h2>

            @if ($errors->any())
                <div
                    class="bg-red-50 text-red-600 p-3 rounded-lg mb-6 text-sm border border-red-200 flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Input: Nama Lengkap -->
                <div class="relative mb-5 group">
                    <label
                        class="absolute -top-2.5 left-3 bg-white px-1 text-[11px] font-semibold text-gray-500 group-focus-within:text-[#0088cc] transition-colors z-10">Nama
                        Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                        placeholder="Aditya Rahma"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-[#0088cc] focus:ring-1 focus:ring-[#0088cc] text-sm transition-all bg-transparent text-gray-800"
                        required>
                </div>

                <!-- Input: Email (Ditampung di name="username") -->
                <div class="relative mb-5 group">
                    <label
                        class="absolute -top-2.5 left-3 bg-white px-1 text-[11px] font-semibold text-gray-500 group-focus-within:text-[#0088cc] transition-colors z-10">Email</label>
                    <!-- Perhatikan name="username" di bawah ini -->
                    <input type="email" name="username" value="{{ old('username') }}" placeholder="dev@domain.com"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-[#0088cc] focus:ring-1 focus:ring-[#0088cc] text-sm transition-all bg-transparent text-gray-800"
                        required>
                </div>

                <!-- Input: Jenis Kelamin -->
                <div class="relative mb-5 group">
                    <label
                        class="absolute -top-2.5 left-3 bg-white px-1 text-[11px] font-semibold text-gray-500 group-focus-within:text-[#0088cc] transition-colors z-10">Jenis
                        Kelamin</label>
                    <div class="relative">
                        <select name="jenis_kelamin"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-[#0088cc] focus:ring-1 focus:ring-[#0088cc] text-sm transition-all bg-transparent text-gray-800 appearance-none cursor-pointer"
                            required>
                            <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki -
                                Laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-800">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Input: Nomer Telpon -->
                <div class="relative mb-5 group">
                    <label
                        class="absolute -top-2.5 left-3 bg-white px-1 text-[11px] font-semibold text-gray-500 group-focus-within:text-[#0088cc] transition-colors z-10">Nomer
                        Telpon</label>
                    <input type="tel" name="no_telp" value="{{ old('no_telp') }}" placeholder="087855154533"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-[#0088cc] focus:ring-1 focus:ring-[#0088cc] text-sm transition-all bg-transparent text-gray-800"
                        required>
                </div>

                <!-- Input: Password -->
                <div class="relative mb-5 group">
                    <label
                        class="absolute -top-2.5 left-3 bg-white px-1 text-[11px] font-semibold text-gray-500 group-focus-within:text-[#0088cc] transition-colors z-10">Password</label>
                    <input type="password" id="password" name="password" placeholder="******************"
                        class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-[#0088cc] focus:ring-1 focus:ring-[#0088cc] text-sm transition-all bg-transparent tracking-widest text-gray-800"
                        required>

                    <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-800 hover:text-[#0088cc] focus:outline-none transition-colors cursor-pointer z-20">
                        <i class="fa-solid fa-eye-slash text-sm" id="eyeIcon1"></i>
                    </button>
                </div>

                <!-- Input: Konfirmasi Password -->
                <div class="relative mb-8 group">
                    <label
                        class="absolute -top-2.5 left-3 bg-white px-1 text-[11px] font-semibold text-gray-500 group-focus-within:text-[#0088cc] transition-colors z-10">Konfirmasi
                        Password</label>
                    <input type="password" id="password_confirm" name="password_confirmation"
                        placeholder="******************"
                        class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-[#0088cc] focus:ring-1 focus:ring-[#0088cc] text-sm transition-all bg-transparent tracking-widest text-gray-800"
                        required>

                    <button type="button" onclick="togglePassword('password_confirm', 'eyeIcon2')"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-800 hover:text-[#0088cc] focus:outline-none transition-colors cursor-pointer z-20">
                        <i class="fa-solid fa-eye-slash text-sm" id="eyeIcon2"></i>
                    </button>
                </div>

                <!-- Tombol Submit & Login -->
                <div class="flex flex-col items-center justify-center mt-2">
                    <button type="submit"
                        class="bg-[#0088cc] text-white px-10 py-2.5 rounded-md text-sm font-bold hover:bg-blue-600 transition-all duration-300 flex items-center gap-2 shadow-md hover:shadow-lg hover:-translate-y-0.5 group">
                        REGISTER
                        <i
                            class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1"></i>
                    </button>

                    <a href="{{ route('login') }}"
                        class="mt-4 text-sm font-bold text-gray-600 hover:text-[#0088cc] transition-colors duration-300 underline underline-offset-4 decoration-gray-400 hover:decoration-[#0088cc]">Login</a>
                </div>
            </form>
        </div>
    </div>

    <!-- BAGIAN KANAN (Banner Biru & Foto Polaroid) -->
    <div
        class="hidden lg:flex w-1/2 bg-gradient-to-br from-[#0088cc] to-[#005f99] flex-col items-center justify-center relative overflow-hidden h-screen sticky top-0">

        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-black/10 rounded-full blur-3xl"></div>

        <div class="text-center text-white z-20 mb-8 mt-10 drop-shadow-lg">
            <h1 class="text-4xl xl:text-5xl font-light leading-[1.1] tracking-wide">
                SOLUSI TRENDI<br>
                TERKINI <span class="font-bold">STYLE</span><br>
                ANDALAN ADA<br>
                MASA KINI
            </h1>
        </div>

        <div class="absolute w-[65%] h-[55%] border-2 border-white/30 border-dashed z-0 bottom-16 rounded-xl"></div>

        <div
            class="absolute bottom-0 w-[85%] h-[65%] bg-gradient-to-t from-[#0f172a] to-[#1e293b] rounded-t-[6rem] z-10 shadow-2xl overflow-hidden flex justify-center items-center">
            <div class="absolute inset-0 opacity-20"
                style="background-image: repeating-linear-gradient(45deg, #f97316 0, #f97316 3px, transparent 3px, transparent 24px);">
            </div>
            <div class="absolute inset-0 opacity-10"
                style="background-image: repeating-linear-gradient(-45deg, #3b82f6 0, #3b82f6 3px, transparent 3px, transparent 24px);">
            </div>
        </div>

        <div class="flex gap-8 relative z-20 mt-4 translate-y-12 perspective-1000">
            <div
                class="polaroid-card animate-float-a bg-[#f8f7f2] p-3 pb-8 shadow-[0_20px_50px_rgba(0,0,0,0.5)] w-48 xl:w-56 transition-all duration-500 ease-out cursor-pointer group">
                <div
                    class="absolute -top-3 left-1/2 -translate-x-1/2 w-5 h-5 bg-gradient-to-br from-yellow-300 to-yellow-600 rounded-full shadow-md border border-yellow-200 z-10 group-hover:scale-110 transition-transform">
                    <div class="absolute inset-0.5 bg-gradient-to-tl from-black/20 to-transparent rounded-full"></div>
                </div>
                <div class="overflow-hidden mb-3 border border-gray-200 bg-gray-100">
                    <img src="https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?q=80&w=300&auto=format&fit=crop"
                        alt="Look A"
                        class="w-full h-60 xl:h-72 object-cover object-top transition-transform duration-700 group-hover:scale-110">
                </div>
                <div class="flex justify-between items-end px-2">
                    <p
                        class="text-black font-extrabold text-lg xl:text-xl tracking-tighter group-hover:text-[#0088cc] transition-colors">
                        LOOK A</p>
                    <span class="text-black font-bold text-[10px] xl:text-xs opacity-60">(01)</span>
                </div>
            </div>

            <div
                class="polaroid-card animate-float-b bg-[#f8f7f2] p-3 pb-8 shadow-[0_20px_50px_rgba(0,0,0,0.5)] w-48 xl:w-56 transition-all duration-500 ease-out cursor-pointer group mt-12">
                <div
                    class="absolute -top-3 left-1/2 -translate-x-1/2 w-5 h-5 bg-gradient-to-br from-yellow-300 to-yellow-600 rounded-full shadow-md border border-yellow-200 z-10 group-hover:scale-110 transition-transform">
                    <div class="absolute inset-0.5 bg-gradient-to-tl from-black/20 to-transparent rounded-full"></div>
                </div>
                <div class="overflow-hidden mb-3 border border-gray-200 bg-gray-100">
                    <img src="https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?q=80&w=300&auto=format&fit=crop"
                        alt="Look B"
                        class="w-full h-60 xl:h-72 object-cover object-top transition-transform duration-700 group-hover:scale-110">
                </div>
                <div class="flex justify-between items-end px-2">
                    <p
                        class="text-black font-extrabold text-lg xl:text-xl tracking-tighter group-hover:text-[#0088cc] transition-colors">
                        LOOK B</p>
                    <span class="text-black font-bold text-[10px] xl:text-xs opacity-60">(02)</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
                eyeIcon.classList.add('text-[#0088cc]');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
                eyeIcon.classList.remove('text-[#0088cc]');
            }
        }
    </script>
</body>

</html>
