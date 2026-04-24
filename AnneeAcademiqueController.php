<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use Illuminate\Http\Request;

class AnneeAcademiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annees = AnneeAcademique::all(); // ✅ camelCase correct
        return view('annees_academiques.index', compact('annees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('annees_academiques.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['anne_ac' => 'required']);

        AnneeAcademique::create($request->all()); // ✅ camelCase correct

        return redirect()->route('annees_academiques.index')->with('success', 'Année académique créée avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnneeAcademique $anneeAcademique) // ✅ paramètre corrigé
    {
        return view('annees_academiques.edit', compact('anneeAcademique'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnneeAcademique $anneeAcademique) // ✅ paramètre corrigé
    {
        $request->validate(['anne_ac' => 'required']);

        $anneeAcademique->update($request->all());

        return redirect()->route('annees_academiques.index')->with('success', 'Année académique modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnneeAcademique $anneeAcademique) // ✅ paramètre corrigé
    {
        $anneeAcademique->delete();

        return redirect()->route('annees_academiques.index')->with('success', 'Année académique supprimée !');
    }
}