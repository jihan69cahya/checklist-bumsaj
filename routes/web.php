<?php

use App\Http\Controllers\Admin\ValidationController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\ChecklistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopbarController;


Route::get('/rekapitulasi/download', [RekapitulasiController::class, 'downloadXLS'])->name('rekapitulasi.download');

Route::get('/', function () {
    return view('beranda');
})->name('beranda');


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [BerandaController::class, 'show'])->name('beranda');

    Route::get('/rekapitulasi', [RekapitulasiController::class, 'showRekapitulasi'])->name('rekapitulasi');

    Route::get('/checklist/entries-by-period', [ChecklistController::class, 'getEntriesByPeriod']);
    Route::post('/checklist/clear-entry-value', [ChecklistController::class, 'clearEntryValue']);
    Route::post('/checklist/save-entry-values', [ChecklistController::class, 'saveEntryValues']);
    Route::get('/checklist/{category_identifier}', [ChecklistController::class, 'show'])->name('checklist.show');
    Route::get('/topbar/username', [TopbarController::class, 'getUserName']);

    Route::get('/validation/{category_identifier}', [ValidationController::class, 'show'])->name('validation.show');
    Route::post('/validation/store', [ValidationController::class, 'validation'])->name('validation.store');
    Route::get('/detail/{tanggal}/{category_id}/{category}', [ValidationController::class, 'detail'])->name('validation.detail');
});
