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

    <!-- Memanggil Sidebar Admin -->
    @include('layouts.admin-sidebar')

    <main class="flex-1 flex flex-col h-full overflow-hidden relative w-full">
        <!-- Memanggil Topbar Admin -->
        @include('layouts.admin-topbar')

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 w-full">
            @yield('content')
        </div>
    </main>

    <!-- Memanggil Modal Logout -->
    @include('layouts.modal-logout')

</body>

</html>
