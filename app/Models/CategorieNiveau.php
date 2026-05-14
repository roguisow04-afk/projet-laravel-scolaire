<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieNiveau extends Model
{
    use HasFactory;

    protected $table = 'categorie_niveaux';

    protected $fillable = ['categorie_niveau', 'niveau_id'];
    //  'niveau' retiré car c'est niveau_id la FK

    public $timestamps = true;

    // Relation avec les classes
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

    // Relation avec Niveau (renommé de niveauRelation → niveau)
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }
}