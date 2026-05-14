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

    // ✅ REMPLACEMENT MODERNE DE $dates
    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'ouverture_inscription' => 'date',
        'fermeture_inscription' => 'date',
    ];

    // ======================
    // LOGIQUE METIER
    // ======================

    public function estModifiable(): bool
    {
        return $this->statut === 'brouillon';
    }

    public function peutOuvrirInscription(): bool
    {
        return $this->statut === 'publie';
    }

    public function peutFermerInscription(): bool
    {
        return $this->statut === 'ouverture_inscription';
    }

    public function peutCloturer(): bool
    {
        return in_array($this->statut, ['publie', 'ouverture_inscription']);
    }

    // ======================
    // DATES INSCRIPTION SAFE
    // ======================

    public function setDatesInscription()
    {
        if ($this->date_debut && $this->date_fin) {

            $this->ouverture_inscription = Carbon::parse($this->date_debut)->subMonth();

            $this->fermeture_inscription = Carbon::parse($this->date_fin)->subDay();
        }
    }

    // ======================
    // VALIDATION DATES SAFE
    // ======================

    public function datesValides(): bool
    {
        return $this->date_debut
            && $this->date_fin
            && $this->date_debut < $this->date_fin;
    }

    // ======================
    // SCOPES
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
    // ACTIONS
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
    // ACCESSORS
    // ======================

    public function getDateDebutFormatteAttribute()
    {
        return $this->date_debut?->format('d/m/Y');
    }

    public function getDateFinFormatteAttribute()
    {
        return $this->date_fin?->format('d/m/Y');
    }

    public function getOuvertureInscriptionFormatteAttribute()
    {
        return $this->ouverture_inscription?->format('d/m/Y');
    }

    public function getFermetureInscriptionFormatteAttribute()
    {
        return $this->fermeture_inscription?->format('d/m/Y');
    }
}