<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\RadniNalog;
use App\Models\Domacinstvo;
use Illuminate\Http\Request;
use App\Http\Requests\RadniNalogStoreRequest;
use App\Http\Requests\RadniNalogUpdateRequest;
use App\Models\PreuzetoMleko;

class RadniNalogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tip === 'rukovodilac') {
            // ako je korisnik rukovodilac, prikazujemo sve radne naloge
            $radni_nalozi = RadniNalog::with('domacinstvo')->get();
        } else {
            $radni_nalozi = RadniNalog::query()
                // ako je korisnik vozac, prikazujemo samo radne naloge kod kojih nije preuzeto mleko
                ->when($request->user()->tip === 'vozac', function ($query) use ($request) {
                    $query->where('kolicina_mleka', NULL)
                        ->where('vozac_id', $request->user()->id);
                })
                // ako je korisnik tehnolog, prikazujemo samo radne naloge kod kojih je preuzeto mleko
                ->when($request->user()->tip === 'tehnolog', function ($query) use ($request) {
                    $query->where('kolicina_mleka', '!=', NULL)
                        ->where('tehnolog_id', $request->user()->id);
                })
                // prikazujemo samo nezavrsene radne naloge
                ->where('primljeno', NULL)
                ->with('domacinstvo')
                ->get();
        }

        return Inertia::render('radni-nalog/Index', [
            'radni_nalozi' => $radni_nalozi
        ]);
    }

    public function create(Request $request)
    {
        if ($request->user()->tip !== 'rukovodilac') return abort(403);

        return Inertia::render('radni-nalog/Create', [
            'domacinstva' => Domacinstvo::all(),
            'vozaci' => User::where('tip', 'vozac')->get(),
            'tehnolozi' => User::where('tip', 'tehnolog')->get(),
        ]);
    }

    public function store(RadniNalogStoreRequest $request)
    {
        if ($request->user()->tip !== 'rukovodilac') return abort(403);

        $attributes = $request->validated();
        $attributes['rukovodilac_id'] = $request->user()->id;
        RadniNalog::create($attributes);
        return redirect(route('dashboard'));
    }

    public function show(Request $request, RadniNalog $radniNalog)
    {
        if ($request->user()->tip !== 'rukovodilac') return abort(403);

        $radniNalog->load([
            'domacinstvo.vlasnik',
            'rukovodilac',
            'vozac',
            'tehnolog'
        ]);
        return Inertia::render('radni-nalog/Show', [
            'radni_nalog' => $radniNalog
        ]);
    }

    public function edit(Request $request, RadniNalog $radniNalog)
    {
        // zabrana zaposlenima da menjaju naloge koji su zavrseni ili nisu njihovi
        if (
            !is_null($radniNalog->primljeno)
            || $request->user()->tip === 'tehnolog' && is_null($radniNalog->kolicina_mleka)
            || $request->user()->tip === 'vozac' && !is_null($radniNalog->kolicina_mleka)
            || $request->user()->tip === 'tehnolog' && $request->user()->id !== $radniNalog->tehnolog_id
            || $request->user()->tip === 'vozac' && $request->user()->id !== $radniNalog->vozac_id
        ) {
            return abort(403);
        }

        $radniNalog->load('domacinstvo.vlasnik');
        return Inertia::render('radni-nalog/Edit', [
            'radni_nalog' => $radniNalog
        ]);
    }

    public function update(RadniNalogUpdateRequest $request, RadniNalog $radniNalog)
    {
        // zabrana zaposlenima da menjaju naloge koji su zavrseni ili nisu njihovi
        if (
            !is_null($radniNalog->primljeno)
            || $request->user()->tip === 'tehnolog' && is_null($radniNalog->kolicina_mleka)
            || $request->user()->tip === 'vozac' && !is_null($radniNalog->kolicina_mleka)
            || $request->user()->tip === 'tehnolog' && $request->user()->id !== $radniNalog->tehnolog_id
            || $request->user()->tip === 'vozac' && $request->user()->id !== $radniNalog->vozac_id
        ) {
            return abort(403);
        }

        $attributes = $request->validated();
        if (empty($attributes['kolicina_mleka']) && is_null($radniNalog->kolicina_mleka)) {
            $attributes['primljeno'] = 0;
        }

        $radniNalog->update($attributes);
        if ($radniNalog->primljeno !== NULL) {
            PreuzetoMleko::fromRadniNalog($radniNalog);
        }

        return redirect(route('radni-nalog.index'));
    }
}
