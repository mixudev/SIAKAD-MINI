<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nilai per mahasiswa per kelas_matkul (bukan per mata_kuliah langsung,
     * supaya jelas nilai itu didapat dari kelas siapa & semester apa).
     *
     * Bobot nilai akhir TETAP untuk semua matkul:
     *   nilai_akhir = (tugas * 0.30) + (uts * 0.30) + (uas * 0.40)
     * Bobot ini dihitung di Model (accessor/method), bukan disimpan manual,
     * supaya kalau bobot berubah suatu saat, tinggal ubah satu tempat.
     *
     * nilai_akhir & nilai_huruf disimpan (denormalized) untuk mempercepat
     * query KHS/transkrip, tapi akan di-generate ulang otomatis tiap nilai komponen berubah.
     */
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('kelas_matkul_id')->constrained('kelas_matkuls')->cascadeOnDelete();
            $table->decimal('nilai_tugas', 5, 2)->nullable();
            $table->decimal('nilai_uts', 5, 2)->nullable();
            $table->decimal('nilai_uas', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable()->comment('Hasil hitung otomatis dari bobot tetap 30/30/40');
            $table->string('nilai_huruf', 2)->nullable()->comment('A, B, C, D, E - hasil konversi nilai_akhir');
            $table->foreignId('diinput_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Satu mahasiswa hanya punya satu baris nilai per kelas_matkul
            $table->unique(['mahasiswa_id', 'kelas_matkul_id'], 'nilai_mahasiswa_kelas_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
