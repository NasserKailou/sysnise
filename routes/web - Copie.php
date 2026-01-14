<?php
use Illuminate\Support\Facades\Route;
use App\Exports\DataTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserRoleController;

Route::get('/', [App\Http\Controllers\DonneeIndicateurController::class, 'extractionDonneesForm'])->name('donneeIndicateur.extractionDonnees.form');

Route::middleware(['auth'])->group(function () {
Route::get('/zones/upload', [App\Http\Controllers\ZoneController::class, 'showUploadForm'])->name('zones.showUploadForm');
Route::post('/zones/upload', [App\Http\Controllers\ZoneController::class, 'upload'])->name('zones.upload');
Route::resource('zones', App\Http\Controllers\ZoneController::class);

Route::resource('type_desagregations', App\Http\Controllers\TypeDesagregationController::class);
Route::resource('desagregations', App\Http\Controllers\DesagregationController::class);
Route::resource('nature_donnees', App\Http\Controllers\NatureDonneeController::class);
Route::get('/periodes/upload', [App\Http\Controllers\PeriodeController::class, 'showUploadForm'])->name('periodes.showUploadForm');
Route::post('/periodes/upload', [App\Http\Controllers\PeriodeController::class, 'upload'])->name('periodes.upload');
Route::resource('periodes', App\Http\Controllers\PeriodeController::class);
Route::get('/source_indicateurs/upload', [App\Http\Controllers\SourceIndicateurController::class, 'showUploadForm'])->name('sourceIndicateurs.showUploadForm');
Route::post('/source_indicateurs/upload', [App\Http\Controllers\SourceIndicateurController::class, 'upload'])->name('sourceIndicateurs.upload');
Route::resource('source_indicateurs', App\Http\Controllers\SourceIndicateurController::class);
Route::get('/unite_indicateurs/upload', [App\Http\Controllers\UniteIndicateurController::class, 'showUploadForm'])->name('uniteIndicateurs.showUploadForm');
Route::post('/unite_indicateurs/upload', [App\Http\Controllers\UniteIndicateurController::class, 'upload'])->name('uniteIndicateurs.upload');
Route::resource('unite_indicateurs', App\Http\Controllers\UniteIndicateurController::class);
Route::resource('commentaire_valeur_indicateurs', App\Http\Controllers\CommentaireValeurIndicateurController::class);
Route::resource('source_financements', App\Http\Controllers\SourceFinancementController::class);
Route::resource('nature_financements', App\Http\Controllers\NatureFinancementController::class);
Route::resource('statut_financements', App\Http\Controllers\StatutFinancementController::class);
Route::resource('ptfs', App\Http\Controllers\PTFController::class);

Route::resource('priorites', App\Http\Controllers\PrioriteController::class);
Route::resource('institution_tutelles', App\Http\Controllers\InstitutionTutelleController::class);
Route::resource('population_cibles', App\Http\Controllers\PopulationCibleController::class);
Route::resource('statut_produits', App\Http\Controllers\StatutProduitController::class);
Route::resource('type_produits', App\Http\Controllers\TypeProduitController::class);
Route::resource('statut_activites', App\Http\Controllers\StatutActiviteController::class);
Route::resource('type_activites', App\Http\Controllers\TypeActiviteController::class);
Route::resource('statut_projets', App\Http\Controllers\StatutProjetController::class);
Route::resource('etudes', App\Http\Controllers\EtudeController::class);

Route::resource('projets', App\Http\Controllers\ProjetController::class);
//Route::get('/projets/{projet}/cadreProjet', [App\Http\Controllers\ProjetController::class, 'cadreProjet'])->name('projet.cadreProjet');
});

