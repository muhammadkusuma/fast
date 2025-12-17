<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();

            // Relasi ke User/Alumni (Sesuaikan 'users' atau 'alumni' dengan nama tabel user anda)
            $table->foreignId('user_id')->nullable()->index();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('fakultas')->nullable();

            // ==========================================
            // STEP 1: DATA PRIBADI (SECTION A)
            // ==========================================
            $table->string('q1_nama')->nullable();
            $table->string('q3_prodi')->nullable();
            $table->string('q2_angkatan')->nullable(); // Tahun Masuk
            $table->string('q4_ipk')->nullable();
            $table->date('q5_tanggal_lulus')->nullable();

            $table->text('q6_alamat')->nullable();
            $table->string('q7_provinsi')->nullable();
            $table->string('q9_kota')->nullable();
            $table->string('q8_kodepos')->nullable();

            $table->string('q10a_no_hp')->nullable();
            $table->string('q10b_email')->nullable();
            $table->string('q11_jenis_kelamin')->nullable(); // Laki-laki / Perempuan

            $table->string('status_bekerja')->nullable(); // Sudah Bekerja / Belum / Sedang Kuliah

            // ==========================================
            // STEP 2: PEKERJAAN (SECTION B)
            // ==========================================
            // Profil Instansi
            $table->string('q12_jenis_perusahaan')->nullable();
            $table->string('q12a_lainnya')->nullable(); // Jika pilih Lainnya
            $table->string('q13a_nama_kantor')->nullable();
            $table->string('q15_tahun_masuk')->nullable(); // Tahun mulai kerja

            // Data Pimpinan
            $table->string('q13b_pimpinan')->nullable();
            $table->string('q13c_email_pimpinan')->nullable();
            $table->string('q16_telp_pimpinan')->nullable();

                                                                // Detail Pekerjaan
            $table->string('q19_penghasilan')->nullable();      // Range Gaji
            $table->string('q20_status_pekerjaan')->nullable(); // Tetap/Kontrak/dll
            $table->string('q21_hubungan')->nullable();         // Kesesuaian Bidang Studi

                                                        // Riwayat Pekerjaan Pertama
            $table->string('is_first_job')->nullable(); // Ya / Tidak
            $table->string('q25_kantor_pertama')->nullable();
            $table->string('q26_alasan_berhenti')->nullable();
            $table->string('q28_gaji_pertama')->nullable();

            // ==========================================
            // STEP 3: PENDIDIKAN & BELAJAR (SECTION C)
            // ==========================================
            $table->string('q33_tempat_tinggal')->nullable();
            $table->string('q34_sumber_biaya')->nullable();

                                                          // Organisasi
            $table->string('q35_organisasi')->nullable(); // Ya / Tidak
            $table->string('q36_keaktifan')->nullable();  // Anggota/Pengurus/Ketua

                                                      // Kursus
            $table->string('q37_kursus')->nullable(); // Ya / Tidak
            $table->string('q37a_nama_kursus')->nullable();

                                                 // Evaluasi Pembelajaran (Skala 1-5)
            $table->integer('q38a')->nullable(); // Perkuliahan
            $table->integer('q38b')->nullable(); // Demonstrasi
            $table->integer('q38c')->nullable(); // Riset
            $table->integer('q38d')->nullable(); // Magang
            $table->integer('q38e')->nullable(); // Diskusi
            $table->integer('q38f')->nullable(); // Seminar

                                                 // Evaluasi Fasilitas (Skala 1-5)
            $table->integer('q40a')->nullable(); // Perpustakaan
            $table->integer('q40b')->nullable(); // TIK
            $table->integer('q40c')->nullable(); // Modul
            $table->integer('q40d')->nullable(); // Ruang Belajar
            $table->integer('q40e')->nullable(); // Lab
            $table->integer('q40g')->nullable(); // Kantin
            $table->integer('q40k')->nullable(); // Ibadah

                                                 // ==========================================
                                                 // STEP 4: KOMPETENSI & PENUTUP (SECTION D)
                                                 // ==========================================
                                                 // Kompetensi Diri (Skala 1-5)
            $table->integer('q42a')->nullable(); // Pengetahuan (Hardskill)
            $table->integer('q42b')->nullable(); // Pengetahuan luar bidang
            $table->integer('q42c')->nullable(); // Pengetahuan umum
            $table->integer('q42d')->nullable(); // Internet
            $table->integer('q42e')->nullable(); // Komputer
            $table->integer('q42f')->nullable(); // Berpikir Kritis
            $table->integer('q42i')->nullable(); // Komunikasi
            $table->integer('q42l')->nullable(); // Kerjasama Tim
            $table->integer('q42m')->nullable(); // Pemecahan Masalah
            $table->integer('q42n')->nullable(); // Analisis
            $table->integer('q42o')->nullable(); // Tanggung Jawab

                                                       // Penutup
            $table->integer('q45_bahasa')->nullable(); // Kemampuan Bahasa Asing (1-5)

            $table->string('q47_uin')->nullable();      // Memilih UIN lagi? (Ya/Tidak)
            $table->text('q48_alasan_uin')->nullable(); // Alasan jika Tidak

            $table->string('q49_prodi')->nullable();      // Memilih Prodi lagi? (Ya/Tidak)
            $table->text('q50_alasan_prodi')->nullable(); // Alasan jika Tidak

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_studies');
    }
};
