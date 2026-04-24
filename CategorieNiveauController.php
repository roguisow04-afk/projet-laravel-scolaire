<?php

namespace App\Http\Controllers;

use App\Models\CategorieNiveau;
use App\Models\Niveau;
use Illuminate\Http\Request;

class CategorieNiveauController extends Controller
{
    // Liste des catégories
    public function index()
    {
        // ✅ 'niveauRelation' corrigé → 'niveau'
        $categorie_niveaux = CategorieNiveau::with('niveau')->get();
        return view('categorie_niveaux.index', compact('categorie_niveaux'));
    }

    // Formulaire création
    public function create()
    {
        $niveaux = Niveau::all();
        return view('categorie_niveaux.create', compact('niveaux'));
    }

    // Stocker nouvelle catégorie
    public function store(Request $request)
    {
        $request->validate([
            'categorie_niveau' => 'required|string|max:255',
            'niveau_id'        => 'required|exists:niveaux,id', // ✅ required car nécessaire
        ]);

        // ✅ only() au lieu de all() pour éviter le mass assignment
        CategorieNiveau::create($request->only([
            'categorie_niveau',
            'niveau_id',
        ]));

        return redirect()->route('categorie_niveaux.index')
                         ->with('success', 'Catégorie ajoutée avec succès !');
    }

    // Formulaire édition
    public function edit(CategorieNiveau $categorie_niveau)
    {
        $niveaux = Niveau::all();
        return view('categorie_niveaux.edit', compact('categorie_niveau', 'niveaux'));
    }

    // Mise à jour
    public function update(Request $request, CategorieNiveau $categorie_niveau)
    {
        $request->validate([
            'categorie_niveau' => 'required|string|max:255',
            'niveau_id'        => 'required|exists:niveaux,id', // ✅ required
        ]);

        // ✅ only() au lieu de all()
        $categorie_niveau->update($request->only([
            'categorie_niveau',
            'niveau_id',
        ]));

        return redirect()->route('categorie_niveaux.index')
                         ->with('success', 'Catégorie mise à jour avec succès !');
    }

    // Suppression
    public function destroy(CategorieNiveau $categorie_niveau)
    {
        $categorie_niveau->delete();
        return redirect()->route('categorie_niveaux.index')
                         ->with('success', 'Catégorie supprimée avec succès !');
    }
}