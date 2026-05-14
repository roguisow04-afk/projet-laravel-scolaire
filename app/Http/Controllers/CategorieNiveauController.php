<?php

namespace App\Http\Controllers;

use App\Models\CategorieNiveau;
use App\Models\Niveau; 
use Illuminate\Http\Request;
use Exception;

class CategorieNiveauController extends Controller
{
    public function index()
    {
        // On récupère les catégories avec leurs niveaux pour l'affichage
        $categorie_niveaux = CategorieNiveau::with('niveau')->get();
        return view('categorie_niveaux.index', compact('categorie_niveaux'));
    }

    public function create()
    {
        // On récupère les niveaux pour le menu déroulant
        $niveaux = Niveau::all(); 
        return view('categorie_niveaux.create', compact('niveaux'));
    }

    public function store(Request $request)
    {
        // Validation : on utilise 'categorie_niveau' comme dans le formulaire
        $request->validate([
            'categorie_niveau' => 'required|string|unique:categorie_niveaux,categorie_niveau',
            'niveau_id'        => 'required|exists:niveaux,id',
        ], [
            'categorie_niveau.required' => 'Le nom de la catégorie est obligatoire.',
            'categorie_niveau.unique'   => 'Cette catégorie existe déjà.',
            'niveau_id.required'        => 'Veuillez choisir un niveau.',
        ]);

        try {
            CategorieNiveau::create([
                'categorie_niveau' => $request->categorie_niveau, // Correction : pas de nom_categorie ici
                'niveau_id'        => $request->niveau_id,
            ]);
            
            return redirect()->route('categorie_niveaux.index')
                             ->with('success', 'Catégorie créée avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    // 1. Affiche le formulaire de modification
public function edit($id)
{
    $categorie_niveau = CategorieNiveau::findOrFail($id);
    $niveaux = Niveau::all(); // Pour pouvoir changer le niveau parent
    return view('categorie_niveaux.edit', compact('categorie_niveau', 'niveaux'));
}

// 2. Enregistre les modifications en base de données
public function update(Request $request, $id)
{
    $request->validate([
        'categorie_niveau' => 'required|string|unique:categorie_niveaux,categorie_niveau,'.$id,
        'niveau_id'        => 'required|exists:niveaux,id',
    ]);

    try {
        $cat = CategorieNiveau::findOrFail($id);
        $cat->update([
            'categorie_niveau' => $request->categorie_niveau,
            'niveau_id'        => $request->niveau_id,
        ]);

        return redirect()->route('categorie_niveaux.index')
                         ->with('success', 'Catégorie mise à jour !');
    } catch (Exception $e) {
        return redirect()->back()->withInput()->with('error', $e->getMessage());
    }
}

// 3. Supprime une catégorie
public function destroy($id)
{
    $cat = CategorieNiveau::findOrFail($id);
    $cat->delete();

    return redirect()->route('categorie_niveaux.index')
                     ->with('success', 'Catégorie supprimée !');
}
}