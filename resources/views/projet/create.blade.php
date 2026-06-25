@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<style>
		.ztree li span.node_name {
				white-space: normal; /* autorise le retour à la ligne */
				display: inline-block; /* garde l'alignement avec l'icône */
				word-break: break-word; /* coupe les mots trop longs */
			}
		#zoneContent,#actionMajeureContent,#secteurContent,#bailleurContent {
			display: none;
			background: #f8f9fa; /* gris clair */
			border: 1px solid #ccc;
			border-radius: 5px;
			width: 100%;
			top: 100%; /* Juste en dessous de l’input */
			left: 0;
			z-index: 9999; /* S’assure qu’elle reste au-dessus */
			max-height: 200px;
			overflow-y: auto;
		}

		#zoneContent ul li,#actionMajeureContent ul li,#secteurContent ul li,#bailleurContent ul li {
			padding: 6px 10px;
			cursor: pointer;
		}
		#zoneContent ul li:hover,#actionMajeureContent ul li:hover,#secteurContent ul li:hover,#bailleurContent ul li:hover {
			background-color: #e9ecef;
		}
	</style>
	<script type="text/javascript">
		var zNodesZone = [
			{ id:0, pId:0, name:"/", open: true}
		];
		
		@foreach($zones as $zone)
			zNodesZone.push({
				id: {{ $zone->id }},
				pId: {{ $zone->zone_id ?? 0 }},
				name: @json($zone->intitule)
			});
		@endforeach
		
		var settingZone = {
			check: {
				enable: true,
				chkboxType: {"Y":"", "N":""}
			},
			view: {
				dblClickExpand: false
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				beforeClick: beforeClickZone,
				onCheck: onCheckZone
			}
		};
		
		function beforeClickZone(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_zone");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		function onCheckZone(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_zone"),
			nodes = zTree.getCheckedNodes(true),
			zone_names = "";zone_ids = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				zone_names += nodes[i].name + ",";
				zone_ids += nodes[i].id + ",";
			}
			if (zone_names.length > 0 ){
				zone_names = zone_names.substring(0, zone_names.length-1);
				zone_ids = zone_ids.substring(0, zone_ids.length-1);
				}
			var cityObj_names = $("#zone_names");
				cityObj_ids = $("#zone_ids");
			cityObj_names.attr("value", zone_names);
			cityObj_ids.attr("value", zone_ids);
		}

		function showZone() {
			var cityObj = $("#zone_names");
			var cityOffset = $("#zone_names").offset();
			$("#zoneContent").slideDown("fast");

			$("body").bind("mousedown", onZoneBodyDown);
		}
		function hideZone() {
			$("#zoneContent").fadeOut("fast");
			$("body").unbind("mousedown", onZoneBodyDown);
		}
		function onZoneBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "zone_names" || event.target.id == "zoneContent" || $(event.target).parents("#zoneContent").length>0)) {
				hideZone();
			}
		}
		/*---------------------------------------------*/
		var zNodesSecteur = [
			{ id:0, pId:0, name:"/", open: true}
		];
		
		@foreach($secteurs as $secteur)
			zNodesSecteur.push({
				id: {{ $secteur->id }},
				pId: {{ $secteur->secteur_id ?? 0 }},
				name: @json($secteur->intitule)
			});
		@endforeach
		
		var settingSecteur = {
			check: {
				enable: true,
				chkboxType: {"Y":"", "N":""}
			},
			view: {
				dblClickExpand: false
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				beforeClick: beforeClickSecteur,
				onCheck: onCheckSecteur
			}
		};
		
		function beforeClickSecteur(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_secteur");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		function onCheckSecteur(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_secteur"),
			nodes = zTree.getCheckedNodes(true),
			secteur_names = "";secteur_ids = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				secteur_names += nodes[i].name + ",";
				secteur_ids += nodes[i].id + ",";
			}
			if (secteur_names.length > 0 ){
				secteur_names = secteur_names.substring(0, secteur_names.length-1);
				secteur_ids = secteur_ids.substring(0, secteur_ids.length-1);
				}
			var cityObj_names = $("#secteur_names");
				cityObj_ids = $("#secteur_ids");
			cityObj_names.attr("value", secteur_names);
			cityObj_ids.attr("value", secteur_ids);
		}

		function showSecteur() {
			var cityObj = $("#secteur_names");
			var cityOffset = $("#secteur_names").offset();
			$("#secteurContent").slideDown("fast");

			$("body").bind("mousedown", onSecteurBodyDown);
		}
		function hideSecteur() {
			$("#secteurContent").fadeOut("fast");
			$("body").unbind("mousedown", onSecteurBodyDown);
		}
		function onSecteurBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "secteur_names" || event.target.id == "secteurContent" || $(event.target).parents("#secteurContent").length>0)) {
				hideSecteur();
			}
		}
		
		/*---------------------------------------------*/
		var zNodesBailleur = [
			{ id:0, pId:0, name:"/", open: true}
		];
		
		@foreach($bailleurs as $bailleur)
			zNodesBailleur.push({
				id: {{ $bailleur->id }},
				pId: {{ $bailleur->bailleur_id ?? 0 }},
				name: @json($bailleur->intitule)
			});
		@endforeach
		
		var settingBailleur = {
			check: {
				enable: true,
				chkboxType: {"Y":"", "N":""}
			},
			view: {
				dblClickExpand: false
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				beforeClick: beforeClickBailleur,
				onCheck: onCheckBailleur
			}
		};
		
		function beforeClickBailleur(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_bailleur");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		function onCheckBailleur(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_bailleur"),
			nodes = zTree.getCheckedNodes(true),
			bailleur_names = "";bailleur_ids = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				bailleur_names += nodes[i].name + ",";
				bailleur_ids += nodes[i].id + ",";
			}
			if (bailleur_names.length > 0 ){
				bailleur_names = bailleur_names.substring(0, bailleur_names.length-1);
				bailleur_ids = bailleur_ids.substring(0, bailleur_ids.length-1);
				}
			var cityObj_names = $("#bailleur_names");
				cityObj_ids = $("#bailleur_ids");
			cityObj_names.attr("value", bailleur_names);
			cityObj_ids.attr("value", bailleur_ids);
		}

		function showBailleur() {
			var cityObj = $("#bailleur_names");
			var cityOffset = $("#bailleur_names").offset();
			$("#bailleurContent").slideDown("fast");

			$("body").bind("mousedown", onBailleurBodyDown);
		}
		function hideBailleur() {
			$("#bailleurContent").fadeOut("fast");
			$("body").unbind("mousedown", onBailleurBodyDown);
		}
		function onBailleurBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "bailleur_names" || event.target.id == "bailleurContent" || $(event.target).parents("#bailleurContent").length>0)) {
				hideBailleur();
			}
		}
		
		/* -----------------------------------------------*/
		var zNodesChaineLogique = [];
		@foreach($chaineLogiques as $chaine)
			zNodesChaineLogique.push({
				/*id: {{ $chaine->id }},
				pId: {{ $chaine->parent_id ?? 0 }},
				*/
				id: @json((string) $chaine->id),
				pId: @json((string) ($chaine->parent_id ?? '0')),
				name: @json($chaine->intitule)
			});
		@endforeach
		
		var settingChaineLogique = {
			check: {
				enable: true,
				chkboxType: {"Y":"", "N":""}
			},
			view: {
				dblClickExpand: false
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				beforeClick: beforeClickChaineLogique,
				onCheck: onCheckChaineLogique
			}
		};
		
		function beforeClickChaineLogique(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_chaine_logique");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		function onCheckChaineLogique(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_chaine_logique"),
			nodes = zTree.getCheckedNodes(true),
			chaine_logique_names = "";chaine_logique_ids = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				chaine_logique_names += nodes[i].name + ",";
				chaine_logique_ids += nodes[i].id + ",";
			}
			if (chaine_logique_names.length > 0 ){
				chaine_logique_names = chaine_logique_names.substring(0, chaine_logique_names.length-1);
				chaine_logique_ids = chaine_logique_ids.substring(0, chaine_logique_ids.length-1);
				}
			var cityObj_names = $("#chaine_logique_names");
				cityObj_ids = $("#chaine_logique_ids");
			cityObj_names.attr("value", chaine_logique_names);
			cityObj_ids.attr("value", chaine_logique_ids);
		}

		function showChaineLogique() {
			var cityObj = $("#chaine_logique_names");
			var cityOffset = $("#chaine_logique_names").offset();
			$("#chaineLogiqueContent").slideDown("fast");

			$("body").bind("mousedown", onBodyDownChaineLogique);
		}
		function hideChaineLogique() {
			$("#chaineLogiqueContent").fadeOut("fast");
			$("body").unbind("mousedown", onBodyDownChaineLogique);
		}
		function onBodyDownChaineLogique(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "chaine_logique_names" || event.target.id == "chaineLogiqueContent" || $(event.target).parents("#chaineLogiqueContent").length>0)) {
				hideChaineLogique();
			}
		}
		
		
	</script>
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Projet</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.store') }}" method="POST">
			@csrf
			<div class="row">
				<div class="row mb-3">
					<div class="col-md-3 mt-3">
					  <label class="form-label">Sigle 
						<span style="color: red;">*</span>
					  </label>
					  <input name="sigle" type="text" class="form-control" required>
					  
					</div>
					<div class="col-md-3 mt-3">
					  <label class="form-label">Intitulé 
						<span style="color: red;">*</span>
					  </label>
					  <input name="intitule" type="text" class="form-control" required>
					</div>
					<div class="col-md-3 mt-3">
					  <label class="form-label">Statut Projet 
						<span style="color: red;">*</span>
					  </label>
					   <select id="statut_projet_id" name="statut_projet_id" class="form-select @error('projet') is-invalid @enderror" required>
							<option value="">-- Sélectionner le statut --</option>
							@foreach($statutProjets as $statut)
								<option value="{{ $statut->id }}">
									{{ $statut->intitule }}
								</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-3 mt-3">
					  <label class="form-label">Priorité </label>
					   <select name="priorite_id" class="form-select">
							<option value="">-- Sélectionner la priorité --</option>
							@foreach($priorites as $priorite)
								<option value="{{ $priorite->id }}">
									{{ $priorite->intitule }}
								</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 mt-3">
					  <label class="form-label">Ministère/Institution de tutelle 
						<span style="color: red;">*</span>
					  </label>
					   <select name="institution_tutelle_id" class="form-select @error('priorite') is-invalid @enderror" required>
							<option value="">-- Sélectionner Ministères/Institutions --</option>
							@foreach($institutionTutelles as $institutionTutelle)
								<option value="{{ $institutionTutelle->id }}" @if ($instituion_tutelle_id==$institutionTutelle->id)		selected="selected" 	@endif >
									{{ $institutionTutelle->intitule }}
								</option>
							@endforeach
						</select>
						<input type="hidden"  name="institution_tutelle_id" value="{{ $instituion_tutelle_id }}">
					</div>
					<div class="col-md-3 mt-3">
					  <label class="form-label">Contact</label>
					  <input name="contact" type="text" class="form-control">
					</div>
					<div class="col-md-3 mt-3">
						<label class="form-label">Secteurs</label>
						<input id="secteur_ids" name="secteur_ids" type="hidden" class="form-control" readonly value=""/>
						<div class="input-group">
							<input id="secteur_names" name="secteur_names" type="text" class="form-control" readonly value="" onclick="showSecteur();"/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary" id="menuBtn" href="#" onclick="showSecteur(); return false;"><i class="fa fa-search"></i></button>
							</span>
						</div>
						
						<div id="secteurContent" class="secteurContent" style="display:none;">
							<ul id="liste_secteur" class="ztree" style="margin-top:0;"></ul>
						</div>
					</div>
					<div class="initialisation col-md-3 mt-3">
					  <label class="form-label">Année démarrage prévue</label>
					  <input name="annee_demarrage" type="integer" class="form-control">
					</div>
					<div id="div_date_debut_prevue" class="formulation col-md-3 mt-3">
					  <label class="form-label">Date début prévue</label>
					  <input id="date_debut_prevue" name="date_debut_prevue" type="date" class="form-control">
					</div>
					<div id="div_date_fin_prevue" class="formulation col-md-3 mt-3">
					  <label class="form-label">Date fin prévue</label>
					  <input id="date_fin_prevue" name="date_fin_prevue" type="date" class="form-control">
					</div>
					<div  class="execution col-md-3 mt-3">
					  <label class="form-label">Date d’approbation </label>
					  <input id="date_approbation" name="date_approbation" type="date" class="form-control">
					</div>
					<div  class="execution col-md-3 mt-3">
					  <label class="form-label">Date de signature  </label>
					  <input id="date_signature" name="date_signature" type="date" class="form-control">
					</div>
					<div  class="execution col-md-3 mt-3">
					  <label class="form-label">Date de mise en vigueur  </label>
					  <input id="date_mise_en_vigueur" name="date_mise_en_vigueur" type="date" class="form-control">
					</div>
					<div  class="execution col-md-3 mt-3">
					  <label class="form-label">Date de démarrage effectif</label>
					  <input id="date_debut_effective" name="date_debut_effective" type="date" class="form-control">
					</div>
					<div  class="execution col-md-3 mt-3">
					  <label class="form-label">Date initiale de clôture </label>
					  <input id="date_fin_effective" name="date_fin_effective" type="date" class="form-control">
					</div>
					<div id="div_duree" class="col-md-3 mt-3">
					  <label class="form-label">durée(mois)</label>
					  <input id="duree" name="duree" type="integer" class="form-control">
					</div>
					<div id="div_cout" class="col-md-6 mt-3">
					  <label class="form-label">coût du projet (FCFA)</label>
					  <input name="cout" type="integer" class="form-control">
					</div>
					
					<div id="div_cout_devise" class="col-md-12 mt-3">
						<div>
							<label class="form-label">Coût du projet (DEVlSE)</label>
							<div class="input-group">
								<input type="number" class="form-control" name="cout_devise" placeholder="montant">
								<select name="devise_id" class="form-select @error('priorite') is-invalid @enderror">
									<option value="">--dévise --</option>
									@foreach($devises as $devise)
										<option value="{{ $devise->id }}">
											{{ $devise->intitule }}
										</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="execution col-md-12 mt-3">
						<label class="form-label">PTFs</label>
						<input id="bailleur_ids" name="bailleur_ids" type="hidden" class="form-control" readonly value=""/>
						<div class="input-group">
							<input id="bailleur_names" name="bailleur_names" type="text" class="form-control" readonly value="" onclick="showBailleur();"/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary" id="menuBtn" href="#" onclick="showBailleur(); return false;"><i class="fa fa-search"></i></button>
							</span>
						</div>
						
						<div id="bailleurContent" class="bailleurContent" style="display:none;">
							<ul id="liste_bailleur" class="ztree" style="margin-top:0;"></ul>
						</div>
					</div>
					
					<!--<div class="col-md-3 form-check mt-3">
                        <input name="prorogation " type="checkbox" class="form-check-input" id="prorogation" checked>
                        <label class="form-check-label" for="prorogation">Prorogation ? </label>
                    </div> -->
					<div id="prorogation_check" class="execution col-md-12 mt-3 d-flex align-items-center">
						<label class="form-label mb-0 me-3">
							Prorogation ?
						</label>

						<div class="form-check form-check-inline mb-0">
							<input class="form-check-input" type="radio" name="prorogation_check" id="prorogation_check_oui" value="Oui">
							<label class="form-check-label" for="oui">Oui</label>
						</div>

						<div class="form-check form-check-inline mb-0">
							<input class="form-check-input" type="radio" name="prorogation_check" id="prorogation_check_non" value="Non" checked="checked">
							<label class="form-check-label" for="non">Non</label>
						</div>
					</div>
					<div  class="prorogation col-md-6 mt-3">
					  <label class="form-label">nouvelle date clôture</label>
					  <input id="date_prorogation" name="date_prorogation" type="date" class="form-control">
					</div>
					
					<div  id="div_duree_prorogation" class="prorogation col-md-6 mt-3">
					  <label class="form-label"> durée prorogation</label>
					  <input id="duree_prorogation" name="duree_prorogation" type="number" class="form-control" disabled>
					</div>
					
				</div>
				<div class="row mt-3">
					<div class="col-md-12">
					  <label class="form-label">Projet lié</label>
					   <select name="projet_id" class="form-select @error('projet') is-invalid @enderror">
							<option value="">-- Sélectionner le projet --</option>
							@foreach($projets as $projet)
								<option value="{{ $projet->id }}">
									{{ $projet->intitule }}
								</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-12">
						<label class="form-label">Zones d'intervention</label>
						<input id="zone_ids" name="zone_ids" type="hidden" class="form-control" readonly value=""/>
						<div class="input-group">
							<input id="zone_names" name="zone_names" type="text" class="form-control" readonly value="" onclick="showZone();"/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary" id="menuBtn" href="#" onclick="showZone(); return false;"><i class="fa fa-search"></i></button>
							</span>
						</div>
						
						<div id="zoneContent" class="zoneContent" style="display:none;">
							<ul id="liste_zone" class="ztree" style="margin-top:0;"></ul>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-12">
						<label class="form-label">Positionnement stratégique</label>
						<input id="chaine_logique_ids" name="chaine_logique_ids" type="hidden" class="form-control" readonly value=""/>
						<div class="input-group">
							<input id="chaine_logique_names" name="chaine_logique_names" type="text" class="form-control" readonly value="" onclick="showChaineLogique();"/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary" id="menuBtn" href="#" onclick="showChaineLogique(); return false;"><i class="fa fa-search"></i></button>
							</span>
						</div>
						
						<div id="chaineLogiqueContent" class="chaineLogiqueContent" style="display:none;">
							<ul id="liste_chaine_logique" class="ztree" style="margin-top:0;"></ul>
						</div>
					</div>
				</div>
			  </div>
			  
		  </div>
        </div>
		
		
		<!-- Boutons -->
		<div class="mt-3 mb-3 text-right">
			<a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
		</div>
		</form>
      </div>
    </div>
	<script>
	$(document).ready(function() {
		function calculerDureeMois() {
			let dateDebut = null;
			let dateFin = null;
			const statut = $("#statut_projet_id").val();

			// Projet approuvé mais non exécuté
			if (statut == "2") {
				dateDebut = $("#date_debut_prevue").val();
				dateFin = $("#date_fin_prevue").val();
			}

			// Projet en exécution
			else if (statut == "3") {
				dateDebut = $("#date_approbation").val();

				const dateClotureProrogation =
					$("#date_cloture_prorogation").val();

				if (dateClotureProrogation) {
					dateFin = dateClotureProrogation;
				} else {
					dateFin = $("#date_fin_effective").val();
				}
			}

			if (!dateDebut || !dateFin) {
				$("#duree").val('');
				return;
			}

			const [anneeDebut, moisDebut, jourDebut] =
				dateDebut.split('-').map(Number);

			const [anneeFin, moisFin, jourFin] =
				dateFin.split('-').map(Number);

			const debut = new Date(anneeDebut, moisDebut - 1, jourDebut);
			const fin = new Date(anneeFin, moisFin - 1, jourFin);

			if (fin < debut) {
				$("#duree").val('');
				return;
			}

			let mois = (fin.getFullYear() - debut.getFullYear()) * 12;
			mois += fin.getMonth() - debut.getMonth();

			if (fin.getDate() < debut.getDate()) {
				mois--;
			}

			$("#duree").val(mois);
		}
	
		function calculerDureeProrogation() {
			const dateDebut = $("#date_prorogation").val();
			const dateFin = $("#date_cloture_prorogation").val();

			if (!dateDebut || !dateFin) {
				$("#duree_prorogation").val('');
				return;
			}

			// Conversion fiable des dates YYYY-MM-DD
			const [anneeDebut, moisDebut, jourDebut] = dateDebut.split('-').map(Number);
			const [anneeFin, moisFin, jourFin] = dateFin.split('-').map(Number);

			const debut = new Date(anneeDebut, moisDebut - 1, jourDebut);
			const fin = new Date(anneeFin, moisFin - 1, jourFin);

			// Vérifie que la date de fin est postérieure à la date de début
			if (fin < debut) {
				$("#duree_prorogation").val('');
				return;
			}

			let mois = (fin.getFullYear() - debut.getFullYear()) * 12;
			mois += fin.getMonth() - debut.getMonth();

			// Le dernier mois n'est pas complet
			if (fin.getDate() < debut.getDate()) {
				mois--;
			}
			$("#duree_prorogation").val(mois);
		}
		
		$.fn.zTree.init($("#liste_zone"), settingZone, zNodesZone);
		$.fn.zTree.init($("#liste_secteur"), settingSecteur, zNodesSecteur);
		$.fn.zTree.init($("#liste_bailleur"), settingBailleur, zNodesBailleur);
		$.fn.zTree.init($("#liste_chaine_logique"), settingChaineLogique, zNodesChaineLogique);
		
		$("#date_debut_prevue, #date_fin_prevue, #date_approbation, #date_fin_effective, #date_cloture_prorogation").on("change", calculerDureeMois);
		$("#date_prorogation, #date_cloture_prorogation").on("change", calculerDureeProrogation);

		// Gestion propre de la Prorogation via Radio
		$('input[name="prorogation_check"]').on('change', function () {
			if ($(this).val() === 'Oui') {
				$('.prorogation').removeClass('d-none').hide().slideDown();
			} else {
				$('.prorogation').slideUp(function() {
					$(this).addClass('d-none');
				});
				$('#date_prorogation, #date_cloture_prorogation, #duree_prorogation').val('');
			}
		});

		// Événement de changement de Statut corrigé
		$('#statut_projet_id').change(function(){
			var statut = $(this).val();

			// 1. On commence par cacher tous les blocs conditionnels proprement
			//$('.execution, #prorogation_check, .prorogation, .formulation, .initialisation').addClass('d-none');
			$('.execution,#prorogation_check,.prorogation,.formulation').addClass('d-none');

			// 2. On applique les règles selon le statut choisi
			if(statut == "1") // Initialisation / Idée
			{
				$('.initialisation').removeClass('d-none');
				$('.execution,#prorogation_check, .prorogation, .formulation').addClass('d-none');
				$("#div_cout").removeClass("col-md-3 col-md-4 col-md-12").addClass("col-md-6");
				//$("#div_cout_devise").removeClass("col-md-3 col-md-4 col-md-6").addClass("col-md-12");
			}
			else if(statut == 2) // Formulation / Approuvé non exécuté
			{
				$("#div_cout").removeClass("col-md-4 col-md-6 col-md-12").addClass("col-md-3");
				//$("#div_cout_devise").removeClass("col-md-3 col-md-4 col-md-6").addClass("col-md-12");
				$('.formulation').removeClass('d-none');
				$('.execution,#prorogation_check, .prorogation, .initialisation').addClass('d-none');
			}
			else if(statut >= 3) // En exécution
			{
				$("#div_duree").removeClass("col-md-4 col-md-6 col-md-12").addClass("col-md-3");
				//$("#div_cout_devise").removeClass("col-md-3 col-md-4 col-md-12").addClass("col-md-6");
				$("#div_cout").removeClass("col-md-3 col-md-4 col-md-12").addClass("col-md-6");
				$('.execution, #prorogation_check').removeClass('d-none');

				// Si le radio prorogation est déjà sur "Oui", on affiche aussi les champs associés
				if ($('#prorogation_check_oui').is(':checked')) {
					$('.prorogation').removeClass('d-none');
				}
			}
		});
		
		// Déclencher le changement au chargement initial si une valeur est pré-sélectionnée
		$('#statut_projet_id').trigger('change');
	});
	</script>
  </div>
  
@endsection
