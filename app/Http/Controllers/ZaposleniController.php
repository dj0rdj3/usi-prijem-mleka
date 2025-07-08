<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ZaposleniController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tip !== 'rukovodilac') abort(403);

        return Inertia::render('rukovodilac/Zaposleni', [
            'zaposleni' => User::doesntHave('domacinstvo')->where('tip', '!=', 'rukovodilac')->get()
        ]);
    }

    public function update(Request $request, User $zaposleni)
    {
        if ($request->user()->tip !== 'rukovodilac') abort(403);

        $attributes = $request->validate([
            'tip' => ['required', 'string', 'in:domacin,vozac,tehnolog']
        ]);

        $zaposleni->update($attributes);
        return redirect(route('zaposleni.index'));
    }

    public function destroy(Request $request, User $zaposleni)
    {
        if ($request->user()->tip !== 'rukovodilac') abort(403);

        $zaposleni->delete();
        return redirect(route('zaposleni.index'));
    }
}
