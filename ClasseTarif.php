<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseTarif extends Model
{
    use HasFactory;

    protected $table = 'classe_tarif'; // Table pivot
    protected $fillable = [
        'classe_id',
        'tarif_id',
        'actif',
    ];

    // Relation vers Classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Relation vers Tarif
    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }
}