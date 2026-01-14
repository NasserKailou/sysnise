<?php
use Illuminate\Support\Facades\Route;
use App\Exports\DataTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserRoleController;

Route::get('/', [App\Http\Controllers\DonneeIndicateurController::class, 'extractionDonneesForm'])->name('donneeIndicateur.extractionDonnees.form');

//Route::middleware(['auth'])->group(function () {
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
Route::resource('categorie_depenses', App\Http\Controllers\CategorieDepenseController::class);
Route::resource('bailleurs', App\Http\Controllers\BailleurController::class);

Route::resource('priorites', App\Http\Controllers\PrioriteController::class);
Route::resource('institution_tutelles', App\Http\Controllers\InstitutionTutelleController::class);
Route::resource('population_cibles', App\Http\Controllers\PopulationCibleController::class);
Route::resource('statut_produits', App\Http\Controllers\StatutProduitController::class);
Route::resource('type_produits', App\Http\Controllers\TypeProduitController::class);
Route::resource('statut_activites', App\Http\Controllers\StatutActiviteController::class);
Route::resource('type_activites', App\Http\Controllers\TypeActiviteController::class);
Route::resource('statut_projets', App\Http\Controllers\StatutProjetController::class);
Route::resource('etudes', App\Http\Controllers\EtudeController::class);

//});

