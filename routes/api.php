<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('zones', App\Http\Controllers\ZoneApiController::class);

//Route::apiResource('cadre_developpements', App\Http\Controllers\CadreDeveloppementApiController::class);

//Route::apiResource('piece-jointes', App\Http\Controllers\PieceJointeController::class);

Route::apiResource('composantes', App\Http\Controllers\ComposanteApiController::class);
Route::apiResource('composante_indicateurs', App\Http\Controllers\ComposanteIndicateurApiController::class);
Route::delete('/composante_indicateurs/{composante_id}/{indicateur_id}',[App\Http\Controllers\ComposanteIndicateurApiController::class, 'destroy']);
Route::get('/composante_indicateurs/{composante_id}/indicateurs', [App\Http\Controllers\ComposanteIndicateurApiController::class, 'getIndicateursByComposante']);
Route::get('/composante_indicateurs/{composante_id}/indicateursSelected', [App\Http\Controllers\ComposanteIndicateurApiController::class, 'getIndicateursInComposante']);
Route::post('/composante_indicateurs/storeBatch',[App\Http\Controllers\ComposanteIndicateurApiController::class, 'storeBatch']);
Route::post('/composante_indicateurs/deleteBatch',[App\Http\Controllers\ComposanteIndicateurApiController::class, 'deleteBatch']);

Route::apiResource('cadre_logiques', App\Http\Controllers\CadreLogiqueApiController::class);

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
