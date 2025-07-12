<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\RadniNalog;
use App\Models\Domacinstvo;
use App\Models\PreuzetoMleko;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function root()
    {
        switch (Auth::user()->tip) {
            case 'domacin':
                $domacinstvo = Domacinstvo::firstWhere('user_id', Auth::user()->id);

                if ($domacinstvo) {
                    return redirect(route('domacinstvo.show', $domacinstvo));
                } else {
                    return redirect(route('pocetna'));
                }
                break;
            case 'rukovodilac':
                return redirect(route('dashboard'));
                break;
            case 'vozac':
            case 'tehnolog':
                return redirect(route('radni-nalog.index'));
                break;
        }
    }

    public function pocetna()
    {
        if (Auth::user()->tip === 'domacin') {
            $domacinstvo = Domacinstvo::firstWhere('user_id', Auth::user()->id);

            if ($domacinstvo) {
                return redirect(route('domacinstvo.show', $domacinstvo));
            } else {
                return Inertia::render('Pocetna');
            }
        } else {
            return redirect(route('home'));
        }
    }

    public function dashboard()
    {
        $stats = [
            'broj_domacinstava' => Domacinstvo::count('id'),
            'broj_radnih_naloga' => RadniNalog::count('id'),
            'broj_vozaca' => User::where('tip', 'vozac')->count('id'),
            'broj_tehnologa' => User::where('tip', 'tehnolog')->count('id'),

            'ukupno_preuzetog_mleka_nedelja' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subWeek()->toDateTimeString())->sum('kolicina_mleka'),
            'kolicina_primljenog_mleka_nedelja' => [
                [
                    'title' => 'Ukupno',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subWeek()->toDateTimeString())->where('primljeno', 1)->sum('kolicina_mleka')
                ],
                [
                    'title' => 'Kravlje',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subWeek()->toDateTimeString())->where('primljeno', 1)->where('tip_mleka', 'kravlje')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Kozije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subWeek()->toDateTimeString())->where('primljeno', 1)->where('tip_mleka', 'kozije')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Ovčije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subWeek()->toDateTimeString())->where('primljeno', 1)->where('tip_mleka', 'ovcije')->sum('kolicina_mleka')
                ],
            ],
            'kolicina_odbijenog_mleka_nedelja' => [
                [
                    'title' => 'Ukupno',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subWeek()->toDateTimeString())->where('primljeno', 0)->sum('kolicina_mleka')
                ],
                [
                    'title' => 'Kravlje',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subWeek()->toDateTimeString())->where('primljeno', 0)->where('tip_mleka', 'kravlje')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Kozije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subWeek()->toDateTimeString())->where('primljeno', 0)->where('tip_mleka', 'kozije')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Ovčije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subWeek()->toDateTimeString())->where('primljeno', 0)->where('tip_mleka', 'ovcije')->sum('kolicina_mleka')
                ],
            ],

            'ukupno_preuzetog_mleka_mesec' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->sum('kolicina_mleka'),
            'kolicina_primljenog_mleka_mesec' => [
                [
                    'title' => 'Ukupno',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->where('primljeno', 1)->sum('kolicina_mleka')
                ],
                [
                    'title' => 'Kravlje',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->where('primljeno', 1)->where('tip_mleka', 'kravlje')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Kozije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->where('primljeno', 1)->where('tip_mleka', 'kozije')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Ovčije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->where('primljeno', 1)->where('tip_mleka', 'ovcije')->sum('kolicina_mleka')
                ],
            ],
            'kolicina_odbijenog_mleka_mesec' => [
                [
                    'title' => 'Ukupno',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->where('primljeno', 0)->sum('kolicina_mleka')
                ],
                [
                    'title' => 'Kravlje',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->where('primljeno', 0)->where('tip_mleka', 'kravlje')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Kozije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->where('primljeno', 0)->where('tip_mleka', 'kozije')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Ovčije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->where('primljeno', 0)->where('tip_mleka', 'ovcije')->sum('kolicina_mleka')
                ],
            ],

            'ukupno_preuzetog_mleka_godina' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subYear()->toDateTimeString())->sum('kolicina_mleka'),
            'kolicina_primljenog_mleka_godina' => [
                [
                    'title' => 'Ukupno',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subYear()->toDateTimeString())->where('primljeno', 1)->sum('kolicina_mleka')
                ],
                [
                    'title' => 'Kravlje',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subYear()->toDateTimeString())->where('primljeno', 1)->where('tip_mleka', 'kravlje')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Kozije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subYear()->toDateTimeString())->where('primljeno', 1)->where('tip_mleka', 'kozije')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Ovčije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subYear()->toDateTimeString())->where('primljeno', 1)->where('tip_mleka', 'ovcije')->sum('kolicina_mleka')
                ],
            ],
            'kolicina_odbijenog_mleka_godina' => [
                [
                    'title' => 'Ukupno',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subYear()->toDateTimeString())->where('primljeno', 0)->sum('kolicina_mleka')
                ],
                [
                    'title' => 'Kravlje',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subYear()->toDateTimeString())->where('primljeno', 0)->where('tip_mleka', 'kravlje')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Kozije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subYear()->toDateTimeString())->where('primljeno', 0)->where('tip_mleka', 'kozije')->sum('kolicina_mleka'),
                ],
                [
                    'title' => 'Ovčije',
                    'value' => PreuzetoMleko::whereDate('created_at', '>=', Carbon::now()->subYear()->toDateTimeString())->where('primljeno', 0)->where('tip_mleka', 'ovcije')->sum('kolicina_mleka')
                ],
            ],
        ];

        return Inertia::render('rukovodilac/Dashboard', [
            'stats' => $stats,
        ]);
    }
}
