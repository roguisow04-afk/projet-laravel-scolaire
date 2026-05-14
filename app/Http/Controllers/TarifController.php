<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // AJOUT : Nécessaire pour sécuriser les opérations SQL

class TarifController extends Controller
{
    // Affiche la liste des tarifs avec leurs classes
    public function index()
    {
        $tarifs = Tarif::with('classes')->get();
        $classes = Classe::all();

        return view('tarifs.index', compact('tarifs', 'classes'));
    }

     public function create()
   {
    $classes = Classe::all();
    return view('tarifs.create', compact('classes'));
    }
    // Crée un nouveau tarif et rattache à une classe
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'classe_id' => 'nullable|exists:classes,id',
        ]);

        

        // AJOUT : On utilise une transaction pour être sûr que tout se passe bien ou rien du tout
        return DB::transaction(function () use ($request) {
            
            // --- Création du tarif ---
            $tarif = Tarif::create([
                'nom' => $request->nom,
                'montant' => $request->montant,
            ]);

            if ($request->classe_id) {
                $classe = Classe::findOrFail($request->classe_id);

                // Vérifie si la classe a déjà des inscrits
                if ($classe->inscrits()->count() > 0) {
                    // AJOUT : Lever une exception dans une transaction annule la création du tarif
                    throw new \Exception('Impossible de rattacher ce tarif : la classe a déjà des inscrits.');
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
            
        // AJOUT : Capture de l'erreur si la transaction échoue
        }, function ($e) {
            return redirect()->back()->with('error', $e->getMessage());
        });
    }
     
      
    public function show($id)
    {
        $tarif = \App\Models\Tarif::findOrFail($id);
        return view('tarifs.show', compact('tarif'));
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

        // AJOUT : Utilisation d'une transaction ici aussi pour la suppression
        DB::transaction(function () use ($tarif) {
            // Détache le tarif de toutes les classes avant suppression
            $tarif->classes()->detach();
            $tarif->delete();
        });

        return redirect()->back()->with('success', 'Tarif supprimé avec succès.');
    }
}