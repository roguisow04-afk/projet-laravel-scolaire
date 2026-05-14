<?php

namespace App\Services;

use App\Models\AnneeAcademique;
use Exception;
use Carbon\Carbon;

class AnneeAcademiqueService
{
    /**
     * Création d'une année académique
     */
    public function creerAnnee(array $data)
    {
        // =====================================================
        // Vérification doublon
        // =====================================================
        if (AnneeAcademique::where('anne_ac', $data['anne_ac'])->exists()) {
            throw new Exception("Ce code d'année académique existe déjà.");
        }

        // =====================================================
        // Date début < date fin
        // =====================================================
        if ($data['date_debut'] >= $data['date_fin']) {
            throw new Exception(
                "La date de début doit être antérieure à la date de fin."
            );
        }

        // =====================================================
        // Vérification durée <= 9 mois
        // =====================================================
        $duree = $this->calculerDureeMoisNormalisee(
            $data['date_debut'],
            $data['date_fin']
        );

        if ($duree > 9) {
            throw new Exception(
                "L'année académique ne peut pas dépasser 9 mois."
            );
        }

        // =====================================================
        // Statut par défaut
        // =====================================================
        $data['statut'] = 'brouillon';

        // =====================================================
        // Création
        // =====================================================
        return AnneeAcademique::create($data);
    }

    /**
     * Modification d'une année académique
     */
    public function mettreAJourAnnee(AnneeAcademique $annee, array $data)
    {
        // =====================================================
        // Modification uniquement si brouillon
        // =====================================================
        if (!$annee->estModifiable()) {
            throw new Exception(
                "Seules les années en mode 'Brouillon' peuvent être modifiées."
            );
        }

        return $annee->update($data);
    }

    /**
     * Changement de statut sécurisé
     */
    public function changerStatut(
        AnneeAcademique $annee,
        string $nouveauStatut
    ) {

        match ($nouveauStatut) {

            // =================================================
            // Brouillon -> publié
            // =================================================
            'publie' =>
                $annee->statut === 'brouillon'
                    ?: throw new Exception(
                        "Impossible de publier."
                    ),

            // =================================================
            // Publication obligatoire avant inscription
            // =================================================
            'ouverture_inscription' =>
                $annee->statut === 'publie'
                    ?: throw new Exception(
                        "L'année doit être publiée avant d'ouvrir les inscriptions."
                    ),

            // =================================================
            // Clôture
            // =================================================
            'cloturer' =>
                $annee->cloturer(),

            // =================================================
            // Statut inconnu
            // =================================================
            default =>
                throw new Exception("Statut inconnu."),
        };

        // =====================================================
        // Mise à jour statut
        // =====================================================
        $annee->update([
            'statut' => $nouveauStatut
        ]);
    }

    /**
     * Calcul normalisé de la durée en mois
     */
    public function calculerDureeMoisNormalisee($debut, $fin)
    {
        $start = Carbon::parse($debut)->startOfMonth();

        $end = Carbon::parse($fin)->startOfMonth();

        // Exemple :
        // Octobre -> Juin = 9 mois
        return $start->diffInMonths($end) + 1;
    }
}