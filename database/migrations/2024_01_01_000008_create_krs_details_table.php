<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Detail matkul (kelas_matkul) yang diambil dalam satu KRS.
     * sks_diambil disalin dari mata_kuliah pada saat pengambilan,
     * supaya kalau SKS matkul berubah di masa depan, riwayat KRS lama tidak ikut berubah.
     */
    public function up(): void
    {
        Schema::create('krs_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('krs_id')->constrained('krs')->cascadeOnDelete();
            $table->foreignId('kelas_matkul_id')->constrained('kelas_matkuls')->cascadeOnDelete();
            $table->unsignedTinyInteger('sks_diambil')->comment('Snapshot SKS matkul pada saat KRS diambil');
            $table->timestamps();

            // Tidak boleh ambil kelas_matkul yang sama dua kali dalam satu KRS
            $table->unique(['krs_id', 'kelas_matkul_id'], 'krs_detail_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krs_details');
    }
};
