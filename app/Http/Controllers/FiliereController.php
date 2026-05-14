<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Services\ScolariteService;
use Illuminate\Http\Request;
use Exception; // AJOUT : Pour capturer les erreurs proprement

class FiliereController extends Controller
{
    protected $scolariteService;

    public function __construct(ScolariteService $scolariteService)
    {
        $this->scolariteService = $scolariteService;
    }

    public function index()
    {
        $filieres = Filiere::all();
        return view('filieres.index', compact('filieres'));
    }

    public function create()
    {
        return view('filieres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10',
            'nom_filiere' => 'required|string|max:255',
        ]);

        try {
            // APPEL SERVICE : On délègue la création
            $this->scolariteService->creerFiliere($request->all());
            return redirect()->route('filieres.index')->with('success', 'Filière créée avec succès.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Filiere $filiere)
    {
        return view('filieres.show', compact('filiere'));
    }

    public function edit(Filiere $filiere)
    {
        return view('filieres.edit', compact('filiere'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $request->validate([
            'code' => 'required|string|max:10',
            'nom_filiere' => 'required|string|max:255',
        ]);

        try {
            // APPEL SERVICE : On délègue la mise à jour
            $this->scolariteService->modifierFiliere($filiere, $request->all());
            return redirect()->route('filieres.index')->with('success', 'Filière mise à jour.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Filiere $filiere)
    {
        try {
            $this->scolariteService->supprimerFiliere($filiere);
            return redirect()->route('filieres.index')->with('success', 'Filière supprimée avec succès.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}