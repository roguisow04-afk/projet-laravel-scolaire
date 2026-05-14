<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use App\Services\NiveauService; // Import du service
use Illuminate\Http\Request;
use Exception;

class NiveauController extends Controller
{
    protected $niveauService;

    public function __construct(NiveauService $niveauService)
    {
        $this->niveauService = $niveauService;
    }

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
            'nom_nivaux' => 'required|string|max:255',
        ]);

        try {
            $this->niveauService->creerNiveau($request->only('nom_nivaux'));
            return redirect()->route('niveaux.index')->with('success', 'Niveau créé avec succès.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Niveau $niveau)
    {
        return view('niveaux.edit', compact('niveau'));
    }

    public function update(Request $request, Niveau $niveau)
    {
        $request->validate([
            'nom_nivaux' => 'required|string|max:255',
        ]);

        try {
            $this->niveauService->modifierNiveau($niveau, $request->only('nom_nivaux'));
            return redirect()->route('niveaux.index')->with('success', 'Niveau mis à jour.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Niveau $niveau)
    {
        try {
            $this->niveauService->supprimerNiveau($niveau);
            return redirect()->route('niveaux.index')->with('success', 'Niveau supprimé avec succès.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}