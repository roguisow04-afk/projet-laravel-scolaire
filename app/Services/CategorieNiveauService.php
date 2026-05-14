<?php

namespace App\Services;

use App\Models\CategorieNiveau;
use Exception;

class CategorieNiveauService
{
    /**
     * Enregistrer une nouvelle catégorie
     */
    public function creerCategorie(array $data)
    {
        // Règle : Vérifier si le nom existe déjà pour ce niveau spécifique
        $existe = CategorieNiveau::where('categorie_niveau', $data['categorie_niveau'])
            ->where('niveau_id', $data['niveau_id'])
            ->exists();

        if ($existe) {
            throw new Exception("Cette catégorie existe déjà pour ce niveau.");
        }

        return CategorieNiveau::create($data);
    }

    /**
     * Mettre à jour une catégorie
     */
    public function mettreAJourCategorie(CategorieNiveau $categorie, array $data)
    {
        return $categorie->update($data);
    }

    /**
     * Suppression sécurisée
     */
    public function supprimerCategorie(CategorieNiveau $categorie)
    {
        // RÈGLE MÉTIER : On ne supprime pas si des classes y sont rattachées
        if ($categorie->classes()->count() > 0) {
            throw new Exception("Suppression impossible : Des classes sont rattachées à cette catégorie.");
        }

        return $categorie->delete();
    }
}