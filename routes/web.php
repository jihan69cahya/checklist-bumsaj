<?php

use App\Http\Controllers\ChecklistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function ()
{
    return view('beranda');
})->name('beranda');

Route::get('/login', function ()
{
    return view('login');
});

Route::get('/checklist/{category_identifier}', [ChecklistController::class, 'show'])->name('checklist.show');
