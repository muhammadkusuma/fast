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
            <div x-show="currentStep === 1" x-transition.opacity class="p-8 space-y-6">
                <div class="border-l-4 border-blue-500 pl-4">
                    <h2 class="text-xl font-bold text-gray-800">A. Data Pribadi</h2>
                    <p class="text-sm text-gray-500">Pastikan data diri Anda mutakhir.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Read Only Fields --}}
                    <div class="space-y-4 md:col-span-2 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="label">NIM</label>
                                <input type="text" value="{{ $alumni->nim }}" class="input-field bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="label">Nama Lengkap</label>
                                <input type="text" name="q1_nama" value="{{ $alumni->nama_lengkap }}"
                                    class="input-field bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="label">Prodi</label>
                                <input type="text" name="q3_prodi" value="{{ $alumni->prodi->nama_prodi ?? '-' }}"
                                    class="input-field bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="label">Angkatan</label>
                                <input type="text" name="q2_angkatan" value="{{ $alumni->tahun_masuk }}"
                                    class="input-field bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="label">IPK</label>
                                <input type="text" name="q4_ipk" value="{{ $alumni->ipk }}"
                                    class="input-field bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="label">Tanggal Lulus (Ijazah) <span class="text-red-500">*</span></label>
                                <input type="date" name="q5_tanggal_lulus" x-model="formData.q5_tanggal_lulus"
                                    class="input-field">
                            </div>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label class="label">Alamat Rumah Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="q6_alamat" x-model="formData.q6_alamat" rows="2" class="input-field"
                            placeholder="Jalan, RT/RW, Kelurahan..."></textarea>
                    </div>

                    {{-- Provinsi & Kota --}}
                    <div>
                        <label class="label">Provinsi <span class="text-red-500">*</span></label>
                        <select name="q7_provinsi" x-model="formData.q7_provinsi" @change="loadKabupaten()"
                            class="input-field">
                            <option value="">-- Pilih Provinsi --</option>
                            <template x-for="p in listProvinsi">
                                <option :value="p" x-text="p"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="label">Kabupaten/Kota <span class="text-red-500">*</span></label>
                        <select name="q9_kota" x-model="formData.q9_kota" :disabled="!formData.q7_provinsi"
                            class="input-field">
                            <option value="">-- Pilih Kota --</option>
                            <template x-for="k in listKabupaten">
                                <option :value="k" x-text="k"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Kode Pos --}}
                    <div>
                        <label class="label">Kode Pos <span class="text-red-500">*</span></label>
                        <input type="number" name="q8_kodepos" x-model="formData.q8_kodepos" class="input-field">
                    </div>

                    {{-- Kontak --}}
                    <div>
                        <label class="label">Nomor HP (WA) <span class="text-red-500">*</span></label>
                        <input type="text" name="q10a_no_hp" x-model="formData.q10a_no_hp" class="input-field"
                            placeholder="0812...">
                    </div>
                    <div>
                        <label class="label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="q10b_email" x-model="formData.q10b_email" class="input-field">
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="label">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <div class="flex gap-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="q11_jenis_kelamin" value="Laki-laki"
                                    x-model="formData.q11_jenis_kelamin" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2">Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="q11_jenis_kelamin" value="Perempuan"
                                    x-model="formData.q11_jenis_kelamin" class="text-pink-600 focus:ring-pink-500">
                                <span class="ml-2">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    {{-- STATUS LOGIC BLOCK --}}
                    <div class="md:col-span-2 bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <label class="label text-blue-800 text-lg">Status Saat Ini <span
                                class="text-red-500">*</span></label>
                        <select name="status_bekerja" x-model="formData.status_bekerja"
                            class="input-field border-blue-300 ring-blue-200">
                            <option value="">-- Pilih Status --</option>
                            <option value="Sudah Bekerja">Sudah Bekerja / Wiraswasta</option>
                            <option value="Belum Bekerja">Belum Bekerja / Sedang Mencari</option>
                            <option value="Sedang Kuliah">Sedang Melanjutkan Pendidikan</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ========================================================================
             STEP 2: PEKERJAAN (SECTION B) - Only if 'Sudah Bekerja'
             ======================================================================== --}}
            <div x-show="currentStep === 2" x-transition.opacity class="p-8 space-y-6">

                {{-- Logic Skip --}}
                <div x-show="formData.status_bekerja !== 'Sudah Bekerja'" class="text-center py-10">
                    <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Langkah ini dilewati</h3>
                    <p class="text-gray-500">Karena Anda belum bekerja, silakan lanjut ke langkah berikutnya.</p>
                </div>

                {{-- Form Pekerjaan --}}
                <div x-show="formData.status_bekerja === 'Sudah Bekerja'" class="space-y-6">
                    <div class="border-l-4 border-orange-500 pl-4">
                        <h2 class="text-xl font-bold text-gray-800">B. Pekerjaan Saat Ini</h2>
                        <p class="text-sm text-gray-500">Detail instansi atau usaha Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Jenis Instansi --}}
                        <div class="md:col-span-2">
                            <label class="label">Jenis Instansi / Perusahaan <span class="text-red-500">*</span></label>
                            <select name="q12_jenis_perusahaan" x-model="formData.q12_jenis_perusahaan"
                                class="input-field">
                                <option value="">-- Pilih --</option>
                                <option value="Instansi Pemerintah">Instansi Pemerintah</option>
                                <option value="BUMN/BUMD">BUMN/BUMD</option>
                                <option value="Swasta Nasional">Institusi/Swasta Nasional</option>
                                <option value="Swasta Multinasional">Institusi/Swasta Multinasional</option>
                                <option value="Wiraswasta">Wiraswasta</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            {{-- Input Lainnya --}}
                            <div x-show="formData.q12_jenis_perusahaan === 'Lainnya'" class="mt-2">
                                <input type="text" name="q12a_lainnya" x-model="formData.q12a_lainnya"
                                    class="input-field" placeholder="Sebutkan jenis instansi...">
                            </div>
                        </div>

                        {{-- Nama & Detail --}}
                        <div>
                            <label class="label">Nama Perusahaan / Kantor <span class="text-red-500">*</span></label>
                            <input type="text" name="q13a_nama_kantor" x-model="formData.q13a_nama_kantor"
                                class="input-field">
                        </div>
                        <div>
                            <label class="label">Tahun Mulai Bekerja <span class="text-red-500">*</span></label>
                            <input type="number" name="q15_tahun_masuk" x-model="formData.q15_tahun_masuk"
                                class="input-field" placeholder="2024">
                        </div>

                        {{-- Pimpinan --}}
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded border">
                            <div class="md:col-span-3">
                                <p class="text-xs font-bold text-gray-500 uppercase">Data Pimpinan (Atasan Langsung)</p>
                            </div>
                            <div>
                                <label class="label">Nama Pimpinan</label>
                                <input type="text" name="q13b_pimpinan" x-model="formData.q13b_pimpinan"
                                    class="input-field">
                            </div>
                            <div>
                                <label class="label">Email Pimpinan</label>
                                <input type="email" name="q13c_email_pimpinan" x-model="formData.q13c_email_pimpinan"
                                    class="input-field">
                            </div>
                            <div>
                                <label class="label">No HP Pimpinan</label>
                                <input type="text" name="q16_telp_pimpinan" x-model="formData.q16_telp_pimpinan"
                                    class="input-field">
                            </div>
                        </div>

                        {{-- Gaji & Keselarasan --}}
                        <div>
                            <label class="label">Rata-rata Penghasilan / Bulan <span
                                    class="text-red-500">*</span></label>
                            <select name="q19_penghasilan" x-model="formData.q19_penghasilan" class="input-field">
                                <option value="">-- Pilih Range --</option>
                                <option value="< 3 Juta">
                                    < 3 Juta</option>
                                <option value="3 - 5 Juta">3 - 5 Juta</option>
                                <option value="5 - 10 Juta">5 - 10 Juta</option>
                                <option value="> 10 Juta">> 10 Juta</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Hubungan Pekerjaan dgn Prodi <span class="text-red-500">*</span></label>
                            <select name="q21_hubungan" x-model="formData.q21_hubungan" class="input-field">
                                <option value="">-- Pilih --</option>
                                <option value="Sangat Erat">Sangat Erat</option>
                                <option value="Erat">Erat</option>
                                <option value="Cukup Erat">Cukup Erat</option>
                                <option value="Kurang Erat">Kurang Erat</option>
                                <option value="Tidak Sama Sekali">Tidak Sama Sekali</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Status Pekerjaan <span class="text-red-500">*</span></label>
                            <select name="q20_status_pekerjaan" x-model="formData.q20_status_pekerjaan"
                                class="input-field">
                                <option value="">-- Pilih --</option>
                                <option value="Tetap">Tetap (PNS/Swasta)</option>
                                <option value="Kontrak">Kontrak</option>
                                <option value="Honorer">Honorer</option>
                                <option value="Self Employed">Wiraswasta / Self Employed</option>
                            </select>
                        </div>
                    </div>

                    {{-- LOGIC BLOCK: RIWAYAT PEKERJAAN PERTAMA --}}
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <label class="label text-base">Apakah ini pekerjaan pertama Anda setelah lulus? <span
                                class="text-red-500">*</span></label>
                        <div class="flex gap-6 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="is_first_job" value="Ya" x-model="formData.is_first_job"
                                    class="text-green-600 focus:ring-green-500">
                                <span class="ml-2 font-medium">Ya, ini pekerjaan pertama</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="is_first_job" value="Tidak" x-model="formData.is_first_job"
                                    class="text-red-600 focus:ring-red-500">
                                <span class="ml-2 font-medium">Tidak</span>
                            </label>
                        </div>

                        {{-- Form Pekerjaan Pertama (Hidden if Yes) --}}
                        <div x-show="formData.is_first_job === 'Tidak'" x-transition
                            class="mt-6 bg-orange-50 p-6 rounded-lg border border-orange-200">
                            <h4 class="font-bold text-gray-800 mb-4 border-b border-orange-200 pb-2">Riwayat Pekerjaan
                                Pertama</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="label">Nama Kantor Pertama</label>
                                    <input type="text" name="q25_kantor_pertama" x-model="formData.q25_kantor_pertama"
                                        class="input-field">
                                </div>
                                <div>
                                    <label class="label">Alasan Berhenti/Pindah</label>
                                    <input type="text" name="q26_alasan_berhenti"
                                        x-model="formData.q26_alasan_berhenti" class="input-field">
                                </div>
                                <div>
                                    <label class="label">Gaji Pertama</label>
                                    <select name="q28_gaji_pertama" x-model="formData.q28_gaji_pertama"
                                        class="input-field">
                                        <option value="">-- Pilih Range --</option>
                                        <option value="< 3 Juta">
                                            < 3 Juta</option>
                                        <option value="3 - 5 Juta">3 - 5 Juta</option>
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
