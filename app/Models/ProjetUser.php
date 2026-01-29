<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetUser extends Model
{
     use HasFactory;

    protected $table = 'projet_users';


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'projet',
        'userr',
        'user_id',
    ];





    // Relation avec l'institution
    public function userr()
    {
        return $this->belongsTo(User::class, 'userr', 'id');
    }

    // Relation avec le cadre de développement
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet', 'id');
    }
}
