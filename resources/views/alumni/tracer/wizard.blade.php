@extends('layouts.main')

@section('title', 'Isi Tracer Study')

@section('content')
    @php
        // Ambil data user yang sedang login
        $alumni = Auth::guard('alumni')->user();
        // Pastikan relasi prodi diload agar tidak error saat memanggil nama prodi
        if ($alumni && !$alumni->relationLoaded('prodi')) {
            $alumni->load('prodi');
        }
    @endphp

    <div x-data="tracerWizard()" class="max-w-6xl mx-auto pb-20 pt-6 px-4 sm:px-6">

        {{-- HEADER --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Tracer Study {{ date('Y') }}</h1>
            <p class="text-gray-500 mt-2">Lengkapi data di bawah ini untuk membantu kami meningkatkan kualitas pendidikan.
            </p>
        </div>

        {{-- PROGRESS INDICATOR --}}
        <div class="mb-12">
            <div class="relative">
                {{-- Garis Background --}}
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 rounded-full -z-10">
                </div>
                {{-- Garis Progress Berwarna --}}
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-blue-600 rounded-full -z-10 transition-all duration-500 ease-out"
                    :style="'width: ' + ((currentStep - 1) / (steps.length - 1) * 100) + '%'"></div>

                <div class="flex justify-between w-full">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex flex-col items-center group cursor-default">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-4 border-white shadow-sm"
                                :class="currentStep > index + 1 ? 'bg-green-500 text-white' : (currentStep === index + 1 ?
                                    'bg-blue-600 text-white shadow-lg scale-110 ring-2 ring-blue-100' :
                                    'bg-gray-200 text-gray-500')">
                                {{-- Angka atau Centang --}}
                                <span x-show="currentStep <= index + 1" x-text="index + 1"></span>
                                <svg x-show="currentStep > index + 1" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold mt-2 hidden sm:block transition-colors duration-300"
                                :class="currentStep >= index + 1 ? 'text-gray-800' : 'text-gray-400'" x-text="step"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- FORM CONTAINER --}}
        <form action="{{ route('alumni.tracer.store') }}" method="POST" @submit.prevent="submitForm"
            class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden relative min-h-[500px]">
            @csrf

            {{-- ========================================================================
             STEP 1: DATA PRIBADI (SECTION A)
             ======================================================================== --}}
            <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-10" class="p-8 space-y-8">

                {{-- INFO ALERT --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Data identitas (NIM, Nama, Prodi) diambil dari database. Silakan lengkapi data kontak dan
                                domisili terbaru Anda.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- SECTION 1: IDENTITAS AKADEMIK (READ ONLY) --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <div class="p-2 bg-indigo-100 rounded-lg mr-3 text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            Identitas Akademik
                        </h3>
                        <span
                            class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full border border-green-200">
                            Terverifikasi
                        </span>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Data ini diambil otomatis dari sistem akademik. Jika ada kesalahan, silakan hubungi
                                        BAAK.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                            {{-- Nama Lengkap --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                                <div class="relative">
                                    <input type="text" name="q1_nama" x-model="formData.q1_nama"
                                        class="w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-600 font-semibold cursor-not-allowed focus:ring-0 select-none shadow-sm"
                                        readonly disabled>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- NIM --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">NIM</label>
                                <div class="relative">
                                    <input type="text" x-model="formData.q2_nim"
                                        class="w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-600 font-medium cursor-not-allowed focus:ring-0 shadow-sm"
                                        readonly disabled>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Angkatan / Tahun Masuk --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tahun Masuk</label>
                                <div class="relative">
                                    <input type="text" name="q2_angkatan" x-model="formData.q2_angkatan"
                                        class="w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-600 font-medium cursor-not-allowed focus:ring-0 shadow-sm"
                                        readonly disabled>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Program Studi --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Program Studi</label>
                                <div class="relative">
                                    <input type="text" name="q3_prodi" x-model="formData.q3_prodi"
                                        class="w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-600 font-medium cursor-not-allowed focus:ring-0 shadow-sm"
                                        readonly disabled>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- SECTION 2: KONTAK & DOMISILI (EDITABLE) --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3 text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                            </div>
                            Kontak & Domisili Saat Ini
                        </h3>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                            <div class="md:col-span-2 mb-2">
                                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Informasi
                                    Kontak</h4>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Aktif <span
                                        class="text-red-500">*</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="email" name="q10b_email" x-model="formData.q10b_email"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none text-gray-800 placeholder-gray-400 sm:text-sm shadow-sm"
                                        placeholder="email@contoh.com">
                                </div>
                            </div>

                            {{-- No HP --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No HP (WhatsApp) <span
                                        class="text-red-500">*</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="text" name="q10a_no_hp" x-model="formData.q10a_no_hp"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all duration-200 outline-none text-gray-800 placeholder-gray-400 sm:text-sm shadow-sm"
                                        placeholder="0812...">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Pastikan nomor terhubung dengan WhatsApp.</p>
                            </div>

                            <div class="md:col-span-2 border-t border-gray-100 my-2"></div>

                            <div class="md:col-span-2 mb-2">
                                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Data Akademik
                                </h4>
                            </div>

                            {{-- IPK --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">IPK Terakhir <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" step="0.01" min="1"max="4" name="q4_ipk"
                                        x-model="formData.q4_ipk"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none sm:text-sm shadow-sm"
                                        placeholder="0.00" disabled>
                                </div>
                            </div>

                            {{-- Tanggal Lulus --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lulus (Ijazah) <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="q5_tanggal_lulus" x-model="formData.q5_tanggal_lulus"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none sm:text-sm shadow-sm text-gray-700">
                            </div>

                            <div class="md:col-span-2 border-t border-gray-100 my-2"></div>

                            <div class="md:col-span-2 mb-2">
                                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Lokasi Tempat
                                    Tinggal</h4>
                            </div>

                            {{-- Alamat --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap Domisili <span
                                        class="text-red-500">*</span></label>
                                <textarea name="q6_alamat" x-model="formData.q6_alamat" rows="2"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none sm:text-sm shadow-sm"
                                    placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan, Kecamatan..."></textarea>
                            </div>

                            {{-- Provinsi --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="q7_provinsi" x-model="formData.q7_provinsi" @change="loadKabupaten()"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none sm:text-sm shadow-sm bg-white appearance-none cursor-pointer">
                                        <option value="">-- Pilih Provinsi --</option>
                                        <template x-for="p in listProvinsi">
                                            <option :value="p" x-text="p"></option>
                                        </template>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Kabupaten --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="q9_kabupaten" x-model="formData.q9_kabupaten"
                                        :disabled="!formData.q7_provinsi"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none sm:text-sm shadow-sm bg-white appearance-none disabled:bg-gray-100 disabled:text-gray-400 cursor-pointer disabled:cursor-not-allowed">
                                        <option value="">-- Pilih Kota --</option>
                                        <template x-for="k in listKabupaten">
                                            <option :value="k" x-text="k"></option>
                                        </template>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Kode Pos --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="q8_kodepos" x-model="formData.q8_kodepos"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none sm:text-sm shadow-sm"
                                    placeholder="Contoh: 12345">
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span
                                        class="text-red-500">*</span></label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="q11_jenis_kelamin" value="Laki-laki"
                                            x-model="formData.q11_jenis_kelamin" class="peer sr-only">
                                        <div
                                            class="p-3 rounded-lg border border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 transition-all flex items-center justify-center text-gray-600 peer-checked:text-blue-700 font-medium text-sm">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            Laki-laki
                                        </div>
                                        <div
                                            class="absolute top-0 right-0 -mt-2 -mr-2 bg-blue-500 text-white rounded-full p-0.5 hidden peer-checked:block shadow-sm">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="q11_jenis_kelamin" value="Perempuan"
                                            x-model="formData.q11_jenis_kelamin" class="peer sr-only">
                                        <div
                                            class="p-3 rounded-lg border border-gray-200 peer-checked:border-pink-500 peer-checked:bg-pink-50 hover:bg-gray-50 transition-all flex items-center justify-center text-gray-600 peer-checked:text-pink-700 font-medium text-sm">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            Perempuan
                                        </div>
                                        <div
                                            class="absolute top-0 right-0 -mt-2 -mr-2 bg-pink-500 text-white rounded-full p-0.5 hidden peer-checked:block shadow-sm">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- SECTION 3: STATUS (HIGHLIGHT) --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100 shadow-sm">
                    <label class="block text-blue-900 font-bold mb-2 text-lg">Status Aktivitas Saat Ini *</label>
                    <p class="text-sm text-blue-600 mb-3">Pilih aktivitas utama yang sedang Anda lakukan saat ini.</p>
                    <div class="relative">
                        <select name="status_aktivitas" x-model="formData.status_bekerja"
                            class="w-full rounded-lg border-blue-300 focus:ring-blue-500 focus:border-blue-500 p-3 text-base shadow-sm">
                            <option value="">-- Pilih Status --</option>
                            <option value="Bekerja (Full Time/Part Time)">Bekerja (Full Time/Part Time)</option>
                            <option value="Wiraswasta">Wiraswasta</option>
                            <option value="Melanjutkan Pendidikan">Melanjutkan Pendidikan</option>
                            <option value="Tidak Bekerja">Sedang Mencari Kerja / Tidak Bekerja</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ========================================================================
             STEP 2: PEKERJAAN (SECTION B)
             ======================================================================== --}}
            <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
                class="p-8 space-y-6">

                {{-- Logic Kondisional --}}
                <div x-show="!isBekerja()" class="flex flex-col items-center justify-center py-16 text-center space-y-4">
                    <div class="bg-blue-100 p-4 rounded-full">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-medium text-gray-800">Bagian ini tidak perlu diisi</h3>
                        <p class="text-gray-500 mt-1 max-w-md mx-auto">Karena Anda memilih status "<span
                                x-text="formData.status_bekerja" class="font-bold text-blue-600"></span>", silakan
                            langsung klik tombol Lanjut.</p>
                    </div>
                </div>

                <div x-show="isBekerja()" class="space-y-6">
                    <div class="border-l-4 border-blue-500 pl-4 mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Detail Pekerjaan</h2>
                        <p class="text-gray-500 text-sm">Informasi mengenai tempat kerja Anda saat ini.</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                                <div class="p-2 bg-orange-100 rounded-lg mr-3 text-orange-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                Informasi Pekerjaan
                            </h3>
                        </div>

                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                                <div class="md:col-span-2 mb-2">
                                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Data
                                        Instansi / Perusahaan</h4>
                                    <hr class="border-gray-100">
                                </div>

                                {{-- Jenis Instansi --}}
                                <div class="md:col-span-2" x-data="{ openLainnya: false }">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Instansi / Perusahaan
                                        <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select name="jenis_instansi" x-model="formData.q12_jenis_perusahaan"
                                            @change="openLainnya = (formData.q12_jenis_perusahaan === 'Lainnya')"
                                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-200 outline-none sm:text-sm shadow-sm bg-white cursor-pointer appearance-none">
                                            <option value="">-- Pilih Jenis Instansi --</option>
                                            <option value="Instansi Pemerintah">Instansi Pemerintah</option>
                                            <option value="BUMN/BUMD">BUMN/BUMD</option>
                                            <option value="Swasta Nasional">Institusi/Swasta Nasional</option>
                                            <option value="Wiraswasta">Wiraswasta</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <div x-show="formData.q12_jenis_perusahaan === 'Lainnya'"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                                        x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-3">
                                        <label class="block text-xs text-gray-500 mb-1 ml-1">Sebutkan jenis instansi
                                            lainnya:</label>
                                        <input type="text" name="q12a_pekerjaan_lainnya"
                                            class="w-full px-4 py-2.5 rounded-lg border border-orange-200 bg-orange-50 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all outline-none sm:text-sm"
                                            placeholder="Contoh: NGO, Yayasan Internasional, dll...">
                                    </div>
                                </div>

                                {{-- Nama Perusahaan --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan / Kantor
                                        <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="text" name="nama_perusahaan" x-model="formData.q13a_nama_kantor"
                                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-200 outline-none sm:text-sm shadow-sm"
                                            placeholder="PT. Mencari Cinta Sejati">
                                    </div>
                                </div>

                                {{-- Provinsi Kerja --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi Tempat Kerja <span
                                            class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <select name="provinsi" x-model="formData.provinsi_kerja"
                                            class="w-full pl-10 pr-8 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-200 outline-none sm:text-sm shadow-sm bg-white appearance-none cursor-pointer">
                                            <option value="">-- Pilih Provinsi --</option>
                                            <template x-for="p in listProvinsi">
                                                <option :value="p" x-text="p"></option>
                                            </template>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-2 mt-4 mb-2">
                                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Detail &
                                        Keselarasan</h4>
                                    <hr class="border-gray-100">
                                </div>

                                {{-- Penghasilan --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rata-rata Penghasilan/Bulan
                                        <span class="text-red-500">*</span></label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 font-bold sm:text-sm">Rp</span>
                                        </div>
                                        <input type="text" name="gaji" x-model="formData.q19_penghasilan"
                                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all duration-200 outline-none sm:text-sm"
                                            placeholder="0">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 sm:text-xs">/ bulan</span>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-[11px] text-gray-400">Isi dengan angka saja tanpa titik/koma
                                        (Contoh: 5000000)</p>
                                </div>

                                {{-- Keselarasan --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Keselarasan Horizontal
                                        <span class="text-red-500">*</span></label>
                                    <div class="relative group">
                                        <div
                                            class="absolute -top-8 right-0 hidden group-hover:block bg-gray-800 text-white text-xs px-2 py-1 rounded shadow-lg transition-opacity">
                                            Hubungan studi dengan pekerjaan
                                        </div>

                                        <select name="keselarasan" x-model="formData.keselarasan"
                                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-200 outline-none sm:text-sm shadow-sm bg-white appearance-none cursor-pointer">
                                            <option value="">-- Seberapa Erat? --</option>
                                            <option value="Sangat Erat">Sangat Erat</option>
                                            <option value="Erat">Erat</option>
                                            <option value="Cukup Erat">Cukup Erat</option>
                                            <option value="Kurang Erat">Kurang Erat</option>
                                            <option value="Tidak Sama Sekali">Tidak Sama Sekali</option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-[11px] text-gray-500 flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Seberapa sesuai bidang studi dengan pekerjaan Anda?
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Selalu Tampil: Riwayat Pencarian Kerja (Semua Alumni Wajib Isi) --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <div class="p-2 bg-purple-100 rounded-lg mr-3 text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            Riwayat Pencarian Kerja
                        </h3>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kapan mulai mencari kerja?
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="waktu_mencari" x-model="formData.waktu_mencari"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200 outline-none sm:text-sm shadow-sm bg-white appearance-none cursor-pointer">
                                        <option value="">-- Pilih Waktu --</option>
                                        <option value="Sebelum Lulus">Sebelum Lulus (Curistart)</option>
                                        <option value="Sesudah Lulus">Sesudah Lulus</option>
                                        <option value="Tidak Mencari">Saya tidak mencari kerja</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Masa Tunggu Mendapat Kerja
                                    <span class="text-red-500">*</span></label>
                                <div class="relative flex rounded-lg shadow-sm">
                                    <input type="number" name="waktu_tunggu" x-model="formData.waktu_tunggu"
                                        class="w-full px-4 py-2.5 rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200 outline-none sm:text-sm z-10"
                                        placeholder="0" min="0">
                                    <div
                                        class="inline-flex items-center px-4 rounded-r-lg border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm font-medium select-none">
                                        Bulan
                                    </div>
                                </div>
                                <p class="mt-1 text-[11px] text-gray-400">


                                    [Image of hourglass]
                                    Dihitung sejak tanggal lulus ijazah hingga diterima kerja.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Jumlah Lamaran <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="number" name="jumlah_lamaran" x-model="formData.jumlah_lamaran"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200 outline-none sm:text-sm shadow-sm"
                                        placeholder="Contoh: 5, 10, 50..." min="0">
                                </div>
                                <p class="mt-1 text-[11px] text-gray-400">Total lamaran yang dikirim via Email, Pos, atau
                                    Jobstreet/Linkedin.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sumber Info Lowongan <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="sumber_info" x-model="formData.sumber_info"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200 outline-none sm:text-sm shadow-sm bg-white appearance-none cursor-pointer">
                                        <option value="">-- Darimana Anda tahu? --</option>
                                        <option value="Media Sosial">Media Sosial (IG, FB, LinkedIn)</option>
                                        <option value="Internet">Internet / Website Job Portal</option>
                                        <option value="Teman/Keluarga">Relasi Teman / Keluarga</option>
                                        <option value="Pusat Karir Kampus">Pusat Karir Kampus / CDC</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================================================
             STEP 3: KOMPETENSI (SECTION C)
             ======================================================================== --}}
            <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
                class="p-8 space-y-6">

                <div class="border-l-4 border-blue-500 pl-4 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Kompetensi (Gap Analysis)</h2>
                    <p class="text-gray-500 text-sm">Bandingkan kemampuan yang didapat di Kampus (A) vs Tuntutan Pekerjaan
                        (B).</p>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 w-1/3">Aspek Kompetensi</th>
                                <th scope="col" class="px-6 py-3 text-center bg-blue-50">A. Kemampuan saat
                                    Lulus<br><span class="text-[10px] normal-case text-gray-500">(1=Rendah,
                                        5=Tinggi)</span></th>
                                <th scope="col" class="px-6 py-3 text-center bg-green-50">B. Kebutuhan
                                    Pekerjaan<br><span class="text-[10px] normal-case text-gray-500">(1=Rendah,
                                        5=Tinggi)</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $kompetensi = [
                                    ['label' => 'Etika', 'name' => 'etika'],
                                    ['label' => 'Keahlian Bidang Ilmu (Hardskill)', 'name' => 'hardskill'],
                                    ['label' => 'Bahasa Inggris', 'name' => 'inggris'],
                                ];
                            @endphp
                            @foreach ($kompetensi as $k)
                                <tr class="bg-white hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $k['label'] }}</td>

                                    {{-- Kolom A --}}
                                    <td class="px-6 py-4 bg-blue-50/30">
                                        <div class="flex justify-center space-x-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="{{ $k['name'] }}_kampus"
                                                        value="{{ $i }}" class="peer sr-only"
                                                        x-model="formData.{{ $k['name'] }}_kampus">
                                                    <div
                                                        class="w-8 h-8 rounded-full border border-blue-200 flex items-center justify-center peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 hover:bg-blue-100 transition-all text-xs">
                                                        {{ $i }}
                                                    </div>
                                                </label>
                                            @endfor
                                        </div>
                                    </td>

                                    {{-- Kolom B --}}
                                    <td class="px-6 py-4 bg-green-50/30">
                                        <div class="flex justify-center space-x-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="{{ $k['name'] }}_kerja"
                                                        value="{{ $i }}" class="peer sr-only"
                                                        x-model="formData.{{ $k['name'] }}_kerja">
                                                    <div
                                                        class="w-8 h-8 rounded-full border border-green-200 flex items-center justify-center peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 hover:bg-green-100 transition-all text-xs">
                                                        {{ $i }}
                                                    </div>
                                                </label>
                                            @endfor
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ========================================================================
             STEP 4: EVALUASI (SECTION D)
             ======================================================================== --}}
            <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
                class="p-8 space-y-6">

                <div class="border-l-4 border-blue-500 pl-4 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Evaluasi Pembelajaran</h2>
                    <p class="text-gray-500 text-sm">Masukan Anda sangat berarti bagi kemajuan Prodi.</p>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
                        <label class="label mb-3 block">Bagaimana penilaian Anda terhadap fasilitas laboratorium?</label>
                        <div class="flex gap-4">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="flex flex-col items-center cursor-pointer group">
                                    <input type="radio" name="eval_lab" value="{{ $i }}"
                                        x-model="formData.eval_lab" class="peer sr-only">
                                    <div
                                        class="w-12 h-12 rounded-lg bg-white border-2 border-yellow-300 peer-checked:bg-yellow-500 peer-checked:border-yellow-600 flex items-center justify-center transition-all shadow-sm group-hover:-translate-y-1">
                                        <span
                                            class="font-bold text-gray-600 peer-checked:text-white">{{ $i }}</span>
                                    </div>
                                    <span
                                        class="text-[10px] mt-1 text-gray-500">{{ $i == 1 ? 'Buruk' : ($i == 5 ? 'Sangat Baik' : '') }}</span>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
                        <label class="label mb-3 block">Bagaimana kualitas pengajaran Dosen secara umum?</label>
                        <div class="flex gap-4">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="flex flex-col items-center cursor-pointer group">
                                    <input type="radio" name="eval_dosen" value="{{ $i }}"
                                        x-model="formData.eval_dosen" class="peer sr-only">
                                    <div
                                        class="w-12 h-12 rounded-lg bg-white border-2 border-yellow-300 peer-checked:bg-yellow-500 peer-checked:border-yellow-600 flex items-center justify-center transition-all shadow-sm group-hover:-translate-y-1">
                                        <span
                                            class="font-bold text-gray-600 peer-checked:text-white">{{ $i }}</span>
                                    </div>
                                    <span
                                        class="text-[10px] mt-1 text-gray-500">{{ $i == 1 ? 'Buruk' : ($i == 5 ? 'Sangat Baik' : '') }}</span>
                                </label>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            {{-- NAVIGATION BUTTONS --}}
            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex justify-between items-center">

                {{-- Tombol Kembali --}}
                <button type="button" x-show="currentStep > 1" @click="prevStep"
                    class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-medium transition flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </button>
                <div x-show="currentStep === 1"></div> {{-- Spacer --}}

                {{-- Tombol Lanjut --}}
                <button type="button" x-show="currentStep < steps.length" @click="nextStep"
                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md font-medium transition flex items-center transform active:scale-95">
                    Lanjut
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                {{-- Tombol Submit --}}
                <button type="submit" x-show="currentStep === steps.length" :disabled="isLoading"
                    class="px-8 py-2.5 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow-lg transform active:scale-95 transition flex items-center disabled:opacity-50 disabled:cursor-wait">
                    <svg x-show="!isLoading" class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <svg x-show="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span x-text="isLoading ? 'Menyimpan...' : 'Selesai & Kirim'"></span>
                </button>
            </div>
        </form>
    </div>

    {{-- CSS Helper --}}
    <style>
        .label {
            @apply block text-sm font-semibold text-gray-700 mb-1.5;
        }

        .input-field {
            @apply w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2.5 text-sm transition shadow-sm placeholder-gray-400;
        }

        [type="radio"]:checked+div {
            @apply ring-2 ring-offset-1;
        }
    </style>

    {{-- Alpine JS --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tracerWizard', () => ({
                currentStep: 1,
                isLoading: false,
                steps: ['Biodata', 'Pekerjaan', 'Kompetensi', 'Evaluasi'],

                // Data Statis
                listProvinsi: ['Riau', 'DKI Jakarta', 'Jawa Barat', 'Sumatera Barat', 'Sumatera Utara',
                    'Kepulauan Riau'
                ],
                listKabupaten: [],

                // Data Form - Diisi dari PHP User
                formData: {
                    // Step 1: Ambil dari DB User
                    q1_nama: "{{ $alumni->nama_lengkap ?? '' }}",
                    q2_nim: "{{ $alumni->nim ?? '' }}",
                    q2_angkatan: "{{ $alumni->tahun_masuk ?? '' }}",
                    q3_prodi: "{{ $alumni->prodi->nama_prodi ?? '-' }}",

                    // Data yang mungkin perlu diupdate user
                    q4_ipk: "{{ $alumni->ipk ?? '' }}",
                    q5_tanggal_lulus: "{{ $alumni->tahun_lulus ? $alumni->tahun_lulus . '-01-01' : '' }}",
                    q6_alamat: `{{ $alumni->alamat_domisili ?? '' }}`,
                    q7_provinsi: '',
                    q9_kabupaten: '',
                    q8_kodepos: '',
                    q10a_no_hp: "{{ $alumni->no_hp ?? '' }}",
                    q10b_email: "{{ $alumni->email ?? '' }}",

                    // Konversi L/P database ke Value Radio Button
                    q11_jenis_kelamin: "{{ ($alumni->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : (($alumni->jenis_kelamin ?? '') == 'P' ? 'Perempuan' : '') }}",
                    status_bekerja: '',

                    // Step 2 (Pekerjaan)
                    q12_jenis_perusahaan: '',
                    q13a_nama_kantor: '',
                    provinsi_kerja: '',
                    q19_penghasilan: '',
                    keselarasan: '',

                    // Step 2 (Pencarian)
                    waktu_mencari: '',
                    waktu_tunggu: '',
                    jumlah_lamaran: '',
                    sumber_info: '',

                    // Step 3 (Kompetensi)
                    etika_kampus: '',
                    etika_kerja: '',
                    hardskill_kampus: '',
                    hardskill_kerja: '',
                    inggris_kampus: '',
                    inggris_kerja: '',

                    // Step 4 (Evaluasi)
                    eval_lab: '',
                    eval_dosen: ''
                },

                init() {
                    // Bisa tambahkan logika init lain jika perlu
                },

                loadKabupaten() {
                    // Simulasi Ajax sederhana
                    const prov = this.formData.q7_provinsi;
                    if (prov === 'Riau') this.listKabupaten = ['Pekanbaru', 'Dumai', 'Kampar', 'Siak',
                        'Bengkalis'
                    ];
                    else if (prov === 'DKI Jakarta') this.listKabupaten = ['Jakarta Selatan',
                        'Jakarta Pusat', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Utara'
                    ];
                    else this.listKabupaten = ['Kota Lainnya'];
                },

                isBekerja() {
                    const status = this.formData.status_bekerja;
                    return status === 'Bekerja (Full Time/Part Time)' || status === 'Wiraswasta';
                },

                validateStep() {
                    // Validasi Sederhana Step 1
                    if (this.currentStep === 1) {
                        if (!this.formData.q1_nama || !this.formData.q11_jenis_kelamin || !this.formData
                            .status_bekerja) {
                            alert('Mohon lengkapi data wajib (Nama, Jenis Kelamin, Status Aktivitas)');
                            return false;
                        }
                    }
                    // Validasi Step 2
                    if (this.currentStep === 2) {
                        if (this.isBekerja()) {
                            if (!this.formData.q13a_nama_kantor || !this.formData.q19_penghasilan) {
                                alert('Untuk yang bekerja, Nama Kantor dan Penghasilan wajib diisi.');
                                return false;
                            }
                        }
                    }
                    return true;
                },

                nextStep() {
                    if (this.validateStep()) {
                        this.currentStep++;
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                },

                prevStep() {
                    this.currentStep--;
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },

                submitForm(e) {
                    if (!confirm('Apakah data yang Anda isi sudah benar?')) return;

                    this.isLoading = true;
                    // Native submit form HTML
                    e.target.submit();
                }
            }))
        })
    </script>
@endsection
