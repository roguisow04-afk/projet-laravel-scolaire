<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Tarif;
use App\Models\ClasseTarif;
use App\Models\Niveau; // Ajouté pour récupérer les niveaux
use Illuminate\Http\Request;

class ClasseTarifController extends Controller
{
    /**
     * Afficher les tarifs par classe
     */
    public function index()
    {
        // On charge les tarifs liés à chaque classe
        $classes = Classe::with(['tarifs'])->get();

        return view('classe_tarif.index', compact('classes'));
    }

    /**
     * Formulaire pour rattacher un tarif à une classe
     */
    public function create()
    {
        $classes = Classe::all();
        $tarifs  = Tarif::all();
        $niveaux = Niveau::all(); // Ajouté pour la vue

        return view('classe_tarif.create', compact('classes', 'tarifs', 'niveaux'));
    }

    /**
     * Enregistrer un nouveau tarif pour une classe
     */
    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'tarif_id'  => 'required|exists:tarifs,id',
        ]);

        $classe = Classe::findOrFail($request->classe_id);

        // Vérifier si la classe a déjà des inscrits (à implémenter selon ton module Inscription)
        // if ($classe->inscriptions()->count() > 0) {
        //     return redirect()->back()->with('error', 'Impossible de modifier, des élèves sont déjà inscrits.');
        // }

        // Désactiver l'ancien tarif actif
        ClasseTarif::where('classe_id', $classe->id)
                    ->where('actif', true)
                    ->update(['actif' => false]);

        // Créer le nouveau tarif actif
        ClasseTarif::create([
            'classe_id' => $request->classe_id,
            'tarif_id'  => $request->tarif_id,
            'actif'     => true,
        ]);

        return redirect()->route('classe_tarif.index')
                         ->with('success', 'Tarif attribué à la classe avec succès !');
    }

    /**
     * Supprimer un tarif d’une classe
     */
    public function destroy($classe_id, $tarif_id)
    {
        // On récupère la liaison Classe-Tarif
        $classeTarif = ClasseTarif::where('classe_id', $classe_id)
                                  ->where('tarif_id', $tarif_id)
                                  ->firstOrFail();

        // Vérifier si la classe a des inscrits avant suppression
        // if ($classeTarif->classe->inscriptions()->count() > 0) {
        //     return redirect()->back()->with('error', 'Impossible de supprimer ce tarif : des élèves sont déjà inscrits.');
        // }

        $classeTarif->delete();

        return redirect()->route('classe_tarif.index')
                         ->with('success', 'Tarif retiré de la classe avec succès !');
    }
}