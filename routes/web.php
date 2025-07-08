<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomepageController::class, 'root'])->name('home');
    
    Route::get('pocetna', [App\Http\Controllers\HomepageController::class, 'pocetna'])->name('pocetna');

    Route::resource('users', App\Http\Controllers\UserController::class)->except('create', 'store', 'edit');

    Route::resource('domacinstvo', App\Http\Controllers\DomacinstvoController::class)->except('index');

    Route::resource('radni-nalog', App\Http\Controllers\RadniNalogController::class)->except('edit');

    Route::resource('preuzeto-mleko', App\Http\Controllers\PreuzetoMlekoController::class)->only('index', 'show');

    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('zaposleni', App\Http\Controllers\ZaposleniController::class)->only('index', 'update', 'destroy');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