Route::middleware(['role:admin'])->group(function () {
	Route::prefix('projets/{projet}')->group(function () {
		// Enregistrer une nouvelle pièce jointe
		Route::post('piece_jointe_projets', [App\Http\Controllers\PieceJointeProjetController::class, 'store'])->name('projets.piece_jointe_projets.store');
		// Formulaire d'édition d'une pièce jointe
		Route::get('piece_jointe_projets/{piece}', [App\Http\Controllers\PieceJointeProjetController::class, 'edit'])->name('projets.piece_jointe_projets.edit');
		// Mise à jour d'une pièce jointe
		Route::put('piece_jointe_projets/{piece}', [App\Http\Controllers\PieceJointeProjetController::class, 'update'])->name('projets.piece_jointe_projets.update');
		// Suppression d'une pièce jointe
		Route::delete('piece_jointe_projets/{piece}', [App\Http\Controllers\PieceJointeProjetController::class, 'destroy'])->name('projets.piece_jointe_projets.destroy');

		//verifier l'appelation des routes
		Route::get('cadreProjet', [App\Http\Controllers\ProjetController::class, 'cadreProjet'])->name('projets.cadreProjet');
		Route::post('cadreProjet', [App\Http\Controllers\ProjetController::class, 'storeCadreProjet'])->name('projets.storeCadreProjet');
		Route::get('editCadreProjet', [App\Http\Controllers\ProjetController::class, 'editCadreProjet'])->name('projets.editCadreProjet');
		Route::post('editCadreProjet', [App\Http\Controllers\ProjetController::class, 'updateCadreProjet'])->name('projets.updateCadreProjet');

		Route::get('populationCibles', [App\Http\Controllers\ProjetController::class, 'populationCible'])->name('projets.populationCibles');
		Route::post('populationCibles', [App\Http\Controllers\ProjetController::class, 'storePopulationCibles'])->name('projets.populationCibles.store');
		Route::get('editPopulationCibles/{populationCible}', [App\Http\Controllers\ProjetController::class, 'editPopulationCibles'])->name('projets.populationCibles.edit');
		Route::put('editPopulationCibles/{populationCible}', [App\Http\Controllers\ProjetController::class, 'updatePopulationCibles'])->name('projets.populationCibles.update');
		Route::post('destroyPopulationCibles', [App\Http\Controllers\ProjetController::class, 'destroyPopulationCibles'])->name('projets.populationCibles.destroy');
		//etudes disponibles
		Route::get('etudeDisponibles', [App\Http\Controllers\ProjetController::class, 'etudeDisponibles'])->name('projets.etudeDisponibles');
		Route::post('etudeDisponibles', [App\Http\Controllers\ProjetController::class, 'storeEtudeDisponibles'])->name('projets.etudeDisponibles.store');
		Route::get('editEtudeDisponibles', [App\Http\Controllers\ProjetController::class, 'editEtudeDisponibles'])->name('projets.etudeDisponibles.edit');
		Route::post('editEtudeDisponibles', [App\Http\Controllers\ProjetController::class, 'updateEtudeDisponibles'])->name('projets.etudeDisponibles.update');
		Route::delete('etudeDisponibles/{etude}', [App\Http\Controllers\ProjetController::class, 'destroyEtudeDisponibles'])->name('projets.etudeDisponibles.destroy');
		//etudes envisagées
		Route::get('etudeEnvisagees', [App\Http\Controllers\ProjetController::class, 'etudeEnvisagees'])->name('projets.etudeEnvisagees');
		Route::post('etudeEnvisagees', [App\Http\Controllers\ProjetController::class, 'storeEtudeEnvisagees'])->name('projets.etudeEnvisagees.store');
		Route::get('editEtudeEnvisagees/{etude}/{sourceFinancement}', [App\Http\Controllers\ProjetController::class, 'editEtudeEnvisagees'])->name('projets.etudeEnvisagees.edit');
		Route::post('editEtudeEnvisagees/{etude}/{sourceFinancement}', [App\Http\Controllers\ProjetController::class, 'updateEtudeEnvisagees'])->name('projets.etudeEnvisagees.update');
		Route::delete('etudeEnvisagees/{etude}/{sourceFinancement}', [App\Http\Controllers\ProjetController::class, 'destroyEtudeEnvisagees'])->name('projets.etudeEnvisagees.destroy');

		//recherche de financement
		Route::get('financements', [App\Http\Controllers\ProjetController::class, 'financements'])->name('projets.financements');
		Route::post('financements', [App\Http\Controllers\ProjetController::class, 'storeFinancements'])->name('projets.financements.store');
		Route::get('editFinancements/{ptf}/{sourceFinancement}/{statutFinancement}/{natureFinancement}', [App\Http\Controllers\ProjetController::class, 'editFinancements'])->name('projets.financements.edit');
		Route::post('editFinancements', [App\Http\Controllers\ProjetController::class, 'updateFinancements'])->name('projets.financements.update');
		Route::delete('financements/{ptf}/{sourceFinancement}/{statutFinancement}/{natureFinancement}', [App\Http\Controllers\ProjetController::class, 'destroyFinancements'])->name('projets.financements.destroy');

		
	});
});
Route::resource('cadre_developpements', App\Http\Controllers\CadreDeveloppementController::class);
Route::prefix('cadre_developpements/{cadre}')->group(function () {
    // Enregistrer une nouvelle pièce jointe
    Route::post('piece_jointes', [App\Http\Controllers\PieceJointeController::class, 'store'])->name('cadre_developpements.piece_jointes.store');
    // Formulaire d'édition d'une pièce jointe
    Route::get('piece_jointes/{piece}', [App\Http\Controllers\PieceJointeController::class, 'edit'])->name('cadre_developpements.piece_jointes.edit');
    // Mise à jour d'une pièce jointe
    Route::put('piece_jointes/{piece}', [App\Http\Controllers\PieceJointeController::class, 'update'])->name('cadre_developpements.piece_jointes.update');
    // Suppression d'une pièce jointe
    Route::delete('piece_jointes/{piece}', [App\Http\Controllers\PieceJointeController::class, 'destroy'])->name('cadre_developpements.piece_jointes.destroy');
});
Route::get('/cadre_developpements/{cadre_developpement}/cadres_logiques', [App\Http\Controllers\CadreLogiqueController::class, 'index'])->name('cadre_developpements.cadres_logiques.index');
Route::get('/cadre_developpements/{cadre_developpement}/cadres_logiques_upload', [App\Http\Controllers\CadreLogiqueController::class, 'showUploadForm'])->name('cadre_developpements.cadres_logiques.showUploadForm');
Route::post('/cadre_developpements/{cadre_developpement}/cadres_logiques_upload', [App\Http\Controllers\CadreLogiqueController::class, 'upload'])->name('cadre_developpements.cadres_logiques.upload');

