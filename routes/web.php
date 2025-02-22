<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function ()
{
    return view('beranda');
})->name('beranda');

Route::get('/login', function ()
{
    return view('login');
});

Route::get('/checklist/fasilitas-gedung-terminal', function ()
{
    return view('checklists.fasilitas');
})->name('checklist.fasilitas');

Route::get('/checklist/kebersihan-gedung-terminal', function ()
{
    return view('checklists.kebersihan');
})->name('checklist.kebersihan');

Route::get('/checklist/curbside-area', function ()
{
    return view('checklists.curbside');
})->name('checklist.curbside');
