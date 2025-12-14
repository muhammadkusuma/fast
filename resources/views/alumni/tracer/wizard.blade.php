@extends('layouts.main')

@section('title', 'Isi Tracer Study')
@section('header', 'Kuesioner Tracer Study')

@section('content')
    <div x-data="tracerWizard()" class="max-w-4xl mx-auto pb-20">

        {{-- PROGRESS BAR --}}
        <div class="mb-8">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 -z-10"></div>
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-primary -z-10 transition-all duration-500"
                    :style="'width: ' + ((currentStep - 1) * 50) + '%'"></div>

                <template x-for="(step, index) in steps" :key="index">
                    <div class="flex flex-col items-center bg-gray-50 px-2 cursor-pointer"
                        @click="if(currentStep > index + 1) currentStep = index + 1">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white transition-all duration-300 ring-4 ring-white"
                            :class="currentStep > index + 1 ? 'bg-green-500' : (currentStep === index + 1 ?
                                'bg-primary scale-110 shadow-lg' : 'bg-gray-300 text-gray-500')">

                            <template x-if="currentStep > index + 1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </template>
                            <template x-if="currentStep <= index + 1">
                                <span x-text="index + 1"></span>
                            </template>
                        </div>
                        <span class="text-xs font-semibold mt-2 transition-colors"
                            :class="currentStep >= index + 1 ? 'text-primary' : 'text-gray-400'" x-text="step"></span>
                    </div>
                </template>
            </div>
        </div>

        <form action="{{ route('alumni.tracer.store') }}" method="POST" @submit="isLoading = true"
            class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden relative">
            @csrf

            {{-- STEP 1: PEKERJAAN --}}
            <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                class="p-8 space-y-6">

                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Status Aktivitas Saat Ini</h2>
                    <p class="text-sm text-gray-500">Pilih status utama Anda</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jelaskan status Anda saat ini? <span
                            class="text-red-500">*</span></label>
                    <select x-model="formData.statusAktivitas" name="status_aktivitas"
                        class="p-3 w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary transition"
                        :class="errors.statusAktivitas ? 'border-red-500 ring-1 ring-red-500' : ''">
                        <option value="">-- Pilih Status --</option>
                        <option value="Bekerja (Full Time/Part Time)">Bekerja (Full Time/Part Time)</option>
                        <option value="Wiraswasta">Wiraswasta / Punya Usaha Sendiri</option>
                        <option value="Melanjutkan Pendidikan">Melanjutkan Pendidikan</option>
                        <option value="Tidak Bekerja">Sedang Mencari Pekerjaan / Belum Bekerja</option>
                        <option value="Lainnya">Lainnya (Rumah Tangga, dll)</option>
                    </select>
                    <p x-show="errors.statusAktivitas" class="text-red-500 text-xs mt-1">Status harus dipilih.</p>
                </div>

                {{-- FORM KHUSUS BEKERJA --}}
                <div x-show="isBekerja()" x-collapse class="space-y-6 bg-blue-50 p-6 rounded-lg border border-blue-100">
                    <h3 class="font-bold text-primary flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Detail Pekerjaan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.namaPerusahaan" name="nama_perusahaan"
                                class="p-2 w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary"
                                :class="errors.namaPerusahaan ? 'border-red-500' : ''">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Instansi <span
                                    class="text-red-500">*</span></label>
                            <select x-model="formData.jenisInstansi" name="jenis_instansi"
                                class="p-2 w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary"
                                :class="errors.jenisInstansi ? 'border-red-500' : ''">
                                <option value="">-- Pilih --</option>
                                <option>Instansi Pemerintah</option>
                                <option>BUMN / BUMD</option>
                                <option>Swasta Nasional</option>
                                <option>Multinasional / Asing</option>
                                <option>Wiraswasta</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gaji / Bulan <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>

                                <input type="text" x-model="displayGaji" @input="formatGaji($el.value)"
                                    class="p-2 w-full pl-10 rounded-lg border-gray-300 focus:ring-primary focus:border-primary"
                                    :class="errors.gaji ? 'border-red-500' : ''" placeholder="0" inputmode="numeric"
                                    autocomplete="off">

                                <input type="hidden" name="gaji" x-model="formData.gaji">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span
                                    class="text-red-500">*</span></label>
                            <select x-model="formData.provinsi" name="provinsi"
                                class="p-2 w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary"
                                :class="errors.provinsi ? 'border-red-500' : ''">
                                <option value="">-- Pilih --</option>
                                <option>Riau</option>
                                <option>DKI Jakarta</option>
                                <option>Jawa Barat</option>
                                <option>Sumatera Barat</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keselarasan Studi & Pekerjaan <span
                                class="text-red-500">*</span></label>
                        <div class="flex gap-2 flex-wrap">
                            <template
                                x-for="option in ['Sangat Erat', 'Erat', 'Cukup Erat', 'Kurang', 'Tidak Sama Sekali']">
                                <label
                                    class="flex items-center space-x-2 border px-3 py-2 rounded-lg cursor-pointer transition-colors"
                                    :class="formData.keselarasan === option ? 'bg-primary/10 border-primary text-primary' :
                                        'hover:bg-gray-50 bg-white border-gray-200'">
                                    <input type="radio" name="keselarasan" :value="option"
                                        x-model="formData.keselarasan" class="text-primary focus:ring-primary">
                                    <span class="text-sm" x-text="option"></span>
                                </label>
                            </template>
                        </div>
                        <p x-show="errors.keselarasan" class="text-red-500 text-xs mt-1">Wajib dipilih.</p>
                    </div>
                </div>
            </div>

            {{-- STEP 2: RIWAYAT --}}
            <div x-show="currentStep === 2" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                class="p-8 space-y-6">

                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Proses Pencarian Kerja</h2>
                    <p class="text-sm text-gray-500">Informasi ini untuk mengukur masa tunggu lulusan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kapan mulai mencari kerja? <span
                                class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer transition-all"
                                :class="formData.waktuMencari === 'Sebelum Lulus' ?
                                    'ring-2 ring-primary border-transparent bg-blue-50' : 'hover:bg-gray-50 bg-white'">
                                <input type="radio" name="waktu_mencari" value="Sebelum Lulus"
                                    x-model="formData.waktuMencari" class="h-5 w-5 text-primary">
                                <div>
                                    <span class="block font-bold text-gray-800">Sebelum Lulus</span>
                                    <span class="text-xs text-gray-500">Saat skripsi/kuliah</span>
                                </div>
                            </label>
                            <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer transition-all"
                                :class="formData.waktuMencari === 'Sesudah Lulus' ?
                                    'ring-2 ring-primary border-transparent bg-blue-50' : 'hover:bg-gray-50 bg-white'">
                                <input type="radio" name="waktu_mencari" value="Sesudah Lulus"
                                    x-model="formData.waktuMencari" class="h-5 w-5 text-primary">
                                <div>
                                    <span class="block font-bold text-gray-800">Sesudah Lulus</span>
                                    <span class="text-xs text-gray-500">Setelah wisuda</span>
                                </div>
                            </label>
                        </div>
                        <p x-show="errors.waktuMencari" class="text-red-500 text-xs mt-1">Wajib dipilih.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Tunggu (Bulan) <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="waktu_tunggu" x-model="formData.waktuTunggu" placeholder="0"
                            class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary"
                            :class="errors.waktuTunggu ? 'border-red-500' : ''">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Lamaran <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="jumlah_lamaran" x-model="formData.jumlahLamaran" placeholder="10"
                            class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary"
                            :class="errors.jumlahLamaran ? 'border-red-500' : ''">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sumber Info Lowongan <span
                                class="text-red-500">*</span></label>
                        <select name="sumber_info" x-model="formData.sumberInfo"
                            class="p-2 w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary"
                            :class="errors.sumberInfo ? 'border-red-500' : ''">
                            <option value="">-- Pilih --</option>
                            <option>Internet / Media Sosial / Apps</option>
                            <option>Pusat Karir Kampus</option>
                            <option>Koneksi Teman / Keluarga</option>
                            <option>Job Fair</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- STEP 3: EVALUASI (KOMPETENSI) --}}
            <div x-show="currentStep === 3" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                class="p-8 space-y-8">

                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Kompetensi & Evaluasi Kampus</h2>
                    <p class="text-sm text-gray-500">Nilai kompetensi: 1 (Sangat Rendah) sampai 5 (Sangat Tinggi).</p>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-4 py-3">Jenis Kompetensi</th>
                                <th class="px-4 py-3 text-center bg-blue-50 w-48">Kampus</th>
                                <th class="px-4 py-3 text-center bg-green-50 w-48">Pekerjaan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            {{-- Reusable Loop untuk Kompetensi --}}
                            @php
                                $kompetensi = [
                                    ['label' => 'Etika & Moral', 'nameA' => 'etika_kampus', 'nameB' => 'etika_kerja'],
                                    [
                                        'label' => 'Hard Skill',
                                        'nameA' => 'hardskill_kampus',
                                        'nameB' => 'hardskill_kerja',
                                    ],
                                    [
                                        'label' => 'Bahasa Inggris',
                                        'nameA' => 'inggris_kampus',
                                        'nameB' => 'inggris_kerja',
                                    ],
                                ];
                            @endphp

                            @foreach ($kompetensi as $k)
                                <tr class="bg-white hover:bg-gray-50">
                                    <td class="px-4 py-4 font-medium text-gray-900">{{ $k['label'] }} <span
                                            class="text-red-500">*</span></td>
                                    <td class="px-4 py-4 text-center bg-blue-50/30">
                                        <div class="flex justify-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="{{ $k['nameA'] }}"
                                                        value="{{ $i }}" class="sr-only peer" required>
                                                    <div
                                                        class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 hover:bg-blue-100 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition font-bold">
                                                        {{ $i }}</div>
                                                </label>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center bg-green-50/30">
                                        <div class="flex justify-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="{{ $k['nameB'] }}"
                                                        value="{{ $i }}" class="sr-only peer" required>
                                                    <div
                                                        class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 hover:bg-green-100 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition font-bold">
                                                        {{ $i }}</div>
                                                </label>
                                            @endfor
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Evaluasi Dosen & Fasilitas --}}
                <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-100">
                    <h3 class="font-bold text-yellow-800 mb-4">Evaluasi Fasilitas Kampus</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fasilitas Laboratorium <span
                                    class="text-red-500">*</span></label>
                            <select name="eval_lab"
                                class="p-2 w-full rounded-lg border-gray-300 text-sm focus:ring-yellow-500 focus:border-yellow-500"
                                required>
                                <option value="">-- Pilih Nilai --</option>
                                <option value="5">Sangat Baik</option>
                                <option value="4">Baik</option>
                                <option value="3">Cukup</option>
                                <option value="2">Buruk</option>
                                <option value="1">Sangat Buruk</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kualitas Dosen <span
                                    class="text-red-500">*</span></label>
                            <select name="eval_dosen"
                                class="p-2 w-full rounded-lg border-gray-300 text-sm focus:ring-yellow-500 focus:border-yellow-500"
                                required>
                                <option value="">-- Pilih Nilai --</option>
                                <option value="5">Sangat Baik</option>
                                <option value="4">Baik</option>
                                <option value="3">Cukup</option>
                                <option value="2">Buruk</option>
                                <option value="1">Sangat Buruk</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- NAVIGASI TOMBOL --}}
            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex justify-between items-center">
                <button type="button" x-show="currentStep > 1" @click="currentStep--"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-white transition-colors">
                    &larr; Kembali
                </button>
                <div x-show="currentStep === 1"></div>

                <button type="button" x-show="currentStep < 3" @click="nextStep()"
                    class="px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-blue-800 shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                    Lanjut &rarr;
                </button>

                <button type="submit" x-show="currentStep === 3"
                    class="flex items-center px-8 py-2.5 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow-lg shadow-green-500/30 transition-all transform hover:-translate-y-0.5"
                    :disabled="isLoading" :class="isLoading ? 'opacity-75 cursor-not-allowed' : ''">

                    <span x-show="!isLoading">Kirim Tracer Study &check;</span>
                    <span x-show="isLoading" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>

    {{-- SCRIPT ALPINE JS --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tracerWizard', () => ({
                currentStep: 1,
                isLoading: false,
                steps: ['Pekerjaan', 'Riwayat', 'Evaluasi'],

                // --- TAMBAHKAN FUNGSI INIT ---
                init() {
                    // Jika ada data old (misal setelah validasi error), format kembali gajinya
                    if (this.formData.gaji) {
                        this.formatGaji(this.formData.gaji);
                    }
                },

                // --- TAMBAHKAN FUNGSI FORMAT GAJI ---
                formatGaji(val) {
                    // 1. Hapus semua karakter selain angka
                    let raw = val.toString().replace(/[^0-9]/g, '');

                    // 2. Simpan angka murni ke formData (untuk dikirim ke server)
                    this.formData.gaji = raw;

                    // 3. Tambahkan titik setiap 3 digit untuk tampilan
                    this.displayGaji = raw.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                },

                // Data Binding untuk Validasi
                formData: {
                    statusAktivitas: '{{ old('status_aktivitas') }}',
                    namaPerusahaan: '{{ old('nama_perusahaan') }}',
                    jenisInstansi: '{{ old('jenis_instansi') }}',
                    gaji: '{{ old('gaji') }}',
                    provinsi: '{{ old('provinsi') }}',
                    keselarasan: '{{ old('keselarasan') }}',
                    waktuMencari: '{{ old('waktu_mencari') }}',
                    waktuTunggu: '{{ old('waktu_tunggu') }}',
                    jumlahLamaran: '{{ old('jumlah_lamaran') }}',
                    sumberInfo: '{{ old('sumber_info') }}',
                },

                // Error State
                errors: {},

                isBekerja() {
                    return this.formData.statusAktivitas === 'Bekerja (Full Time/Part Time)' ||
                        this.formData.statusAktivitas === 'Wiraswasta';
                },

                validateStep() {
                    this.errors = {}; // Reset error
                    let isValid = true;

                    if (this.currentStep === 1) {
                        if (!this.formData.statusAktivitas) {
                            this.errors.statusAktivitas = true;
                            isValid = false;
                        }
                        if (this.isBekerja()) {
                            if (!this.formData.namaPerusahaan) {
                                this.errors.namaPerusahaan = true;
                                isValid = false;
                            }
                            if (!this.formData.jenisInstansi) {
                                this.errors.jenisInstansi = true;
                                isValid = false;
                            }
                            if (!this.formData.gaji) {
                                this.errors.gaji = true;
                                isValid = false;
                            }
                            if (!this.formData.provinsi) {
                                this.errors.provinsi = true;
                                isValid = false;
                            }
                            if (!this.formData.keselarasan) {
                                this.errors.keselarasan = true;
                                isValid = false;
                            }
                        }
                    }

                    if (this.currentStep === 2) {
                        if (!this.formData.waktuMencari) {
                            this.errors.waktuMencari = true;
                            isValid = false;
                        }
                        if (!this.formData.waktuTunggu) {
                            this.errors.waktuTunggu = true;
                            isValid = false;
                        }
                        if (!this.formData.jumlahLamaran) {
                            this.errors.jumlahLamaran = true;
                            isValid = false;
                        }
                        if (!this.formData.sumberInfo) {
                            this.errors.sumberInfo = true;
                            isValid = false;
                        }
                    }

                    // Step 3 divalidasi oleh browser (HTML5 required attribute) karena radio button banyak

                    return isValid;
                },

                nextStep() {
                    if (this.validateStep()) {
                        this.currentStep++;
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        // Efek Shake jika error (Opsional, perlu CSS tambahan) atau alert
                        alert('Mohon lengkapi data bertanda * sebelum lanjut.');
                    }
                }
            }))
        })
    </script>
@endsection