Route::resource('cadre_logiques.hypothese_risques', App\Http\Controllers\HypotheseRisqueController::class);
Route::resource('cadre_logiques.produits', App\Http\Controllers\ProduitController::class);
Route::prefix('cadre_logiques.produits/{produit}')->group(function () {
    // Enregistrer une nouvelle pièce jointe
    Route::post('piece_jointe_produits', [App\Http\Controllers\PieceJointeProduitController::class, 'store'])->name('produits.piece_jointe_produits.store');
    // Formulaire d'édition d'une pièce jointe
    Route::get('piece_jointe_produits/{piece}', [App\Http\Controllers\PieceJointeProduitController::class, 'edit'])->name('produits.piece_jointe_produits.edit');
    // Mise à jour d'une pièce jointe
    Route::put('piece_jointe_produits/{piece}', [App\Http\Controllers\PieceJointeProduitController::class, 'update'])->name('produits.piece_jointe_produits.update');
    // Suppression d'une pièce jointe
    Route::delete('piece_jointe_produits/{piece}', [App\Http\Controllers\PieceJointeProduitController::class, 'destroy'])->name('produits.piece_jointe_produits.destroy');
});

Route::resource('cadre_logiques.activites', App\Http\Controllers\ActiviteController::class);
Route::prefix('cadre_logiques.activites/{activite}')->group(function () {
    // Enregistrer une nouvelle pièce jointe
    Route::post('piece_jointe_activites', [App\Http\Controllers\PieceJointeActiviteController::class, 'store'])->name('activites.piece_jointe_activites.store');
    // Formulaire d'édition d'une pièce jointe
    Route::get('piece_jointe_activites/{piece}', [App\Http\Controllers\PieceJointeActiviteController::class, 'edit'])->name('activites.piece_jointe_activites.edit');
    // Mise à jour d'une pièce jointe
    Route::put('piece_jointe_activites/{piece}', [App\Http\Controllers\PieceJointeActiviteController::class, 'update'])->name('activites.piece_jointe_activites.update');
    // Suppression d'une pièce jointe
    Route::delete('piece_jointe_activites/{piece}', [App\Http\Controllers\PieceJointeActiviteController::class, 'destroy'])->name('activites.piece_jointe_activites.destroy');
});

