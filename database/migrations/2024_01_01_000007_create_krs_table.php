<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Header KRS: satu mahasiswa hanya punya SATU baris KRS per semester.
     * Detail matkul yang diambil ada di tabel `krs_details`.
     *
     * total_sks disimpan langsung di sini (denormalized) supaya validasi
     * SKS max (24 SKS) gampang dicek tanpa perlu SUM tiap saat.
     */
    public function up(): void
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->unsignedTinyInteger('total_sks')->default(0);
            $table->enum('status', ['draft', 'diajukan', 'disetujui', 'ditolak'])->default('draft');
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users')->nullOnDelete()
                ->comment('User (dosen PA / admin) yang menyetujui KRS ini');
            $table->timestamp('diajukan_at')->nullable();
            $table->timestamp('disetujui_at')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Satu mahasiswa hanya boleh punya satu KRS per semester
            $table->unique(['mahasiswa_id', 'semester_id'], 'krs_mahasiswa_semester_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
