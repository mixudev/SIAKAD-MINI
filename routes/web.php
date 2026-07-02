<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->isDosen()) {
        return redirect()->route('dosen.dashboard');
    }

    if ($user->isMahasiswa()) {
        return redirect()->route('mahasiswa.dashboard');
    }

    return redirect('/');
})->name('dashboard');

require __DIR__.'/dashboard.php';
require __DIR__.'/auth.php';
require __DIR__.'/docs.php';
