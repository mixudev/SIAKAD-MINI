<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Manajemen semester. Hanya boleh ada 1 semester is_active = true pada satu waktu
     * (logic ini akan dijaga di Model/Observer, bukan di level DB constraint).
     *
     * tipe: ganjil / genap
     * tahun_ajaran: format "2025/2026"
     */
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->comment('Contoh: Ganjil 2025/2026');
            $table->string('tahun_ajaran')->comment('Contoh: 2025/2026');
            $table->enum('tipe', ['ganjil', 'genap']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('krs_mulai')->nullable()->comment('Tanggal mulai periode pengisian KRS');
            $table->date('krs_selesai')->nullable()->comment('Tanggal akhir periode pengisian KRS');
            $table->boolean('is_active')->default(false)->comment('Semester yang sedang berjalan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
