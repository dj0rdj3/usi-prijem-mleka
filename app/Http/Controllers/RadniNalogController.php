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
        //
    }

    public function create(Request $request)
    {
        return Inertia::render('radni-nalog/Create', [
            'domacinstva' => Domacinstvo::all(),
            'vozaci' => User::where('tip', 'vozac')->get(),
            'tehnolozi' => User::where('tip', 'tehnolog')->get(),
        ]);
    }

    public function store(RadniNalogStoreRequest $request)
    {
        $attributes = $request->validated();
        $attributes['rukovodilac_id'] = $request->user()->id;
        RadniNalog::create($attributes);
        return redirect(route('dashboard'));
    }

    public function show(Request $request, RadniNalog $radniNalog)
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
