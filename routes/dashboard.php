<?php

use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\KelasMatkulController;
use App\Http\Controllers\Admin\KhsMahasiswaController;
use App\Http\Controllers\Admin\KrsApprovalController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\NilaiController as AdminNilaiController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Ai\ChatController;
use App\Http\Controllers\Ai\ChatPageController;
use App\Http\Controllers\Ai\InsightController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\JadwalController as DosenJadwalController;
use App\Http\Controllers\Dosen\NilaiController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\JadwalController as MahasiswaJadwalController;
use App\Http\Controllers\Mahasiswa\KhsController;
use App\Http\Controllers\Mahasiswa\KrsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::prefix('ai')->name('ai.')->group(function () {
        Route::get('chat', ChatPageController::class)->name('chat');
        Route::get('insight', [InsightController::class, 'index'])->name('insight');
        Route::get('conversations', [ChatController::class, 'conversations'])->name('conversations');
        Route::get('conversations/{conversationId}', [ChatController::class, 'history'])->name('conversations.history');
        Route::post('chat', [ChatController::class, 'send'])->name('chat.send');
        Route::get('analyze-grade/{kelasMatkul}', [InsightController::class, 'analyzeGrade'])->name('analyze-grade');
    });

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

        Route::resource('akun', AkunController::class)->except(['create', 'edit']);
        Route::patch('akun/{akun}/toggle-active', [AkunController::class, 'toggleActive'])->name('akun.toggle-active');

        Route::resource('mahasiswa', MahasiswaController::class)->except(['create', 'edit']);
        Route::resource('dosen', DosenController::class)->except(['create', 'edit']);
        Route::resource('mata-kuliah', MataKuliahController::class)->except(['create', 'edit']);
        Route::resource('semester', SemesterController::class)->except(['create', 'edit']);
        Route::patch('semester/{semester}/set-active', [SemesterController::class, 'setActive'])->name('semester.set-active');
        Route::resource('kelas-matkul', KelasMatkulController::class)->except(['create', 'edit']);

        Route::get('krs', [KrsApprovalController::class, 'index'])->name('krs.index');
        Route::patch('krs/{krs}/approve', [KrsApprovalController::class, 'approve'])->name('krs.approve');
        Route::patch('krs/{krs}/tolak', [KrsApprovalController::class, 'tolak'])->name('krs.tolak');

        Route::get('nilai', [AdminNilaiController::class, 'index'])->name('nilai.index');

        Route::get('khs', [KhsMahasiswaController::class, 'index'])->name('khs.index');

        Route::get('jadwal', [AdminJadwalController::class, 'index'])->name('jadwal.index');
    });

    Route::middleware(['role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', MahasiswaDashboardController::class)->name('dashboard');

        Route::get('krs', [KrsController::class, 'index'])->name('krs.index');
        Route::post('krs/{kelasMatkul}', [KrsController::class, 'tambah'])->name('krs.tambah');
        Route::delete('krs/detail/{krsDetail}', [KrsController::class, 'hapus'])->name('krs.hapus');
        Route::patch('krs/{krs}/ajukan', [KrsController::class, 'ajukan'])->name('krs.ajukan');

        Route::get('khs', [KhsController::class, 'index'])->name('khs.index');
        Route::get('khs/{semester}', [KhsController::class, 'show'])->name('khs.show');

        Route::get('jadwal', [MahasiswaJadwalController::class, 'index'])->name('jadwal.index');
    });

    Route::middleware(['role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', DosenDashboardController::class)->name('dashboard');

        Route::get('nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('nilai/{kelasMatkul}', [NilaiController::class, 'edit'])->name('nilai.edit');
        Route::put('nilai/{kelasMatkul}', [NilaiController::class, 'update'])->name('nilai.update');

        Route::get('jadwal', [DosenJadwalController::class, 'index'])->name('jadwal.index');
    });
});
