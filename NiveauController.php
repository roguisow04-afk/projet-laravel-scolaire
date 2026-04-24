<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    public function index()
    {
        $niveaux = Niveau::all();
        return view('niveaux.index', compact('niveaux'));
    }

    public function create()
    {
        return view('niveaux.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_nivaux' => 'required',
        ]);

        Niveau::create($request->all());
        return redirect()->route('niveaux.index');
    }

    public function show(Niveau $niveau)
    {
        return view('niveaux.show', compact('niveau'));
    }

    public function edit(Niveau $niveau)
    {
        return view('niveaux.edit', compact('niveau'));
    }

    public function update(Request $request, Niveau $niveau)
    {
        $request->validate([
            'nom_nivaux' => 'required',
        ]);

        $niveau->update($request->all());
        return redirect()->route('niveaux.index');
    }

    public function destroy(Niveau $niveau)
    {
        $niveau->delete();
        return redirect()->route('niveaux.index');
    }
}
