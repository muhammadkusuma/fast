<?php
namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\TracerMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TracerController extends Controller
{
    public function create()
    {
        // Cek apakah alumni sudah mengisi tahun ini
        $existing = TracerMain::where('id_alumni', Auth::guard('alumni')->id())
            ->where('tahun_tracer', date('Y'))
            ->exists();

        if ($existing) {
            return redirect()->route('alumni.dashboard')
                ->with('error', 'Anda sudah mengisi Tracer Study periode ini. Terima kasih!');
        }

        return view('alumni.tracer.wizard');
    }

    public function store(Request $request)
    {
        // 1. DEFINISI ATURAN VALIDASI
        $rules = [
            'status_aktivitas' => 'required|string',

            // Validasi Step 2 (Pencarian Kerja)
            'waktu_mencari'    => 'required|string',
            'waktu_tunggu'     => 'required|numeric|min:0',
            'jumlah_lamaran'   => 'required|numeric|min:0',
            'sumber_info'      => 'required|string',

            // Validasi Step 3 (Kompetensi & Evaluasi) - Wajib diisi semua (skala 1-5)
            'etika_kampus'     => 'required|integer|between:1,5',
            'etika_kerja'      => 'required|integer|between:1,5',
            'hardskill_kampus' => 'required|integer|between:1,5',
            'hardskill_kerja'  => 'required|integer|between:1,5',
            'inggris_kampus'   => 'required|integer|between:1,5',
            'inggris_kerja'    => 'required|integer|between:1,5',
            'eval_lab'         => 'required|integer|between:1,5',
            'eval_dosen'       => 'required|integer|between:1,5',
        ];

        // 2. VALIDASI KONDISIONAL
        // Jika status bekerja/wiraswasta, maka data perusahaan WAJIB diisi
        $pekerja = ['Bekerja (Full Time/Part Time)', 'Wiraswasta'];

        if (in_array($request->status_aktivitas, $pekerja)) {
            $rules['nama_perusahaan'] = 'required|string|max:255';
            $rules['jenis_instansi']  = 'required|string';
            $rules['provinsi']        = 'required|string';
            $rules['gaji']            = 'required|numeric|min:0';
            $rules['keselarasan']     = 'required|string';
        }

        $validated = $request->validate($rules);

        try {
            DB::transaction(function () use ($request, $pekerja) {
                $alumniId = Auth::guard('alumni')->id();

                // Cek apakah user bekerja? Jika tidak, kosongkan data perusahaan
                $isBekerja = in_array($request->status_aktivitas, $pekerja);

                // A. SIMPAN MAIN TRACER
                $tracer = TracerMain::create([
                    'id_alumni'              => $alumniId,
                    'tahun_tracer'           => date('Y'),
                    'status_aktivitas'       => $request->status_aktivitas,

                    // Simpan NULL jika tidak bekerja agar database bersih
                    'nama_perusahaan'        => $isBekerja ? $request->nama_perusahaan : null,
                    'jenis_perusahaan'       => $isBekerja ? $request->jenis_instansi : null,
                    'provinsi_perusahaan'    => $isBekerja ? $request->provinsi : null,
                    'gaji_bulanan'           => $isBekerja ? $request->gaji : 0,
                    'keselarasan_horizontal' => $isBekerja ? $request->keselarasan : null,
                ]);

                // B. SIMPAN PROCESS (Pencarian Kerja)
                $tracer->process()->create([
                    'bulan_mulai_mencari'  => $request->waktu_mencari,
                    'waktu_tunggu_bulan'   => $request->waktu_tunggu,
                    'jumlah_lamaran'       => $request->jumlah_lamaran,
                    'sumber_info_lowongan' => $request->sumber_info,
                ]);

                // C. SIMPAN COMPETENCE (Gap Analysis)
                $tracer->competence()->create([
                    'etika_a'           => $request->etika_kampus,
                    'etika_b'           => $request->etika_kerja,
                    'keahlian_bidang_a' => $request->hardskill_kampus,
                    'keahlian_bidang_b' => $request->hardskill_kerja,
                    'bahasa_inggris_a'  => $request->inggris_kampus,
                    'bahasa_inggris_b'  => $request->inggris_kerja,
                ]);

                // D. SIMPAN EVALUATION
                $tracer->evaluation()->create([
                    'fasilitas_laboratorium' => $request->eval_lab,
                    'kualitas_dosen'         => $request->eval_dosen,
                ]);
            });

            return redirect()->route('alumni.dashboard')
                ->with('success', 'Terima kasih! Data Tracer Study Anda berhasil disimpan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
