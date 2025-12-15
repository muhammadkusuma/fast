<?php
namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
// Import Model
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

        // 2. Hitung Persentase Profil (Sederhana)
        // Cek kolom wajib: nik, npwp, no_hp, alamat, email
        $filled     = 0;
        $totalField = 5;
        if ($alumni->nik) {
            $filled++;
        }

        if ($alumni->npwp) {
            $filled++;
        }

        if ($alumni->no_hp) {
            $filled++;
        }

        if ($alumni->alamat) {
            $filled++;
        }

        if ($alumni->email) {
            $filled++;
        }

        $persentaseProfil = ($filled / $totalField) * 100;

        // 3. AMBIL PENGUMUMAN DARI DB (Tambahan Baru)
        $announcements = Announcement::where('is_active', true)
            ->latest()
            ->take(5) // Ambil 5 terbaru saja
            ->get();

        return view('alumni.dashboard', compact(
            'alumni',
            'sudahIsiTracer',
            'persentaseProfil',
            'announcements' // Kirim ke view
        ));
    }
}
