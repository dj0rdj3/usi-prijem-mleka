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
        $domacinstvo = Domacinstvo::firstWhere('user_id', $request->user()->id);

        if ($domacinstvo) {
            return redirect(route('domacinstvo.show', $domacinstvo));
        }

        return Inertia::render('domacinstvo/Create');
    }

    public function store(DomacinstvoStoreRequest $request)
    {
        $attributes = $request->validated();
        $koordinate = $attributes['koordinate']['lat'] . "," . $attributes['koordinate']['lng'];
        $attributes['koordinate'] = $koordinate;
        $attributes['tipovi_mleka'] = implode(',', $attributes['tipovi_mleka']);
        $attributes['user_id'] = $request->user()->id;

        $domacinstvo = Domacinstvo::create($attributes);
        return redirect(route('domacinstvo.show', $domacinstvo));
    }

    public function show(Request $request, Domacinstvo $domacinstvo)
    {
        if ($domacinstvo->user_id !== $request->user()->id) {
            return abort(403);
        }

        $domacinstvo->load(['radniNalozi' => function ($query) {
            $query->where('primljeno', '!=', NULL);
        }]);
        
        return Inertia::render('domacinstvo/Show', [
            'domacinstvo' => $domacinstvo
        ]);
    }

    public function edit(Request $request, Domacinstvo $domacinstvo)
    {
        if ($domacinstvo->user_id !== $request->user()->id) {
            return abort(403);
        }

        return Inertia::render('domacinstvo/Edit', [
            'domacinstvo' => $domacinstvo
        ]);
    }

    public function update(DomacinstvoUpdateRequest $request, Domacinstvo $domacinstvo)
    {
        if ($domacinstvo->user_id !== $request->user()->id) {
            return abort(403);
        }

        $attributes = $request->validated();
        $koordinate = $attributes['koordinate']['lat'] . "," . $attributes['koordinate']['lng'];
        $attributes['koordinate'] = $koordinate;
        $attributes['tipovi_mleka'] = implode(',', $attributes['tipovi_mleka']);

        $domacinstvo->update($attributes);
        return redirect(route('domacinstvo.show', $domacinstvo));
    }

    public function destroy(Request $request, Domacinstvo $domacinstvo)
    {
        if ($domacinstvo->user_id !== $request->user()->id) {
            return abort(403);
        }

        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $domacinstvo->delete();

        return redirect(route('home'));
    }
}
