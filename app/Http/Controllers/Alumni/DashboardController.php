<?php
namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\TracerMain;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $idAlumni = Auth::guard('alumni')->id();
        $alumni   = Auth::guard('alumni')->user();

        // 1. Cek Status Tracer (Sudah isi atau belum tahun ini)
        $sudahIsiTracer = TracerMain::where('id_alumni', $idAlumni)
            ->where('tahun_tracer', date('Y'))
            ->exists();

        // 2. Hitung Persentase Profil (Berdasarkan Migrasi m_alumni)
        // Kolom yang dicek: nik, no_hp, email, alamat_domisili
        $filled     = 0;
        $totalField = 4; // Jumlah kolom yang dicek

        if (! empty($alumni->nik)) {
            $filled++;
        }

        if (! empty($alumni->no_hp)) {
            $filled++;
        }

        if (! empty($alumni->email)) {
            $filled++;
        }

        if (! empty($alumni->alamat_domisili)) {
            $filled++;
        }

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
