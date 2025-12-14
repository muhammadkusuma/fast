@extends('layouts.auth')

@section('title', 'Masuk Aplikasi')

@section('content')
    <div class="p-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali</h2>
            <p class="text-gray-500 text-sm mt-2">Silakan masuk untuk mengakses dashboard.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-3 text-sm rounded">
                <p class="font-bold">Gagal Masuk</p>
                <ul class="list-disc pl-4 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="identity" class="block text-sm font-medium text-gray-700 mb-1">
                    NIM atau Email
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input type="text" name="identity" id="identity" required autofocus
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary sm:text-sm placeholder-gray-400 transition"
                        placeholder="Contoh: 1195011xxxx atau admin@uin.ac.id">
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <a href="#" class="text-xs font-medium text-primary hover:text-blue-700">Lupa Password?</a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input type="password" name="password" id="password" required
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary sm:text-sm transition"
                        placeholder="••••••••">
                </div>
                <p class="mt-1 text-xs text-gray-500">*Untuk Alumni, default password adalah Tanggal Lahir (DDMMYYYY)</p>
            </div>

            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox" 
                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-600">
                    Ingat Saya
                </label>
            </div>

            <div>
                <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all transform hover:-translate-y-0.5">
                    Masuk Sekarang
                </button>
            </div>
        </form>
    </div>

    <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex justify-center">
        <p class="text-xs text-gray-500">
            Belum punya akun? <a href="#" class="text-primary font-bold hover:underline">Hubungi Admin Prodi</a>
        </p>
    </div>
@endsection