Route::get('/indicateurs/upload', [App\Http\Controllers\IndicateurController::class, 'showUploadForm'])->name('indicateurs.upload.form');
Route::post('indicateurs/upload', [App\Http\Controllers\IndicateurController::class, 'upload'])->name('indicateurs.upload');
Route::get('/indicateurs/{indicateur}/desagregation', [App\Http\Controllers\IndicateurController::class, 'showDesagregationForm'])->name('indicateurs.desagregation.form');

Route::get('/donnee_indicateurs/create', [App\Http\Controllers\DonneeIndicateurController::class, 'create']);
Route::post('/donnee_indicateurs/store', [App\Http\Controllers\DonneeIndicateurController::class, 'store'])->name('donnee_indicateurs.store');

Route::get('/donnee_indicateurs/uploadData', [App\Http\Controllers\DonneeIndicateurController::class, 'showUploadDataForm'])->name('donnee_indicateurs.uploadData.form');
Route::post('donnee_indicateurs/uploadData', [App\Http\Controllers\DonneeIndicateurController::class, 'uploadData'])->name('donnee_indicateurs.uploadData');
Route::get('/donnee_indicateurs/extractionDonnees', [App\Http\Controllers\DonneeIndicateurController::class, 'extractionDonneesForm'])->name('donneeIndicateur.extractionDonnees.form');
Route::post('/donnee_indicateurs/extractionDonnees', [App\Http\Controllers\DonneeIndicateurController::class, 'extractionDonnees'])->name('donneeIndicateur.extractionDonnees');

Route::get('/donnee_indicateurs/parametreSaisie', [App\Http\Controllers\DonneeIndicateurController::class, 'parametreSaisieForm'])->name('donneeIndicateur.parametreSaisie.form');
Route::post('/donnee_indicateurs/parametreSaisie', [App\Http\Controllers\DonneeIndicateurController::class, 'matriceSaisie'])->name('donneeIndicateur.parametreSaisie');
Route::post('/donnee_indicateurs/matriceSaisie', [App\Http\Controllers\DonneeIndicateurController::class, 'saveMatriceSaisie'])->name('donneeIndicateur.matriceSaisie.store');

Route::get('/export_data_template', function () {
    return Excel::download(new DataTemplateExport, 'data_template.xlsx');
});

Route::get('/afficher_cmr/{cadre_id}', [App\Http\Controllers\DonneeIndicateurController::class, 'afficherCMR']);
Route::get('/telecharger_cmr/{cadre_id}', [App\Http\Controllers\DonneeIndicateurController::class, 'telecharger_cmr']);


// Routes de connexion
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class)->except(['show']);
    Route::get('users', [UserRoleController::class, 'index'])->name('users.index');
    Route::post('users/{user}/roles', [UserRoleController::class, 'updateRoles'])->name('users.updateRoles');
});
