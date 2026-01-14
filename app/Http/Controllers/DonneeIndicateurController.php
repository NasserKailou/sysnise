<?php

namespace App\Http\Controllers;
use App\Exports\CmrExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\DonneeIndicateurStoreRequest;
use App\Http\Requests\DonneeIndicateurUpdateRequest;
use App\Imports\DonneesImport;
use App\Models\DonneeIndicateur;
use App\Models\CadreLogique;
use App\Models\CadreDeveloppement;
use App\Models\Indicateur;
use App\Models\Periode;
use App\Models\Zone;
use App\Models\Desagregation;
use App\Models\NatureDonnee;
use App\Models\SourceIndicateur;
use App\Models\UniteIndicateur;
use App\Models\CommentaireValeurIndicateur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonneeIndicateurController extends Controller
{
    public function afficherCMR($cadre_id)
    {
		$cadreDeveloppement = CadreDeveloppement::findOrFail($cadre_id);
		$CMR = DB::table('view_cmr')->where('cadre_developpement_id', $cadre_id)->orderBy('parent_id')->orderBy('cadre_id')->get();
		$breadcrumb	= 'Cadre Stratégique > Afficher CMR';
		return view('donneeIndicateur.afficherCMR', compact('breadcrumb','CMR','cadreDeveloppement'));
	}
	public function telecharger_cmr($cadre_id)
	{
		$cadreDeveloppement = CadreDeveloppement::findOrFail($cadre_id);

		// Téléchargement direct du fichier Excel
		return Excel::download(new CmrExport($cadre_id), 'CMR_'.$cadreDeveloppement->intitule.'.xlsx');
	}
	public function extractionDonneesForm()
    {
        $indicateurs = Indicateur::where('type_indicateur_id',1)->get();
		$cadre_logiques = DB::table('view_cadre_logique')->get();
		$periodes = Periode::orderBy('intitule', 'desc')->get();
		$zones = Zone::all();
		$nature_donnees = NatureDonnee::all();
		$breadcrumb	= 'Cadre Stratégique > Extraction de données';
        return view('donneeIndicateur.extractionDonnees', compact('breadcrumb','cadre_logiques','indicateurs','periodes','zones','nature_donnees'));
    }
	
	public function extractionDonnees(Request $request)
	{
		// 1 Récupération des filtres
		$natureIds = $request->input('paramNatureDonnee', []);
		$indicateurIds = $request->input('paramIndicateur', []);
		$zoneIds = $request->input('paramZone', []);
		$periodeIds = $request->input('paramPeriode', []);

		// 2 Construction de la requête
		$query = DB::table('indicateurs')
			->select(
				'indicateurs.id AS indicateur_id',
				'indicateurs.intitule AS indicateur_intitule',
				'view_extraction_donnees.nature_donnee_id',
				'view_extraction_donnees.nature_donnee_intitule',
				'view_extraction_donnees.zone_id',
				'view_extraction_donnees.zone_intitule',
				'view_extraction_donnees.source_indicateur_id',
				'view_extraction_donnees.source_indicateur_intitule',
				'view_extraction_donnees.unite_indicateur_id',
				'view_extraction_donnees.unite_indicateur_intitule',
				'view_extraction_donnees.commentaire_valeur_indicateur_id',
				'view_extraction_donnees.commentaire_intitule',
				'view_extraction_donnees.periode_id',
				'view_extraction_donnees.periode_intitule',
				'view_extraction_donnees.valeur',
				'view_extraction_donnees.desagregations',
				'view_extraction_donnees.desagregation_ids'
			)
			->leftJoin('view_extraction_donnees', 'indicateurs.id', '=', 'view_extraction_donnees.indicateur_id');

		// 3 Application des filtres
		if (!empty($indicateurIds)) {
			$query->whereIn('indicateurs.id', $indicateurIds);
		}

		if (!empty($natureIds)) {
			$query->whereIn('view_extraction_donnees.nature_donnee_id', $natureIds);
		}

		if (!empty($zoneIds)) {
			$query->whereIn('view_extraction_donnees.zone_id', $zoneIds);
		}

		if (!empty($periodeIds)) {
			$query->whereIn('view_extraction_donnees.periode_id', $periodeIds);
		}

		// 4 Exécution et renvoi en JSON
		$resultats = $query->get();
		
		return response()->json($resultats);
	}


	
	public function showUploadDataForm()
    {
		$breadcrumb	= 'Cadre Stratégique > Chargement de données';
        return view('donneeIndicateur.uploadData',compact('breadcrumb'));
    }
	
	public function uploadData(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);
		
		try {
			Excel::import(new DonneesImport, $request->file('file'));
			$request->session()->flash('success', 'Données importées avec succès !');
		} catch (Throwable $e) {
			$request->session()->flash('error', 'Données non importées du probablement aux formules qui sont dans la feuille data !');
			
		}

		return redirect()->back();
	}
	
	//-----------formulaire de saisie
	public function create()
	{
		return view('donneeIndicateur.create', [
			'breadcrumb'	=> 'Cadre Stratégique > Saisie de données',
			'natures'       => NatureDonnee::all(),
			'indicateurs'   => Indicateur::where('type_indicateur_id',1)->get(),
			'zones'         => Zone::all(),
			'desagregations' => Desagregation::all(),
			'periodes'      => Periode::orderBy('intitule', 'desc')->get(),
			'sources'       => SourceIndicateur::all(),
			'unites'        => UniteIndicateur::all(),
			'commentaires'  => CommentaireValeurIndicateur::all(),
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'nature_donnee_id.*'  => 'required|integer',
			'indicateur_id.*'     => 'required|integer',
			'zone_id.*'           => 'required|integer',
			'desagregation_id.*'  => 'required|integer',
			'periode_id.*'        => 'required|integer',
			'source_indicateur_id.*' => 'required|integer',
			'unite_indicateur_id.*'  => 'required|integer',
			'valeur.*'            => 'required|numeric',
		]);

		// Enregistrer chaque ligne
		foreach ($request->nature_donnee_id as $i => $nature) {
			$donneeIndicateur = DonneeIndicateur::updateOrCreate([
				'nature_donnee_id'               => $nature,
				'indicateur_id'                  => $request->indicateur_id[$i],
				'zone_id'                        => $request->zone_id[$i],
				'periode_id'                     => $request->periode_id[$i],
				'source_indicateur_id'           => $request->source_indicateur_id[$i],
				'unite_indicateur_id'            => $request->unite_indicateur_id[$i],
				'commentaire_valeur_indicateur_id' => $request->commentaire_valeur_indicateur_id[$i] ?? null,
				],[
				'valeur'                         => $request->valeur[$i],
				'statut'                         => DonneeIndicateur::STATUT_EN_ATTENTE, // Statut par défaut
			]);
			
			$desagregations = array_filter(explode('_', $request->desagregation_id[$i] ?? ''));
			if (!empty($desagregations)) {
				$donneeIndicateur->desagregations()->sync($desagregations);
			}
		}

		return redirect()->back()->with('success', 'Données enregistrées avec succès ! Elles sont en attente de validation.');
	}
	
	public function store2(Request $request)
	{
		// -------------------------------
		// 1. VALIDATION
		// -------------------------------
		$request->validate([
			'nature_donnee_id'                 => 'required|array',
			'indicateur_id'                    => 'required|array',
			'zone_id'                          => 'required|array',
			'periode_id'                       => 'required|array',
			'source_indicateur_id'             => 'required|array',
			'unite_indicateur_id'              => 'required|array',
			'commentaire_valeur_indicateur_id' => 'required|array',
			'valeur'                           => 'required|array',

			// Validation par élément
			'nature_donnee_id.*'                 => 'required|integer|exists:nature_donnees,id',
			'indicateur_id.*'                    => 'required|integer|exists:indicateurs,id',
			'zone_id.*'                          => 'required|integer|exists:zones,id',
			'periode_id.*'                       => 'required|integer|exists:periodes,id',
			'source_indicateur_id.*'             => 'required|integer|exists:source_indicateurs,id',
			'unite_indicateur_id.*'              => 'required|integer|exists:unite_indicateurs,id',
			'commentaire_valeur_indicateur_id.*' => 'nullable|integer|exists:commentaire_valeur_indicateurs,id',
			'valeur.*'                           => 'nullable|numeric'
		]);

		// -------------------------------
		// 2. ENREGISTRER LES LIGNES UNE PAR UNE
		// -------------------------------
		$total = count($request->nature_donnee_id);

		for ($i = 0; $i < $total; $i++) {

			// si la valeur est vide → on ignore cette ligne
			if ($request->valeur[$i] === null || $request->valeur[$i] === '') {
				continue;
			}

			DonneeIndicateur::create([
				'nature_donnee_id'                  => $request->nature_donnee_id[$i],
				'indicateur_id'                     => $request->indicateur_id[$i],
				'zone_id'                           => $request->zone_id[$i],
				'periode_id'                        => $request->periode_id[$i],
				'source_indicateur_id'              => $request->source_indicateur_id[$i],
				'unite_indicateur_id'               => $request->unite_indicateur_id[$i],
				'commentaire_valeur_indicateur_id'  => $request->commentaire_valeur_indicateur_id[$i] ?? null,
				'valeur'                            => $request->valeur[$i],
				'statut'                            => DonneeIndicateur::STATUT_EN_ATTENTE, // Statut par défaut
			]);
		}

		// -------------------------------
		// 3. RETOUR
		// -------------------------------
		return redirect()
			->back()
			->with('success', 'Toutes les données ont été enregistrées avec succès !');
	}
	
	//------------------matrice de saisie ----------
	public function parametreSaisieForm()
    {
        $indicateurs = Indicateur::where('type_indicateur_id',1)->get();
		$cadre_logiques = DB::table('view_cadre_logique')->get();
		$periodes = Periode::orderBy('intitule', 'desc')->get();
		$breadcrumb	= 'Cadre Stratégique > Saisie de données';
		
        return view('donneeIndicateur.parametreSaisie', compact('breadcrumb','cadre_logiques','indicateurs','periodes'));
    }
	// la bonne matrice utilisé----------
	public function matriceSaisie(Request $request)
	{
		$indicateurs = $request->indicateurs;
		$periodes    = $request->periodes;

		/**
		 * 1. Lignes donnee_indicateurs (brutes)
		 */
		$donnees = DB::table('donnee_indicateurs')
			->select(
				'id',
				DB::raw('2 AS nature_donnee_id'),
				'indicateur_id',
				'zone_id',
				'source_indicateur_id',
				'unite_indicateur_id',
				DB::raw('3 AS commentaire_valeur_indicateur_id')
			)
			->whereIn('indicateur_id', $indicateurs)
			->get();

		/**
		 * 2. Regroupement par clés métier
		 */
		$groupes = $donnees->groupBy(function ($item) {
			return implode('_', [
				$item->nature_donnee_id,
				$item->indicateur_id,
				$item->zone_id,
				$item->source_indicateur_id,
				$item->unite_indicateur_id,
				$item->commentaire_valeur_indicateur_id
			]);
		});

		/**
		 * 3. Périodes
		 */
		$periodesData = DB::table('periodes')
			->whereIn('id', $periodes)
			->orderBy('id')
			->get();

		/**
		 * 4. Désagrégations liées aux lignes donnee_indicateurs
		 */
		$desagregations = DB::table('donnee_indicateur_desagregation as did')
			->join('desagregations as d', 'd.id', '=', 'did.desagregation_id')
			->select(
				'did.donnee_indicateur_id',
				'd.id as desagregation_id',
				'd.intitule'
			)
			->whereIn('did.donnee_indicateur_id', $donnees->pluck('id'))
			->get()
			->groupBy('donnee_indicateur_id');

		/**
		 * 5. Construction de la matrice (1 ligne métier)
		 */
		$matrice = [];

		foreach ($groupes as $items) {

			// Référence métier (première ligne du groupe)
			$ref = $items->first();

			// Tous les IDs donnee_indicateurs concernés
			$donneeIds = $items->pluck('id');

			// Désagrégations concaténées et dédupliquées
			$desags = [];

			foreach ($donneeIds as $did) {
				if (isset($desagregations[$did])) {
					foreach ($desagregations[$did] as $d) {
						$desags[$d->desagregation_id] = $d->intitule;
					}
				}
			}

			$ligne = [
				// On garde UN id représentatif pour la saisie
				'donnee_indicateur_id'            => $donneeIds->first(),
				'nature_donnee_id'                => $ref->nature_donnee_id,
				'indicateur_id'                   => $ref->indicateur_id,
				'zone_id'                         => $ref->zone_id,
				'source_indicateur_id'            => $ref->source_indicateur_id,
				'unite_indicateur_id'             => $ref->unite_indicateur_id,
				'commentaire_valeur_indicateur_id'=> $ref->commentaire_valeur_indicateur_id,
				'desagregations'                  => collect($desags)
														->map(fn ($v, $k) => [
															'id' => $k,
															'intitule' => $v
														])
														->values()
														->toArray(),
				'periodes'                        => []
			];

			foreach ($periodesData as $p) {
				$ligne['periodes'][$p->id] = '';
			}

			$matrice[] = $ligne;
		}

		/**
		 * 6. Libellés
		 */
		$natureDonnees   = DB::table('nature_donnees')->pluck('intitule', 'id');
		$zones           = DB::table('zones')->pluck('intitule', 'id');
		$sources         = DB::table('source_indicateurs')->pluck('intitule', 'id');
		$unites          = DB::table('unite_indicateurs')->pluck('intitule', 'id');
		$commentaires    = DB::table('commentaire_valeur_indicateurs')->pluck('intitule', 'id');
		$indicateursData = DB::table('indicateurs')->pluck('intitule', 'id');
		$breadcrumb	= 'Cadre Stratégique > Saisie de données';
		return view('donneeIndicateur.matriceSaisie', compact(
			'matrice',
			'periodesData',
			'natureDonnees',
			'zones',
			'sources',
			'unites',
			'commentaires',
			'indicateursData',
			'breadcrumb'
		));
	}

	public function saveMatriceSaisie(Request $request)
	{
		$valeurs        = $request->valeurs ?? [];
		$desagregations = $request->desagregations ?? [];

		DB::beginTransaction();

		try {

			foreach ($valeurs as $modaliteKey => $dataPeriode) {

				[
					$nature_donnee_id,
					$indicateur_id,
					$zone_id,
					$source_indicateur_id,
					$unite_indicateur_id,
					$commentaire_valeur_indicateur_id
				] = explode('_', $modaliteKey);

				foreach ($dataPeriode as $periode_id => $valeur) {

					if ($valeur === null || $valeur === '') {
						continue;
					}

					/**
					 * 1. Création ou mise à jour de la ligne donnee_indicateurs
					 */
					$donneeIndicateur = \App\Models\DonneeIndicateur::updateOrCreate(
						[
							'nature_donnee_id'                 => $nature_donnee_id,
							'indicateur_id'                    => $indicateur_id,
							'zone_id'                          => $zone_id,
							'periode_id'                       => $periode_id,
							'source_indicateur_id'             => $source_indicateur_id,
							'unite_indicateur_id'              => $unite_indicateur_id,
							'commentaire_valeur_indicateur_id' => $commentaire_valeur_indicateur_id
						],
						[
							'valeur' => $valeur,
							'statut' => DonneeIndicateur::STATUT_EN_ATTENTE, // Statut par défaut
						]
					);

					/**
					 * 2. Association des désagrégations
					 */
					if (isset($desagregations[$modaliteKey])) {
						$donneeIndicateur
							->desagregations()
							->sync($desagregations[$modaliteKey]);
					}
				}
			}

			DB::commit();
			return back()->with('success', 'Données enregistrées avec succès.');

		} catch (\Throwable $e) {

			DB::rollBack();
			return back()->with('error', $e->getMessage());
		}
	}

	/**
	 * Afficher la liste des données en attente de validation
	 */
	public function indexValidation()
	{
		$donnees = DonneeIndicateur::with([
			'natureDonnee',
			'indicateur',
			'zone',
			'periode',
			'sourceIndicateur',
			'uniteIndicateur',
			'commentaireValeurIndicateur',
			'desagregations'
		])
		->enAttente()
		->orderBy('created_at', 'desc')
		->paginate(50);

		$breadcrumb = 'Cadre Stratégique > Validation des données';
		
		return view('donneeIndicateur.validation', compact('donnees', 'breadcrumb'));
	}

	/**
	 * Valider une donnée individuelle
	 */
	public function valider($id)
	{
		$donnee = DonneeIndicateur::findOrFail($id);
		
		if ($donnee->valider()) {
			return redirect()->back()->with('success', 'Donnée validée avec succès !');
		}
		
		return redirect()->back()->with('error', 'Erreur lors de la validation.');
	}

	/**
	 * Rejeter une donnée individuelle
	 */
	public function rejeter($id)
	{
		$donnee = DonneeIndicateur::findOrFail($id);
		
		if ($donnee->rejeter()) {
			return redirect()->back()->with('success', 'Donnée rejetée avec succès !');
		}
		
		return redirect()->back()->with('error', 'Erreur lors du rejet.');
	}

	/**
	 * Validation globale de toutes les données en attente
	 */
	public function validerGlobal(Request $request)
	{
		$donneesIds = $request->input('donnees_ids', []);
		
		if (empty($donneesIds)) {
			return redirect()->back()->with('error', 'Aucune donnée sélectionnée.');
		}

		try {
			DB::beginTransaction();
			
			$count = DonneeIndicateur::whereIn('id', $donneesIds)
				->enAttente()
				->update(['statut' => DonneeIndicateur::STATUT_VALIDE]);
			
			DB::commit();
			
			return redirect()->back()->with('success', "$count donnée(s) validée(s) avec succès !");
			
		} catch (\Exception $e) {
			DB::rollBack();
			return redirect()->back()->with('error', 'Erreur lors de la validation globale : ' . $e->getMessage());
		}
	}

	/**
	 * Validation globale de TOUTES les données en attente (sans sélection)
	 */
	public function validerTout()
	{
		try {
			DB::beginTransaction();
			
			$count = DonneeIndicateur::enAttente()
				->update(['statut' => DonneeIndicateur::STATUT_VALIDE]);
			
			DB::commit();
			
			return redirect()->back()->with('success', "Toutes les données en attente ($count) ont été validées avec succès !");
			
		} catch (\Exception $e) {
			DB::rollBack();
			return redirect()->back()->with('error', 'Erreur lors de la validation globale : ' . $e->getMessage());
		}
	}

	/**
	 * Rejeter plusieurs données
	 */
	public function rejeterGlobal(Request $request)
	{
		$donneesIds = $request->input('donnees_ids', []);
		
		if (empty($donneesIds)) {
			return redirect()->back()->with('error', 'Aucune donnée sélectionnée.');
		}

		try {
			DB::beginTransaction();
			
			$count = DonneeIndicateur::whereIn('id', $donneesIds)
				->enAttente()
				->update(['statut' => DonneeIndicateur::STATUT_REJETE]);
			
			DB::commit();
			
			return redirect()->back()->with('success', "$count donnée(s) rejetée(s) avec succès !");
			
		} catch (\Exception $e) {
			DB::rollBack();
			return redirect()->back()->with('error', 'Erreur lors du rejet global : ' . $e->getMessage());
		}
	}

	
	
}
