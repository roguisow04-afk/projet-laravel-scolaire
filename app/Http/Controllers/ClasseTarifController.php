<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Tarif;
use App\Models\ClasseTarif;
use App\Models\Niveau;
use Illuminate\Http\Request;

class ClasseTarifController extends Controller
{
    /**
     * Afficher les classes avec leurs tarifs
     */
    public function index()
    {
        $classes = Classe::with('tarifs')->get();

        return view('classe_tarif.index', compact('classes'));
    }

    /**
     * Formulaire d’attribution
     */
    public function create()
    {
        $classes = Classe::all();
        $tarifs  = Tarif::all();
        $niveaux = Niveau::all();

        return view('classe_tarif.create', compact('classes', 'tarifs', 'niveaux'));
    }

    /**
     * Affecter un tarif à une classe
     */
    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'tarif_id'  => 'required|exists:tarifs,id',
        ]);

        $classe = Classe::findOrFail($request->classe_id);

        // désactiver ancien tarif actif
        ClasseTarif::where('classe_id', $classe->id)
            ->where('actif', true)
            ->update(['actif' => false]);

        // nouveau tarif actif
        ClasseTarif::create([
            'classe_id' => $request->classe_id,
            'tarif_id'  => $request->tarif_id,
            'actif'     => true,
        ]);

        return redirect()->route('classe_tarif.index')
            ->with('success', 'Tarif attribué avec succès');
    }

    /**
     * Supprimer liaison classe-tarif
     */
    public function destroy($classe_id, $tarif_id)
    {
        ClasseTarif::where('classe_id', $classe_id)
            ->where('tarif_id', $tarif_id)
            ->delete();

        return redirect()->route('classe_tarif.index')
            ->with('success', 'Tarif retiré avec succès');
    }

    // ======================================================
    // AJOUT DEMANDÉ : TARIF SIMPLE + AFFICHAGE
    // ======================================================

    /**
     * Enregistrer un tarif
     */
    public function storeTarif(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'montant' => 'required|numeric'
        ]);

        $tarif = Tarif::create([
            'nom' => $request->nom,
            'montant' => $request->montant
        ]);

        if ($request->classe_id) {
            $tarif->classes()->attach($request->classe_id);
        }

        return redirect()->route('tarifs.show', $tarif->id);
    }

    /**
     * Afficher un tarif
     */
    public function show(Tarif $tarif)
    {
        return view('tarifs.show', compact('tarif'));
    }
}