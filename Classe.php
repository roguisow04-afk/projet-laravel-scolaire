<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = 'classes';
    protected $fillable = ['nom', 'niveau_id', 'filiere_id', 'categorie_niveau_id'];

    // Relation avec Niveau
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    // Relation avec Filiere
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    // Relation avec CategorieNiveau
    public function categorieNiveau()
    {
        return $this->belongsTo(CategorieNiveau::class);
    }

    // Tous les tarifs
    public function tarifs()
    {
        return $this->belongsToMany(Tarif::class, 'classe_tarif')
                    ->withPivot('actif')
                    ->withTimestamps();
    }

    // Tarif actif (relation Eloquent)
    public function tarifActif()
    {
        return $this->belongsToMany(Tarif::class, 'classe_tarif')
                    ->withPivot('actif')
                    ->withTimestamps()
                    ->wherePivot('actif', 1);
    }

    // Récupérer le tarif actif comme objet simple
    public function getTarifActifAttribute()
    {
        return $this->tarifs->firstWhere('pivot.actif', 1);
    }
}