<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel users adalah tabel auth utama untuk SEMUA role (admin, dosen, mahasiswa).
     *
     * Kolom `identifier` menampung:
     * - Admin    -> username bebas (misal: "admin01")
     * - Dosen    -> NIDN
     * - Mahasiswa -> NIM
     *
     * Role sebenarnya (admin/dosen/mahasiswa) di-assign lewat Spatie Permission,
     * bukan kolom enum di sini, supaya permission per role tetap fleksibel diatur.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique()->comment('NIM / NIDN / username, tergantung role');
            $table->string('name');
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
