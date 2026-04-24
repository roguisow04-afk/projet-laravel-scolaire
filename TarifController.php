<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use App\Models\Classe;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    // Affiche la liste des tarifs avec leurs classes
    public function index()
    {
        $tarifs = Tarif::with('classes')->get();
        $classes = Classe::all();

        return view('tarifs', compact('tarifs', 'classes'));
    }

    // Crée un nouveau tarif et rattache à une classe
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'classe_id' => 'nullable|exists:classes,id',
        ]);

        // --- Création du tarif ---
        $tarif = Tarif::create([
            'nom' => $request->nom,
            'montant' => $request->montant,
        ]);

        if ($request->classe_id) {
            $classe = Classe::findOrFail($request->classe_id);

            // Vérifie si la classe a déjà des inscrits
            if ($classe->inscrits()->count() > 0) {
                return redirect()->back()->with('error', 'Impossible de rattacher ce tarif : la classe a déjà des inscrits.');
            }

            // Désactive l’ancien tarif actif
            $classe->tarifs()->updateExistingPivot(
                $classe->tarifs()->wherePivot('actif', true)->pluck('tarif_id')->toArray(),
                ['actif' => false]
            );

            // Rattache le nouveau tarif
            $classe->tarifs()->attach($tarif->id, ['actif' => true]);
        }

        return redirect()->back()->with('success', 'Tarif créé avec succès.');
    }

    // Supprime un tarif
    public function destroy($id)
    {
        $tarif = Tarif::findOrFail($id);

        // Vérifie si le tarif est rattaché à une classe avec des inscrits
        foreach ($tarif->classes as $classe) {
            if ($classe->inscrits()->count() > 0) {
                return redirect()->back()->with('error', 'Impossible de supprimer ce tarif car des élèves sont déjà inscrits.');
            }
        }

        // Détache le tarif de toutes les classes avant suppression
        $tarif->classes()->detach();

        $tarif->delete();

        return redirect()->back()->with('success', 'Tarif supprimé avec succès.');
    }
}