<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Fakultas;
use App\Models\Prodi;

class MasterDataController extends Controller
{
    // === HALAMAN ALUMNI ===
    public function indexAlumni()
    {
        // Mengambil data alumni dengan relasi prodi, diurutkan tahun lulus terbaru
        $alumni = Alumni::with('prodi')->orderBy('tahun_lulus', 'desc')->paginate(10);
        return view('admin.master.alumni', compact('alumni'));
    }

    // === HALAMAN PRODI ===
    public function indexProdi()
    {
        $prodi = Prodi::with('fakultas')->get();
        return view('admin.master.prodi', compact('prodi'));
    }

    // === HALAMAN FAKULTAS ===
    public function indexFakultas()
    {
        $fakultas = Fakultas::all();
        return view('admin.master.fakultas', compact('fakultas'));
    }
}
