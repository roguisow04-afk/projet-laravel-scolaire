<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AnneeAcademique;

class AnneeAcademiqueTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TEST 1 : Création réussie
     * On teste le "chemin heureux" avec des données valides.
     */
    public function test_creation_annee_reussie()
    {
        $response = $this->post(route('annees_academiques.store'), [
            'anne_ac' => '2026-2027',
            'date_debut' => '2026-10-01',
            'date_fin' => '2027-06-30', // Octobre à Juin = 9 mois pile selon ton calcul
            'date_ouverture_inscription' => '2026-09-01'
        ]);

        // Vérifie la redirection vers l'index avec le message de succès
        $response->assertStatus(302);
        $response->assertSessionHas('success'); 
        
        // Vérifie la présence en base de données
        $this->assertDatabaseHas('annees_academiques', [
            'anne_ac' => '2026-2027',
            'statut'  => 'brouillon' // Ton service force ce statut
        ]);
    }

    /**
     * TEST 2 : Échec si durée > 9 mois
     * Test de la règle métier dans AnneeAcademiqueService
     */
    public function test_creation_echoue_si_plus_de_9_mois()
    {
        $response = $this->post(route('annees_academiques.store'), [
            'anne_ac' => '2026-2027',
            'date_debut' => '2026-01-01',
            'date_fin' => '2026-11-01', // 11 mois
        ]);

        // Ton contrôleur catch l'exception et renvoie l'erreur en session
        $response->assertSessionHas('error', "L'année académique ne peut pas dépasser 9 mois."); 
        $this->assertDatabaseCount('annees_academiques', 0);
    }

    /**
     * TEST 3 : Échec si doublon de code
     * Test de la vérification d'existence dans le Service
     */
    public function test_creation_echoue_si_doublon()
    {
        // On crée manuellement une première année
        AnneeAcademique::create([
            'anne_ac' => '2025-2026',
            'date_debut' => '2025-10-01',
            'date_fin' => '2026-06-30',
            'statut' => 'brouillon'
        ]);

        // On tente d'envoyer le même code via la route store
        $response = $this->post(route('annees_academiques.store'), [
            'anne_ac' => '2025-2026',
            'date_debut' => '2025-10-01',
            'date_fin' => '2026-06-30',
        ]);

        // Vérifie le message d'erreur spécifique défini dans ton Service
        $response->assertSessionHas('error', "Ce code d'année académique existe déjà.");
        $this->assertDatabaseCount('annees_academiques', 1);
    }
}