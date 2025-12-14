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
        // 1. Modul Prestasi
        Schema::create('t_prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_alumni')->constrained('m_alumni')->onDelete('cascade');
            $table->string('nama_kompetisi', 200);
            $table->enum('jenis_prestasi', ['Akademik/Sains', 'Olahraga', 'Seni/Budaya', 'Teknologi/Inovasi', 'Lainnya']);
            $table->enum('tingkat', ['Kabupaten/Kota', 'Provinsi', 'Nasional', 'Regional/ASEAN', 'Internasional']);
            $table->string('peringkat', 50);
            $table->string('penyelenggara', 150)->nullable();
            $table->year('tahun_perolehan');
            $table->string('file_sertifikat')->nullable();
            $table->enum('status_validasi', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->text('keterangan_admin')->nullable();
            $table->timestamps();
        });

        // 2. Tracer Main (Induk Kuesioner)
        Schema::create('t_tracer_main', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_alumni')->constrained('m_alumni')->onDelete('cascade');
            $table->year('tahun_tracer');
            $table->dateTime('tanggal_pengisian')->useCurrent();
            
            $table->enum('status_aktivitas', [
                'Bekerja (Full Time/Part Time)',
                'Wiraswasta',
                'Melanjutkan Pendidikan',
                'Tidak Bekerja',
                'Lainnya'
            ]);

            // Detail Pekerjaan (Nullable)
            $table->string('nama_perusahaan', 200)->nullable();
            $table->enum('jenis_perusahaan', ['Instansi Pemerintah', 'BUMN/BUMD', 'Swasta Nasional', 'Swasta Asing', 'Wiraswasta', 'NGO', 'Pendidikan'])->nullable();
            $table->string('provinsi_perusahaan', 100)->nullable();
            $table->decimal('gaji_bulanan', 15, 2)->default(0);

            // Relevansi (Nullable, bisa diisi nanti di frontend logic)
            $table->enum('keselarasan_horizontal', ['Sangat Erat', 'Erat', 'Cukup Erat', 'Kurang Erat', 'Tidak Sama Sekali'])->nullable();
            $table->enum('keselarasan_vertikal', ['Setingkat Lebih Tinggi', 'Tingkat Yang Sama', 'Setingkat Lebih Rendah', 'Tidak Perlu Pendidikan Tinggi'])->nullable();

            $table->timestamps();
        });

        // 3. Tracer Process (Riwayat Cari Kerja)
        Schema::create('t_tracer_process', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tracer_main')->constrained('t_tracer_main')->onDelete('cascade');
            
            $table->enum('bulan_mulai_mencari', ['Sebelum Lulus', 'Sesudah Lulus']);
            $table->integer('waktu_tunggu_bulan');
            $table->integer('jumlah_lamaran')->default(0);
            $table->integer('jumlah_wawancara')->default(0);
            $table->string('sumber_info_lowongan', 100)->nullable();
            $table->timestamps(); // Optional jika tidak butuh created_at/updated_at
        });

        // 4. Tracer Competence (Gap Analysis)
        Schema::create('t_tracer_competence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tracer_main')->constrained('t_tracer_main')->onDelete('cascade');

            // Kita gunakan loop atau tulis manual. Manual lebih aman untuk dibaca.
            $fields = ['etika', 'keahlian_bidang', 'bahasa_inggris', 'teknologi_informasi', 'komunikasi', 'kerjasama_tim', 'pengembangan_diri'];
            
            foreach($fields as $field) {
                $table->tinyInteger($field . '_a')->nullable(); // Kampus
                $table->tinyInteger($field . '_b')->nullable(); // Pekerjaan
            }
            
            $table->timestamps();
        });

        // 5. Tracer Evaluation (Fasilitas Kampus)
        Schema::create('t_tracer_evaluation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tracer_main')->constrained('t_tracer_main')->onDelete('cascade');

            $table->tinyInteger('kualitas_dosen')->nullable();
            $table->tinyInteger('kualitas_pembimbing_akademik')->nullable();
            $table->tinyInteger('fasilitas_laboratorium')->nullable();
            $table->tinyInteger('fasilitas_perpustakaan')->nullable();
            $table->tinyInteger('fasilitas_internet')->nullable();
            $table->tinyInteger('layanan_admin_akademik')->nullable();
            $table->tinyInteger('pusat_karir_kampus')->nullable();
            
            $table->text('saran_perbaikan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('t_tracer_evaluation');
        Schema::dropIfExists('t_tracer_competence');
        Schema::dropIfExists('t_tracer_process');
        Schema::dropIfExists('t_tracer_main');
        Schema::dropIfExists('t_prestasi');
    }
};
