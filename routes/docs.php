<?php

use App\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

Route::prefix('docs')->name('docs.')->group(function () {
    Route::get('/', [DocsController::class, 'index'])->name('index');
    Route::get('{view}', [DocsController::class, 'show'])
        ->where('view', '.*')
        ->name('show');
});
