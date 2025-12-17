<?php
namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\TracerStudy; // UBAH: Gunakan Model TracerStudy (bukan TracerMain)
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $idAlumni = Auth::guard('alumni')->id();
        $alumni   = Auth::guard('alumni')->user();

        // 1. Cek Status Tracer (Sudah isi atau belum tahun ini)
        // PERBAIKAN:
        // - Menggunakan model TracerStudy
        // - Menggunakan kolom 'user_id' (sesuai migrasi baru)
        // - Menggunakan 'created_at' untuk cek tahun (karena tidak ada kolom tahun_tracer di tabel baru)
        $sudahIsiTracer = TracerStudy::where('user_id', $idAlumni)
            ->whereYear('created_at', date('Y'))
            ->exists();

        // 2. Hitung Persentase Profil (Berdasarkan Migrasi m_alumni)
        $filled     = 0;
        $totalField = 4;

        if (! empty($alumni->nik)) {$filled++;}
        if (! empty($alumni->no_hp)) {$filled++;}
        if (! empty($alumni->email)) {$filled++;}
        if (! empty($alumni->alamat_domisili)) {$filled++;}

        $persentaseProfil = ($filled / $totalField) * 100;

        // 3. Ambil Pengumuman
        $announcements = Announcement::where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        return view('alumni.dashboard', compact(
            'alumni',
            'sudahIsiTracer',
            'persentaseProfil',
            'announcements'
        ));
    }
}