//Route::middleware(['role:admin'])->group(function () {
	
	Route::resource('projets', App\Http\Controllers\ProjetController::class);
	//Route::get('/projets/{projet}/cadreProjet', [App\Http\Controllers\ProjetController::class, 'cadreProjet'])->name('projet.cadreProjet');
	Route::get('/projets/{projet}/composantes', [App\Http\Controllers\ComposanteController::class, 'index'])->name('projets.composantes.index');
	Route::get('/projets/{projet}/composantes_upload', [App\Http\Controllers\ComposanteController::class, 'showUploadForm'])->name('projets.composantes.showUploadForm');
	Route::post('/projets/{projet}/composantes_upload', [App\Http\Controllers\ComposanteController::class, 'upload'])->name('projets.composantes.upload');


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
		Route::delete('populationCibles/{populationCible}', [App\Http\Controllers\ProjetController::class, 'destroyPopulationCibles'])->name('projets.populationCibles.destroy');
		//etudes disponibles
		Route::get('etudeDisponibles', [App\Http\Controllers\ProjetController::class, 'etudeDisponibles'])->name('projets.etudeDisponibles');
		Route::post('etudeDisponibles', [App\Http\Controllers\ProjetController::class, 'storeEtudeDisponibles'])->name('projets.etudeDisponibles.store');
		Route::delete('etudeDisponibles/{etude}', [App\Http\Controllers\ProjetController::class, 'destroyEtudeDisponibles'])->name('projets.etudeDisponibles.destroy');
		//etudes envisagées
		Route::get('etudeEnvisagees', [App\Http\Controllers\ProjetController::class, 'etudeEnvisagees'])->name('projets.etudeEnvisagees');
		Route::post('etudeEnvisagees', [App\Http\Controllers\ProjetController::class, 'storeEtudeEnvisagees'])->name('projets.etudeEnvisagees.store');
		Route::get('editEtudeEnvisagees/{etude}/{sourceFinancement}', [App\Http\Controllers\ProjetController::class, 'editEtudeEnvisagees'])->name('projets.etudeEnvisagees.edit');
		Route::post('editEtudeEnvisagees/{etude}/{sourceFinancement}', [App\Http\Controllers\ProjetController::class, 'updateEtudeEnvisagees'])->name('projets.etudeEnvisagees.update');
		Route::delete('etudeEnvisagees/{etude}/{sourceFinancement}', [App\Http\Controllers\ProjetController::class, 'destroyEtudeEnvisagees'])->name('projets.etudeEnvisagees.destroy');

		//recherche de financement
		Route::get('rechercheFinancements', [App\Http\Controllers\ProjetController::class, 'rechercheFinancements'])->name('projets.rechercheFinancements');
		Route::post('rechercheFinancements', [App\Http\Controllers\ProjetController::class, 'storeRechercheFinancements'])->name('projets.rechercheFinancements.store');
		Route::get('editRechercheFinancements/{bailleur}/{sourceFinancement}/{statutFinancement}/{natureFinancement}', [App\Http\Controllers\ProjetController::class, 'editRechercheFinancements'])->name('projets.rechercheFinancements.edit');
		Route::post('editrechercheFinancements', [App\Http\Controllers\ProjetController::class, 'updateRechercheFinancements'])->name('projets.rechercheFinancements.update');
		Route::delete('rechercheFinancements/{bailleur}/{sourceFinancement}/{statutFinancement}/{natureFinancement}', [App\Http\Controllers\ProjetController::class, 'destroyRechercheFinancements'])->name('projets.rechercheFinancements.destroy');
		
		//plan de financement
		Route::get('planFinancements', [App\Http\Controllers\ProjetController::class, 'planFinancements'])->name('projets.planFinancements');
		Route::post('planFinancements', [App\Http\Controllers\ProjetController::class, 'storePlanFinancements'])->name('projets.planFinancements.store');
		Route::get('editPlanFinancements/{composante_id}/{source_financement_id}/{bailleur_id}/{categorie_depense_id}/{nature_financement_id}/{statut_financement_id}', [App\Http\Controllers\ProjetController::class, 'editPlanFinancements'])->name('projets.planFinancements.edit');
		Route::post('editplanFinancements', [App\Http\Controllers\ProjetController::class, 'updatePlanFinancements'])->name('projets.planFinancements.update');
		Route::delete('planFinancements/{composante_id}/{source_financement_id}/{bailleur_id}/{categorie_depense_id}/{nature_financement_id}/{statut_financement_id}', [App\Http\Controllers\ProjetController::class, 'destroyPlanFinancements'])->name('projets.planFinancements.destroy');
		
		Route::get('budgetAnnuelPrevu/{composante_id}/{source_financement_id}/{bailleur_id}/{categorie_depense_id}/{nature_financement_id}/{statut_financement_id}', [App\Http\Controllers\ProjetController::class, 'budgetAnnuelPrevu'])->name('projets.planFinancements.budgetAnnuelPrevu');
		Route::post('budgetAnnuelPrevu/{planFinancement}', [App\Http\Controllers\ProjetController::class, 'storeBudgetAnnuelPrevu'])->name('projets.planFinancements.budgetAnnuelPrevu.store');
		Route::get('editBudgetAnnuelPrevu/{budgetAnnuelPrevu}', [App\Http\Controllers\ProjetController::class, 'editBudgetAnnuelPrevu'])->name('projets.planFinancements.budgetAnnuelPrevu.edit');
		Route::post('editbudgetAnnuelPrevu/{budgetAnnuelPrevu}', [App\Http\Controllers\ProjetController::class, 'updateBudgetAnnuelPrevu'])->name('projets.planFinancements.budgetAnnuelPrevu.update');
		
		//class, 'updateBudgetAnnuelPrevu'])->name('projets.planFinancements.budgetAnnuelPrevu.update');
		Route::delete('budgetAnnuelPrevu/{budgetAnnuelPrevu}', [App\Http\Controllers\ProjetController::class, 'destroyBudgetAnnuelPrevu'])->name('projets.planFinancements.budgetAnnuelPrevu.destroy');
		
		Route::get('budgetAnnuelDepense/{composante_id}/{source_financement_id}/{bailleur_id}/{categorie_depense_id}/{nature_financement_id}/{statut_financement_id}', [App\Http\Controllers\ProjetController::class, 'budgetAnnuelDepense'])->name('projets.planFinancements.budgetAnnuelDepense');
		Route::post('budgetAnnuelDepense/{planFinancement}', [App\Http\Controllers\ProjetController::class, 'storeBudgetAnnuelDepense'])->name('projets.planFinancements.budgetAnnuelDepense.update');
		
	});
