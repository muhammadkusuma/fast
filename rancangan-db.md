/* ==================================================
   DATABASE SCHEMA FINAL: SISTEM TRACER STUDY & PRESTASI
   Author: Gemini AI for Wira
   Target: MySQL / MariaDB
   ================================================== */

-- --------------------------------------------------
-- 1. MASTER DATA: FAKULTAS, PRODI, ALUMNI
-- --------------------------------------------------

-- A. Tabel Fakultas (Untuk Insight tingkat Fakultas)
CREATE TABLE m_fakultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_fakultas VARCHAR(10) NOT NULL,
    nama_fakultas VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- B. Tabel Program Studi
CREATE TABLE m_prodi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_fakultas INT NOT NULL,
    kode_prodi VARCHAR(10) NOT NULL,
    nama_prodi VARCHAR(100) NOT NULL,
    jenjang ENUM('D3', 'D4', 'S1', 'S2', 'S3') DEFAULT 'S1',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_fakultas) REFERENCES m_fakultas(id) ON DELETE CASCADE
);

-- C. Tabel Master Alumni (Profil Tetap)
CREATE TABLE m_alumni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_prodi INT NOT NULL,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(150) NOT NULL,
    nik VARCHAR(16) NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tahun_masuk YEAR NOT NULL,
    tahun_lulus YEAR NOT NULL,
    ipk DECIMAL(3, 2) NULL,
    no_hp VARCHAR(20),
    email VARCHAR(100),
    alamat_domisili TEXT,
    password VARCHAR(255) NULL COMMENT 'Hash password untuk login',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_prodi) REFERENCES m_prodi(id) ON DELETE CASCADE,
    INDEX (nim),
    INDEX (tahun_lulus)
);

-- --------------------------------------------------
-- 2. MODUL PRESTASI (Terpisah dari Tracer)
-- --------------------------------------------------

CREATE TABLE t_prestasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_alumni INT NOT NULL,
    nama_kompetisi VARCHAR(200) NOT NULL,
    jenis_prestasi ENUM('Akademik/Sains', 'Olahraga', 'Seni/Budaya', 'Teknologi/Inovasi', 'Lainnya') NOT NULL,
    tingkat ENUM('Kabupaten/Kota', 'Provinsi', 'Nasional', 'Regional/ASEAN', 'Internasional') NOT NULL,
    peringkat VARCHAR(50) NOT NULL COMMENT 'Contoh: Juara 1, Medali Emas, Finalis',
    penyelenggara VARCHAR(150),
    tahun_perolehan YEAR NOT NULL,
    file_sertifikat VARCHAR(255) NULL COMMENT 'Path upload file',
    status_validasi ENUM('Pending', 'Disetujui', 'Ditolak') DEFAULT 'Pending',
    keterangan_admin TEXT COMMENT 'Catatan jika ditolak',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_alumni) REFERENCES m_alumni(id) ON DELETE CASCADE
);

-- --------------------------------------------------
-- 3. MODUL TRACER STUDY (Kuesioner)
-- Dibagi menjadi 4 Tabel Relasional (One-to-One)
-- --------------------------------------------------

-- Tabel Utama: Menyimpan sesi pengisian dan Status Pekerjaan (Standard DIKTI)
CREATE TABLE t_tracer_main (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_alumni INT NOT NULL,
    tahun_tracer YEAR NOT NULL COMMENT 'Tahun pelaksanaan survei',
    tanggal_pengisian DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    -- Status Utama
    status_aktivitas ENUM(
        'Bekerja (Full Time/Part Time)',
        'Wiraswasta',
        'Melanjutkan Pendidikan',
        'Tidak Bekerja',
        'Lainnya'
    ) NOT NULL,
    
    -- Detail Pekerjaan (Hanya diisi jika Bekerja)
    nama_perusahaan VARCHAR(200) NULL,
    jenis_perusahaan ENUM('Instansi Pemerintah', 'BUMN/BUMD', 'Swasta Nasional', 'Swasta Asing', 'Wiraswasta', 'NGO', 'Pendidikan') NULL,
    provinsi_perusahaan VARCHAR(100) NULL,
    gaji_bulanan DECIMAL(15, 2) DEFAULT 0,
    
    -- Relevansi
    keselarasan_horizontal ENUM('Sangat Erat', 'Erat', 'Cukup Erat', 'Kurang Erat', 'Tidak Sama Sekali') COMMENT 'Kesesuaian dengan Prodi',
    keselarasan_vertikal ENUM('Setingkat Lebih Tinggi', 'Tingkat Yang Sama', 'Setingkat Lebih Rendah', 'Tidak Perlu Pendidikan Tinggi') COMMENT 'Kesesuaian Jenjang',
    
    FOREIGN KEY (id_alumni) REFERENCES m_alumni(id) ON DELETE CASCADE
);

-- Tabel Detail: Riwayat Pencarian Kerja (Insight Waktu Tunggu)
CREATE TABLE t_tracer_process (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_tracer_main INT NOT NULL,
    
    bulan_mulai_mencari ENUM('Sebelum Lulus', 'Sesudah Lulus') NOT NULL,
    waktu_tunggu_bulan INT NOT NULL COMMENT 'Berapa bulan setelah lulus baru dapat kerja',
    jumlah_lamaran INT DEFAULT 0,
    jumlah_wawancara INT DEFAULT 0,
    sumber_info_lowongan VARCHAR(100) COMMENT 'Jobstreet, LinkedIn, Teman, Kampus',
    
    FOREIGN KEY (id_tracer_main) REFERENCES t_tracer_main(id) ON DELETE CASCADE
);

-- Tabel Detail: Gap Kompetensi (Insight Kurikulum)
-- Skala 1-5 (1=Sangat Rendah, 5=Sangat Tinggi)
CREATE TABLE t_tracer_competence (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_tracer_main INT NOT NULL,
    
    -- A = Kompetensi yang didapat di Kampus
    -- B = Kompetensi yang dibutuhkan di Pekerjaan
    
    etika_a TINYINT, etika_b TINYINT,
    keahlian_bidang_a TINYINT, keahlian_bidang_b TINYINT,
    bahasa_inggris_a TINYINT, bahasa_inggris_b TINYINT,
    teknologi_informasi_a TINYINT, teknologi_informasi_b TINYINT,
    komunikasi_a TINYINT, komunikasi_b TINYINT,
    kerjasama_tim_a TINYINT, kerjasama_tim_b TINYINT,
    pengembangan_diri_a TINYINT, pengembangan_diri_b TINYINT,
    
    FOREIGN KEY (id_tracer_main) REFERENCES t_tracer_main(id) ON DELETE CASCADE
);

-- Tabel Detail: Evaluasi Kampus (Insight Fasilitas & Layanan)
-- Skala 1-5 (1=Sangat Buruk, 5=Sangat Baik)
CREATE TABLE t_tracer_evaluation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_tracer_main INT NOT NULL,
    
    kualitas_dosen TINYINT,
    kualitas_pembimbing_akademik TINYINT,
    fasilitas_laboratorium TINYINT,
    fasilitas_perpustakaan TINYINT,
    fasilitas_internet TINYINT,
    layanan_admin_akademik TINYINT,
    pusat_karir_kampus TINYINT,
    
    saran_perbaikan TEXT,
    
    FOREIGN KEY (id_tracer_main) REFERENCES t_tracer_main(id) ON DELETE CASCADE
);