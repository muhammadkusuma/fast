<?php
namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\TracerMain;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data Alumni yang sedang login
        $alumni = Auth::guard('alumni')->user();

        // 2. Cek apakah sudah mengisi Tracer Study tahun ini
        $sudahIsiTracer = TracerMain::where('id_alumni', $alumni->id)
            ->where('tahun_tracer', date('Y'))
            ->exists();

                          // 3. Hitung Kelengkapan Data Profil (Logika Sederhana)
                          // Sesuaikan kolom ini dengan tabel 'alumni' kamu
        $totalField  = 5; // Misal: email, no_hp, alamat, nik, npwp
        $filledField = 0;

        if ($alumni->email) {
            $filledField++;
        }

        if ($alumni->no_hp) {
            $filledField++;
        }

        if ($alumni->alamat) {
            $filledField++;
        }

        if ($alumni->nik) {
            $filledField++;
        }

        if ($alumni->npwp) {
            $filledField++;
        }
        // Asumsi ada kolom npwp

        $persentaseProfil = ($filledField / $totalField) * 100;

        // 4. Kirim data ke View
        return view('alumni.dashboard', [
            'alumni'           => $alumni,
            'sudahIsiTracer'   => $sudahIsiTracer,
            'persentaseProfil' => round($persentaseProfil),
            // 'prestasiCount' => $alumni->prestasi()->count() // Jika ada relasi prestasi
        ]);
    }
}
