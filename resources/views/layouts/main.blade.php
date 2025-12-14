<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FAST System') - Tracer Study</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        primary: '#1e40af',
                        /* Blue 800 */
                        secondary: '#f59e0b',
                        /* Amber 500 */
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased leading-normal tracking-normal text-gray-800">

    {{-- LOGIKA PHP UNTUK MENENTUKAN USER DAN GUARD --}}
    @php
        $currentUser = null;
        $userName = 'Tamu';
        $userInitial = 'T';
        $dashboardRoute = '#';
        $profileRoute = '#';

        // 1. Cek jika Login sebagai ALUMNI
        if (Auth::guard('alumni')->check()) {
            // PENTING: Tetap gunakan ->user() meskipun modelnya Alumni
            $currentUser = Auth::guard('alumni')->user();

            // Ambil kolom 'nama' (sesuai tabel alumni)
            $userName = $currentUser->nama_lengkap ?? 'Alumni';

            // Set Route
            $dashboardRoute = route('alumni.dashboard');
            $profileRoute = route('alumni.profil'); // Pastikan route ini ada
        }

        // 2. Cek jika Login sebagai ADMIN (Web)
        elseif (Auth::guard('web')->check()) {
            $currentUser = Auth::guard('web')->user();

            // Ambil kolom 'name' (standar tabel users)
            $userName = $currentUser->name ?? 'Admin';

            // Set Route
            $dashboardRoute = '/dashboard';
            $profileRoute = '#'; // Atau route profile admin jika ada
        }

        // Ambil inisial huruf depan untuk avatar
        if ($currentUser) {
            $userInitial = strtoupper(substr($userName, 0, 1));
        }
    @endphp

    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
            class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

        <aside :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
            class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-white border-r border-gray-200 lg:translate-x-0 lg:static lg:inset-0 shadow-lg lg:shadow-none">

            <div class="flex items-center justify-center h-16 bg-primary text-white shadow-md">
                <div class="flex items-center gap-2 font-bold text-xl tracking-wider">
                    <span class="bg-white text-primary px-2 rounded">FAST</span> SYSTEM
                </div>
            </div>

            <nav class="mt-5 px-4 space-y-2">

                <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>

                {{-- Link Dashboard Dinamis --}}
                <a href="{{ $dashboardRoute }}"
                    class="flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg group hover:bg-blue-50 hover:text-primary transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                {{-- Tempat Inject Menu Tambahan dari View Lain --}}
                @yield('sidebar-menu')

                <div class="border-t border-gray-200 my-4"></div>

                {{-- Tombol Logout --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="font-medium">Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        <div class="flex flex-col flex-1 overflow-hidden">

            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true"
                        class="text-gray-500 focus:outline-none lg:hidden hover:text-primary">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <h2 class="text-xl font-semibold text-gray-800 ml-4 lg:ml-0">
                        @yield('header', 'Halaman Utama')
                    </h2>
                </div>

                <div class="flex items-center gap-4">
                    <button class="text-gray-400 hover:text-primary relative">
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </button>

                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center space-x-2 focus:outline-none">
                            <div
                                class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm uppercase">
                                {{ $userInitial }}
                            </div>
                            <span class="hidden md:block text-sm font-medium text-gray-700">
                                {{ $userName }}
                            </span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-cloak
                            class="absolute right-0 w-48 mt-2 bg-white rounded-md shadow-xl py-1 border border-gray-100 z-50">

                            <a href="{{ $profileRoute }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profil Saya
                            </a>

                            {{-- Jika ingin menambah menu setting --}}
                            {{-- <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a> --}}

                            <div class="border-t border-gray-100 my-1"></div>

                            {{-- Logout via Dropdown --}}
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm"
                        role="alert">
                        <p class="font-bold">Berhasil</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm"
                        role="alert">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
