<?php
namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\TracerMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// Pastikan model dibuat

class TracerController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Dasar (Tidak semua saya tulis agar tidak terlalu panjang, tapi ini contohnya)
        $request->validate([
            'q1_nama'              => 'required',
            'status_bekerja'       => 'required',
            'q42_kompetensi_lulus' => 'required|array', // Validasi Array Matrix
        ]);

        try {
            DB::transaction(function () use ($request) {
                $alumniId = Auth::guard('alumni')->id();

                // A. SIMPAN TABEL MAIN
                $main = TracerMain::create([
                    'id_alumni'         => $alumniId,
                    'tahun_tracer'      => date('Y'),
                    'q1_nama'           => $request->q1_nama,
                    'q2_angkatan'       => $request->q2_angkatan,
                    'q3_prodi'          => $request->q3_prodi,
                    'q4_ipk'            => $request->q4_ipk,
                    'q5_tanggal_lulus'  => $request->q5_tanggal_lulus,
                    'q6_alamat'         => $request->q6_alamat,
                    'q7_provinsi'       => $request->q7_provinsi,
                    'q8_kodepos'        => $request->q8_kodepos,
                    'q9_kabupaten'      => $request->q9_kabupaten,
                    'q10a_no_hp'        => $request->q10a_no_hp,
                    'q10b_email'        => $request->q10b_email,
                    'q11_jenis_kelamin' => $request->q11_jenis_kelamin,
                    'status_bekerja'    => $request->status_bekerja,

                    // Penutup
                    'q47_pilih_uin'     => $request->q47_pilih_uin,
                    'q48_alasan_uin'    => $request->q48_alasan_uin,
                    'q49_pilih_prodi'   => $request->q49_pilih_prodi,
                    'q50_alasan_prodi'  => $request->q50_alasan_prodi,
                ]);

                // B. SIMPAN PEKERJAAN (Hanya jika Status = Sudah Bekerja)
                if ($request->status_bekerja == 'Sudah Bekerja') {
                    $main->job()->create([
                        'q12_jenis_perusahaan'   => $request->q12_jenis_perusahaan,
                        'q12a_pekerjaan_lainnya' => $request->q12a_pekerjaan_lainnya,
                        'q13a_nama_kantor'       => $request->q13a_nama_kantor,
                        'q13b_nama_pimpinan'     => $request->q13b_nama_pimpinan,
                        'q14_bidang_pekerjaan'   => $request->q14_bidang_pekerjaan,
                        'q19_penghasilan'        => $request->q19_penghasilan,
                        'q22_waktu_tunggu'       => $request->q22_waktu_tunggu,

                        // Riwayat First Job
                        'is_first_job'           => $request->is_first_job,
                        'q25_nama_kantor_1'      => $request->q25_nama_kantor_1,
                        'q26_alasan_berhenti_1'  => $request->q26_alasan_berhenti_1,
                        // ... Mapping field lain Q24-Q32 disini
                    ]);
                }

                // C. SIMPAN PENDIDIKAN
                $main->education()->create([
                    'q33_tempat_tinggal' => $request->q33_tempat_tinggal,
                    'q34_pembiayaan'     => $request->q34_pembiayaan,
                    'q35_organisasi'     => $request->q35_organisasi,
                    'q36_keaktifan_org'  => $request->q36_keaktifan_org,
                    'q37_kursus'         => $request->q37_kursus ?? 'Tidak',

                    // Simpan Matrix Pertanyaan Q38
                    'q38a_perkuliahan'   => $request->q38a_perkuliahan,
                    'q38b_demonstrasi'   => $request->q38b_demonstrasi,
                    'q38c_riset'         => $request->q38c_riset,
                    'q38d_diskusi'       => $request->q38d_diskusi,
                    'q38e_pkl'           => $request->q38e_pkl,
                    'q38f_seminar'       => $request->q38f_seminar,

                                                                                     // JSON Fields untuk Matrix Besar lainnya
                    'q39_aspek_belajar'  => json_encode($request->input('q39', [])), // Asumsi nama input di view q39[...]
                    'q40_fasilitas'      => json_encode($request->input('q40', [])),
                    'q41_pengalaman'     => json_encode($request->input('q41', [])),
                ]);

                // D. SIMPAN KOMPETENSI (JSON)
                $main->competence()->create([
                    'q42_kompetensi_lulus' => json_encode($request->q42_kompetensi_lulus),
                    'q43_manfaat_prodi'    => json_encode($request->input('q43_manfaat', [])),
                    'q44_peran_pekerjaan'  => json_encode($request->input('q44_peran', [])),
                ]);

            });

            return redirect()->route('alumni.dashboard')->with('success', 'Tracer Study berhasil dikirim! Terima kasih.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }
}
