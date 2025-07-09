<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\RadniNalog;
use App\Models\Domacinstvo;
use Illuminate\Http\Request;
use App\Http\Requests\RadniNalogStoreRequest;
use App\Http\Requests\RadniNalogUpdateRequest;

class RadniNalogController extends Controller
{
    public function index(Request $request)
    {
        $radni_nalozi = RadniNalog::where('primljeno', NULL)
            ->where('vozac_id', $request->user()->id)
            ->orWhere('tehnolog_id', $request->user()->id)
            ->with('domacinstvo')
            ->get();

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
        //
    }

    public function edit(Request $request, RadniNalog $radniNalog)
    {
        //
    }

    public function update(RadniNalogUpdateRequest $request, RadniNalog $radniNalog)
    {
        //
    }

    public function destroy(Request $request, RadniNalog $radniNalog)
    {
        //
    }
}
