<?php

namespace App\Services;

use App\Models\Tarif;
use App\Models\Classe;
use App\Models\ClasseTarif;
use App\Models\Filiere;
use App\Models\CategorieNiveau;
use Illuminate\Support\Facades\DB;
use Exception;

class ScolariteService
{
    /**
     * Règle : Un tarif rattaché à une classe avec des inscrits ne peut plus être modifié.
     */
    public function modifierTarif(Tarif $tarif, array $data)
    {
        foreach ($tarif->classes as $classe) {
            // On vérifie s'il y a des inscrits
            if ($classe->tarifs()->wherePivot('actif', true)->exists() && method_exists($classe, 'inscriptions') && $classe->inscriptions()->count() > 0) {
                throw new Exception("Modification impossible : des élèves sont déjà inscrits avec ce tarif.");
            }
        }
        return $tarif->update($data);
    }

    /**
     * Règle : Rattacher un tarif à une classe. 
     * Si la classe avait un tarif, l'ancien est désactivé et le nouveau est activé.
     */
    public function attribuerTarif(int $classeId, int $tarifId)
    {
        return DB::transaction(function () use ($classeId, $tarifId) {
            $classe = Classe::findOrFail($classeId);

            // Vérification des inscrits avant changement
            if (method_exists($classe, 'inscriptions') && $classe->inscriptions()->count() > 0) {
                throw new Exception("Impossible de changer le tarif : la classe a déjà des inscrits.");
            }

            // --- PARTIE AJOUTÉE / MODIFIÉE ---
            // Désactiver l'ancien tarif actif via la relation pivot
            $classe->tarifs()->updateExistingPivot(
                $classe->tarifs()->wherePivot('actif', true)->pluck('tarif_id')->toArray(),
                ['actif' => false]
            );

            // Créer le nouveau lien actif
            return $classe->tarifs()->attach($tarifId, ['actif' => true]);
            // ----------------------------------
        });
    }

    /**
     * Créer une filière avec vérification du code unique
     */
    public function creerFiliere(array $data)
    {
        if (Filiere::where('code', $data['code'])->exists()) {
            throw new Exception("Le code de filière '{$data['code']}' est déjà utilisé.");
        }

        return Filiere::create($data);
    }

    /**
     * Modifier une filière
     */
    public function modifierFiliere(Filiere $filiere, array $data)
    {
        if ($filiere->code !== $data['code'] && Filiere::where('code', $data['code'])->exists()) {
            throw new Exception("Le code '{$data['code']}' est déjà assigné à une autre filière.");
        }

        return $filiere->update($data);
    }

    /**
     * Gestion des Filières : Suppression sécurisée
     */
    public function supprimerFiliere(Filiere $filiere)
    {
        if (Classe::where('filiere_id', $filiere->id)->exists()) {
            throw new Exception("Impossible de supprimer cette filière : elle est liée à des classes.");
        }
        return $filiere->delete();
    }
}