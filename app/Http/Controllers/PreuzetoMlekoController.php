<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PreuzetoMleko;

class PreuzetoMlekoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tip !== 'rukovodilac') return abort(403);

        return Inertia::render('preuzeto-mleko/Index', [
            'preuzeto_mleko' => PreuzetoMleko::all(),
        ]);
    }

    public function show(Request $request, PreuzetoMleko $preuzetoMleko)
    {
        if ($request->user()->tip !== 'rukovodilac') return abort(403);

        return Inertia::render('preuzeto-mleko/Show', [
            'preuzeto_mleko' => $preuzetoMleko,
        ]);
    }
}
