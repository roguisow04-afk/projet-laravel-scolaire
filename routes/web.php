<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AnneeAcademiqueController;
use App\Http\Controllers\CategorieNiveauController;
use App\Http\Controllers\ClasseTarifController;

Route::get('/', function () {
    return redirect()->route('filieres.index'); // redirection vers la page d'accueil (filieres)
});

Route::resource('filieres', FiliereController::class);
Route::resource('niveaux', NiveauController::class);
Route::resource('classes', ClasseController::class);
Route::resource('tarifs', TarifController::class);
Route::resource('annees_academiques', AnneeAcademiqueController::class);
Route::resource('categorie_niveaux', CategorieNiveauController::class);
Route::resource('classe_tarif', ClasseTarifController::class);
Route::patch('/annees-academiques/{anneeAcademique}/statut/{action}',
 [AnneeAcademiqueController::class, 'changerStatut'])->name('annees_academiques.changerStatut');


/**
 * Route spécifique pour le changement de statut de l'année académique.
 * On utilise PATCH car on ne modifie qu'une partie de la ressource (le statut).
 */
Route::patch('/annees-academiques/{anneeAcademique}/statut/{action}', [
    AnneeAcademiqueController::class, 
    'changerStatut'
])->name('annees_academiques.changerStatut');
