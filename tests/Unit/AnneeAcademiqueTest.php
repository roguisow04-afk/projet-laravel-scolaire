<?php

namespace Tests\Unit;

use App\Models\AnneeAcademique;
use App\Services\AnneeAcademiqueService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AnneeAcademiqueTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================
    //  TEST 1 : Création réussie via le service
    // =========================================================
    #[Test]
    public function une_annee_academique_peut_etre_creee_avec_succes()
    {
        $service = new AnneeAcademiqueService();

        $annee = $service->creerAnnee([
            'anne_ac'    => '2025-2026',
            'date_debut' => '2025-10-01',
            'date_fin'   => '2026-06-01',
        ]);

        $this->assertDatabaseHas('annees_academiques', [
            'anne_ac' => '2025-2026',
            'statut'  => 'brouillon',
        ]);

        $this->assertEquals('2025-2026', $annee->anne_ac);
        $this->assertEquals('brouillon', $annee->statut);
    }

    // =========================================================
    //  TEST 2 : date_debut doit être antérieure à date_fin
    // =========================================================
    #[Test]
    public function date_debut_doit_etre_anterieure_a_date_fin()
    {
        $service = new AnneeAcademiqueService();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("La date de début doit être antérieure à la date de fin.");

        // date_debut APRÈS date_fin → doit lever une exception
        $service->creerAnnee([
            'anne_ac'    => '2025-2026',
            'date_debut' => '2026-01-01',
            'date_fin'   => '2025-01-01',
        ]);
    }

    // =========================================================
    //  TEST 3 : Impossible de créer un doublon de code
    // =========================================================
    #[Test]
    public function impossible_de_creer_un_doublon_de_code()
    {
        $service = new AnneeAcademiqueService();

        // Première création → doit réussir
        $service->creerAnnee([
            'anne_ac'    => '2025-2026',
            'date_debut' => '2025-10-01',
            'date_fin'   => '2026-06-01',
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Ce code d'année académique existe déjà.");

        // Deuxième création avec le même code → doit échouer
        $service->creerAnnee([
            'anne_ac'    => '2025-2026',
            'date_debut' => '2025-10-01',
            'date_fin'   => '2026-06-01',
        ]);
    }

    // =========================================================
    //  TEST 4 : On ne peut pas sauter l'étape de publication
    // =========================================================
    #[Test]
    public function on_ne_peut_pas_sauter_l_etape_de_publication()
    {
        $service = new AnneeAcademiqueService();

        $annee = $service->creerAnnee([
            'anne_ac'    => '2026-2027',
            'date_debut' => '2026-10-01',
            'date_fin'   => '2027-06-01',
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("L'année doit être publiée avant d'ouvrir les inscriptions.");

        // Tentative illégale : passer directement à 'ouverture_inscription'
        $service->changerStatut($annee, 'ouverture_inscription');
    }

    // =========================================================
    //  TEST 5 : Transition correcte brouillon → publie
    // =========================================================
    #[Test]
    public function on_peut_publier_une_annee_en_brouillon()
    {
        $service = new AnneeAcademiqueService();

        $annee = $service->creerAnnee([
            'anne_ac'    => '2026-2027',
            'date_debut' => '2026-10-01',
            'date_fin'   => '2027-06-01',
        ]);

        $service->changerStatut($annee, 'publie');

        $this->assertDatabaseHas('annees_academiques', [
            'anne_ac' => '2026-2027',
            'statut'  => 'publie',
        ]);
    }

    // =========================================================
    //  TEST 6 : Une année ne peut pas dépasser 9 mois
    // =========================================================
    #[Test]
    public function une_annee_ne_peut_pas_depasser_neuf_mois()
    {
        $service = new AnneeAcademiqueService();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("L'année académique ne peut pas dépasser 9 mois.");

        // 11 mois → doit échouer
        $service->creerAnnee([
            'anne_ac'    => '2025-2026',
            'date_debut' => '2025-01-01',
            'date_fin'   => '2025-12-01',
        ]);
    }

    // =========================================================
    //  TEST 7 : La durée exacte de 9 mois est acceptée
    // =========================================================
    #[Test]
    public function la_duree_de_lannee_academique_doit_etre_egale_a_neuf_mois()
    {
        $service = new AnneeAcademiqueService();

        // Nov(1) → Juil(9) = exactement 9 mois → doit réussir
        $annee = $service->creerAnnee([
            'anne_ac'    => '2013-9MOIS',
            'date_debut' => '2013-11-15',
            'date_fin'   => '2014-07-24',
        ]);

        $debut = \Carbon\Carbon::parse($annee->date_debut)->startOfMonth();
        $fin   = \Carbon\Carbon::parse($annee->date_fin)->startOfMonth();

        $this->assertEquals(9, $debut->diffInMonths($fin) + 1);
    }

    // =========================================================
    //  TEST 8 : Modification interdite si l'année n'est plus brouillon
    // =========================================================
    #[Test]
    public function modification_interdite_si_annee_non_brouillon()
    {
        $service = new AnneeAcademiqueService();

        $annee = $service->creerAnnee([
            'anne_ac'    => '2026-2027',
            'date_debut' => '2026-10-01',
            'date_fin'   => '2027-06-01',
        ]);

        $service->changerStatut($annee, 'publie');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Seules les années en mode 'Brouillon' peuvent être modifiées.");

        // Tentative de modification après publication → doit échouer
        $service->mettreAJourAnnee($annee, [
            'date_fin' => '2027-08-01',
        ]);
    }
}