<?php
namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\TracerStudy; // Pastikan ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TracerController extends Controller
{
    /**
     * Menampilkan Form Wizard (Logic Redirect)
     */
    public function index()
    {
        // Cek apakah alumni sudah pernah mengisi tracer tahun ini?
        $alumniId      = Auth::guard('alumni')->id();
        $alreadyFilled = TracerStudy::where('user_id', $alumniId)
            ->whereYear('created_at', date('Y'))
            ->exists();

        if ($alreadyFilled) {
            return redirect()->route('alumni.dashboard')->with('info', 'Anda sudah mengisi Tracer Study tahun ini.');
        }

        return view('alumni.tracer.wizard');
    }

    /**
     * Menampilkan Form Wizard (Route /tracer/isi)
     */
    public function create()
    {
        // PERBAIKAN: Gunakan TracerStudy agar konsisten dengan store() dan index()
        $alumniId      = Auth::guard('alumni')->id();
        
        // Cek menggunakan model TracerStudy (bukan TracerMain)
        $alreadyFilled = TracerStudy::where('user_id', $alumniId)
            ->whereYear('created_at', date('Y'))
            ->exists();

        if ($alreadyFilled) {
            return redirect()->route('alumni.dashboard')
                ->with('info', 'Anda sudah mengisi Tracer Study tahun ini.');
        }

        return view('alumni.tracer.wizard');
    }

    /**
     * Menyimpan Data Tracer Study
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            // --- STEP 1: Data Pribadi ---
            'q1_nama'              => 'required|string',
            'q2_angkatan'          => 'required',
            'q3_prodi'             => 'required',
            'q4_ipk'               => 'required',
            'q5_tanggal_lulus'     => 'required|date',
            'q6_alamat'            => 'required|string',
            'q7_provinsi'          => 'required|string',
            'q9_kota'              => 'required|string',
            'q8_kodepos'           => 'required',
            'q10a_no_hp'           => 'required',
            'q10b_email'           => 'required|email',
            'q11_jenis_kelamin'    => 'required',
            'status_bekerja'       => 'required|string',

            // --- STEP 2: Pekerjaan ---
            'q12_jenis_perusahaan' => 'required_if:status_bekerja,Sudah Bekerja',
            'q12a_lainnya'         => 'nullable',
            'q13a_nama_kantor'     => 'required_if:status_bekerja,Sudah Bekerja',
            'q15_tahun_masuk'      => 'required_if:status_bekerja,Sudah Bekerja',
            'q13b_pimpinan'        => 'nullable',
            'q13c_email_pimpinan'  => 'nullable',
            'q16_telp_pimpinan'    => 'nullable',
            'q19_penghasilan'      => 'required_if:status_bekerja,Sudah Bekerja',
            'q20_status_pekerjaan' => 'required_if:status_bekerja,Sudah Bekerja',
            'q21_hubungan'         => 'required_if:status_bekerja,Sudah Bekerja',
            'is_first_job'         => 'required_if:status_bekerja,Sudah Bekerja',

            // Sub-step: Pekerjaan Pertama
            'q25_kantor_pertama'   => 'required_if:is_first_job,Tidak',
            'q26_alasan_berhenti'  => 'nullable',
            'q28_gaji_pertama'     => 'nullable',

            // --- STEP 3: Pendidikan & Organisasi ---
            'q33_tempat_tinggal'   => 'required',
            'q34_sumber_biaya'     => 'required',
            'q35_organisasi'       => 'required',
            'q36_keaktifan'        => 'required_if:q35_organisasi,Ya',
            'q37_kursus'           => 'required',
            'q37a_nama_kursus'     => 'required_if:q37_kursus,Ya',

            // Matriks Evaluasi Pembelajaran
            'q38a' => 'required|integer', 'q38b' => 'required|integer', 'q38c' => 'required|integer',
            'q38d' => 'required|integer', 'q38e' => 'required|integer', 'q38f' => 'required|integer',

            // Matriks Fasilitas
            'q40a' => 'required|integer', 'q40b' => 'required|integer', 'q40c' => 'required|integer',
            'q40d' => 'required|integer', 'q40e' => 'required|integer', 'q40g' => 'required|integer',
            'q40k' => 'required|integer',

            // --- STEP 4: Kompetensi ---
            'q42a' => 'required|integer', 'q42b' => 'required|integer', 'q42c' => 'required|integer',
            'q42d' => 'required|integer', 'q42e' => 'required|integer', 'q42f' => 'required|integer',
            'q42i' => 'required|integer', 'q42l' => 'required|integer', 'q42m' => 'required|integer',
            'q42n' => 'required|integer', 'q42o' => 'required|integer',

            // Penutup
            'q45_bahasa'           => 'required|integer',
            'q47_uin'              => 'required',
            'q48_alasan_uin'       => 'required_if:q47_uin,Tidak',
            'q49_prodi'            => 'required',
            'q50_alasan_prodi'     => 'required_if:q49_prodi,Tidak',

            'fakultas'             => 'nullable|string',
        ]);

        // 2. Tambahkan User ID
        $validatedData['user_id'] = Auth::guard('alumni')->id();

        // 3. Simpan ke Database
        TracerStudy::create($validatedData);

        // 4. Redirect
        return redirect()->route('alumni.dashboard')
            ->with('success', 'Terima kasih! Data Tracer Study Anda berhasil disimpan.');
    }
}