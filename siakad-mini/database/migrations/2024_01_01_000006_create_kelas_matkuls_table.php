<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ini tabel KUNCI di seluruh sistem.
     *
     * Satu baris = satu "kelas" dari sebuah matkul, di semester tertentu, diampu satu dosen.
     * Karena 1 matkul bisa diampu beberapa dosen dengan kelas/jadwal berbeda,
     * matkul yang sama akan punya banyak baris di sini (beda dosen/kelas/semester).
     *
     * Mahasiswa mengambil KRS dengan memilih `kelas_matkul`, BUKAN langsung `mata_kuliah`.
     * Nilai juga dicatat per `kelas_matkul`, bukan per `mata_kuliah` langsung.
     */
    public function up(): void
    {
        Schema::create('kelas_matkuls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->cascadeOnDelete();
            $table->foreignId('dosen_id')->constrained('dosens')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->string('nama_kelas')->default('A')->comment('Contoh: A, B, Pagi, Malam');
            $table->unsignedSmallInteger('kapasitas')->default(40);
            $table->string('hari')->nullable();
            $table->string('jam_mulai')->nullable();
            $table->string('jam_selesai')->nullable();
            $table->string('ruangan')->nullable();
            $table->timestamps();

            // Kombinasi matkul + dosen + semester + kelas harus unik,
            // supaya tidak ada duplikat kelas yang sama persis.
            $table->unique(
                ['mata_kuliah_id', 'dosen_id', 'semester_id', 'nama_kelas'],
                'kelas_matkul_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas_matkuls');
    }
};
