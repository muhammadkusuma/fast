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
       // 1. Master Fakultas
        Schema::create('m_fakultas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_fakultas', 10);
            $table->string('nama_fakultas', 100);
            $table->timestamps();
        });

        // 2. Master Prodi
        Schema::create('m_prodi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_fakultas')->constrained('m_fakultas')->onDelete('cascade');
            $table->string('kode_prodi', 10);
            $table->string('nama_prodi', 100);
            $table->enum('jenjang', ['D3', 'D4', 'S1', 'S2', 'S3'])->default('S1');
            $table->timestamps();
        });

        // 3. Master Alumni
        Schema::create('m_alumni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_prodi')->constrained('m_prodi')->onDelete('cascade');
            $table->string('nim', 20)->unique();
            $table->string('nama_lengkap', 150);
            $table->string('nik', 16)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->year('tahun_masuk');
            $table->year('tahun_lulus');
            $table->decimal('ipk', 3, 2)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('alamat_domisili')->nullable();
            $table->string('password')->nullable(); // Hash
            $table->timestamps();

            // Indexing untuk performa pencarian
            $table->index('nim');
            $table->index('tahun_lulus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('m_alumni');
        Schema::dropIfExists('m_prodi');
        Schema::dropIfExists('m_fakultas');
    }
};
