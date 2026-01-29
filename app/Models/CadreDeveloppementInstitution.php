<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadreDeveloppementInstitution extends Model
{
    use HasFactory;

    protected $table = 'cadre_developpement_institutions';


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cadre_developpement',
        'institution',
        'user_id',
    ];





    // Relation avec l'institution
    public function institution()
    {
        return $this->belongsTo(InstitutionTutelle::class, 'institution', 'id');
    }

    // Relation avec le cadre de développement
    public function cadreDeveloppement()
    {
        return $this->belongsTo(CadreDeveloppement::class, 'cadre_developpement', 'id');
    }

}
 