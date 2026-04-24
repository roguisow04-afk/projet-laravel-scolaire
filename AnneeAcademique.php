<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AnneeAcademique extends Model
{
    protected $table = 'annees_academiques';

    protected $fillable = [
        'anne_ac',
        'statut',
        'date_debut',
        'date_fin',
        'ouverture_inscription',
        'fermeture_inscription',
    ];

    // Dates automatiquement converties en objets Carbon
    protected $dates = [
        'date_debut',
        'date_fin',
        'ouverture_inscription',
        'fermeture_inscription',
    ];

    /**
     * Vérifie si l'année est modifiable
     */
    public function estModifiable(): bool
    {
        return $this->statut === 'brouillon';
    }

    /**
     * Vérifie si l'ouverture des inscriptions est possible
     */
    public function peutOuvrirInscription(): bool
    {
        return $this->statut === 'publie';
    }

    /**
     * Vérifie si la fermeture des inscriptions est possible
     */
    public function peutFermerInscription(): bool
    {
        return $this->statut === 'ouverture_inscription';
    }

    /**
     * Vérifie si l'année peut être clôturée
     */
    public function peutCloturer(): bool
    {
        return !in_array($this->statut, ['cloturer']);
    }

    /**
     * Définir les dates d'inscription automatiquement
     */
    public function setDatesInscription()
    {
        $this->ouverture_inscription = $this->date_debut->copy()->subMonth();
        $this->fermeture_inscription = $this->date_fin->copy()->subDay(); 
    }

    /**
     * Validation des dates
     */
    public function datesValides(): bool
    {
        return $this->date_debut < $this->date_fin;
    }

    // ======================
    // Scopes pour filtrer
    // ======================
    public function scopeBrouillon($query)
    {
        return $query->where('statut', 'brouillon');
    }

    public function scopePublie($query)
    {
        return $query->where('statut', 'publie');
    }

    public function scopeOuvertureInscription($query)
    {
        return $query->where('statut', 'ouverture_inscription');
    }

    public function scopeCloturer($query)
    {
        return $query->where('statut', 'cloturer');
    }

    // ======================
    // Méthodes pour changer le statut
    // ======================
    public function ouvrirInscription()
    {
        if ($this->peutOuvrirInscription()) {
            $this->statut = 'ouverture_inscription';
            $this->save();
        }
    }

    public function fermerInscription()
    {
        if ($this->peutFermerInscription()) {
            $this->statut = 'cloturer';
            $this->save();
        }
    }

    public function cloturer()
    {
        if ($this->peutCloturer()) {
            $this->statut = 'cloturer';
            $this->save();
        }
    }

    // ======================
    // Accessors pour formater les dates
    // ======================
    public function getDateDebutFormatteAttribute()
    {
        return $this->date_debut ? $this->date_debut->format('d/m/Y') : null;
    }

    public function getDateFinFormatteAttribute()
    {
        return $this->date_fin ? $this->date_fin->format('d/m/Y') : null;
    }

    public function getOuvertureInscriptionFormatteAttribute()
    {
        return $this->ouverture_inscription ? $this->ouverture_inscription->format('d/m/Y') : null;
    }

    public function getFermetureInscriptionFormatteAttribute()
    {
        return $this->fermeture_inscription ? $this->fermeture_inscription->format('d/m/Y') : null;
    }
}