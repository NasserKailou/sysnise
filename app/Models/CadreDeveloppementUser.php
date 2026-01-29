<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadreDeveloppementUser extends Model
{
     use HasFactory;

    protected $table = 'cadre_developpement_users';


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cadre_developpement',
        'userr',
        'user_id',
    ];





    // Relation avec l'institution
    public function userr()
    {
        return $this->belongsTo(User::class, 'userr', 'id');
    }

    // Relation avec le cadre de développement
    public function cadreDeveloppement()
    {
        return $this->belongsTo(CadreDeveloppement::class, 'cadre_developpement', 'id');
    }
}
