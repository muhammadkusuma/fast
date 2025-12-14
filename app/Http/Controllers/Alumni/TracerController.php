<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TracerMain;

class TracerController extends Controller
{
    /**
     * Menampilkan Form Wizard
     */
    public function create()
    {
        // Cek apakah alumni sudah pernah isi tahun ini?
        $existing = TracerMain::where('id_alumni', Auth::id())
                    ->where('tahun_tracer', date('Y'))
                    ->exists();

        if ($existing) {
            return redirect()->route('alumni.dashboard')
                ->with('error', 'Anda sudah mengisi Tracer Study untuk periode tahun ini. Terima kasih!');
        }

        return view('alumni.tracer.wizard');
    }

    /**
     * Menyimpan Data (Database Transaction)
     */
    public function store(Request $request)
    {
        // 1. VALIDASI DATA
        // Kita buat rules dasar. Sesuaikan 'required' dengan logika bisnis Anda.
        $request->validate([
            // Step 1
            'status_aktivitas' => 'required',
            // Step 2 & 3 (Sebaiknya required, tapi bisa nullable jika status='tidak bekerja')
            'etika_kampus' => 'nullable|numeric', 
            'etika_kerja' => 'nullable|numeric',
            // ... tambahkan validasi lain sesuai kebutuhan
        ]);

        try {
            // 2. MULAI TRANSAKSI DATABASE
            DB::transaction(function () use ($request) {
                
                $alumniId = Auth::guard('alumni')->id();

                // A. SIMPAN TABEL UTAMA (t_tracer_main)
                $tracer = TracerMain::create([
                    'id_alumni' => $alumniId,
                    'tahun_tracer' => date('Y'), // Tahun saat ini
                    'status_aktivitas' => $request->status_aktivitas,
                    'nama_perusahaan' => $request->nama_perusahaan,
                    'jenis_perusahaan' => $request->jenis_instansi, // Sesuaikan name di form view
                    'provinsi_perusahaan' => $request->provinsi,
                    'gaji_bulanan' => $request->gaji ?? 0,
                    'keselarasan_horizontal' => $request->keselarasan, // Sangat Erat, dll
                    // 'keselarasan_vertikal' => ... (jika ada inputnya)
                ]);

                // B. SIMPAN RIWAYAT CARI KERJA (t_tracer_process)
                // Kita gunakan relasi hasOne -> create()
                $tracer->process()->create([
                    'bulan_mulai_mencari' => $request->waktu_mencari, // sebelum_lulus / sesudah_lulus
                    'waktu_tunggu_bulan' => $request->waktu_tunggu ?? 0,
                    'jumlah_lamaran' => $request->jumlah_lamaran ?? 0,
                    'sumber_info_lowongan' => $request->sumber_info,
                ]);

                // C. SIMPAN KOMPETENSI / GAP ANALYSIS (t_tracer_competence)
                $tracer->competence()->create([
                    'etika_a' => $request->etika_kampus,
                    'etika_b' => $request->etika_kerja,
                    
                    'keahlian_bidang_a' => $request->hardskill_kampus,
                    'keahlian_bidang_b' => $request->hardskill_kerja,
                    
                    'bahasa_inggris_a' => $request->inggris_kampus,
                    'bahasa_inggris_b' => $request->inggris_kerja,
                    
                    // Tambahkan field lain sesuai name di view (teknologi, komunikasi, dll)
                    // Pastikan di View Wizard name-nya sesuai dengan request ini
                ]);

                // D. SIMPAN EVALUASI KAMPUS (t_tracer_evaluation)
                $tracer->evaluation()->create([
                    'fasilitas_laboratorium' => $request->eval_lab,
                    'kualitas_dosen' => $request->eval_dosen,
                    // Tambahkan field lain...
                ]);

            }); // End Transaction

            // Jika sukses sampai sini, redirect ke dashboard
            return redirect()->route('alumni.dashboard')
                ->with('success', 'Terima kasih! Data Tracer Study Anda berhasil disimpan.');

        } catch (\Exception $e) {
            // Jika ada error, kembali ke form dengan pesan error
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                         ->withInput();
        }
    }
}