@extends('layouts.main')

@section('title', 'Dashboard Alumni')
@section('header', 'Dashboard')

@section('sidebar-menu')
    <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Aktivitas</p>

    <a href="{{ route('alumni.profil') }}"
        class="flex items-center px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-primary rounded-lg transition-colors">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Biodata Saya
    </a>

    @php
        // Logika Cek Status Tracer (Langsung di View)
        // Agar variabel ini tersedia meskipun kita sedang membuka halaman Profil atau lainnya
        $statusTracer = false;

        if (Auth::guard('alumni')->check()) {
            $statusTracer = \App\Models\TracerMain::where('id_alumni', Auth::guard('alumni')->id())
                ->where('tahun_tracer', date('Y'))
                ->exists();
        }
    @endphp

    <a href="{{ $statusTracer ? '#' : route('alumni.tracer.create') }}"
        class="flex items-center px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-primary rounded-lg transition-colors {{ request()->routeIs('alumni.tracer.*') ? 'bg-blue-50 text-primary font-semibold' : '' }}">

        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
            </path>
        </svg>

        {{-- Ubah Teks Menu --}}
        {{ $statusTracer ? 'Data Tracer Anda' : 'Isi Tracer Study' }}

        {{-- Opsional: Tambahkan Badge Centang jika sudah --}}
        @if ($statusTracer)
            <span class="ml-auto text-green-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </span>
        @endif
    </a>

    <a href="#"
        class="flex items-center px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-primary rounded-lg transition-colors">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
            </path>
        </svg>
        Prestasi
    </a>
@endsection

@section('content')
    {{-- Notifikasi Flash Message (Opsional, jika ada redirect success/error) --}}
    {{-- @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif --}}

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border-l-4 border-primary">
        <div class="flex items-center justify-between">
            <div>
                {{-- MENGAMBIL DATA NAMA ALUMNI --}}
                <h1 class="text-2xl font-bold text-gray-800">Halo, {{ $alumni->nama ?? 'Alumni' }}! 👋</h1>
                <p class="text-gray-600 mt-1">Selamat datang di Sistem Tracer Study UIN Suska Riau.</p>
            </div>
            <div class="hidden md:block">
                {{-- MENGAMBIL TAHUN LULUS (Pastikan ada kolom tahun_lulus atau angkatan di tabel alumni) --}}
                <span class="bg-blue-100 text-primary px-4 py-1 rounded-full text-sm font-semibold">
                    Alumni {{ $alumni->tahun_lulus ?? date('Y') }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- CARD STATUS TRACER STUDY --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 mt-4 mr-4 w-12 h-12 {{ $sudahIsiTracer ? 'bg-green-100 text-green-500' : 'bg-red-100 text-red-500' }} rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                @if ($sudahIsiTracer)
                    {{-- Icon Checklist jika sudah --}}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                @else
                    {{-- Icon X / Warning jika belum --}}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @endif
            </div>

            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Status Tracer ({{ date('Y') }})</h3>

            <p class="text-2xl font-bold {{ $sudahIsiTracer ? 'text-green-600' : 'text-gray-800' }} mt-1">
                {{ $sudahIsiTracer ? 'Sudah Mengisi' : 'Belum Mengisi' }}
            </p>

            <div class="mt-4">
                @if (!$sudahIsiTracer)
                    {{-- Link diarahkan ke route alumni.tracer.create --}}
                    <a href="{{ route('alumni.tracer.create') }}"
                        class="text-sm font-semibold text-red-500 hover:text-red-700 flex items-center">
                        Isi Sekarang <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                @else
                    <span class="text-sm font-semibold text-green-500 flex items-center">
                        Terima Kasih <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </span>
                @endif
            </div>
        </div>

        {{-- CARD KELENGKAPAN DATA --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 mt-4 mr-4 w-12 h-12 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Kelengkapan Data</h3>

            {{-- DATA PERSENTASE DARI CONTROLLER --}}
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $persentaseProfil }}%</p>

            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-4">
                <div class="bg-yellow-500 h-1.5 rounded-full" style="width: {{ $persentaseProfil }}%"></div>
            </div>

            @if ($persentaseProfil < 100)
                <p class="text-xs text-gray-500 mt-1">Segera lengkapi Biodata Anda</p>
            @else
                <p class="text-xs text-green-500 mt-1">Data Profil Lengkap</p>
            @endif
        </div>

        {{-- CARD PRESTASI --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 mt-4 mr-4 w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                    </path>
                </svg>
            </div>
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Prestasi Anda</h3>

            {{-- Jika belum ada fitur prestasi, biarkan hardcoded atau buat dinamis nanti --}}
            <p class="text-2xl font-bold text-gray-800 mt-1">0 Prestasi</p>

            <div class="mt-4 flex gap-2">
                {{-- Placeholder status --}}
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                    Belum ada data
                </span>
            </div>
        </div>
    </div>

    {{-- BAGIAN JADWAL (Biasanya Static atau dari Table Config) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="font-bold text-gray-800">Info & Jadwal Tracer Study</h3>
        </div>
        <div class="p-6">
            <ol class="relative border-l border-gray-200 ml-3">
                <li class="mb-10 ml-6">
                    <span
                        class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white">
                        <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">Periode Pengisian Dibuka</h3>
                    {{-- Contoh tanggal dinamis --}}
                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400">Tahun
                        {{ date('Y') }}</time>
                    <p class="mb-4 text-base font-normal text-gray-500">Seluruh alumni angkatan {{ date('Y') - 1 }} wajib
                        mengisi kuesioner tracer study sebagai syarat legalisir ijazah.</p>
                </li>
                <li class="mb-10 ml-6">
                    <span
                        class="absolute flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full -left-3 ring-8 ring-white">
                        <svg class="w-3 h-3 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <h3 class="mb-1 text-lg font-semibold text-gray-900">Batas Akhir Pengisian</h3>
                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400">Desember
                        {{ date('Y') }}</time>
                </li>
            </ol>
        </div>
    </div>
@endsection
