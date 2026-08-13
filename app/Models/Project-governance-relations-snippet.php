<?php

/*
|--------------------------------------------------------------------------
| A AJOUTER dans votre modèle App\Models\Projet existant
|--------------------------------------------------------------------------
| Ce fichier n'est PAS un modèle à part entière : c'est un extrait de
| méthodes à copier-coller dans la classe Projet déjà présente dans
| votre application (app/Models/Projet.php), à l'intérieur du corps
| de la classe.
*/

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

public function governancePilotage(): HasOne
{
    return $this->hasOne(\App\Models\GovernancePilotage::class);
}

public function governanceAudit(): HasOne
{
    return $this->hasOne(\App\Models\GovernanceAudit::class);
}

public function governanceProblemes(): HasMany
{
    return $this->hasMany(\App\Models\GovernanceProbleme::class);
}

public function governanceRecommandations(): HasMany
{
    return $this->hasMany(\App\Models\GovernanceRecommandation::class);
}
