<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\Prodi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Grafik (Jumlah Alumni per Prodi)
        // Kita ambil nama prodi dan hitung jumlah alumni di relasinya
        $dataProdi = Prodi::withCount('alumni')->get();

                                                      // Format data agar mudah dibaca oleh Chart.js di View
        $labels    = $dataProdi->pluck('nama_prodi'); // Asumsi kolom nama di tabel prodi adalah 'nama_prodi'
        $dataCount = $dataProdi->pluck('alumni_count');

        // 2. Data Pengumuman
        $announcements = Announcement::latest()->get();

        // 3. Statistik Ringkas
        $totalAlumni = Alumni::count();
        $totalProdi  = Prodi::count();

        return view('admin.dashboard', compact(
            'labels',
            'dataCount',
            'announcements',
            'totalAlumni',
            'totalProdi'
        ));
    }

    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi'   => 'required|string',
        ]);

        Announcement::create([
            'judul'     => $request->judul,
            'isi'       => $request->isi,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil dibuat!');
    }

    public function deleteAnnouncement($id)
    {
        Announcement::destroy($id);
        return redirect()->back()->with('success', 'Pengumuman dihapus.');
    }
}
