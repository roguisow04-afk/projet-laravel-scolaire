<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;

    protected $table = 'niveaux';
    protected $fillable = ['nom_nivaux'];
    public $timestamps = true;

    // Relation avec les classes
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

    // Relation avec les catégories de niveaux
    public function categorieNiveaux()
    {
        return $this->hasMany(CategorieNiveau::class);
    }
}