//});
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
//Route::prefix('cadre_logiques.produits/{produit}')->group(function () {
    // Enregistrer une nouvelle pièce jointe
    Route::post('piece_jointe_produits', [App\Http\Controllers\PieceJointeProduitController::class, 'store'])->name('produits.piece_jointe_produits.store');
    // Formulaire d'édition d'une pièce jointe
    Route::get('piece_jointe_produits/{piece}', [App\Http\Controllers\PieceJointeProduitController::class, 'edit'])->name('produits.piece_jointe_produits.edit');
    // Mise à jour d'une pièce jointe
    Route::put('piece_jointe_produits/{piece}', [App\Http\Controllers\PieceJointeProduitController::class, 'update'])->name('produits.piece_jointe_produits.update');
    // Suppression d'une pièce jointe
    Route::delete('piece_jointe_produits/{piece}', [App\Http\Controllers\PieceJointeProduitController::class, 'destroy'])->name('produits.piece_jointe_produits.destroy');
//});

Route::resource('cadre_logiques.activites', App\Http\Controllers\ActiviteController::class);
//Route::prefix('cadre_logiques.activites/{activite}')->group(function () {
    // Enregistrer une nouvelle pièce jointe
    Route::post('piece_jointe_activites', [App\Http\Controllers\PieceJointeActiviteController::class, 'store'])->name('activites.piece_jointe_activites.store');
    // Formulaire d'édition d'une pièce jointe
    Route::get('piece_jointe_activites/{piece}', [App\Http\Controllers\PieceJointeActiviteController::class, 'edit'])->name('activites.piece_jointe_activites.edit');
    // Mise à jour d'une pièce jointe
    Route::put('piece_jointe_activites/{piece}', [App\Http\Controllers\PieceJointeActiviteController::class, 'update'])->name('activites.piece_jointe_activites.update');
    // Suppression d'une pièce jointe
    Route::delete('piece_jointe_activites/{piece}', [App\Http\Controllers\PieceJointeActiviteController::class, 'destroy'])->name('activites.piece_jointe_activites.destroy');
//});

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

// Routes de validation des données
Route::get('/donnee_indicateurs/validation', [App\Http\Controllers\DonneeIndicateurController::class, 'indexValidation'])->name('donneeIndicateur.validation.index');
Route::get('/donnee_indicateurs/validees', [App\Http\Controllers\DonneeIndicateurController::class, 'indexValidees'])->name('donneeIndicateur.validees.index');
Route::get('/donnee_indicateurs/rejetees', [App\Http\Controllers\DonneeIndicateurController::class, 'indexRejetees'])->name('donneeIndicateur.rejetees.index');
Route::post('/donnee_indicateurs/{id}/valider', [App\Http\Controllers\DonneeIndicateurController::class, 'valider'])->name('donneeIndicateur.valider');
Route::post('/donnee_indicateurs/{id}/rejeter', [App\Http\Controllers\DonneeIndicateurController::class, 'rejeter'])->name('donneeIndicateur.rejeter');
Route::post('/donnee_indicateurs/valider-global', [App\Http\Controllers\DonneeIndicateurController::class, 'validerGlobal'])->name('donneeIndicateur.valider.global');
Route::post('/donnee_indicateurs/valider-tout', [App\Http\Controllers\DonneeIndicateurController::class, 'validerTout'])->name('donneeIndicateur.valider.tout');
Route::post('/donnee_indicateurs/rejeter-global', [App\Http\Controllers\DonneeIndicateurController::class, 'rejeterGlobal'])->name('donneeIndicateur.rejeter.global');

Route::get('/export_data_template', function () {
    return Excel::download(new DataTemplateExport, 'data_template.xlsx');
});

Route::get('/afficher_cmr/{cadre_id}', [App\Http\Controllers\DonneeIndicateurController::class, 'afficherCMR']);
Route::get('/telecharger_cmr/{cadre_id}', [App\Http\Controllers\DonneeIndicateurController::class, 'telecharger_cmr']);


// Routes de connexion
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class)->except(['show']);
    Route::get('users', [UserRoleController::class, 'index'])->name('users.index');
    Route::post('users/{user}/roles', [UserRoleController::class, 'updateRoles'])->name('users.updateRoles');
});
