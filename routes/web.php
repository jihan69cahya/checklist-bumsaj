<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\ChecklistController;
use Illuminate\Support\Facades\Route;


Route::get('/rekapitulasi/download', [RekapitulasiController::class, 'downloadXLS'])->name('rekapitulasi.download');

Route::get('/', function ()
{
    return view('beranda');
})->name('beranda');


Route::get('/login', function ()
{
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function ()
{
    Route::get('/', [BerandaController::class, 'show'])->name('beranda');

    Route::get('/rekapitulasi', [RekapitulasiController::class, 'showRekapitulasi'])->name('rekapitulasi');

    Route::get('/checklist/entries-by-period', [ChecklistController::class, 'getEntriesByPeriod']);
    Route::post('/checklist/clear-entry-value', [ChecklistController::class, 'clearEntryValue']);
    Route::post('/checklist/save-entry-values', [ChecklistController::class, 'saveEntryValues']);
    Route::get('/checklist/{category_identifier}', [ChecklistController::class, 'show'])->name('checklist.show');
});
