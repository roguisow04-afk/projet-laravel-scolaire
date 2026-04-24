<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\CategorieNiveau;
use App\Models\Tarif;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    // Liste des classes
    public function index()
    {
        $classes = Classe::with(['niveau', 'filiere', 'categorieNiveau'])->get();
        return view('classes.index', compact('classes'));
    }

    // Formulaire de création
    public function create()
    {
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        $categorieNiveaux = CategorieNiveau::all();
        $tarifs = Tarif::all(); // si tu veux choisir un tarif à la création

        return view('classes.create', compact('niveaux', 'filieres', 'categorieNiveaux', 'tarifs'));
    }

    // Enregistrer une nouvelle classe
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau_id' => 'required|exists:niveaux,id',
            'filiere_id' => 'required|exists:filieres,id',
            'categorie_niveau_id' => 'required|exists:categorie_niveaux,id',
            'tarif_id' => 'nullable|exists:tarifs,id', // si optionnel
        ]);

        Classe::create([
            'nom' => $request->nom,
            'niveau_id' => $request->niveau_id,
            'filiere_id' => $request->filiere_id,
            'categorie_niveau_id' => $request->categorie_niveau_id,
            'tarif_id' => $request->tarif_id ?? null,
        ]);

        return redirect()->route('classes.index')->with('success', 'Classe créée avec succès.');
    }

    // Formulaire d'édition
    public function edit(Classe $classe)
    {
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        $categorieNiveaux = CategorieNiveau::all();
        $tarifs = Tarif::all(); // si applicable

        return view('classes.edit', compact('classe', 'niveaux', 'filieres', 'categorieNiveaux', 'tarifs'));
    }

    // Mettre à jour une classe
    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau_id' => 'required|exists:niveaux,id',
            'filiere_id' => 'required|exists:filieres,id',
            'categorie_niveau_id' => 'required|exists:categorie_niveaux,id',
            'tarif_id' => 'nullable|exists:tarifs,id',
        ]);

        $classe->update([
            'nom' => $request->nom,
            'niveau_id' => $request->niveau_id,
            'filiere_id' => $request->filiere_id,
            'categorie_niveau_id' => $request->categorie_niveau_id,
            'tarif_id' => $request->tarif_id ?? null,
        ]);

        return redirect()->route('classes.index')->with('success', 'Classe mise à jour.');
    }

    // Supprimer une classe
    public function destroy(Classe $classe)
    {
        $classe->delete();
        return redirect()->route('classes.index')->with('success', 'Classe supprimée.');
    }
}