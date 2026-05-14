<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = 'classes';
    
    // Ajoute 'annee_academique_id' ici pour permettre l'enregistrement
    protected $fillable = ['nom', 'niveau_id', 'filiere_id', 'categorie_niveau_id'];

    // --- RELATIONS EXISTANTES ---
    public function niveau() { return $this->belongsTo(Niveau::class); }
    public function filiere() { return $this->belongsTo(Filiere::class); }
    public function categorieNiveau() { return $this->belongsTo(CategorieNiveau::class); }

    // --- LA RELATION MANQUANTE À AJOUTER ---
    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class, 'annee_academique_id');
    }

    // --- LE RESTE DE TON CODE (Tarifs, etc.) ---
    public function tarifs()
    {
        return $this->belongsToMany(Tarif::class, 'classe_tarif')
                    ->withPivot('actif')
                    ->withTimestamps();
    }
    public function tarifActif()
{
    return $this->belongsToMany(Tarif::class, 'classe_tarif')
                ->wherePivot('actif', true)
                ->limit(1);
}

// Accesseur pour faciliter l'affichage : $classe->tarif_actif_info
public function getTarifActifAttribute()
   {
    return $this->tarifActif()->first();
   }
}