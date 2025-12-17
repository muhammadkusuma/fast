@extends('layouts.main')

@section('title', 'Isi Tracer Study')

@section('content')
    @php
        $alumni = Auth::guard('alumni')->user();
        if ($alumni && !$alumni->relationLoaded('prodi')) {
            $alumni->load('prodi');
        }

        // Helper untuk Matriks Pertanyaan (Agar kode HTML lebih bersih)
        $aspek_pembelajaran = [
            'q38a' => 'Perkuliahan',
            'q38b' => 'Demonstrasi / Praktek',
            'q38c' => 'Partisipasi dalam proyek riset',
            'q38d' => 'Magang / PKL',
            'q38e' => 'Diskusi',
            'q38f' => 'Seminar / Workshop',
        ];

        $fasilitas = [
            'q40a' => 'Perpustakaan',
            'q40b' => 'Teknologi Informasi & Komunikasi',
            'q40c' => 'Modul Belajar',
            'q40d' => 'Ruang Belajar / Kelas',
            'q40e' => 'Laboratorium',
            'q40g' => 'Kantin',
            'q40k' => 'Tempat Ibadah (Masjid)',
        ];

        $kompetensi = [
            'a' => 'Pengetahuan di bidang ilmu (Hardskill)',
            'b' => 'Pengetahuan di luar bidang ilmu',
            'c' => 'Pengetahuan umum',
            'd' => 'Keterampilan Internet',
            'e' => 'Keterampilan Komputer',
            'f' => 'Berpikir Kritis',
            'i' => 'Komunikasi',
            'l' => 'Kerjasama Tim',
            'm' => 'Pemecahan Masalah',
            'n' => 'Analisis',
            'o' => 'Tanggung Jawab',
        ];
    @endphp

    <div x-data="tracerWizard()" class="max-w-7xl mx-auto pb-20 pt-6 px-4 sm:px-6">

        {{-- HEADER --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Tracer Study {{ date('Y') }}</h1>
            <p class="text-gray-500 mt-2">Selamat Datang, <span
                    class="font-semibold text-blue-600">{{ $alumni->nama_lengkap ?? 'Alumni' }}</span>. Mohon isi data dengan
                lengkap.</p>
        </div>

        {{-- PROGRESS INDICATOR --}}
        <div class="mb-10">
            <div class="relative">
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 rounded-full -z-10">
                </div>
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-blue-600 rounded-full -z-10 transition-all duration-500"
                    :style="'width: ' + ((currentStep - 1) / (steps.length - 1) * 100) + '%'"></div>
                <div class="flex justify-between w-full">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex flex-col items-center relative">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border-4 border-white shadow-sm transition-all duration-300"
                                :class="currentStep > index + 1 ? 'bg-green-500 text-white' : (currentStep === index + 1 ?
                                    'bg-blue-600 text-white ring-2 ring-blue-100 scale-110' :
                                    'bg-gray-200 text-gray-500')">
                                <span x-show="currentStep <= index + 1" x-text="index + 1"></span>
                                <svg x-show="currentStep > index + 1" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-[10px] font-semibold mt-1 uppercase tracking-wider hidden sm:block"
                                :class="currentStep >= index + 1 ? 'text-gray-800' : 'text-gray-400'" x-text="step"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <form action="{{ route('alumni.tracer.store') }}" method="POST" @submit.prevent="submitForm"
            class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden relative min-h-[500px]">
            @csrf

            {{-- Hidden Fields --}}
            <input type="hidden" name="user_id" value="{{ $alumni->id }}">
            <input type="hidden" name="fakultas" value="SAINS DAN TEKNOLOGI">

            {{-- ========================================================================
             STEP 1: DATA PRIBADI (SECTION A)
             ======================================================================== --}}
            <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0" class="max-w-4xl mx-auto pt-5">

                <div class="mb-8 border-l-4 border-blue-600 pl-4">
                    <h2 class="text-2xl font-bold text-gray-800">A. Data Pribadi</h2>
                    <p class="text-gray-500 mt-1">Mohon periksa data akademik dan lengkapi data kontak Anda.</p>
                </div>

                <div class="space-y-8">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <h3 class="font-semibold text-gray-700">Data Akademik (Terkunci)</h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider">NIM</span>
                                <div class="mt-1 font-semibold text-gray-800">{{ $alumni->nim }}</div>
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Nama
                                    Lengkap</span>
                                <div class="mt-1 font-semibold text-gray-800">{{ $alumni->nama_lengkap }}</div>
                                <input type="hidden" name="q1_nama" value="{{ $alumni->nama_lengkap }}">
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Program
                                    Studi</span>
                                <div class="mt-1 font-semibold text-gray-800">{{ $alumni->prodi->nama_prodi ?? '-' }}</div>
                                <input type="hidden" name="q3_prodi" value="{{ $alumni->prodi->nama_prodi ?? '-' }}">
                            </div>
                            <div>
                                <span
                                    class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Angkatan</span>
                                <div class="mt-1 font-semibold text-gray-800">{{ $alumni->tahun_masuk }}</div>
                                <input type="hidden" name="q2_angkatan" value="{{ $alumni->tahun_masuk }}">
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider">IPK</span>
                                <div class="mt-1 font-semibold text-gray-800">{{ $alumni->ipk }}</div>
                                <input type="hidden" name="q4_ipk" value="{{ $alumni->ipk }}">
                            </div>

                            <div class="relative">
                                <label class="block text-xs font-medium text-blue-600 uppercase tracking-wider mb-1">Tanggal
                                    Lulus (Ijazah) <span class="text-red-500">*</span></label>
                                <input type="date" name="q5_tanggal_lulus" x-model="formData.q5_tanggal_lulus"
                                    class="block w-full px-3 py-2 bg-blue-50 border border-blue-200 rounded-md text-gray-900 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

                        <div class="md:col-span-7 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Domisili Lengkap <span
                                        class="text-red-500">*</span></label>
                                <textarea name="q6_alamat" x-model="formData.q6_alamat" rows="3"
                                    class="p-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                                    placeholder="Nama Jalan, No. Rumah, RT/RW, Kelurahan..."></textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span
                                            class="text-red-500">*</span></label>
                                    <select name="q7_provinsi" x-model="formData.q7_provinsi" @change="loadKabupaten()"
                                        class="p-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Pilih Provinsi</option>
                                        <template x-for="p in listProvinsi">
                                            <option :value="p" x-text="p"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten <span
                                            class="text-red-500">*</span></label>
                                    <select name="q9_kota" x-model="formData.q9_kota" :disabled="!formData.q7_provinsi"
                                        class="p-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed">
                                        <option value="">Pilih Kota</option>
                                        <template x-for="k in listKabupaten">
                                            <option :value="k" x-text="k"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="q8_kodepos" x-model="formData.q8_kodepos"
                                        class="p-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-5 space-y-6">
                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                                <h4 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wide">Kontak Personal
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm text-gray-600 mb-1">No. WhatsApp <span
                                                class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </div>
                                            <input type="text" name="q10a_no_hp" x-model="formData.q10a_no_hp"
                                                class="p-3 pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                placeholder="0812...">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-600 mb-1">Email Aktif <span
                                                class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <input type="email" name="q10b_email" x-model="formData.q10b_email"
                                                class="p-3 pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span
                                        class="text-red-500">*</span></label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="q11_jenis_kelamin" value="Laki-laki"
                                            x-model="formData.q11_jenis_kelamin" class="peer sr-only">
                                        <div
                                            class="text-center p-3 border rounded-lg hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition">
                                            <span class="font-medium text-sm">Laki-laki</span>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="q11_jenis_kelamin" value="Perempuan"
                                            x-model="formData.q11_jenis_kelamin" class="peer sr-only">
                                        <div
                                            class="text-center p-3 border rounded-lg hover:bg-gray-50 peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:text-pink-700 transition">
                                            <span class="font-medium text-sm">Perempuan</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="border border-gray-300 rounded-xl p-1 shadow-lg">
                            <div class="bg-white rounded-lg p-6">
                                <label class="block text-lg font-bold text-gray-800 mb-2">
                                    Status Saat Ini <span class="text-red-500">*</span>
                                </label>
                                <p class="text-sm text-gray-500 mb-4">Pilih status yang paling menggambarkan kondisi Anda
                                    saat ini untuk menentukan pertanyaan selanjutnya.</p>

                                <select name="status_bekerja" x-model="formData.status_bekerja"
                                    class="block w-full text-md py-3 px-4 border-2 border-blue-100 bg-blue-50 rounded-lg text-blue-900 focus:ring-blue-500 focus:border-blue-500 transition cursor-pointer">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Sudah Bekerja">Sudah Bekerja / Wiraswasta</option>
                                    <option value="Belum Bekerja">Belum Bekerja / Sedang Mencari</option>
                                    <option value="Sedang Kuliah">Sedang Melanjutkan Pendidikan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ========================================================================
             STEP 2: PEKERJAAN (SECTION B) - Only if 'Sudah Bekerja'
             ======================================================================== --}}
            <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0" class="max-w-4xl mx-auto pt-5">

                <div x-show="formData.status_bekerja !== 'Sudah Bekerja'"
                    class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white rounded-xl border-2 border-dashed border-gray-300">
                    <div class="bg-gray-50 rounded-full p-6 mb-6 shadow-sm">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Langkah ini dilewati</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Berdasarkan status Anda, bagian detail pekerjaan tidak perlu
                        diisi. Silakan klik tombol <b>"Lanjut"</b> di bawah.</p>
                </div>

                <div x-show="formData.status_bekerja === 'Sudah Bekerja'" class="space-y-8">

                    <div class="border-l-4 border-orange-500 pl-4">
                        <h2 class="text-2xl font-bold text-gray-800">B. Pekerjaan Saat Ini</h2>
                        <p class="text-gray-500 mt-1">Mohon lengkapi detail instansi tempat Anda bekerja saat ini.</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Profil Instansi</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Instansi / Perusahaan
                                    <span class="text-red-500">*</span></label>
                                <select name="q12_jenis_perusahaan" x-model="formData.q12_jenis_perusahaan"
                                    class="p-3 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">-- Pilih Jenis Instansi --</option>
                                    <option value="Instansi Pemerintah">Instansi Pemerintah (PNS/Non-PNS)</option>
                                    <option value="BUMN/BUMD">BUMN / BUMD</option>
                                    <option value="Swasta Nasional">Perusahaan Swasta Nasional</option>
                                    <option value="Swasta Multinasional">Perusahaan Multinasional</option>
                                    <option value="Wiraswasta">Wiraswasta / Pemilik Usaha</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>

                                <div x-show="formData.q12_jenis_perusahaan === 'Lainnya'" x-transition class="mt-3">
                                    <input type="text" name="q12a_lainnya" x-model="formData.q12a_lainnya"
                                        class="p-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 bg-gray-50"
                                        placeholder="Sebutkan jenis instansi Anda...">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan / Kantor <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <input type="text" name="q13a_nama_kantor" x-model="formData.q13a_nama_kantor"
                                        class="p-2 pl-10 w-full rounded-lg border border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                        placeholder="PT. Mencari Cinta Sejati">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai Bekerja <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="q15_tahun_masuk" x-model="formData.q15_tahun_masuk"
                                    class="p-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                    placeholder="Contoh: 2023">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="bg-orange-100 p-2 rounded-lg text-orange-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Data Pimpinan (Atasan Langsung)</h3>
                                <p class="text-sm text-gray-500">Data ini digunakan untuk survey kepuasan pengguna lulusan.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama
                                    Pimpinan</label>
                                <input type="text" name="q13b_pimpinan" x-model="formData.q13b_pimpinan"
                                    class="p-2 w-full rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Email
                                    Pimpinan</label>
                                <input type="email" name="q13c_email_pimpinan" x-model="formData.q13c_email_pimpinan"
                                    class="p-2 w-full rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">No. HP
                                    Pimpinan</label>
                                <input type="text" name="q16_telp_pimpinan" x-model="formData.q16_telp_pimpinan"
                                    class="p-2 w-full rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-4">Detail Pekerjaan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Range Gaji/Bulan <span
                                        class="text-red-500">*</span></label>
                                <select name="q19_penghasilan" x-model="formData.q19_penghasilan"
                                    class="p-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">-- Pilih Range --</option>
                                    <option value="< 3 Juta">
                                        < Rp 3 Juta</option>
                                    <option value="3 - 5 Juta">Rp 3 - 5 Juta</option>
                                    <option value="5 - 10 Juta">Rp 5 - 10 Juta</option>
                                    <option value="> 10 Juta">> Rp 10 Juta</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status Kepegawaian <span
                                        class="text-red-500">*</span></label>
                                <select name="q20_status_pekerjaan" x-model="formData.q20_status_pekerjaan"
                                    class="p-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Tetap">Tetap</option>
                                    <option value="Kontrak">Kontrak</option>
                                    <option value="Honorer">Honorer</option>
                                    <option value="Self Employed">Wiraswasta / Self Employed</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kesesuaian Bidang Studi <span
                                        class="text-red-500">*</span></label>
                                <select name="q21_hubungan" x-model="formData.q21_hubungan"
                                    class="p-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="Sangat Erat">Sangat Erat</option>
                                    <option value="Erat">Erat</option>
                                    <option value="Cukup Erat">Cukup Erat</option>
                                    <option value="Kurang Erat">Kurang Erat</option>
                                    <option value="Tidak Sama Sekali">Tidak Sama Sekali</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <label class="block text-lg font-bold text-gray-800 mb-3">Apakah ini pekerjaan pertama Anda setelah
                            lulus? <span class="text-red-500">*</span></label>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="is_first_job" value="Ya" x-model="formData.is_first_job"
                                    class="peer sr-only">
                                <div
                                    class="p-4 rounded-xl border-2 border-gray-200 hover:border-green-400 hover:bg-green-50 peer-checked:border-green-500 peer-checked:bg-green-50 transition duration-200 flex flex-col items-center">
                                    <span class="text-2xl mb-1">👍</span>
                                    <span class="font-bold text-gray-700 peer-checked:text-green-700">Ya, Pertama</span>
                                </div>
                                <div class="absolute top-2 right-2 hidden peer-checked:block text-green-600">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="is_first_job" value="Tidak" x-model="formData.is_first_job"
                                    class="peer sr-only">
                                <div
                                    class="p-4 rounded-xl border-2 border-gray-200 hover:border-orange-400 hover:bg-orange-50 peer-checked:border-orange-500 peer-checked:bg-orange-50 transition duration-200 flex flex-col items-center">
                                    <span class="text-2xl mb-1">💼</span>
                                    <span class="font-bold text-gray-700 peer-checked:text-orange-700">Tidak, Pindah
                                        Kerja</span>
                                </div>
                                <div class="absolute top-2 right-2 hidden peer-checked:block text-orange-600">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>
                        </div>

                        <div x-show="formData.is_first_job === 'Tidak'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="bg-orange-50 rounded-xl border border-orange-200 p-6 relative mt-4">

                            <div
                                class="absolute -top-3 left-3/4 w-6 h-6 bg-orange-50 border-t border-l border-orange-200 transform rotate-45">
                            </div>

                            <h4 class="font-bold text-orange-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Riwayat Pekerjaan Pertama
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="label text-orange-900">Nama Kantor Pertama</label>
                                    <input type="text" name="q25_kantor_pertama" x-model="formData.q25_kantor_pertama"
                                        class="p-2 w-full rounded-lg border border-orange-300 focus:border-orange-500 focus:ring-orange-500 bg-white">
                                </div>
                                <div>
                                    <label class="label text-orange-900">Alasan Berhenti/Pindah</label>
                                    <input type="text" name="q26_alasan_berhenti"
                                        x-model="formData.q26_alasan_berhenti"
                                        class="p-2 w-full rounded-lg border border-orange-300 focus:border-orange-500 focus:ring-orange-500 bg-white"
                                        placeholder="Cth: Mendapat tawaran lebih baik">
                                </div>
                                <div>
                                    <label class="label text-orange-900">Gaji Awal (Saat itu)</label>
                                    <select name="q28_gaji_pertama" x-model="formData.q28_gaji_pertama"
                                        class="p-2 w-full rounded-lg border border-orange-300 focus:border-orange-500 focus:ring-orange-500 bg-white">
                                        <option value="">-- Pilih Range --</option>
                                        <option value="< 3 Juta">
                                            < Rp 3 Juta</option>
                                        <option value="3 - 5 Juta">Rp 3 - 5 Juta</option>
                                        <option value="> 5 Juta">> Rp 5 Juta</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ========================================================================
             STEP 3: PENDIDIKAN & BELAJAR (SECTION C)
             ======================================================================== --}}
            <div x-show="currentStep === 3" x-transition.opacity class="p-8 space-y-8">
                <div class="border-l-4 border-purple-500 pl-4">
                    <h2 class="text-xl font-bold text-gray-800">C. Pengalaman Belajar</h2>
                    <p class="text-sm text-gray-500">Evaluasi pengalaman Anda selama kuliah.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="label">Tempat Tinggal Selama Kuliah <span class="text-red-500">*</span></label>
                        <select name="q33_tempat_tinggal" x-model="formData.q33_tempat_tinggal" class="input-field">
                            <option value="">-- Pilih --</option>
                            <option value="Bersama Orang Tua">Bersama Orang Tua</option>
                            <option value="Kos">Kos / Sewa</option>
                            <option value="Asrama">Asrama</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">Sumber Biaya Kuliah <span class="text-red-500">*</span></label>
                        <select name="q34_sumber_biaya" x-model="formData.q34_sumber_biaya" class="input-field">
                            <option value="">-- Pilih --</option>
                            <option value="Biaya Sendiri / Keluarga">Biaya Sendiri / Keluarga</option>
                            <option value="Beasiswa ADIK">Beasiswa ADIK</option>
                            <option value="Beasiswa BIDIKMISI">Beasiswa BIDIKMISI</option>
                            <option value="Beasiswa Lain">Beasiswa Lain</option>
                        </select>
                    </div>

                    {{-- Organisasi --}}
                    <div class="md:col-span-2 bg-gray-50 p-4 rounded">
                        <label class="label">Apakah Anda aktif di Organisasi? <span class="text-red-500">*</span></label>
                        <div class="flex gap-4 mb-3">
                            <label class="inline-flex items-center"><input type="radio" name="q35_organisasi"
                                    value="Ya" x-model="formData.q35_organisasi" class="mr-2"> Ya</label>
                            <label class="inline-flex items-center"><input type="radio" name="q35_organisasi"
                                    value="Tidak" x-model="formData.q35_organisasi" class="mr-2"> Tidak</label>
                        </div>
                        <div x-show="formData.q35_organisasi === 'Ya'" x-transition>
                            <label class="label">Tingkat Keaktifan</label>
                            <select name="q36_keaktifan" x-model="formData.q36_keaktifan" class="input-field w-1/2">
                                <option value="Anggota Biasa">Anggota Biasa</option>
                                <option value="Pengurus">Pengurus</option>
                                <option value="Ketua">Ketua / Pimpinan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Kursus --}}
                    <div class="md:col-span-2 bg-gray-50 p-4 rounded">
                        <label class="label">Apakah Anda mengambil Pendidikan Tambahan/Kursus? <span
                                class="text-red-500">*</span></label>
                        <div class="flex gap-4 mb-3">
                            <label class="inline-flex items-center"><input type="radio" name="q37_kursus"
                                    value="Ya" x-model="formData.q37_kursus" class="mr-2"> Ya</label>
                            <label class="inline-flex items-center"><input type="radio" name="q37_kursus"
                                    value="Tidak" x-model="formData.q37_kursus" class="mr-2"> Tidak</label>
                        </div>
                        <div x-show="formData.q37_kursus === 'Ya'" x-transition>
                            <label class="label">Sebutkan Nama Kursus</label>
                            <input type="text" name="q37a_nama_kursus" x-model="formData.q37a_nama_kursus"
                                class="input-field" placeholder="Contoh: English Course, Coding Bootcamp">
                        </div>
                    </div>
                </div>

                {{-- MATRIKS EVALUASI (Q38 & Q40) --}}
                <div class="space-y-6 mt-6">
                    <h3 class="font-bold text-gray-700">Evaluasi Pembelajaran (1: Sangat Buruk - 5: Sangat Baik)</h3>

                    {{-- Q38 --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-gray-600">
                            <thead class="bg-gray-100 text-xs uppercase">
                                <tr>
                                    <th class="px-4 py-3 text-left">Aspek Pembelajaran</th>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <th class="px-2 py-3 text-center">{{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($aspek_pembelajaran as $key => $label)
                                    <tr>
                                        <td class="px-4 py-2 font-medium">{{ $label }}</td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <td class="px-2 py-2 text-center">
                                                <input type="radio" name="{{ $key }}"
                                                    value="{{ $i }}" x-model="formData.{{ $key }}"
                                                    class="cursor-pointer">
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h3 class="font-bold text-gray-700 mt-4">Evaluasi Fasilitas (1: Sangat Buruk - 5: Sangat Baik)</h3>
                    {{-- Q40 --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-gray-600">
                            <thead class="bg-gray-100 text-xs uppercase">
                                <tr>
                                    <th class="px-4 py-3 text-left">Fasilitas</th>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <th class="px-2 py-3 text-center">{{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($fasilitas as $key => $label)
                                    <tr>
                                        <td class="px-4 py-2 font-medium">{{ $label }}</td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <td class="px-2 py-2 text-center">
                                                <input type="radio" name="{{ $key }}"
                                                    value="{{ $i }}" x-model="formData.{{ $key }}"
                                                    class="cursor-pointer">
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ========================================================================
             STEP 4: KOMPETENSI & PENUTUP (SECTION D)
             ======================================================================== --}}
            <div x-show="currentStep === 4" x-transition.opacity class="p-8 space-y-8">
                <div class="border-l-4 border-green-500 pl-4">
                    <h2 class="text-xl font-bold text-gray-800">D. Kompetensi & Penutup</h2>
                    <p class="text-sm text-gray-500">Evaluasi kemampuan diri dan umpan balik.</p>
                </div>

                {{-- Kompetensi --}}
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-gray-600">
                        <thead class="bg-gray-100 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left w-1/2">Kompetensi yang dikuasai saat Lulus</th>
                                <th class="px-2 py-3 text-center" colspan="5">Skala (1: Rendah - 5: Tinggi)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($kompetensi as $key => $label)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 font-medium">{{ $label }}</td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <td class="px-2 py-2 text-center">
                                            <label class="block w-full h-full cursor-pointer">
                                                <input type="radio" name="q42{{ $key }}"
                                                    value="{{ $i }}"
                                                    x-model="formData.q42{{ $key }}" class="sr-only peer">
                                                <div
                                                    class="w-6 h-6 mx-auto rounded-full border flex items-center justify-center text-xs peer-checked:bg-green-500 peer-checked:text-white transition">
                                                    {{ $i }}
                                                </div>
                                            </label>
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Penutup --}}
                <div class="space-y-4 bg-gray-50 p-6 rounded-xl">
                    <h3 class="font-bold text-gray-800 border-b pb-2">Pertanyaan Penutup</h3>

                    {{-- Bahasa --}}
                    <div>
                        <label class="label">Kemampuan Bahasa Asing (1-5)</label>
                        <div class="flex gap-4">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer"><input type="radio" name="q45_bahasa"
                                        value="{{ $i }}" x-model="formData.q45_bahasa" class="mr-1">
                                    {{ $i }}</label>
                            @endfor
                        </div>
                    </div>

                    {{-- Pilih UIN --}}
                    <div>
                        <label class="label">Apakah Anda akan memilih UIN Suska lagi jika mengulang kuliah? <span
                                class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center"><input type="radio" name="q47_uin" value="Ya"
                                    x-model="formData.q47_uin" class="mr-2"> Ya</label>
                            <label class="inline-flex items-center"><input type="radio" name="q47_uin" value="Tidak"
                                    x-model="formData.q47_uin" class="mr-2"> Tidak</label>
                        </div>
                        <div x-show="formData.q47_uin === 'Tidak'" x-transition class="mt-2">
                            <input type="text" name="q48_alasan_uin" x-model="formData.q48_alasan_uin"
                                class="input-field" placeholder="Mengapa tidak?">
                        </div>
                    </div>

                    {{-- Pilih Prodi --}}
                    <div>
                        <label class="label">Apakah Anda akan memilih Prodi yang sama lagi? <span
                                class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center"><input type="radio" name="q49_prodi"
                                    value="Ya" x-model="formData.q49_prodi" class="mr-2"> Ya</label>
                            <label class="inline-flex items-center"><input type="radio" name="q49_prodi"
                                    value="Tidak" x-model="formData.q49_prodi" class="mr-2"> Tidak</label>
                        </div>
                        <div x-show="formData.q49_prodi === 'Tidak'" x-transition class="mt-2">
                            <input type="text" name="q50_alasan_prodi" x-model="formData.q50_alasan_prodi"
                                class="input-field" placeholder="Mengapa tidak?">
                        </div>
                    </div>
                </div>
            </div>

            {{-- NAVIGATION --}}
            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex justify-between items-center">
                <button type="button" x-show="currentStep > 1" @click="prevStep"
                    class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-medium transition shadow-sm">
                    Kembali
                </button>
                <div x-show="currentStep === 1"></div>

                <button type="button" x-show="currentStep < steps.length" @click="nextStep"
                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md font-medium transition">
                    Lanjut
                </button>

                <button type="submit" x-show="currentStep === steps.length" :disabled="isLoading"
                    class="px-8 py-2.5 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow-lg transition flex items-center disabled:opacity-50">
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
    </style>

    {{-- Alpine JS --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tracerWizard', () => ({
                currentStep: 1,
                isLoading: false,
                steps: ['Biodata', 'Pekerjaan', 'Pendidikan', 'Evaluasi'],

                listProvinsi: ['Riau', 'DKI Jakarta', 'Jawa Barat', 'Sumatera Barat', 'Sumatera Utara',
                    'Kepulauan Riau'
                ],
                listKabupaten: [],

                formData: {
                    // Step 1
                    q5_tanggal_lulus: "{{ $alumni->tahun_lulus ? $alumni->tahun_lulus . '-01-01' : '' }}",
                    q6_alamat: `{{ $alumni->alamat_domisili ?? '' }}`,
                    q7_provinsi: '',
                    q9_kota: '',
                    q8_kodepos: '',
                    q10a_no_hp: "{{ $alumni->no_hp ?? '' }}",
                    q10b_email: "{{ $alumni->email ?? '' }}",
                    q11_jenis_kelamin: "{{ ($alumni->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}",
                    status_bekerja: '',

                    // Step 2
                    q12_jenis_perusahaan: '',
                    q12a_lainnya: '',
                    q13a_nama_kantor: '',
                    q15_tahun_masuk: '',
                    q19_penghasilan: '',
                    is_first_job: '',
                    q25_kantor_pertama: '',

                    // Step 3
                    q33_tempat_tinggal: '',
                    q34_sumber_biaya: '',
                    q35_organisasi: '',
                    q37_kursus: '',
                    // ... matriks dihandle x-model dinamis

                    // Step 4
                    q47_uin: '',
                    q49_prodi: ''
                },

                loadKabupaten() {
                    const prov = this.formData.q7_provinsi;
                    if (prov === 'Riau') this.listKabupaten = ['Pekanbaru', 'Dumai', 'Kampar', 'Siak',
                        'Bengkalis'
                    ];
                    else if (prov === 'DKI Jakarta') this.listKabupaten = ['Jakarta Selatan',
                        'Jakarta Pusat', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Utara'
                    ];
                    else this.listKabupaten = ['Kota Lainnya'];
                },

                validateStep() {
                    // Validasi Step 1
                    if (this.currentStep === 1) {
                        if (!this.formData.q6_alamat || !this.formData.q7_provinsi || !this.formData
                            .status_bekerja) {
                            alert('Mohon lengkapi Data Pribadi wajib bertanda bintang (*)');
                            return false;
                        }
                    }
                    // Validasi Step 2 (Jika Bekerja)
                    if (this.currentStep === 2 && this.formData.status_bekerja === 'Sudah Bekerja') {
                        if (!this.formData.q12_jenis_perusahaan || !this.formData.q13a_nama_kantor) {
                            alert('Mohon lengkapi data Pekerjaan Anda.');
                            return false;
                        }
                        if (!this.formData.is_first_job) {
                            alert('Mohon pilih status Riwayat Pekerjaan Pertama.');
                            return false;
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
                    if (!confirm('Apakah data sudah benar?')) return;
                    this.isLoading = true;
                    e.target.submit();
                }
            }))
        })
    </script>
@endsection
