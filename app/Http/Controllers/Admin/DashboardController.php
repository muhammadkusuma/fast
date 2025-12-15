<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\Prodi;
use App\Models\TracerMain;
use Illuminate\Http\Request;
// Pastikan model ini ada (sesuai migrasi tracer main)
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Grafik Batang (Alumni per Prodi) - Sudah ada sebelumnya
        $dataProdi      = Prodi::withCount('alumni')->get();
        $labelsProdi    = $dataProdi->pluck('nama_prodi');
        $dataCountProdi = $dataProdi->pluck('alumni_count');

        // 2. Data Grafik Lingkaran (Status Aktivitas Tracer Study) - BARU
        // Mengelompokkan berdasarkan 'status_aktivitas' di tabel t_tracer_main
        $dataTracer = TracerMain::select('status_aktivitas', DB::raw('count(*) as total'))
            ->groupBy('status_aktivitas')
            ->get();

        $labelsTracer    = $dataTracer->pluck('status_aktivitas');
        $dataCountTracer = $dataTracer->pluck('total');

        // 3. Statistik Ringkas
        $totalAlumni = Alumni::count();
        $totalProdi  = Prodi::count();
        $totalTracer = TracerMain::count(); // Jumlah yang sudah isi tracer

        // 4. Pengumuman
        $announcements = Announcement::latest()->get();

        return view('admin.dashboard', compact(
            'labelsProdi', 'dataCountProdi',
            'labelsTracer', 'dataCountTracer',
            'totalAlumni', 'totalProdi', 'totalTracer',
            'announcements'
        ));
    }

    // ... method storeAnnouncement dan deleteAnnouncement tetap sama ...
    public function storeAnnouncement(Request $request)
    {
        $request->validate(['judul' => 'required', 'isi' => 'required']);
        Announcement::create($request->only('judul', 'isi') + ['is_active' => true]);
        return back()->with('success', 'Pengumuman dibuat');
    }

    public function deleteAnnouncement($id)
    {
        Announcement::destroy($id);
        return back()->with('success', 'Dihapus');
    }
}
