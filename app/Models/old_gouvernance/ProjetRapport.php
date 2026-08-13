<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjetRapport extends Model
{
    protected $table = 'projet_rapports';
    protected $fillable = ['projet_id', 'type', 'fichier', 'date_rapport', 'description'];

    protected $casts = [
        'date_rapport' => 'date',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->fichier);
    }
}