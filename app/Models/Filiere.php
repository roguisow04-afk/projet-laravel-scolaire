<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
     protected $table = 'filieres';          
    protected $fillable = ['code', 'nom_filiere']; 
    public $timestamps = true; 
}
