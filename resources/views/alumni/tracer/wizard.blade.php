@extends('layouts.main')

@section('title', 'Isi Tracer Study')
@section('header', 'Kuesioner Tracer Study')

@section('content')
    <div x-data="{ 
            currentStep: 1, 
            statusAktivitas: '', 
            // Fungsi untuk pindah step + validasi sederhana (opsional)
            nextStep() { if(this.currentStep < 3) this.currentStep++ },
            prevStep() { if(this.currentStep > 1) this.currentStep-- }
         }" 
         class="max-w-4xl mx-auto">

        <div class="mb-8">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 -z-10"></div>
                
                <div class="flex flex-col items-center bg-gray-50 px-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white transition-colors duration-300"
                         :class="currentStep >= 1 ? 'bg-primary' : 'bg-gray-300'">1</div>
                    <span class="text-xs font-semibold mt-2 text-gray-600">Pekerjaan</span>
                </div>

                <div class="flex flex-col items-center bg-gray-50 px-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white transition-colors duration-300"
                         :class="currentStep >= 2 ? 'bg-primary' : 'bg-gray-300'">2</div>
                    <span class="text-xs font-semibold mt-2 text-gray-600">Riwayat</span>
                </div>

                <div class="flex flex-col items-center bg-gray-50 px-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white transition-colors duration-300"
                         :class="currentStep >= 3 ? 'bg-primary' : 'bg-gray-300'">3</div>
                    <span class="text-xs font-semibold mt-2 text-gray-600">Evaluasi</span>
                </div>
            </div>
        </div>

        <form action="{{ route('alumni.tracer.store') }}" method="POST" class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            @csrf

            <div x-show="currentStep === 1" x-transition.opacity class="p-8 space-y-6">
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Status Aktivitas Saat Ini</h2>
                    <p class="text-sm text-gray-500">Pilih status utama Anda (F8 - Standar Dikti)</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jelaskan status Anda saat ini?</label>
                    <select x-model="statusAktivitas" name="status_aktivitas" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
    <option value="">-- Pilih Status --</option>
    <option value="Bekerja (Full Time/Part Time)">Bekerja (Full Time/Part Time)</option>
    <option value="Wiraswasta">Wiraswasta / Punya Usaha Sendiri</option>
    <option value="Melanjutkan Pendidikan">Melanjutkan Pendidikan</option>
    <option value="Tidak Bekerja">Sedang Mencari Pekerjaan / Belum Bekerja</option>
    <option value="Lainnya">Lainnya (Rumah Tangga, dll)</option>
</select>
                </div>

                <div x-show="statusAktivitas === 'bekerja' || statusAktivitas === 'wiraswasta'" x-transition class="space-y-6 bg-blue-50 p-6 rounded-lg border border-blue-100">
                    <h3 class="font-bold text-primary flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Detail Pekerjaan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan / Instansi</label>
                            <input type="text" name="nama_perusahaan" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Instansi</label>
                            <select name="jenis_instansi" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                <option>Instansi Pemerintah</option>
                                <option>BUMN / BUMD</option>
                                <option>Swasta Nasional</option>
                                <option>Multinasional / Asing</option>
                                <option>Wiraswasta</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gaji Rata-rata per Bulan</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                <input type="number" name="gaji" class="w-full pl-10 rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi Tempat Kerja</label>
                            <select name="provinsi" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                <option>Riau</option>
                                <option>DKI Jakarta</option>
                                <option>Jawa Barat</option>
                                </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Seberapa erat hubungan bidang studi dengan pekerjaan Anda?</label>
                        <div class="flex gap-4 flex-wrap">
    <label class="flex items-center space-x-2 border p-3 rounded-lg cursor-pointer hover:bg-white bg-white w-full md:w-auto">
        <input type="radio" name="keselarasan" value="Sangat Erat" class="text-primary focus:ring-primary">
        <span class="text-sm">Sangat Erat</span>
    </label>
    <label class="flex items-center space-x-2 border p-3 rounded-lg cursor-pointer hover:bg-white bg-white w-full md:w-auto">
        <input type="radio" name="keselarasan" value="Erat" class="text-primary focus:ring-primary">
        <span class="text-sm">Erat</span>
    </label>
    <label class="flex items-center space-x-2 border p-3 rounded-lg cursor-pointer hover:bg-white bg-white w-full md:w-auto">
        <input type="radio" name="keselarasan" value="Cukup Erat" class="text-primary focus:ring-primary">
        <span class="text-sm">Cukup Erat</span>
    </label>
    <label class="flex items-center space-x-2 border p-3 rounded-lg cursor-pointer hover:bg-white bg-white w-full md:w-auto">
        <input type="radio" name="keselarasan" value="Kurang Erat" class="text-primary focus:ring-primary">
        <span class="text-sm">Kurang Erat</span>
    </label>
    <label class="flex items-center space-x-2 border p-3 rounded-lg cursor-pointer hover:bg-white bg-white w-full md:w-auto">
        <input type="radio" name="keselarasan" value="Tidak Sama Sekali" class="text-primary focus:ring-primary">
        <span class="text-sm">Tidak Sama Sekali</span>
    </label>
