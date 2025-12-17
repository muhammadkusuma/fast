@extends('layouts.main')

@section('title', 'Isi Tracer Study')

@section('content')
    <div x-data="tracerWizard()" class="max-w-5xl mx-auto pb-20 pt-10">

        {{-- PROGRESS INDICATOR --}}
        <div class="mb-10 px-4">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 -z-10"></div>
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-blue-600 -z-10 transition-all duration-500"
                    :style="'width: ' + ((currentStep - 1) * 33.3) + '%'"></div>

                <template x-for="(step, index) in steps" :key="index">
                    <div class="flex flex-col items-center bg-gray-50 px-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm text-white transition-all duration-300 ring-4 ring-white"
                            :class="currentStep > index + 1 ? 'bg-green-500' : (currentStep === index + 1 ?
                                'bg-blue-600 shadow-lg scale-110' : 'bg-gray-300')">
                            <span x-text="index + 1"></span>
                        </div>
                        <span class="text-xs font-semibold mt-2 hidden sm:block"
                            :class="currentStep >= index + 1 ? 'text-blue-600' : 'text-gray-400'" x-text="step"></span>
                    </div>
                </template>
            </div>
        </div>

        <form action="{{ route('alumni.tracer.store') }}" method="POST" @submit="submitForm"
            class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden relative">
            @csrf

            {{-- ========================================================================
             STEP 1: DATA PRIBADI (SECTION A)
             ======================================================================== --}}
            <div x-show="currentStep === 1" x-transition class="p-8 space-y-6">
                <div class="border-b pb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Data Pribadi</h2>
                    <p class="text-gray-500 text-sm">Pastikan data diri Anda sesuai.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><label class="label">Nama Lengkap *</label><input type="text" name="q1_nama"
                            x-model="formData.q1_nama" class="input-field"></div>
                    <div><label class="label">NIM / Angkatan *</label><input type="number" name="q2_angkatan"
                            x-model="formData.q2_angkatan" class="input-field"></div>
                    <div><label class="label">Program Studi *</label><input type="text" name="q3_prodi"
                            x-model="formData.q3_prodi" class="input-field" readonly></div>
                    <div><label class="label">IPK Terakhir *</label><input type="number" step="0.01" name="q4_ipk"
                            x-model="formData.q4_ipk" class="input-field"></div>
                    <div><label class="label">Tanggal Lulus *</label><input type="date" name="q5_tanggal_lulus"
                            x-model="formData.q5_tanggal_lulus" class="input-field"></div>

                    <div class="md:col-span-2"><label class="label">Alamat Rumah *</label>
                        <textarea name="q6_alamat" x-model="formData.q6_alamat" class="input-field" rows="2"></textarea>
                    </div>

                    <div>
                        <label class="label">Provinsi *</label>
                        <select name="q7_provinsi" x-model="formData.q7_provinsi" @change="loadKabupaten()"
                            class="input-field">
                            <option value="">-- Pilih Provinsi --</option>
                            <template x-for="p in listProvinsi">
                                <option :value="p" x-text="p"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="label">Kabupaten/Kota *</label>
                        <select name="q9_kabupaten" x-model="formData.q9_kabupaten" class="input-field">
                            <option value="">-- Pilih Kota --</option>
                            <template x-for="k in listKabupaten">
                                <option :value="k" x-text="k"></option>
                            </template>
                        </select>
                    </div>
                    <div><label class="label">Kode Pos *</label><input type="number" name="q8_kodepos"
                            x-model="formData.q8_kodepos" class="input-field"></div>

                    <div><label class="label">No HP (WA) *</label><input type="text" name="q10a_no_hp"
                            x-model="formData.q10a_no_hp" class="input-field"></div>
                    <div><label class="label">Email *</label><input type="email" name="q10b_email"
                            x-model="formData.q10b_email" class="input-field"></div>
                    <div>
                        <label class="label">Jenis Kelamin *</label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center"><input type="radio" name="q11_jenis_kelamin"
                                    value="Laki-laki" x-model="formData.q11_jenis_kelamin" class="mr-2"> Laki-laki</label>
                            <label class="flex items-center"><input type="radio" name="q11_jenis_kelamin"
                                    value="Perempuan" x-model="formData.q11_jenis_kelamin" class="mr-2"> Perempuan</label>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <label class="label text-blue-800">Status Pekerjaan Saat Ini *</label>
                    <select name="status_bekerja" x-model="formData.status_bekerja"
                        class="input-field border-blue-300 focus:ring-blue-500">
                        <option value="">-- Pilih Status --</option>
                        <option value="Sudah Bekerja">Sudah Bekerja</option>
                        <option value="Belum Bekerja">Belum Bekerja</option>
                        <option value="Sedang Kuliah">Sedang Kuliah</option>
                    </select>
                </div>
            </div>

            {{-- ========================================================================
             STEP 2: PEKERJAAN (SECTION B) - KONDISIONAL
             ======================================================================== --}}
            <div x-show="currentStep === 2" x-transition class="p-8 space-y-6">

                <div x-show="formData.status_bekerja !== 'Sudah Bekerja'" class="text-center py-10">
                    <h3 class="text-lg font-medium text-gray-600">Anda memilih status "<span
                            x-text="formData.status_bekerja"></span>".</h3>
                    <p class="text-sm text-gray-500">Silakan lanjutkan ke tahap berikutnya.</p>
                </div>

                <div x-show="formData.status_bekerja === 'Sudah Bekerja'" class="space-y-6">
                    <div class="border-b pb-4">
                        <h2 class="text-2xl font-bold text-gray-800">Pekerjaan Saat Ini</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="label">Q12. Jenis Perusahaan *</label>
                            <select name="q12_jenis_perusahaan" x-model="formData.q12_jenis_perusahaan"
                                class="input-field">
                                <option value="">Pilih...</option>
                                <option>Instansi Pemerintah</option>
                                <option>BUMN/BUMD</option>
                                <option>Swasta Nasional</option>
                                <option>Wiraswasta</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <input x-show="formData.q12_jenis_perusahaan === 'Lainnya'" type="text"
                                name="q12a_pekerjaan_lainnya" placeholder="Sebutkan..." class="input-field mt-2">
                        </div>

                        <div><label class="label">Nama Kantor *</label><input type="text" name="q13a_nama_kantor"
                                x-model="formData.q13a_nama_kantor" class="input-field"></div>
                        <div><label class="label">Nama Pimpinan</label><input type="text" name="q13b_nama_pimpinan"
                                class="input-field"></div>
                        <div><label class="label">Bidang Pekerjaan</label><input type="text"
                                name="q14_bidang_pekerjaan" class="input-field"></div>
                        <div><label class="label">Penghasilan / Bulan *</label>
                            <select name="q19_penghasilan" x-model="formData.q19_penghasilan" class="input-field">
                                <option value="">Pilih Range...</option>
                                <option>
                                    < 3 Juta</option>
                                <option>3 - 5 Juta</option>
                                <option>> 5 Juta</option>
                            </select>
                        </div>
                        <div><label class="label">Waktu Tunggu Mendapat Kerja</label>
                            <select name="q22_waktu_tunggu" x-model="formData.q22_waktu_tunggu" class="input-field">
                                <option value="">Pilih...</option>
                                <option>Before Graduation</option>
                                <option>
                                    < 3 Bulan</option>
                                <option>3 - 6 Bulan</option>
                                <option>> 6 Bulan</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200 mt-6">
                        <label class="label block mb-2">Apakah ini pekerjaan pertama Anda setelah lulus?</label>
                        <div class="flex gap-4">
                            <label><input type="radio" name="is_first_job" value="Ya"
                                    x-model="formData.is_first_job" class="mr-1"> Ya</label>
                            <label><input type="radio" name="is_first_job" value="Tidak"
                                    x-model="formData.is_first_job" class="mr-1"> Tidak</label>
                        </div>

                        <div x-show="formData.is_first_job === 'Tidak'"
                            class="mt-4 space-y-4 border-t border-yellow-200 pt-4">
                            <h4 class="font-bold text-sm uppercase text-yellow-800">Riwayat Pekerjaan Pertama</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="label">Nama Kantor Pertama</label><input type="text"
                                        name="q25_nama_kantor_1" class="input-field"></div>
                                <div><label class="label">Alasan Berhenti</label><input type="text"
                                        name="q26_alasan_berhenti_1" class="input-field"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================================================
             STEP 3: PENDIDIKAN (SECTION C)
             ======================================================================== --}}
            <div x-show="currentStep === 3" x-transition class="p-8 space-y-6">
                <div class="border-b pb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Pendidikan & Pembelajaran</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><label class="label">Q33. Tempat Tinggal saat Kuliah</label>
                        <select name="q33_tempat_tinggal" x-model="formData.q33_tempat_tinggal" class="input-field">
                            <option>Bersama Orang Tua</option>
                            <option>Kos</option>
                            <option>Asrama</option>
                        </select>
                    </div>
                    <div><label class="label">Q34. Sumber Biaya Kuliah Utama</label>
                        <select name="q34_pembiayaan" x-model="formData.q34_pembiayaan" class="input-field">
                            <option>Orang Tua / Keluarga</option>
                            <option>Beasiswa</option>
                            <option>Biaya Sendiri</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">Q35. Aktif Organisasi?</label>
                        <select name="q35_organisasi" x-model="formData.q35_organisasi" class="input-field">
                            <option value="Tidak">Tidak</option>
                            <option value="Ya">Ya</option>
                        </select>
                    </div>
                    <div x-show="formData.q35_organisasi === 'Ya'">
                        <label class="label">Q36. Tingkat Keaktifan</label>
                        <select name="q36_keaktifan_org" class="input-field">
                            <option>Anggota Biasa</option>
                            <option>Pengurus</option>
                            <option>Ketua/Pimpinan</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="label block mb-2 font-bold">Q38. Penekanan Aspek Pembelajaran (1-5)</label>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 text-left">Aspek</th>
                                    <th class="p-2">1 (Buruk) - 5 (Baik)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach (['q38a_perkuliahan' => 'Perkuliahan', 'q38b_demonstrasi' => 'Demonstrasi', 'q38c_riset' => 'Riset'] as $key => $label)
                                    <tr>
                                        <td class="p-2">{{ $label }}</td>
                                        <td class="p-2 text-center">
                                            <div class="flex justify-center gap-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <label><input type="radio" name="{{ $key }}"
                                                            value="{{ $i }}" required>
                                                        {{ $i }}</label>
                                                @endfor
                                            </div>
                                        </td>
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
            <div x-show="currentStep === 4" x-transition class="p-8 space-y-6">
                <div class="border-b pb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Kompetensi & Penutup</h2>
                </div>

                <div class="mb-6">
                    <p class="font-bold mb-2">Q42. Kompetensi Saat Lulus (Self-Assessment)</p>
                    <div class="bg-gray-50 p-4 rounded text-sm text-gray-600 mb-2">
                        Skala: 1 (Sangat Rendah) - 5 (Sangat Tinggi)
                    </div>
                    <div class="h-64 overflow-y-auto border rounded p-2">
                        @php
                            $kompetensi = [
                                'a' => 'Pengetahuan Bidang',
                                'b' => 'Pengetahuan Luar Bidang',
                                'c' => 'Umum',
                                'd' => 'Internet',
                                'e' => 'Komputer',
                                'f' => 'Berpikir Kritis',
                                'i' => 'Komunikasi',
                                'l' => 'Kerjasama Tim',
                            ];
                        @endphp
                        @foreach ($kompetensi as $code => $text)
                            <div class="flex justify-between items-center py-2 border-b">
                                <span>{{ $text }}</span>
                                <div class="flex gap-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="text-xs"><input type="radio"
                                                name="q42_kompetensi_lulus[{{ $code }}]"
                                                value="{{ $i }}" required> {{ $i }}</label>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-green-50 p-6 rounded-lg border border-green-200 space-y-4">
                    <h3 class="font-bold text-green-800">Evaluasi Akhir</h3>

                    <div>
                        <label class="label">Q47. Apakah Anda akan memilih UIN Suska lagi? *</label>
                        <div class="flex gap-4">
                            <label><input type="radio" name="q47_pilih_uin" value="Ya"
                                    x-model="formData.q47_pilih_uin"> Ya</label>
                            <label><input type="radio" name="q47_pilih_uin" value="Tidak"
                                    x-model="formData.q47_pilih_uin"> Tidak</label>
                        </div>
                        <textarea x-show="formData.q47_pilih_uin === 'Tidak'" name="q48_alasan_uin" placeholder="Alasannya..."
                            class="input-field mt-2"></textarea>
                    </div>

                    <div>
                        <label class="label">Q49. Apakah Anda akan memilih Prodi yang sama? *</label>
                        <div class="flex gap-4">
                            <label><input type="radio" name="q49_pilih_prodi" value="Ya"
                                    x-model="formData.q49_pilih_prodi"> Ya</label>
                            <label><input type="radio" name="q49_pilih_prodi" value="Tidak"
                                    x-model="formData.q49_pilih_prodi"> Tidak</label>
                        </div>
                        <textarea x-show="formData.q49_pilih_prodi === 'Tidak'" name="q50_alasan_prodi" placeholder="Alasannya..."
                            class="input-field mt-2"></textarea>
                    </div>
                </div>
            </div>

            {{-- NAVIGATION BUTTONS --}}
            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex justify-between">
                <button type="button" x-show="currentStep > 1" @click="currentStep--"
                    class="px-6 py-2 border rounded-lg hover:bg-white text-gray-700">Kembali</button>
                <div x-show="currentStep === 1"></div> {{-- Spacer --}}

                <button type="button" x-show="currentStep < 4" @click="nextStep()"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow">Lanjut</button>

                <button type="submit" x-show="currentStep === 4" :disabled="isLoading"
                    class="px-8 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow">
                    <span x-text="isLoading ? 'Menyimpan...' : 'Selesai & Kirim'"></span>
                </button>
            </div>
        </form>
    </div>

    {{-- CSS Helper for Tailwind --}}
    <style>
        .label {
            @apply block text-sm font-medium text-gray-700 mb-1;
        }

        .input-field {
            @apply w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2 text-sm transition;
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tracerWizard', () => ({
                currentStep: 1,
                isLoading: false,
                steps: ['Data Pribadi', 'Pekerjaan', 'Pendidikan', 'Kompetensi'],

                // Dummy Data untuk Provinsi (Agar langsung jalan)
                listProvinsi: ['Riau', 'DKI Jakarta', 'Jawa Barat', 'Sumatera Barat', 'Sumatera Utara'],
                listKabupaten: [],

                formData: {
                    // Section A Defaults
                    q1_nama: '{{ Auth::guard('alumni')->user()->nama ?? 'M. Wira Ade Kusuma' }}',
                    q2_angkatan: '2021',
                    q3_prodi: 'SISTEM INFORMASI',
                    q4_ipk: '',
                    q5_tanggal_lulus: '2025-01-15',
                    q6_alamat: '',
                    q7_provinsi: '',
                    q9_kabupaten: '',
                    q8_kodepos: '',
                    q10a_no_hp: '',
                    q10b_email: 'mwiraadekusuma1@gmail.com',
                    q11_jenis_kelamin: '',
                    status_bekerja: '',

                    // Section B Logic
                    q12_jenis_perusahaan: '',
                    is_first_job: '',

                    // Section C & D Logic
                    q33_tempat_tinggal: '',
                    q34_pembiayaan: '',
                    q35_organisasi: 'Tidak',
                    q47_pilih_uin: '',
                    q49_pilih_prodi: ''
                },

                loadKabupaten() {
                    // Simulasi Load Ajax
                    if (this.formData.q7_provinsi === 'Riau') {
                        this.listKabupaten = ['Pekanbaru', 'Dumai', 'Kampar', 'Siak'];
                    } else if (this.formData.q7_provinsi === 'DKI Jakarta') {
                        this.listKabupaten = ['Jakarta Selatan', 'Jakarta Pusat', 'Jakarta Barat'];
                    } else {
                        this.listKabupaten = ['Kota Lainnya'];
                    }
                },

                validateStep() {
                    // Implementasi Validasi sederhana per Step
                    if (this.currentStep === 1) {
                        if (!this.formData.q1_nama || !this.formData.status_bekerja) {
                            alert('Mohon lengkapi Nama dan Status Pekerjaan!');
                            return false;
                        }
                    }
                    // Tambahkan validasi lain sesuai kebutuhan
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

                submitForm() {
                    this.isLoading = true;
                    // Form submit default behavior proceeds
                }
            }))
        })
    </script>
@endsection
