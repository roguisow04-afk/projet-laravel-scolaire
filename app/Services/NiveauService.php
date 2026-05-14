<?php

namespace App\Services;

use App\Models\Niveau;
use Exception;

class NiveauService
{
    /**
     * Créer un niveau avec vérification de doublon
     */
    public function creerNiveau(array $data)
    {
        $existe = Niveau::where('nom_nivaux', $data['nom_nivaux'])->exists();

        if ($existe) {
            throw new Exception("Ce niveau (ex: Lycée, Université) existe déjà.");
        }

        return Niveau::create($data);
    }

    /**
     * Mise à jour du niveau
     */
    public function modifierNiveau(Niveau $niveau, array $data)
    {
        return $niveau->update($data);
    }

    /**
     * Suppression sécurisée (La règle la plus importante)
     */
    public function supprimerNiveau(Niveau $niveau)
    {
        // RÈGLE 1 : Vérifier s'il y a des catégories rattachées (L1, L2, etc.)
        if ($niveau->categorieNiveaux()->count() > 0) {
            throw new Exception("Impossible de supprimer : ce niveau possède des catégories de niveaux rattachées.");
        }

        // RÈGLE 2 : Vérifier s'il y a des classes rattachées
        if ($niveau->classes()->count() > 0) {
            throw new Exception("Impossible de supprimer : des classes sont liées à ce niveau.");
        }

        return $niveau->delete();
    }
}