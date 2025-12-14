<?php
namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\TracerMain;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data alumni yang sedang login
        // Asumsi: User login terhubung ke tabel m_alumni via relasi atau Auth custom
        // Jika menggunakan Auth standar User, ambil data alumni berdasarkan ID user
        $user = auth()->user();
        // Contoh: $alumni = Alumni::where('email', $user->email)->first();
        // Atau jika model User adalah Alumni:
        $alumni = auth()->user();

        // 2. Tentukan kolom-kolom di tabel 'm_alumni' yang wajib diisi untuk dianggap lengkap
        $columnsToCheck = [
            'nim',
            'nama_lengkap',
            'nik', // Nullable di schema, jadi penting dicek
            'jenis_kelamin',
            'tahun_masuk',
            'tahun_lulus',
            'ipk',             // Nullable
            'no_hp',           // Nullable
            'email',           // Nullable
            'alamat_domisili', // Nullable
        ];

        // 3. Hitung berapa kolom yang sudah terisi
        $filledCount = 0;
        foreach ($columnsToCheck as $col) {
            if (! empty($alumni->$col)) {
                $filledCount++;
            }
        }

        // 4. Hitung persentase
        $totalColumns     = count($columnsToCheck);
        $persentaseProfil = round(($filledCount / $totalColumns) * 100);

        // 5. Cek Status Tracer (Contoh logika sederhana)
        $sudahIsiTracer = $alumni->tracerMain()->exists();

        return view('alumni.dashboard', compact('alumni', 'persentaseProfil', 'sudahIsiTracer'));
    }
}
