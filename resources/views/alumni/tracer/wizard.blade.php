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
                x-transition:enter-end="opacity-100 transform translate-y-0" class="p-8">

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
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Provinsi <span class="text-red-500">*</span>
                                    </label>
                                    <select name="q7_provinsi" x-model="formData.q7_provinsi" @change="loadKabupaten()"
                                        required
                                        class="p-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Pilih Provinsi</option>
                                        <template x-for="p in listProvinsi" :key="p">
                                            <option :value="p" x-text="p"></option>
                                        </template>
                                    </select>
                                    <p x-show="!formData.q7_provinsi" class="text-[10px] text-red-500 mt-1">Silakan pilih
                                        provinsi</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Kota/Kabupaten <span class="text-red-500">*</span>
                                    </label>
                                    <select name="q9_kota" x-model="formData.q9_kota" :disabled="!formData.q7_provinsi"
                                        required
                                        class="p-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed">
                                        <option value="">Pilih Kota</option>
                                        <template x-for="k in listKabupaten" :key="k">
                                            <option :value="k" x-text="k"></option>
                                        </template>
                                    </select>
                                    <p x-show="formData.q7_provinsi && !formData.q9_kota"
                                        class="text-[10px] text-red-500 mt-1">Silakan pilih kota/kabupaten</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Kode Pos <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="q8_kodepos" x-model="formData.q8_kodepos"
                                        inputmode="numeric" pattern="[0-9]*" required
                                        @keypress="if (!/[0-9]/.test($event.key)) $event.preventDefault()"
                                        @input="formData.q8_kodepos = formData.q8_kodepos.replace(/\D/g, '').slice(0, 5)"
                                        class="p-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Contoh: 12345">

                                    <div class="flex justify-between">
                                        <p x-show="!formData.q8_kodepos" class="text-[10px] text-red-500 mt-1">Kode pos
                                            wajib diisi</p>
                                        <p x-show="formData.q8_kodepos && formData.q8_kodepos.length < 5"
                                            class="text-[10px] text-orange-500 mt-1">Harus 5 digit</p>
                                    </div>
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
                                <p class="text-sm text-gray-500 mb-4">
                                    Pilih status yang paling menggambarkan kondisi Anda saat ini untuk menentukan pertanyaan
                                    selanjutnya.
                                </p>

                                <select name="status_bekerja" x-model="formData.status_bekerja" required
                                    class="block w-full text-md py-3 px-4 border-2 border-blue-100 bg-blue-50 rounded-lg text-blue-900 focus:ring-blue-500 focus:border-blue-500 transition cursor-pointer"
                                    :class="!formData.status_bekerja ? 'border-red-200' : 'border-blue-100'">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Sudah Bekerja">Sudah Bekerja / Wiraswasta</option>
                                    <option value="Belum Bekerja">Belum Bekerja / Sedang Mencari</option>
                                    <option value="Sedang Kuliah">Sedang Melanjutkan Pendidikan</option>
                                </select>

                                <div x-show="!formData.status_bekerja" x-transition
                                    class="mt-2 flex items-center gap-1 text-red-500 text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Status wajib dipilih untuk melanjutkan.</span>
                                </div>
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
                x-transition:enter-end="opacity-100 transform translate-y-0" class="p-8">

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
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Jenis Instansi / Perusahaan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="q12_jenis_perusahaan" x-model="formData.q12_jenis_perusahaan" required
                                        class="p-3 w-full rounded-lg border border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors"
                                        :class="!formData.q12_jenis_perusahaan ? 'bg-orange-50/30' : 'bg-white'">
                                        <option value="">-- Pilih Jenis Instansi --</option>
                                        <option value="Instansi Pemerintah">Instansi Pemerintah (PNS/Non-PNS)</option>
                                        <option value="BUMN/BUMD">BUMN / BUMD</option>
                                        <option value="Swasta Nasional">Perusahaan Swasta Nasional</option>
                                        <option value="Swasta Multinasional">Perusahaan Multinasional</option>
                                        <option value="Wiraswasta">Wiraswasta / Pemilik Usaha</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>

                                    <div x-show="!formData.q12_jenis_perusahaan" x-transition.opacity
                                        class="mt-1 text-[10px] text-red-500 font-medium flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Pilih salah satu jenis instansi.
                                    </div>
                                </div>

                                <div x-show="formData.q12_jenis_perusahaan === 'Lainnya'" x-transition class="mt-3">
                                    <label class="block text-xs font-medium text-gray-600 mb-1 ml-1">
                                        Sebutkan Jenis Instansi <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="q12a_lainnya" x-model="formData.q12a_lainnya"
                                        {{-- Input ini hanya wajib diisi jika q12 adalah 'Lainnya' --}} :required="formData.q12_jenis_perusahaan === 'Lainnya'"
                                        class="p-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 bg-gray-50"
                                        placeholder="Sebutkan jenis instansi Anda...">

                                    <p x-show="formData.q12_jenis_perusahaan === 'Lainnya' && !formData.q12a_lainnya"
                                        class="text-[10px] text-red-500 mt-1 ml-1">
                                        Bagian ini tidak boleh kosong jika memilih 'Lainnya'.
                                    </p>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Perusahaan / Kantor <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400"
                                                :class="!formData.q13a_nama_kantor ? 'text-red-300' : 'text-gray-400'"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <input type="text" name="q13a_nama_kantor" x-model="formData.q13a_nama_kantor"
                                            required
                                            class="p-2 pl-10 w-full rounded-lg border border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                            :class="!formData.q13a_nama_kantor ? 'border-red-200 bg-red-50/10' :
                                                'border-gray-300 bg-white'"
                                            placeholder="PT. Contoh Perusahaan">
                                    </div>

                                    <p x-show="!formData.q13a_nama_kantor" x-transition
                                        class="text-[10px] text-red-500 mt-1 ml-1 flex items-center gap-1">
                                        <span class="w-1 h-1 bg-red-500 rounded-full"></span>
                                        Nama perusahaan wajib diisi.
                                    </p>
                                </div>
                            </div>
                            <div x-data="{
                                startYear: 2000,
                                currentYear: new Date().getFullYear(),
                                get yearRange() {
                                    let years = [];
                                    for (let i = this.currentYear; i >= this.startYear; i--) {
                                        years.push(i);
                                    }
                                    return years;
                                }
                            }">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Tahun Mulai Bekerja <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="q15_tahun_masuk" x-model="formData.q15_tahun_masuk"
                                    list="list_tahun" inputmode="numeric" required {{-- Mencegah ketik huruf --}}
                                    @keypress="if (!/[0-9]/.test($event.key)) $event.preventDefault()"
                                    {{-- Logika filter angka, limit 4 digit, dan batasan tahun --}}
                                    @input="
            formData.q15_tahun_masuk = formData.q15_tahun_masuk.replace(/\D/g, '').slice(0, 4);
            if (formData.q15_tahun_masuk.length === 4) {
                if (formData.q15_tahun_masuk > currentYear) formData.q15_tahun_masuk = currentYear;
            }
        "
                                    class="p-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                    :class="!formData.q15_tahun_masuk || (formData.q15_tahun_masuk.length === 4 && formData
                                        .q15_tahun_masuk < startYear) ? 'border-red-300' : 'border-gray-300'"
                                    placeholder="Cari atau pilih tahun (2000 - Sekarang)">

                                <datalist id="list_tahun">
                                    <template x-for="year in yearRange" :key="year">
                                        <option :value="year"></option>
                                    </template>
                                </datalist>

                                <p x-show="!formData.q15_tahun_masuk" class="text-[10px] text-red-500 mt-1">
                                    Tahun mulai bekerja wajib diisi.
                                </p>

                                <p x-show="formData.q15_tahun_masuk && (formData.q15_tahun_masuk < startYear) && formData.q15_tahun_masuk.length === 4"
                                    class="text-[10px] text-red-500 mt-1">
                                    Tahun minimal adalah 2000.
                                </p>
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
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                    Nama Pimpinan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="q13b_pimpinan" x-model="formData.q13b_pimpinan" required
                                    class="p-2 w-full rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                                    placeholder="Nama Lengkap">
                                <p x-show="!formData.q13b_pimpinan" class="text-[10px] text-red-500 mt-1">Nama pimpinan
                                    wajib diisi</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                    Email Pimpinan <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="q13c_email_pimpinan" x-model="formData.q13c_email_pimpinan"
                                    required
                                    class="p-2 w-full rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                                    placeholder="contoh@perusahaan.com">
                                <p x-show="!formData.q13c_email_pimpinan" class="text-[10px] text-red-500 mt-1">Email
                                    wajib diisi</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                    No. HP Pimpinan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="q16_telp_pimpinan" x-model="formData.q16_telp_pimpinan"
                                    inputmode="numeric" required
                                    @keypress="if (!/[0-9]/.test($event.key)) $event.preventDefault()"
                                    @input="formData.q16_telp_pimpinan = formData.q16_telp_pimpinan.replace(/\D/g, '').slice(0, 12)"
                                    class="p-2 w-full rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                                    placeholder="Contoh: 081234567890">

                                <div class="flex justify-between mt-1">
                                    <p x-show="!formData.q16_telp_pimpinan" class="text-[10px] text-red-500">Nomor HP
                                        wajib diisi</p>
                                    <span class="text-[10px] text-gray-400 ml-auto"
                                        x-text="(formData.q16_telp_pimpinan?.length || 0) + '/12'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-4">Detail Pekerjaan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Range Gaji/Bulan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="q19_penghasilan" x-model="formData.q19_penghasilan" required
                                        class="p-2 w-full rounded-lg border shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all"
                                        :class="!formData.q19_penghasilan ? 'border-red-300 bg-red-50/10' :
                                            'border-gray-300 bg-white'">
                                        <option value="">-- Pilih Range --</option>
                                        <option value="< 3 Juta">
                                            < Rp 3 Juta</option>
                                        <option value="3 - 5 Juta">Rp 3 - 5 Juta</option>
                                        <option value="5 - 10 Juta">Rp 5 - 10 Juta</option>
                                        <option value="> 10 Juta">> Rp 10 Juta</option>
                                    </select>

                                    <div x-show="!formData.q19_penghasilan" x-transition
                                        class="text-[10px] text-red-500 mt-1 ml-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Pilih salah satu range gaji.
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Status Kepegawaian <span class="text-red-500">*</span>
                                    </label>
                                    <select name="q20_status_pekerjaan" x-model="formData.q20_status_pekerjaan" required
                                        class="p-2 w-full rounded-lg border shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all"
                                        :class="!formData.q20_status_pekerjaan ? 'border-red-300 bg-red-50/10' :
                                            'border-gray-300 bg-white'">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Tetap">Tetap</option>
                                        <option value="Kontrak">Kontrak</option>
                                        <option value="Honorer">Honorer</option>
                                        <option value="Self Employed">Wiraswasta / Self Employed</option>
                                    </select>

                                    <div x-show="!formData.q20_status_pekerjaan" x-transition
                                        class="text-[10px] text-red-500 mt-1 ml-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Status kepegawaian wajib dipilih.</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Kesesuaian Bidang Studi <span class="text-red-500">*</span>
                                    </label>
                                    <select name="q21_hubungan" x-model="formData.q21_hubungan" required
                                        class="p-2 w-full rounded-lg border shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all"
                                        :class="!formData.q21_hubungan ? 'border-red-300 bg-red-50/10' :
                                            'border-gray-300 bg-white'">
                                        <option value="">-- Pilih Tingkat --</option>
                                        <option value="Sangat Erat">Sangat Erat</option>
                                        <option value="Erat">Erat</option>
                                        <option value="Cukup Erat">Cukup Erat</option>
                                        <option value="Kurang Erat">Kurang Erat</option>
                                        <option value="Tidak Sama Sekali">Tidak Sama Sekali</option>
                                    </select>

                                    <div x-show="!formData.q21_hubungan" x-transition
                                        class="text-[10px] text-red-500 mt-1 ml-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Tingkat kesesuaian wajib dipilih.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <label class="block text-lg font-bold text-gray-800 mb-3">
                            Apakah ini pekerjaan pertama Anda setelah lulus? <span class="text-red-500">*</span>
                        </label>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="is_first_job" value="Ya" x-model="formData.is_first_job"
                                    required class="peer sr-only">
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

                        <p x-show="!formData.is_first_job" class="text-xs text-red-500 mb-4 animate-pulse">
                            * Silakan pilih salah satu status pekerjaan di atas.
                        </p>

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
                                Riwayat Pekerjaan Pertama <span class="text-red-500">*</span>
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-orange-900 mb-1">
                                        Nama Kantor Pertama <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="q25_kantor_pertama" x-model="formData.q25_kantor_pertama"
                                        :required="formData.is_first_job === 'Tidak'"
                                        class="p-2 w-full rounded-lg border shadow-sm focus:border-orange-500 focus:ring-orange-500 bg-white"
                                        :class="formData.is_first_job === 'Tidak' && !formData.q25_kantor_pertama ?
                                            'border-orange-400' : 'border-orange-300'"
                                        placeholder="Masukkan nama perusahaan/kantor sebelumnya">

                                    <p x-show="formData.is_first_job === 'Tidak' && !formData.q25_kantor_pertama"
                                        class="text-[10px] text-orange-600 mt-1 font-medium">
                                        Wajib diisi jika ini bukan pekerjaan pertama Anda.
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-orange-900 mb-1">
                                        Alasan Berhenti/Pindah <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="q26_alasan_berhenti"
                                        x-model="formData.q26_alasan_berhenti"
                                        :required="formData.is_first_job === 'Tidak'"
                                        class="p-2 w-full rounded-lg border shadow-sm focus:border-orange-500 focus:ring-orange-500 bg-white"
                                        :class="formData.is_first_job === 'Tidak' && !formData.q26_alasan_berhenti ?
                                            'border-orange-400' : 'border-orange-300'"
                                        placeholder="Cth: Mendapat tawaran lebih baik">

                                    <p x-show="formData.is_first_job === 'Tidak' && !formData.q26_alasan_berhenti"
                                        class="text-[10px] text-orange-600 mt-1 font-medium">
                                        Alasan wajib diisi.
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-orange-900 mb-1">
                                        Gaji Awal (Saat itu) <span class="text-red-500">*</span>
                                    </label>
                                    <select name="q28_gaji_pertama" x-model="formData.q28_gaji_pertama"
                                        :required="formData.is_first_job === 'Tidak'"
                                        class="p-2 w-full rounded-lg border shadow-sm focus:border-orange-500 focus:ring-orange-500 bg-white"
                                        :class="formData.is_first_job === 'Tidak' && !formData.q28_gaji_pertama ?
                                            'border-orange-400' : 'border-orange-300'">
                                        <option value="">-- Pilih Range --</option>
                                        <option value="< 3 Juta">
                                            < Rp 3 Juta</option>
                                        <option value="3 - 5 Juta">Rp 3 - 5 Juta</option>
                                        <option value="> 5 Juta">> Rp 5 Juta</option>
                                    </select>

                                    <p x-show="formData.is_first_job === 'Tidak' && !formData.q28_gaji_pertama"
                                        class="text-[10px] text-orange-600 mt-1 font-medium">
                                        Silakan pilih range gaji awal.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ========================================================================
             STEP 3: PENDIDIKAN & BELAJAR (SECTION C)
             ======================================================================== --}}
            <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0" class="p-8">

                <div class="mb-8 border-l-4 border-purple-600 pl-4">
                    <h2 class="text-2xl font-bold text-gray-800">C. Pengalaman Belajar</h2>
                    <p class="text-gray-500 mt-1">Bagikan pengalaman Anda selama menempuh pendidikan untuk evaluasi kampus.
                    </p>
                </div>

                <div class="space-y-8">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Latar Belakang
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tempat Tinggal Selama Kuliah <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="q33_tempat_tinggal" x-model="formData.q33_tempat_tinggal" required
                                            class="p-2 w-full rounded-lg border shadow-sm focus:border-purple-500 focus:ring-purple-500 cursor-pointer transition-all"
                                            :class="!formData.q33_tempat_tinggal ? 'border-red-300 bg-red-50/10' :
                                                'border-gray-300 bg-white'">
                                            <option value="">-- Pilih Tempat Tinggal --</option>
                                            <option value="Bersama Orang Tua">Bersama Orang Tua</option>
                                            <option value="Kos">Kos / Sewa</option>
                                            <option value="Asrama">Asrama</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div x-show="!formData.q33_tempat_tinggal" x-transition
                                        class="text-[10px] text-red-500 mt-1 ml-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Mohon pilih tempat tinggal Anda.</span>
                                    </div>

                                    <div x-show="formData.q33_tempat_tinggal === 'Lainnya'" x-transition
                                        class="mt-3 pl-2 border-l-4 border-purple-200">
                                        <input type="text" name="q33a_tempat_tinggal_lainnya"
                                            x-model="formData.q33a_tempat_tinggal_lainnya"
                                            :required="formData.q33_tempat_tinggal === 'Lainnya'"
                                            class="p-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50 text-sm"
                                            placeholder="Sebutkan tempat tinggal lainnya...">
                                        <p x-show="!formData.q33a_tempat_tinggal_lainnya"
                                            class="text-[10px] text-red-500 mt-1">Keterangan wajib diisi.</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Sumber Biaya Kuliah <span class="text-red-500">*</span>
                                    </label>
                                    <select name="q34_sumber_biaya" x-model="formData.q34_sumber_biaya" required
                                        class="p-2 w-full rounded-lg border shadow-sm focus:border-purple-500 focus:ring-purple-500 cursor-pointer transition-all"
                                        :class="!formData.q34_sumber_biaya ? 'border-red-300 bg-red-50/10' :
                                            'border-gray-300 bg-white'">
                                        <option value="">-- Pilih Sumber Biaya --</option>
                                        <option value="Biaya Sendiri / Keluarga">Biaya Sendiri / Keluarga</option>
                                        <option value="Beasiswa ADIK">Beasiswa ADIK</option>
                                        <option value="Beasiswa BIDIKMISI">Beasiswa BIDIKMISI</option>
                                        <option value="Beasiswa Lain">Beasiswa Lainnya</option>
                                    </select>

                                    <div x-show="!formData.q34_sumber_biaya" x-transition
                                        class="text-[10px] text-red-500 mt-1 ml-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Mohon pilih sumber biaya kuliah Anda.</span>
                                    </div>

                                    <div x-show="formData.q34_sumber_biaya === 'Beasiswa Lain'" x-transition
                                        class="mt-3 pl-2 border-l-4 border-purple-200">
                                        <label class="block text-[10px] font-semibold text-purple-700 mb-1">Nama
                                            Beasiswa</label>
                                        <input type="text" name="q34a_sumber_biaya_lainnya"
                                            x-model="formData.q34a_sumber_biaya_lainnya"
                                            :required="formData.q34_sumber_biaya === 'Beasiswa Lain'"
                                            class="p-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50 text-sm"
                                            placeholder="Sebutkan nama beasiswa lainnya...">

                                        <p x-show="!formData.q34a_sumber_biaya_lainnya"
                                            class="text-[10px] text-red-500 mt-1">Nama beasiswa wajib diisi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="bg-purple-50 rounded-xl border border-purple-100 p-6 flex flex-col h-full">
                            <div>
                                <label class="font-bold text-gray-800 mb-3 block">
                                    Aktif di Organisasi Kampus? <span class="text-red-500">*</span>
                                </label>

                                <div class="flex gap-4 mb-2">
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="q35_organisasi" value="Ya"
                                            x-model="formData.q35_organisasi" required class="peer sr-only">
                                        <div
                                            class="text-center py-2 px-4 border rounded-lg bg-white text-gray-600 peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-600 transition shadow-sm hover:border-purple-300">
                                            Ya
                                        </div>
                                    </label>
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="q35_organisasi" value="Tidak"
                                            x-model="formData.q35_organisasi" class="peer sr-only">
                                        <div
                                            class="text-center py-2 px-4 border rounded-lg bg-white text-gray-600 peer-checked:bg-gray-600 peer-checked:text-white peer-checked:border-gray-600 transition shadow-sm hover:border-gray-300">
                                            Tidak
                                        </div>
                                    </label>
                                </div>

                                <div x-show="!formData.q35_organisasi" x-transition
                                    class="text-[10px] text-red-500 mt-1 mb-3 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Silakan pilih salah satu jawaban.</span>
                                </div>

                                <div x-show="formData.q35_organisasi === 'Ya'" x-transition
                                    class="mt-3 p-4 bg-purple-50 rounded-xl border border-purple-100 relative">
                                    <div
                                        class="absolute -top-2 left-1/4 w-4 h-4 bg-purple-50 border-t border-l border-purple-100 transform rotate-45">
                                    </div>

                                    <label class="block text-xs font-semibold text-purple-900 mb-2">Sebutkan Nama
                                        Organisasi <span class="text-red-500">*</span></label>
                                    <input type="text" name="q35a_nama_organisasi"
                                        x-model="formData.q35a_nama_organisasi"
                                        :required="formData.q35_organisasi === 'Ya'"
                                        class="p-2 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-white text-sm"
                                        placeholder="Contoh: BEM, Himpunan Mahasiswa, UKM Seni">

                                    <p x-show="!formData.q35a_nama_organisasi" class="text-[10px] text-red-500 mt-1">Nama
                                        organisasi tidak boleh kosong.</p>
                                </div>
                            </div>

                            <div x-show="formData.q35_organisasi === 'Ya'" x-transition
                                class="mt-auto pt-4 border-t border-purple-200">
                                <div>
                                    <label class="text-xs font-semibold text-purple-700 uppercase mb-1 block">
                                        Tingkat Keaktifan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="q36_keaktifan" x-model="formData.q36_keaktifan" {{-- Wajib diisi jika pertanyaan organisasi dijawab 'Ya' --}}
                                        :required="formData.q35_organisasi === 'Ya'"
                                        class="p-2 w-full rounded-md border shadow-sm focus:ring-purple-500 focus:border-purple-500 text-sm transition-all"
                                        :class="!formData.q36_keaktifan ? 'border-red-300 bg-red-50/10' :
                                            'border-purple-300 bg-white'">
                                        <option value="">-- Pilih Tingkat --</option>
                                        <option value="Anggota Biasa">Anggota Biasa</option>
                                        <option value="Pengurus">Pengurus</option>
                                        <option value="Ketua">Ketua / Pimpinan</option>
                                    </select>

                                    <div x-show="!formData.q36_keaktifan && formData.q35_organisasi === 'Ya'" x-transition
                                        class="text-[10px] text-red-500 mt-1 ml-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Mohon pilih peran Anda dalam organisasi.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded-xl border border-blue-100 p-6 flex flex-col h-full">
                            <label class="font-bold text-gray-800 mb-3 block">Pendidikan Tambahan / Kursus?</label>

                            <div class="flex gap-4 mb-4">
                                <div>
                                    <label class="font-bold text-gray-800 mb-3 block">
                                        Pernah Mengikuti Kursus/Pelatihan? <span class="text-red-500">*</span>
                                    </label>

                                    <div class="flex gap-4 mb-2">
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="q37_kursus" value="Ya"
                                                x-model="formData.q37_kursus" required class="peer sr-only">
                                            <div
                                                class="text-center py-2 px-4 border rounded-lg bg-white text-gray-600 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition shadow-sm hover:border-blue-300">
                                                Ya
                                            </div>
                                        </label>
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="q37_kursus" value="Tidak"
                                                x-model="formData.q37_kursus" class="peer sr-only">
                                            <div
                                                class="text-center py-2 px-4 border rounded-lg bg-white text-gray-600 peer-checked:bg-gray-600 peer-checked:text-white peer-checked:border-gray-600 transition shadow-sm hover:border-gray-300">
                                                Tidak
                                            </div>
                                        </label>
                                    </div>

                                    <div x-show="!formData.q37_kursus" x-transition
                                        class="text-[10px] text-red-500 mt-1 mb-3 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Silakan pilih Ya atau Tidak.</span>
                                    </div>

                                </div>
                            </div>

                            <div x-show="formData.q37_kursus === 'Ya'" x-transition
                                class="mt-auto pt-4 border-t border-blue-200">
                                <div>
                                    <label class="text-xs font-semibold text-blue-700 uppercase mb-1 block">
                                        Nama Kursus <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="q37a_nama_kursus" x-model="formData.q37a_nama_kursus"
                                        {{-- Wajib diisi hanya jika user memilih 'Ya' pada status kursus --}} :required="formData.q37_kursus === 'Ya'"
                                        class="p-2 w-full rounded-md border shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm transition-all"
                                        :class="formData.q37_kursus === 'Ya' && !formData.q37a_nama_kursus ?
                                            'border-red-300 bg-red-50/10' : 'border-blue-300 bg-white'"
                                        placeholder="Contoh: English Course">

                                    <p x-show="formData.q37_kursus === 'Ya' && !formData.q37a_nama_kursus" x-transition
                                        class="text-[10px] text-red-500 mt-1 ml-1 font-medium">
                                        Silakan sebutkan nama kursus yang pernah diikuti.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 space-y-8">

                        <div
                            class="bg-gray-800 text-white rounded-lg p-4 flex justify-between items-center shadow-md sticky top-0 z-10 opacity-95">
                            <span class="text-xs md:text-sm font-bold">Panduan Skala:</span>
                            <div class="flex items-center gap-4 text-xs md:text-sm">
                                <div class="flex items-center gap-1"><span
                                        class="w-3 h-3 rounded-full bg-red-400 block"></span> 1: Buruk</div>
                                <div class="flex items-center gap-1"><span
                                        class="w-3 h-3 rounded-full bg-green-400 block"></span> 5: Sangat Baik</div>
                            </div>
                        </div>

                        {{-- Bagian Evaluasi Pembelajaran --}}
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-4 pl-2 border-l-4 border-purple-500">
                                Evaluasi Pembelajaran <span class="text-red-500 text-sm">*</span>
                            </h3>
                            <div class="space-y-4">
                                @foreach ($aspek_pembelajaran as $key => $label)
                                    <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition duration-200"
                                        :class="!formData.{{ $key }} ? 'border-red-100 bg-red-50/10' :
                                            'border-gray-200'">

                                        <div class="flex justify-between items-start mb-3">
                                            <p class="text-gray-700 font-medium">{{ $label }}</p>
                                            {{-- Alert kecil jika belum diisi --}}
                                            <span x-show="!formData.{{ $key }}"
                                                class="text-[10px] text-red-400 font-bold animate-pulse">WAJIB ISI</span>
                                        </div>

                                        <div class="flex justify-between md:justify-start md:gap-4">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer relative">
                                                    <input type="radio" name="{{ $key }}"
                                                        value="{{ $i }}"
                                                        x-model="formData.{{ $key }}" required
                                                        {{-- Browser validation --}} class="peer sr-only">
                                                    <div
                                                        class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 bg-gray-50 text-gray-400 font-bold hover:bg-purple-50 hover:border-purple-200 hover:text-purple-600 transition-all peer-checked:bg-purple-600 peer-checked:border-purple-600 peer-checked:text-white peer-checked:scale-110 shadow-sm">
                                                        {{ $i }}
                                                    </div>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Bagian Evaluasi Fasilitas --}}
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 pl-2 border-l-4 border-indigo-500">
                                Evaluasi Fasilitas <span class="text-red-500 text-sm">*</span>
                            </h3>
                            <div class="space-y-4">
                                @foreach ($fasilitas as $key => $label)
                                    <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition duration-200"
                                        :class="!formData.{{ $key }} ? 'border-red-100 bg-red-50/10' :
                                            'border-gray-200'">

                                        <div class="flex justify-between items-start mb-3">
                                            <p class="text-gray-700 font-medium">{{ $label }}</p>
                                            <span x-show="!formData.{{ $key }}"
                                                class="text-[10px] text-red-400 font-bold animate-pulse">WAJIB ISI</span>
                                        </div>

                                        <div class="flex justify-between md:justify-start md:gap-4">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer relative">
                                                    <input type="radio" name="{{ $key }}"
                                                        value="{{ $i }}"
                                                        x-model="formData.{{ $key }}" required
                                                        {{-- Browser validation --}} class="peer sr-only">
                                                    <div
                                                        class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 bg-gray-50 text-gray-400 font-bold hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition-all peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:text-white peer-checked:scale-110 shadow-sm">
                                                        {{ $i }}
                                                    </div>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ========================================================================
             STEP 4: KOMPETENSI & PENUTUP (SECTION D)
             ======================================================================== --}}
            <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0" class="p-8">

                <div class="mb-8 border-l-4 border-green-500 pl-4">
                    <h2 class="text-2xl font-bold text-gray-800">D. Kompetensi & Penutup</h2>
                    <p class="text-gray-500 mt-1">Langkah terakhir! Evaluasi diri dan berikan masukan untuk kampus.</p>
                </div>

                <div class="space-y-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-6 border-b pb-4">
                            <h3 class="text-lg font-bold text-gray-800">Kompetensi Diri <span
                                    class="text-red-500">*</span></h3>
                            <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                Skala 1 (Rendah) - 5 (Tinggi)
                            </div>
                        </div>

                        <div class="space-y-6">
                            @foreach ($kompetensi as $key => $label)
                                <div class="group p-3 rounded-lg transition"
                                    :class="!formData.q42{{ $key }} ? 'bg-red-50/30' : ''">
                                    <div class="flex justify-between items-center mb-3">
                                        <p class="text-gray-700 font-medium group-hover:text-green-700 transition">
                                            {{ $label }}</p>
                                        <span x-show="!formData.q42{{ $key }}"
                                            class="text-[10px] text-red-400 font-bold animate-pulse">WAJIB</span>
                                    </div>

                                    <div class="flex justify-between md:justify-start md:gap-4">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer relative">
                                                <input type="radio" name="q42{{ $key }}"
                                                    value="{{ $i }}"
                                                    x-model="formData.q42{{ $key }}" required
                                                    class="peer sr-only">
                                                <div
                                                    class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 bg-gray-50 text-gray-400 font-bold hover:bg-green-50 hover:border-green-200 hover:text-green-600 transition-all peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white peer-checked:shadow-md peer-checked:scale-110">
                                                    {{ $i }}
                                                </div>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-xl border border-green-200 p-6 space-y-8">
                        <h3 class="font-bold text-green-900 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Umpan Balik Terakhir
                        </h3>

                        <div class="bg-white p-5 rounded-lg shadow-sm border"
                            :class="!formData.q45_bahasa ? 'border-red-200' : 'border-transparent'">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Bagaimana kemampuan Bahasa Asing
                                Anda? <span class="text-red-500">*</span></label>
                            <div class="flex justify-between md:justify-start md:gap-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="q45_bahasa" value="{{ $i }}"
                                            x-model="formData.q45_bahasa" required class="peer sr-only">
                                        <div
                                            class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-200 text-gray-500 hover:border-blue-400 peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white transition">
                                            {{ $i }}
                                        </div>
                                    </label>
                                @endfor
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-3">Memilih UIN Suska lagi jika
                                    mengulang? <span class="text-red-500">*</span></label>
                                <div class="flex gap-3 mb-3">
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="q47_uin" value="Ya" x-model="formData.q47_uin"
                                            required class="peer sr-only">
                                        <div
                                            class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 bg-white hover:bg-green-50 peer-checked:border-green-500 peer-checked:bg-green-100 transition">
                                            <span class="text-xl">😍</span>
                                            <span class="text-sm font-bold mt-1 text-center">Ya, Pasti</span>
                                        </div>
                                    </label>
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="q47_uin" value="Tidak" x-model="formData.q47_uin"
                                            class="peer sr-only">
                                        <div
                                            class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 bg-white hover:bg-red-50 peer-checked:border-red-500 peer-checked:bg-red-100 transition">
                                            <span class="text-xl">🤔</span>
                                            <span class="text-sm font-bold mt-1 text-center">Mungkin Tidak</span>
                                        </div>
                                    </label>
                                </div>
                                <div x-show="formData.q47_uin === 'Tidak'" x-transition class="mt-2">
                                    <textarea name="q48_alasan_uin" x-model="formData.q48_alasan_uin" rows="2"
                                        :required="formData.q47_uin === 'Tidak'"
                                        class="p-2 w-full rounded-md border-red-300 focus:ring-red-500 text-sm"
                                        placeholder="Kritik & saran Anda sangat berharga..."></textarea>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-3">Memilih Prodi yang sama lagi?
                                    <span class="text-red-500">*</span></label>
                                <div class="flex gap-3 mb-3">
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="q49_prodi" value="Ya"
                                            x-model="formData.q49_prodi" required class="peer sr-only">
                                        <div
                                            class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 bg-white hover:bg-green-50 peer-checked:border-green-500 peer-checked:bg-green-100 transition">
                                            <span class="text-xl">📚</span>
                                            <span class="text-sm font-bold mt-1 text-center">Ya, Sesuai</span>
                                        </div>
                                    </label>
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="q49_prodi" value="Tidak"
                                            x-model="formData.q49_prodi" class="peer sr-only">
                                        <div
                                            class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 bg-white hover:bg-red-50 peer-checked:border-red-500 peer-checked:bg-red-100 transition">
                                            <span class="text-xl">🔄</span>
                                            <span class="text-sm font-bold mt-1 text-center">Ingin Pindah</span>
                                        </div>
                                    </label>
                                </div>
                                <div x-show="formData.q49_prodi === 'Tidak'" x-transition class="mt-2">
                                    <textarea name="q50_alasan_prodi" x-model="formData.q50_alasan_prodi" rows="2"
                                        :required="formData.q49_prodi === 'Tidak'"
                                        class="p-2 w-full rounded-md border-red-300 focus:ring-red-500 text-sm" placeholder="Apa alasan utamanya?"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- NAVIGATION BAR (Sticky & Modern) --}}
            <div
                class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-50">
                <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">

                    <button type="button" x-show="currentStep > 1" @click="prevStep"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium transition duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        <span class="hidden sm:inline">Kembali</span>
                    </button>
                    <div x-show="currentStep === 1"></div> {{-- Spacer jika tidak ada tombol kembali --}}

                    <div class="hidden sm:flex gap-1">
                        <template x-for="step in steps">
                            <div class="w-2.5 h-2.5 rounded-full transition-colors duration-300"
                                :class="step <= currentStep ? 'bg-blue-600' : 'bg-gray-300'"></div>
                        </template>
                    </div>

                    <button type="button" x-show="currentStep < steps.length" @click="nextStep"
                        class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-lg hover:shadow-blue-500/30 font-medium transition duration-200 transform hover:-translate-y-0.5">
                        <span>Lanjut</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>

                    <button type="submit" x-show="currentStep === steps.length" :disabled="isLoading"
                        class="flex items-center gap-2 px-8 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-lg hover:from-green-600 hover:to-emerald-700 shadow-lg hover:shadow-green-500/30 transition duration-200 transform hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed">

                        <svg x-show="isLoading" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>

                        <span x-text="isLoading ? 'Menyimpan Data...' : 'Selesai & Kirim'"></span>
                        <svg x-show="!isLoading" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="h-24"></div>

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
