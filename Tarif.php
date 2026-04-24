<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tarif extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'montant',
    ];

    /**
     * Relation Many-to-Many avec les classes
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class, 'classe_tarif')
                    ->withPivot('actif')
                    ->withTimestamps();
    }

    /**
     * Vérifie si le tarif est modifiable pour une classe donnée
     */
    public function estModifiablePourClasse(int $classeId): bool
    {
        $classe = $this->classes()->where('classes.id', $classeId)->first();

        if (!$classe) {
            return true; // pas rattaché → modifiable
        }

        // Vérifie si la classe a des inscrits
        return $classe->inscrits()->count() === 0;
    }
}