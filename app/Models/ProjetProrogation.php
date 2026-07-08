<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetProrogation extends Model
{
    use HasFactory;

    protected $table = 'projet_prorogations';

    protected $fillable = [
        'projet_id',
        'date_prorogation',
    ];

    // Cast la date pour pouvoir faire des ->format() dans Blade sans problème
    protected $casts = [
        'date_prorogation' => 'date',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}