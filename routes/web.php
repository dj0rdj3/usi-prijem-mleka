<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';


Route::resource('users', App\Http\Controllers\UserController::class)->except('create', 'store', 'edit');

Route::resource('domacinstvo', App\Http\Controllers\DomacinstvoController::class)->except('index', 'edit');

Route::resource('radni-nalog', App\Http\Controllers\RadniNalogController::class)->except('edit');

Route::resource('preuzeto-mleko', App\Http\Controllers\PreuzetoMlekoController::class)->only('index', 'show');
