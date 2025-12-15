@extends('layouts.main')

@section('title', 'Dashboard Alumni')
@section('header', 'Dashboard')

@section('sidebar-menu')
    <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Aktivitas</p>

    {{-- Menu Biodata --}}
    <a href="{{ route('alumni.profil') }}"
        class="flex items-center px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-primary rounded-lg transition-colors {{ request()->routeIs('alumni.profil') ? 'bg-blue-50 text-primary font-semibold' : '' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Biodata Saya
    </a>

    {{-- Menu Tracer Study --}}
    @php
        $statusTracerSidebar = false;
        if (Auth::guard('alumni')->check()) {
            $statusTracerSidebar = \App\Models\TracerMain::where('id_alumni', Auth::guard('alumni')->id())
                ->where('tahun_tracer', date('Y'))
                ->exists();
        }
    @endphp

    <a href="{{ $statusTracerSidebar ? '#' : route('alumni.tracer.create') }}"
        class="flex items-center px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-primary rounded-lg transition-colors {{ request()->routeIs('alumni.tracer.*') ? 'bg-blue-50 text-primary font-semibold' : '' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
            </path>
        </svg>
        {{ $statusTracerSidebar ? 'Data Tracer Anda' : 'Isi Tracer Study' }}

        @if ($statusTracerSidebar)
            <span class="ml-auto text-green-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </span>
        @endif
    </a>

    {{-- Menu Prestasi --}}
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

    {{-- HEADER SAMBUTAN --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border-l-4 border-primary">
        <div class="flex items-center justify-between">
            <div>
                {{-- PERBAIKAN: Menggunakan nama_lengkap sesuai tabel m_alumni --}}
                <h1 class="text-2xl font-bold text-gray-800">Halo, {{ $alumni->nama_lengkap ?? 'Alumni' }}! 👋</h1>
                <p class="text-gray-600 mt-1">Selamat datang di Sistem Tracer Study UIN Suska Riau.</p>
            </div>
            <div class="hidden md:block">
                <span class="bg-blue-100 text-primary px-4 py-1 rounded-full text-sm font-semibold">
                    Alumni {{ $alumni->tahun_lulus ?? date('Y') }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- CARD 1: STATUS TRACER --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 mt-4 mr-4 w-12 h-12 {{ $sudahIsiTracer ? 'bg-green-100 text-green-500' : 'bg-red-100 text-red-500' }} rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                @if ($sudahIsiTracer)
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                @else
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

        {{-- CARD 2: KELENGKAPAN DATA --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 mt-4 mr-4 w-12 h-12 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Kelengkapan Data</h3>

            {{-- Angka ini dihitung di Controller berdasarkan NIK, No HP, Email, Domisili --}}
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($persentaseProfil, 0) }}%</p>

            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-4">
                <div class="bg-yellow-500 h-1.5 rounded-full" style="width: {{ $persentaseProfil }}%"></div>
            </div>

            @if ($persentaseProfil < 100)
                <p class="text-xs text-gray-500 mt-1">Segera lengkapi Biodata Anda</p>
            @else
                <p class="text-xs text-green-500 mt-1">Data Profil Lengkap</p>
            @endif
        </div>

        {{-- CARD 3: PRESTASI --}}
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

            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $alumni->prestasi->count() ?? 0 }} Prestasi</p>

            <div class="mt-4 flex gap-2">
                @if (($alumni->prestasi->count() ?? 0) > 0)
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                        Terdata
                    </span>
                @else
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                        Belum ada data
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- BAGIAN PENGUMUMAN --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Papan Pengumuman & Informasi</h3>
            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Terbaru</span>
        </div>
        <div class="p-6">
            @if ($announcements->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p>Belum ada pengumuman saat ini.</p>
                </div>
            @else
                <ol class="relative border-l border-gray-200 ml-3">
                    @foreach ($announcements as $info)
                        <li class="mb-10 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white">
                                <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">
                                {{ $info->judul }}
                            </h3>
                            <time class="block mb-2 text-sm font-normal leading-none text-gray-400">
                                {{ $info->created_at->format('d F Y, H:i') }} WIB
                            </time>
                            <div
                                class="mb-4 text-base font-normal text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                {!! nl2br(e($info->isi)) !!}
                            </div>
                        </li>
                    @endforeach
                </ol>
            @endif
        </div>
    </div>
@endsection
