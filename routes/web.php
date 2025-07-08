<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()) {
        if (Auth::user()->tip === 'domacin') {
            $domacinstvo = \App\Models\Domacinstvo::firstWhere('user_id', Auth::user()->id);

            if ($domacinstvo) {
                return redirect(route('domacinstvo.show', $domacinstvo));
            } else {
                return redirect(route('pocetna'));
            }
        }
    } else {
        return redirect(route('login'));
    }
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('pocetna', function () {
        if (Auth::user()->tip === 'domacin') {
            $domacinstvo = \App\Models\Domacinstvo::firstWhere('user_id', Auth::user()->id);

            if ($domacinstvo) {
                return redirect(route('domacinstvo.show', $domacinstvo));
            } else {
                return Inertia::render('Pocetna');
            }
        } else {
            return redirect(route('home'));
        }
    })->name('pocetna');

    Route::resource('users', App\Http\Controllers\UserController::class)->except('create', 'store', 'edit');

    Route::resource('domacinstvo', App\Http\Controllers\DomacinstvoController::class)->except('index');

    Route::resource('radni-nalog', App\Http\Controllers\RadniNalogController::class)->except('edit');

    Route::resource('preuzeto-mleko', App\Http\Controllers\PreuzetoMlekoController::class)->only('index', 'show');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
