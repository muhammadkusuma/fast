<?php
namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Menampilkan Halaman Profil
     */
    public function index()
    {
        // Ambil data alumni yang sedang login
        // Kita gunakan 'load' untuk mengambil data relasi prodi (jika ada) agar efisien
        $alumni = Auth::guard('alumni')->user()->load('prodi');

        return view('alumni.profile.index', [
            'alumni' => $alumni,
        ]);
    }

    /**
     * Memproses Update Data Profil
     */
    public function update(Request $request)
    {
        // 1. Ambil ID user yang sedang login
        $id     = Auth::guard('alumni')->id();
        $alumni = Alumni::findOrFail($id);

        // 2. Validasi Input
        $request->validate([
            'nik'             => 'nullable|numeric|digits:16',
            'email'           => 'required|email|max:100',
            'no_hp'           => 'required|numeric',
            'alamat_domisili' => 'required|string|max:500',
            // 'linkedin'     => 'nullable|url' // Aktifkan jika sudah tambah kolom linkedin di database
        ], [
            // Custom Error Messages (Opsional)
            'nik.digits'    => 'NIK harus berjumlah 16 digit.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
        ]);

        // 3. Update Database
        $alumni->update([
            'nik'             => $request->nik,
            'email'           => $request->email,
            'no_hp'           => $request->no_hp,
            'alamat_domisili' => $request->alamat_domisili,
            // Kolom lain seperti NIM, Nama, IPK biasanya tidak boleh diedit alumni sendiri (readonly)
        ]);

        // 4. Redirect kembali dengan pesan sukses
        return back()->with('success', 'Data profil berhasil diperbaharui.');
    }
}
