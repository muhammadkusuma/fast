@extends('layouts.main')

@section('title', 'Dashboard Alumni')
@section('header', 'Dashboard')

@section('sidebar-menu')
    <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Aktivitas</p>
    
    <a href="{{ route('alumni.profil') }}" class="flex items-center px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-primary rounded-lg transition-colors">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        Biodata Saya
    </a>
    
    <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-primary rounded-lg transition-colors">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        Isi Tracer Study
    </a>

    <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-primary rounded-lg transition-colors">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
        Prestasi
    </a>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border-l-4 border-primary">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Halo, Wira Ade Kusuma! 👋</h1>
                <p class="text-gray-600 mt-1">Selamat datang di Sistem Tracer Study UIN Suska Riau.</p>
            </div>
            <div class="hidden md:block">
                <span class="bg-blue-100 text-primary px-4 py-1 rounded-full text-sm font-semibold">Alumni 2024</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 mt-4 mr-4 w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Status Tracer</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">Belum Mengisi</p>
            <div class="mt-4">
                <a href="#" class="text-sm font-semibold text-red-500 hover:text-red-700 flex items-center">
                    Isi Sekarang <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 mt-4 mr-4 w-12 h-12 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Kelengkapan Data</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">80%</p>
            
            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-4">
                <div class="bg-yellow-500 h-1.5 rounded-full" style="width: 80%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-1">Segera lengkapi NPWP & Alamat</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 mt-4 mr-4 w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
            </div>
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Prestasi Anda</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">2 Prestasi</p>
            <div class="mt-4 flex gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                    1 Valid
                </span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                    1 Pending
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="font-bold text-gray-800">Info & Jadwal Tracer Study</h3>
        </div>
        <div class="p-6">
            <ol class="relative border-l border-gray-200 ml-3">                  
                <li class="mb-10 ml-6">            
                    <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white">
                        <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </span>
                    <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">Periode Pengisian Dibuka</h3>
                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400">Dimulai 1 November 2025</time>
                    <p class="mb-4 text-base font-normal text-gray-500">Seluruh alumni angkatan 2024 wajib mengisi kuesioner tracer study sebagai syarat legalisir ijazah.</p>
                </li>
                <li class="mb-10 ml-6">
                    <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full -left-3 ring-8 ring-white">
                        <svg class="w-3 h-3 text-gray-800" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                    </span>
                    <h3 class="mb-1 text-lg font-semibold text-gray-900">Batas Akhir Pengisian</h3>
                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400">Berakhir 31 Desember 2025</time>
                </li>
            </ol>
        </div>
    </div>
@endsection