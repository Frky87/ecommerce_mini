<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Marketqu</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Animasi mengambang untuk foto polaroid */
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
<!-- Hapus h-screen dan overflow-hidden agar bisa di-scroll saat zoom 250% -->

<body class="bg-white font-sans min-h-screen flex flex-col lg:flex-row selection:bg-[#0088cc] selection:text-white">

    <!-- BAGIAN KIRI (Form Login) - Bisa di-scroll jika layar terlalu kecil akibat zoom -->
    <div class="w-full lg:w-1/2 flex flex-col px-6 sm:px-12 md:px-24 lg:px-32 relative bg-gray-50/30 min-h-screen">

        <!-- Logo (Dibuat relative / masuk ke flow normal agar tidak menabrak form saat di-zoom) -->
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

        <!-- Form Container (Flex-grow agar terdorong ke tengah) -->
        <div class="flex-grow flex flex-col justify-center w-full max-w-sm mx-auto py-8">
            <h2 class="text-2xl font-extrabold mb-8 text-gray-800 relative inline-block w-max">
                Sign in
                <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-[#0088cc] rounded-full"></span>
            </h2>

            @if ($errors->any())
                <div
                    class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm border border-red-200 flex items-start gap-3 animate-pulse">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Input Username / Email -->
                <div class="mb-5 relative group">
                    <div
                        class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 group-focus-within:text-[#0088cc] transition-colors duration-300">
                        <i class="fa-regular fa-envelope text-lg"></i>
                    </div>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Email Address *"
                        class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-[#0088cc] focus:ring-4 focus:ring-[#0088cc]/10 text-sm transition-all duration-300 shadow-sm hover:border-gray-400"
                        required>
                </div>

                <!-- Input Password dengan Ikon Mata -->
                <div class="mb-8 relative group">
                    <div
                        class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 group-focus-within:text-[#0088cc] transition-colors duration-300">
                        <i class="fa-solid fa-lock text-lg"></i>
                    </div>

                    <input type="password" id="password" name="password" placeholder="Password *"
                        class="w-full pl-12 pr-12 py-3.5 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-[#0088cc] focus:ring-4 focus:ring-[#0088cc]/10 text-sm transition-all duration-300 shadow-sm hover:border-gray-400"
                        required>

                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-[#0088cc] focus:outline-none transition-colors duration-300 cursor-pointer">
                        <i class="fa-regular fa-eye text-lg" id="eyeIcon"></i>
                    </button>
                </div>

                <!-- Tombol Login & Lupa Password -->
                <div class="flex items-center justify-between mb-10 gap-4 flex-wrap">
                    <button type="submit"
                        class="bg-[#0088cc] text-white px-8 py-3 rounded-lg text-sm font-bold hover:bg-blue-600 transition-all duration-300 flex items-center gap-3 shadow-md hover:shadow-xl hover:-translate-y-1 group">
                        LOGIN
                        <i
                            class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1.5"></i>
                    </button>
                    <a href="#"
                        class="text-xs font-bold text-gray-500 hover:text-[#0088cc] transition-colors duration-300 underline underline-offset-4 decoration-transparent hover:decoration-[#0088cc]">Forgot
                        your password?</a>
                </div>
            </form>

            <!-- Divider Or Login With -->
            <div class="flex items-center gap-4 mb-8">
                <hr class="flex-1 border-gray-200">
                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Or login with</span>
                <hr class="flex-1 border-gray-200">
            </div>

            <!-- Tombol Google -->
            <button
                class="w-full bg-white border border-gray-200 text-gray-700 py-3 rounded-lg flex justify-center items-center gap-3 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 mb-8 shadow-sm hover:shadow-md hover:-translate-y-0.5">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google"
                    class="w-5 h-5">
                <span class="font-bold text-sm">Continue with Google</span>
            </button>
        </div>

        <!-- Register (Ditaruh di bawah flow form) -->
        <div class="text-center pb-8 pt-4">
            <span class="text-sm text-gray-500">Don't have an account? </span>
            <a href="#"
                class="text-gray-800 font-extrabold text-sm hover:text-[#0088cc] transition-colors duration-300 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-gray-800 hover:after:bg-[#0088cc]">Register</a>
        </div>
    </div>

    <!-- BAGIAN KANAN (Banner Biru & Foto Polaroid) - Dibuat Sticky agar tidak bergeser saat sisi kiri di-scroll -->
    <div
        class="hidden lg:flex w-1/2 bg-gradient-to-br from-[#0088cc] to-[#005f99] flex-col items-center justify-center relative overflow-hidden h-screen sticky top-0">

        <!-- Lingkaran Dekorasi Background -->
        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-black/10 rounded-full blur-3xl"></div>

        <!-- Teks Slogan -->
        <div class="text-center text-white z-20 mb-8 mt-10 drop-shadow-lg">
            <h1 class="text-4xl xl:text-5xl font-light leading-[1.1] tracking-wide">
                SOLUSI TRENDI<br>
                TERKINI <span class="font-bold">STYLE</span><br>
                ANDALAN ADA<br>
                MASA KINI
            </h1>
        </div>

        <!-- Frame Dekorasi Garis Putih Putus-putus -->
        <div class="absolute w-[65%] h-[55%] border-2 border-white/30 border-dashed z-0 bottom-16 rounded-xl"></div>

        <!-- Dekorasi Background Baju Abstrak -->
        <div
            class="absolute bottom-0 w-[85%] h-[65%] bg-gradient-to-t from-[#0f172a] to-[#1e293b] rounded-t-[6rem] z-10 shadow-2xl overflow-hidden flex justify-center items-center">
            <div class="absolute inset-0 opacity-20"
                style="background-image: repeating-linear-gradient(45deg, #f97316 0, #f97316 3px, transparent 3px, transparent 24px);">
            </div>
            <div class="absolute inset-0 opacity-10"
                style="background-image: repeating-linear-gradient(-45deg, #3b82f6 0, #3b82f6 3px, transparent 3px, transparent 24px);">
            </div>
        </div>

        <!-- Gambar Polaroid Interaktif -->
        <div class="flex gap-8 relative z-20 mt-4 translate-y-12 perspective-1000">
            <!-- Look A -->
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

            <!-- Look B -->
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

    <!-- Script JavaScript untuk fungsi Show/Hide Password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    </script>
</body>

</html>