</div>
                    </div>
                </div>
            </div>

            <div x-show="currentStep === 2" x-cloak x-transition.opacity class="p-8 space-y-6">
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Proses Pencarian Kerja</h2>
                    <p class="text-sm text-gray-500">Informasi ini untuk mengukur masa tunggu lulusan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kapan Anda mulai mencari pekerjaan?</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 bg-white">
        <input type="radio" name="waktu_mencari" value="Sebelum Lulus" class="h-5 w-5 text-primary">
        <div>
            <span class="block font-bold text-gray-800">Sebelum Lulus</span>
            <span class="text-xs text-gray-500">Saya mencari kerja saat skripsi/kuliah</span>
        </div>
    </label>
    <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 bg-white">
        <input type="radio" name="waktu_mencari" value="Sesudah Lulus" class="h-5 w-5 text-primary">
        <div>
            <span class="block font-bold text-gray-800">Sesudah Lulus</span>
            <span class="text-xs text-gray-500">Saya mencari setelah wisuda</span>
        </div>
    </label>
</div>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Berapa bulan waktu tunggu hingga dapat kerja pertama?</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="waktu_tunggu" placeholder="0" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                            <span class="text-gray-600 font-medium">Bulan</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">*Isi 0 jika langsung dapat kerja</p>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Berapa perusahaan yang Anda lamar?</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="jumlah_lamaran" placeholder="10" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                            <span class="text-gray-600 font-medium">Perusahaan</span>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sumber informasi lowongan kerja utama?</label>
                        <select name="sumber_info" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                            <option>Internet / Media Sosial / Apps</option>
                            <option>Pusat Karir Kampus (Career Center)</option>
                            <option>Koneksi Teman / Keluarga</option>
                            <option>Bursa Kerja (Job Fair)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div x-show="currentStep === 3" x-cloak x-transition.opacity class="p-8 space-y-8">
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Kompetensi & Evaluasi Kampus</h2>
                    <p class="text-sm text-gray-500">Bandingkan kompetensi yang didapat di kampus vs yang dibutuhkan di kerja.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 rounded-tl-lg">Jenis Kompetensi</th>
                                <th class="px-4 py-3 text-center bg-blue-50">A. Didapat di Kampus<br>(1 = Rendah, 5 = Tinggi)</th>
                                <th class="px-4 py-3 text-center bg-green-50 rounded-tr-lg">B. Butuh di Kerja<br>(1 = Rendah, 5 = Tinggi)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-4 py-4 font-medium text-gray-900">Etika & Moral</td>
                                <td class="px-4 py-4 text-center bg-blue-50/30">
                                    <div class="flex justify-center gap-2">
                                        @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="etika_kampus" value="{{ $i }}" class="sr-only peer">
                                            <div class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition">{{ $i }}</div>
                                        </label>
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center bg-green-50/30">
                                    <div class="flex justify-center gap-2">
                                        @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="etika_kerja" value="{{ $i }}" class="sr-only peer">
                                            <div class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition">{{ $i }}</div>
                                        </label>
                                        @endfor
                                    </div>
                                </td>
                            </tr>

                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-4 py-4 font-medium text-gray-900">Keahlian Bidang Ilmu (Hard Skill)</td>
                                <td class="px-4 py-4 text-center bg-blue-50/30">
                                    <div class="flex justify-center gap-2">
                                        @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="hardskill_kampus" value="{{ $i }}" class="sr-only peer">
                                            <div class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition">{{ $i }}</div>
                                        </label>
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center bg-green-50/30">
                                    <div class="flex justify-center gap-2">
                                        @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="hardskill_kerja" value="{{ $i }}" class="sr-only peer">
                                            <div class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition">{{ $i }}</div>
                                        </label>
                                        @endfor
                                    </div>
                                </td>
                            </tr>

                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-4 py-4 font-medium text-gray-900">Bahasa Inggris</td>
                                <td class="px-4 py-4 text-center bg-blue-50/30">
                                    <div class="flex justify-center gap-2">
                                        @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="inggris_kampus" value="{{ $i }}" class="sr-only peer">
                                            <div class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition">{{ $i }}</div>
                                        </label>
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center bg-green-50/30">
                                    <div class="flex justify-center gap-2">
                                        @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="inggris_kerja" value="{{ $i }}" class="sr-only peer">
                                            <div class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition">{{ $i }}</div>
                                        </label>
                                        @endfor
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-100">
                    <h3 class="font-bold text-yellow-800 mb-4">Evaluasi Fasilitas Kampus</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Fasilitas Laboratorium</label>
                            <select name="eval_lab" class="rounded border-gray-300 text-sm">
                                <option value="5">Sangat Baik</option>
                                <option value="4">Baik</option>
                                <option value="3">Cukup</option>
                                <option value="2">Buruk</option>
                                <option value="1">Sangat Buruk</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Kualitas Dosen</label>
                            <select name="eval_dosen" class="rounded border-gray-300 text-sm">
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

            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex justify-between items-center">
                
                <button type="button" 
                        x-show="currentStep > 1" 
                        @click="prevStep()" 
                        class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-white transition-colors">
                    &larr; Kembali
                </button>
                <div x-show="currentStep === 1"></div> <button type="button" 
                        x-show="currentStep < 3" 
                        @click="nextStep()" 
                        class="px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-blue-800 shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                    Lanjut &rarr;
                </button>

                <button type="submit" 
                        x-show="currentStep === 3" 
                        x-cloak
                        class="px-8 py-2.5 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow-lg shadow-green-500/30 transition-all transform hover:-translate-y-0.5">
                    Kirim Tracer Study &check;
                </button>
            </div>

        </form>
    </div>
@endsection