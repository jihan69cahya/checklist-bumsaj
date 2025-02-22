<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function ()
{
    return view('beranda');
})->name('beranda');

Route::get('/login', function()
{
    return view('login');
});

Route::get('/rekapitulasi', function()
{
    return view('rekapitulasi');
})->name('rekapitulasi');