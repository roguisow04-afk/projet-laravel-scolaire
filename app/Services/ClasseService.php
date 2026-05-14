<?php

namespace App\Services;

use App\Models\Classe;
use Illuminate\Support\Facades\DB;
use Exception;

class ClasseService
{
    /**
     * Créer une classe selon les règles de l'énoncé
     */
    public function creerClasse(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Vérification des doublons (Même nom dans la même filière et niveau)
            $existe = Classe::where('nom_classe', $data['nom_classe'])
                ->where('filiere_id', $data['filiere_id'])
                ->where('niveau_id', $data['niveau_id'])
                ->exists();

            if ($existe) {
                throw new Exception("Cette classe existe déjà pour ce niveau et cette filière.");
            }

            // 2. Création avec les nouveaux noms de colonnes de votre base
            return Classe::create([
                'code_classe'         => $data['code_classe'],
                'nom_classe'          => $data['nom_classe'],
                'filiere_id'          => $data['filiere_id'],
                'niveau_id'           => $data['niveau_id'],
                'categorie_niveau_id' => $data['categorie_niveau_id'],
                'tarif_id'            => $data['tarif_id'] ?? null,
            ]);
        });
    }

    /**
     * Rattacher un nouveau tarif (Règle de l'énoncé)
     * "Si la classe avait un tarif, ce tarif est désactivé et le nouveau est activé"
     */
    public function mettreAJourClasse(Classe $classe, array $data)
    {
        return DB::transaction(function () use ($classe, $data) {
            // RÈGLE : Un tarif déjà rattaché à une classe avec des inscrits ne peut plus être modifié
            // On vérifie si le tarif change
            if (isset($data['tarif_id']) && $classe->tarif_id != $data['tarif_id']) {
                if ($this->aDesInscrits($classe)) {
                    throw new Exception("Impossible de changer le tarif : des élèves sont déjà inscrits.");
                }
            }

            return $classe->update($data);
        });
    }

    /**
     * Suppression sécurisée
     */
    public function supprimerClasse(Classe $classe)
    {
        if ($this->aDesInscrits($classe)) {
            throw new Exception("Suppression impossible : des élèves sont déjà inscrits.");
        }

        return $classe->delete();
    }

    /**
     * Vérifie si la classe possède des inscriptions
     */
    private function aDesInscrits(Classe $classe)
    {
        // Simulation de la relation inscriptions (à adapter selon votre modèle Inscription)
        return method_exists($classe, 'inscriptions') && $classe->inscriptions()->count() > 0;
    }
}