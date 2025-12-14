@extends('layouts.main')

@section('title', 'Biodata Saya')
@section('header', 'Profil Alumni')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="relative w-32 h-32 mx-auto mb-4">
                    <img class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 shadow" 
                         src="https://ui-avatars.com/api/?name=Wira+Ade&background=1e40af&color=fff&size=256" 
                         alt="Foto Profil">
                    <button class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow border hover:bg-gray-50 text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </button>
                </div>
                
                <h2 class="text-xl font-bold text-gray-800">Wira Ade Kusuma</h2>
                <p class="text-gray-500 mb-4">1195011xxxx</p>
                
                <div class="border-t border-gray-100 pt-4 text-left space-y-3">
                    <div>
                        <span class="text-xs text-gray-400 block uppercase tracking-wide">Program Studi</span>
                        <span class="text-sm font-medium text-gray-700">S1 Sistem Informasi</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block uppercase tracking-wide">Fakultas</span>
                        <span class="text-sm font-medium text-gray-700">Sains dan Teknologi</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block uppercase tracking-wide">Tahun Lulus</span>
                        <span class="text-sm font-medium text-gray-700">2024</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block uppercase tracking-wide">IPK</span>
                        <span class="text-sm font-bold text-primary">3.85</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-1 md:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-1">Update Kontak & Biodata</h3>
                <p class="text-sm text-gray-500 mb-6">Pastikan email dan nomor HP aktif agar mudah dihubungi.</p>

                <form action="#" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK (KTP)</label>
                            <input type="text" name="nik" value="1471xxxxxxxx" 
                                class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Pribadi</label>
                            <input type="email" name="email" value="wira@example.com" 
                                class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Handphone / WA</label>
                            <input type="tel" name="no_hp" value="081234567890" 
                                class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL LinkedIn (Opsional)</label>
                            <input type="url" name="linkedin" placeholder="https://linkedin.com/in/..." 
                                class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Domisili Saat Ini</label>
                            <textarea name="alamat" rows="3" 
                                class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">Jl. HR. Soebrantas Km. 15, Pekanbaru</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-4">
                        <button type="button" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-blue-800 shadow-sm transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection