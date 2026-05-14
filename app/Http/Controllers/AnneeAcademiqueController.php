<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Services\AnneeAcademiqueService;
use Illuminate\Http\Request;

class AnneeAcademiqueController extends Controller
{
    protected $anneeService;

    public function __construct(AnneeAcademiqueService $anneeService)
    {
        $this->anneeService = $anneeService;
    }

    // =========================
    // LISTE
    // =========================
    public function index()
    {
        $annees = AnneeAcademique::all();
        return view('annees_academiques.index', compact('annees'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('annees_academiques.create');
    }

    // =========================
    // STORE (CORRIGÉ)
    // =========================
    public function store(Request $request)
{
    //dd($request->all());
    try {

        $request->validate([
            'anne_ac'    => 'required',
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after:date_debut',
        ]);

        $this->anneeService->creerAnnee($request->all());

        return redirect()
            ->route('annees_academiques.index')
            ->with('success', 'Année académique créée avec succès !');

    } catch (\Exception $e) {
    return redirect()
        ->back()
        ->with('error', $e->getMessage());
}
}
    // =========================
    // DELETE
    // =========================
    public function destroy(AnneeAcademique $anneeAcademique)
    {
        $anneeAcademique->delete();

        return redirect()
            ->route('annees_academiques.index')
            ->with('success', 'Année académique supprimée !');
    }

    // =========================
    // STATUT
    // =========================
    public function changerStatut(AnneeAcademique $anneeAcademique, $action)
    {
        try {

            $this->anneeService->changerStatut($anneeAcademique, $action);

            return redirect()
                ->back()
                ->with('success', "L'opération '$action' a été effectuée.");

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}