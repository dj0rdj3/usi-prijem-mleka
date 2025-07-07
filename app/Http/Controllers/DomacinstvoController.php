<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Domacinstvo;
use Illuminate\Http\Request;
use App\Http\Requests\DomacinstvoStoreRequest;
use App\Http\Requests\DomacinstvoUpdateRequest;

class DomacinstvoController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('domacinstvo/Create');
    }

    public function store(DomacinstvoStoreRequest $request)
    {
        $attributes = $request->validated();
        $koordinate = $attributes['koordinate']['lat'] . "," . $attributes['koordinate']['lng'];
        $attributes['koordinate'] = $koordinate;
        $attributes['tipovi_mleka'] = implode(',', $attributes['tipovi_mleka']);
        $attributes['user_id'] = $request->user()->id;
        Domacinstvo::create($attributes);
        return redirect(route('home'));
    }

    public function show(Request $request, Domacinstvo $domacinstvo)
    {
        //
    }

    public function update(DomacinstvoUpdateRequest $request, Domacinstvo $domacinstvo)
    {
        //
    }

    public function destroy(Request $request, Domacinstvo $domacinstvo)
    {
        //
    }
}
