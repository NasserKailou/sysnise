<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetFinancementAdditionnel extends Model
{
    use HasFactory;

    protected $table = 'projet_financement_additionnels';

    protected $fillable = [
        'projet_id',
        'cout',
        'cout_devise',
        'devise_id'
    ];

    // Relation inverse vers le Projet
    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    // Relation pour récupérer les informations de la devise
    public function devise()
    {
        return $this->belongsTo(Devise::class, 'devise_id');
    }
}