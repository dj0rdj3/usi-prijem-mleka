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
            $radni_nalozi = RadniNalog::with('domacinstvo')->get();
        } else {
            $radni_nalozi = RadniNalog::query()
                ->when($request->user()->tip === 'vozac', function ($query) use ($request) {
                    $query->where('kolicina_mleka', NULL)
                        ->where('vozac_id', $request->user()->id);
                })
                ->when($request->user()->tip === 'tehnolog', function ($query) use ($request) {
                    $query->where('kolicina_mleka', '!=', NULL)
                        ->where('tehnolog_id', $request->user()->id);
                })
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
        if ($request->user()->tip !== 'rukovodilac') abort(403);

        return Inertia::render('radni-nalog/Create', [
            'domacinstva' => Domacinstvo::all(),
            'vozaci' => User::where('tip', 'vozac')->get(),
            'tehnolozi' => User::where('tip', 'tehnolog')->get(),
        ]);
    }

    public function store(RadniNalogStoreRequest $request)
    {
        if ($request->user()->tip !== 'rukovodilac') abort(403);

        $attributes = $request->validated();
        $attributes['rukovodilac_id'] = $request->user()->id;
        RadniNalog::create($attributes);
        return redirect(route('dashboard'));
    }

    public function show(Request $request, RadniNalog $radniNalog)
    {
        if ($request->user()->tip !== 'rukovodilac') abort(403);

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
        if (
            !is_null($radniNalog->primljeno)
            || $request->user()->tip === 'tehnolog' && is_null($radniNalog->kolicina_mleka)
            || $request->user()->tip === 'vozac' && !is_null($radniNalog->kolicina_mleka)
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
        if (
            !is_null($radniNalog->primljeno)
            || $request->user()->tip === 'tehnolog' && is_null($radniNalog->kolicina_mleka)
            || $request->user()->tip === 'vozac' && !is_null($radniNalog->kolicina_mleka)
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

    public function destroy(Request $request, RadniNalog $radniNalog)
    {
        //
    }
}
