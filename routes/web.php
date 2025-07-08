<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomepageController::class, 'root'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('pocetna', [App\Http\Controllers\HomepageController::class, 'pocetna'])->name('pocetna');

    Route::resource('users', App\Http\Controllers\UserController::class)->except('create', 'store', 'edit');

    Route::resource('domacinstvo', App\Http\Controllers\DomacinstvoController::class)->except('index');

    Route::resource('radni-nalog', App\Http\Controllers\RadniNalogController::class)->except('edit');

    Route::resource('preuzeto-mleko', App\Http\Controllers\PreuzetoMlekoController::class)->only('index', 'show');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
