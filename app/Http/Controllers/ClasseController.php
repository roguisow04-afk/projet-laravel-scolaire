<?php
namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\CategorieNiveau;
use App\Models\Tarif;
use App\Models\AnneeAcademique;
use App\Services\ClasseService;
use Illuminate\Http\Request;
use Exception;

class ClasseController extends Controller
{
    protected $classeService;

    public function __construct(ClasseService $classeService)
    {
        $this->classeService = $classeService;
    }

    public function index()
    {
        $classes = Classe::with(['niveau', 'filiere', 'categorieNiveau', 'anneeAcademique'])->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        // Je garde 'categories' pour que ton @foreach à la ligne 49 de create.blade.php fonctionne
        $categories = CategorieNiveau::all(); 
        $tarifs = Tarif::all();
        $annees = AnneeAcademique::all();

        return view('classes.create', compact('niveaux', 'filieres', 'categories', 'tarifs', 'annees'));
    }

    public function store(Request $request)
    {
        // Validation (Indispensable pour ne pas faire planter la base de données)
        $request->validate([
            'code_classe' => 'required|string|unique:classes,code_classe',
            'nom_classe' => 'required|string',
            'filiere_id' => 'required|exists:filieres,id',
            'niveau_id' => 'required|exists:niveaux,id',
            'categorie_niveau_id' => 'required|exists:categorie_niveaux,id',
        ]);

        try {
            // ON UTILISE LE SERVICE (C'est là qu'on a mis la logique et les tests hier)
            $this->classeService->creerClasse($request->all());
            
            return redirect()->route('classes.index')->with('success', 'Classe enregistrée avec succès.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Classe $classe)
    {
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        $categories = CategorieNiveau::all();
        $tarifs = Tarif::all();
        $annees = AnneeAcademique::all();

        return view('classes.edit', compact('classe', 'niveaux', 'filieres', 'categories', 'tarifs', 'annees'));
    }

    public function update(Request $request, Classe $classe)
    {
        // Validation pour l'update
        $request->validate([
            'nom_classe' => 'required|string|max:255',
            'code_classe' => 'required|string|max:255|unique:classes,code_classe,'.$classe->id,
            'niveau_id' => 'required|exists:niveaux,id',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        try {
            $this->classeService->mettreAJourClasse($classe, $request->all());
            return redirect()->route('classes.index')->with('success', 'Classe mise à jour.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Classe $classe)
    {
        try {
            // On appelle la suppression sécurisée du Service
            $this->classeService->supprimerClasse($classe);
            
            return redirect()->route('classes.index')
                ->with('success', 'La classe a été supprimée.');

        } catch (Exception $e) {
            return redirect()->route('classes.index')
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}