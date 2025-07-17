<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomepageController::class, 'root'])->name('home');
    
    Route::get('pocetna', [App\Http\Controllers\HomepageController::class, 'pocetna'])->name('pocetna');

    Route::inertia('ugovor', 'Ugovor')->name('ugovor');

    Route::resource('zaposleni', App\Http\Controllers\UserController::class)->except('create', 'show', 'store', 'edit');

    Route::resource('domacinstvo', App\Http\Controllers\DomacinstvoController::class)->except('index');

    Route::resource('radni-nalog', App\Http\Controllers\RadniNalogController::class)->except('destroy');

    Route::resource('preuzeto-mleko', App\Http\Controllers\PreuzetoMlekoController::class)->only('index', 'show');

    Route::get('dashboard', [App\Http\Controllers\HomepageController::class, 'dashboard'])->name('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
