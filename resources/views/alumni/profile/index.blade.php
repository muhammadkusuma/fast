@extends('layouts.main')

@section('title', 'Biodata Saya')
@section('header', 'Profil Alumni')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- BAGIAN FOTO & INFO UTAMA (Read Only) --}}
        <div class="col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="relative w-32 h-32 mx-auto mb-4">
                    {{-- Avatar Dinamis berdasarkan Nama --}}
                    <img class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 shadow"
                        src="https://ui-avatars.com/api/?name={{ urlencode($alumni->nama_lengkap) }}&background=1e40af&color=fff&size=256"
                        alt="Foto Profil">

                    {{-- Tombol Ganti Foto (Opsional) --}}
                    <button
                        class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow border hover:bg-gray-50 text-gray-600 cursor-not-allowed"
                        title="Fitur upload foto belum tersedia">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>
                </div>

                <h2 class="text-xl font-bold text-gray-800">{{ $alumni->nama_lengkap }}</h2>
                <p class="text-gray-500 mb-4">{{ $alumni->nim }}</p>

                <div class="border-t border-gray-100 pt-4 text-left space-y-3">
                    <div>
                        <span class="text-xs text-gray-400 block uppercase tracking-wide">Program Studi</span>
                        {{-- Menggunakan null coalescing operator (??) jika relasi prodi belum ada --}}
                        <span
                            class="text-sm font-medium text-gray-700">{{ $alumni->prodi->nama_prodi ?? 'Data Prodi Tidak Ditemukan' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block uppercase tracking-wide">Fakultas</span>
                        <span class="text-sm font-medium text-gray-700">Sains dan Teknologi</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block uppercase tracking-wide">Tahun Lulus</span>
                        <span class="text-sm font-medium text-gray-700">{{ $alumni->tahun_lulus }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block uppercase tracking-wide">IPK</span>
                        <span class="text-sm font-bold text-primary">{{ $alumni->ipk ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN FORM UPDATE (Editable) --}}
        <div class="col-span-1 md:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-1">Update Kontak & Biodata</h3>
                <p class="text-sm text-gray-500 mb-6">Pastikan email dan nomor HP aktif agar mudah dihubungi.</p>

                <form action="{{ route('alumni.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Method spoofing untuk Update --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        {{-- NIK --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK (KTP)</label>
                            <input type="text" name="nik" value="{{ old('nik', $alumni->nik) }}"
                                placeholder="3201xxxxxxxxxxxx"
                                class="p-2 w-full rounded-lg border focus:ring-primary focus:border-primary @error('nik') border-red-500 @enderror">
                            @error('nik')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Pribadi</label>
                            <input type="email" name="email" value="{{ old('email', $alumni->email) }}"
                                placeholder="email@kamu.com"
                                class="p-2 w-full rounded-lg border focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NO HP --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Handphone / WA</label>

                            <input type="tel" name="no_hp" value="{{ old('no_hp', $alumni->no_hp) }}"
                                class="p-2 w-full rounded-lg border focus:ring-primary focus:border-primary @error('no_hp') border-red-500 @enderror"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric"maxlength="15"
                                placeholder="08xxxxxxxxxx">

                            @error('no_hp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- LINKEDIN --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL LinkedIn (Opsional)</label>
                            <input type="url" name="linkedin" placeholder="Belum tersedia di database" disabled
                                class="p-2 w-full rounded-lg border bg-gray-100 text-gray-500 cursor-not-allowed">
                            <p class="text-xs text-gray-400 mt-1">*Fitur ini akan segera hadir</p>
                        </div>

                        {{-- ALAMAT DOMISILI --}}
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Domisili Saat Ini</label>
                            <textarea name="alamat_domisili" rows="3" placeholder="Jl. Mencari Cinta Abadi I"
                                class="p-2 w-full rounded-lg border focus:ring-primary focus:border-primary @error('alamat_domisili') border-red-500 @enderror">{{ old('alamat_domisili', $alumni->alamat_domisili) }}</textarea>
                            @error('alamat_domisili')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-4">
                        <a href="{{ route('alumni.dashboard') }}"
                            class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors inline-flex items-center justify-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-blue-800 shadow-sm transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
