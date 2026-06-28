<?php

use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\KelasMatkulController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\SemesterController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('akun', AkunController::class)->except(['create', 'edit']);
        Route::patch('akun/{akun}/toggle-active', [AkunController::class, 'toggleActive'])->name('akun.toggle-active');

        Route::resource('mahasiswa', MahasiswaController::class)->except(['create', 'edit']);
        Route::resource('dosen', DosenController::class)->except(['create', 'edit']);
        Route::resource('mata-kuliah', MataKuliahController::class)->except(['create', 'edit']);
        Route::resource('semester', SemesterController::class)->except(['create', 'edit']);
        Route::patch('semester/{semester}/set-active', [SemesterController::class, 'setActive'])->name('semester.set-active');
        Route::resource('kelas-matkul', KelasMatkulController::class)->except(['create', 'edit']);
    });

    Route::middleware(['role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('dashboard');
    });

    Route::middleware(['role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dosen.dashboard');
        })->name('dashboard');
    });
});
