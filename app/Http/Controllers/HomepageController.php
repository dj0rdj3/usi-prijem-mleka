<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Domacinstvo;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function root()
    {
        if (auth()) {
            if (Auth::user()->tip === 'domacin') {
                $domacinstvo = Domacinstvo::firstWhere('user_id', Auth::user()->id);

                if ($domacinstvo) {
                    return redirect(route('domacinstvo.show', $domacinstvo));
                } else {
                    return redirect(route('pocetna'));
                }
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function pocetna()
    {
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
    }
}
