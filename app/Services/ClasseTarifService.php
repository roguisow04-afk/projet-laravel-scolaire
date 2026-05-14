<?php

namespace App\Services;

use App\Models\Tarif;
use App\Models\Classe;
use App\Models\ClasseTarif;
use Illuminate\Support\Facades\DB;
use Exception;

class TarifService
{
    /**
     * Enregistre un nouveau tarif et l'associe éventuellement à une classe.
     */
    public function enregistrerTarif(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Création du tarif technique
            $tarif = Tarif::create([
                'nom' => $data['nom'],
                'montant' => $data['montant']
            ]);

            // 2. Si une classe est sélectionnée à la création, on fait l'attribution
            if (!empty($data['classe_id'])) {
                $this->attribuerTarifAClasse($data['classe_id'], $tarif->id);
            }

            return $tarif;
        });
    }

    /**
     * Logique d'attribution d'un tarif à une classe (Gère le switch d'activation)
     */
    public function attribuerTarifAClasse($classeId, $tarifId)
    {
        return DB::transaction(function () use ($classeId, $tarifId) {
            $classe = Classe::findOrFail($classeId);

            // RÈGLE MÉTIER : Vérifier s'il y a déjà des inscrits (Sécurité)
            // Si ta relation 'inscrits' existe dans le modèle Classe
            if (method_exists($classe, 'inscrits') && $classe->inscrits()->count() > 0) {
                throw new Exception("Impossible de changer le tarif : cette classe possède déjà des inscriptions.");
            }

            // 1. Désactiver tous les anciens tarifs actifs pour cette classe
            ClasseTarif::where('classe_id', $classeId)
                ->where('actif', true)
                ->update(['actif' => false]);

            // 2. Créer ou mettre à jour la liaison comme étant le tarif actif
            // On utilise updateOrCreate pour éviter les doublons dans la table pivot
            return ClasseTarif::updateOrCreate(
                ['classe_id' => $classeId, 'tarif_id' => $tarifId],
                ['actif' => true]
            );
        });
    }

    /**
     * Suppression sécurisée
     */
    public function supprimerLiaison($classeId, $tarifId)
    {
        $liaison = ClasseTarif::where('classe_id', $classeId)
                               ->where('tarif_id', $tarifId)
                               ->first();

        if ($liaison && $liaison->actif) {
            throw new Exception("Impossible de supprimer un tarif actuellement actif. Veuillez en activer un autre d'abord.");
        }

        return ClasseTarif::where('classe_id', $classeId)
            ->where('tarif_id', $tarifId)
            ->delete();
    }
}