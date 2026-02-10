<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('zones', App\Http\Controllers\ZoneApiController::class);

Route::apiResource('composantes', App\Http\Controllers\ComposanteApiController::class);
Route::apiResource('composante_produits', App\Http\Controllers\ComposanteProduitApiController::class);
Route::delete('/composante_produits/{composante_id}/{produit_id}',[App\Http\Controllers\ComposanteProduitApiController::class, 'destroy']);
//Route::get('/composante_produits/{composante_id}/produits', [App\Http\Controllers\ComposanteProduitApiController::class, 'getProduitsByComposante']);
Route::get('/composante_produits/{projet}/{composante}/produits', [App\Http\Controllers\ComposanteProduitApiController::class, 'getProduitsByComposante']);

Route::get('/composante_produits/{composante_id}/produitsSelected', [App\Http\Controllers\ComposanteProduitApiController::class, 'getProduitsInComposante']);
Route::post('/composante_produits/storeBatch',[App\Http\Controllers\ComposanteProduitApiController::class, 'storeBatch']);
Route::post('/composante_produits/deleteBatch',[App\Http\Controllers\ComposanteProduitApiController::class, 'deleteBatch']);

Route::apiResource('cadre_logiques', App\Http\Controllers\CadreLogiqueApiController::class);
Route::put('/cadre_mesure_resultats/{id}/update-parent', [App\Http\Controllers\CadreLogiqueApiController::class, 'updateParent']);

Route::apiResource('orientation-cadre-developpements', App\Http\Controllers\OrientationCadreDeveloppementController::class);

Route::apiResource('cadre_mesure_resultats', App\Http\Controllers\CadreMesureResultatApiController::class);
Route::delete('/cadre_mesure_resultats/{cadre_logique_id}/{indicateur_id}',[App\Http\Controllers\CadreMesureResultatApiController::class, 'destroy']);
Route::get('/cadre_mesure_resultats/{cadre_logique_id}/indicateurs', [App\Http\Controllers\CadreMesureResultatApiController::class, 'getIndicateursByCadreLogique']);
Route::get('/cadre_mesure_resultats/{cadre_logique_id}/indicateursSelected', [App\Http\Controllers\CadreMesureResultatApiController::class, 'getIndicateursInCadreLogique']);
Route::post('/cadre_mesure_resultats/storeBatch',[App\Http\Controllers\CadreMesureResultatApiController::class, 'storeBatch']);
Route::post('/cadre_mesure_resultats/deleteBatch',[App\Http\Controllers\CadreMesureResultatApiController::class, 'deleteBatch']);

Route::apiResource('indicateurs', App\Http\Controllers\IndicateurApiController::class);

Route::apiResource('donnee_indicateurs', App\Http\Controllers\DonneeIndicateurController::class);

Route::apiResource('type_desagregations', App\Http\Controllers\TypeDesagregationApiController::class);

Route::apiResource('desagregations', App\Http\Controllers\DesagregationApiController::class);

Route::get('/indicateurs/{indicateur_id}/{typeDesagregation_id}/', [App\Http\Controllers\IndicateurApiController::class, 'getDesagregationsByIndicateur']);


Route::apiResource('nature_donnees', App\Http\Controllers\NatureDonneeController::class);

Route::apiResource('periodes', App\Http\Controllers\PeriodeController::class);

Route::apiResource('source_indicateurs', App\Http\Controllers\SourceIndicateurController::class);

Route::apiResource('unite_indicateurs', App\Http\Controllers\UniteIndicateurController::class);

Route::apiResource('commentaire_valeur_indicateurs', App\Http\Controllers\CommentaireValeurIndicateurController::class);
