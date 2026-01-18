@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<style>
		.ztree li span.node_name {
				white-space: normal; /* autorise le retour à la ligne */
				display: inline-block; /* garde l'alignement avec l'icône */
				word-break: break-word; /* coupe les mots trop longs */
			}
		#zoneContent,#actionMajeureContent {
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

		#zoneContent ul li,#actionMajeureContent ul li {
			padding: 6px 10px;
			cursor: pointer;
		}
		#zoneContent ul li:hover,#actionMajeureContent ul li:hover {
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

			$("body").bind("mousedown", onBodyDown);
		}
		function hideZone() {
			$("#zoneContent").fadeOut("fast");
			$("body").unbind("mousedown", onBodyDown);
		}
		function onBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "zone_names" || event.target.id == "zoneContent" || $(event.target).parents("#zoneContent").length>0)) {
				hideZone();
			}
		}
		
		/* -----------------------------------------------*/
		var zNodesChaineLogique = [];
		@foreach($chaineLogiques as $chaine)
			zNodesChaineLogique.push({
				id: {{ $chaine->id }},
				pId: {{ $chaine->parent_id ?? 0 }},
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
		function calculerDuree() {
			const dateDebut = document.getElementById('date_debut_prevue').value;
			const dateFin   = document.getElementById('date_fin_prevue').value;

			// Si une des dates est vide, on ne calcule rien
			if (!dateDebut || !dateFin) {
				document.getElementById('duree').value = '';
				return;
			}

			const debut = new Date(dateDebut);
			const fin   = new Date(dateFin);

			// Vérification de cohérence
			if (fin < debut) {
				alert('La date de fin doit être postérieure à la date de début.');
				document.getElementById('duree').value = '';
				return;
			}

			const MS_PAR_JOUR = 1000 * 60 * 60 * 24;

			// Calcul de la durée en jours
			const duree = Math.round((fin - debut) / MS_PAR_JOUR) + 1;

			document.getElementById('duree').value = duree;
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
			<form action="{{ route('projets.update', $projet->id) }}" method="POST">
			@csrf
			@method('PUT')
			<div class="row">
				<div class="row mb-3">
					<div class="col-md-3">
					  <label class="form-label">Sigle 
						<span style="color: red;">*</span>
					  </label>
					  <input name="sigle" type="text" class="form-control" value="{{ old('sigle', $projet->sigle) }}" required>
					</div>
					<div class="col-md-3">
					  <label class="form-label">Intitulé 
						<span style="color: red;">*</span>
					  </label>
					  <input name="intitule" type="text" class="form-control" value="{{ old('intitule', $projet->intitule) }}" required>
					</div>
					<div class="col-md-3">
					  <label class="form-label">Statut Projet 
						<span style="color: red;">*</span>
					  </label>
					   <select id="statut_projet_id" name="statut_projet_id" class="form-select @error('projet') is-invalid @enderror" required>
							<option value="">-- Sélectionner le statut --</option>
							@foreach($statutProjets as $statut)
								<option value="{{ $statut->id }}"
									{{ old('statut_projet_id', $projet->statutProjet->id ?? '') == $statut->id ? 'selected' : '' }}>
									{{ $statut->intitule }}
								</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-3">
					  <label class="form-label">Priorité</label>
					   <select name="priorite_id" class="form-select @error('priorite') is-invalid @enderror">
							<option value="">-- Sélectionner la priorité --</option>
							@foreach($priorites as $priorite)
								<option value="{{ $priorite->id }}"
									{{ old('priorite_id', $projet->priorite->id ?? '') == $priorite->id ? 'selected' : '' }}>
									{{ $priorite->intitule }}
								</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-4">
					  <label class="form-label">Ministère/Institution de tutelle 
						<span style="color: red;">*</span>
					  </label>
					   <select name="institution_tutelle_id" class="form-select @error('priorite') is-invalid @enderror" required>
							<option value="">-- Sélectionner Ministères/Institutions --</option>
							@foreach($institutionTutelles as $institutionTutelle)
								<option value="{{ $institutionTutelle->id }}"
									{{ old('institution_tutelle_id', $projet->institutionTutelle->id ?? '') == $institutionTutelle->id ? 'selected' : '' }}>
									{{ $institutionTutelle->intitule }}
								</option>
							@endforeach
						</select>
					</div>
					
					<div class="col-md-4">
					  <label class="form-label">Contact</label>
					  <input name="contact" type="text" class="form-control" value="{{ old('contact', $projet->contact) }}">
					</div>
					<div class="col-md-4">
					  <label class="form-label">Secteur 
						<span style="color: red;">*</span>
					  </label>
					   <select name="secteur_id" class="form-select @error('secteur') is-invalid @enderror" required>
							<option value="">-- Sélectionner Secteur --</option>
							@foreach($secteurs as $secteur)
								<option value="{{ $secteur->id }}"
									{{ old('secteur_id', $projet->secteur->id ?? '') == $secteur->id ? 'selected' : '' }}>
									{{ $secteur->intitule }}
								</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row mb-3">
					<div id="annee_demarrage" class="col-md-3" style="display: {{ $projet->statutProjet->id == 1 ? 'block' : 'none' }}">
					  <label class="form-label">Année démarrage</label>
					  <input name="annee_demarrage" type="integer" class="form-control" value="{{ old('annee_demarrage', $projet->annee_demarrage) }}">
					</div>
					<div id="div_date_debut_prevue" class="col-md-3" style="display: {{ $projet->statutProjet->id == 2 ? 'block' : 'none' }}">
					  <label class="form-label">Date de début</label>
					  <input id="date_debut_prevue" name="date_debut_prevue" type="date" class="form-control" value="{{ old('date_debut_prevue', $projet->date_debut_prevue) }}">
					</div>
					<div id="div_date_fin_prevue" class="col-md-3" style="display: {{ $projet->statutProjet->id == 2 ? 'block' : 'none' }}">
					  <label class="form-label">Date de fin</label>
					  <input id="date_fin_prevue" name="date_fin_prevue" type="date" class="form-control" value="{{ old('date_fin_prevue', $projet->date_fin_prevue) }}">
					</div>
					<div  class="execution_projet col-md-3" style="display: {{ $projet->statutProjet->id == 3 ? 'block' : 'none' }}">
					  <label class="form-label">Date d’approbation </label>
					  <input name="date_approbation" type="date" class="form-control" value="{{ old('date_approbation', $projet->date_approbation) }}">
					</div>
					<div  class="execution_projet col-md-3" style="display: {{ $projet->statutProjet->id == 3 ? 'block' : 'none' }}">
					  <label class="form-label">Date de signature  </label>
					  <input name="date_signature" type="date" class="form-control" value="{{ old('date_signature', $projet->date_signature) }}">
					</div>
					<div  class="execution_projet col-md-3" style="display: {{ $projet->statutProjet->id == 3 ? 'block' : 'none' }}">
					  <label class="form-label">Date de mise en vigueur  </label>
					  <input name="date_mise_en_vigueur" type="date" class="form-control" value="{{ old('date_mise_en_vigueur', $projet->date_mise_en_vigueur) }}">
					</div>
					<div  class="execution_projet col-md-3" style="display: {{ $projet->statutProjet->id == 3 ? 'block' : 'none' }}">
					  <label class="form-label">Date de démarrage effectif</label>
					  <input name="date_demarrage_effectif" type="date" class="form-control" value="{{ old('date_demarrage_effectif', $projet->date_demarrage_effectif) }}">
					</div>
					<div class="col-md-3">
					  <label class="form-label">durée(mois)</label>
					  <input id="duree" name="duree" type="integer" class="form-control" value="{{ old('duree', $projet->duree) }}">
					</div>
					<div class="col-md-3">
					  <label class="form-label">coût du projet (FCFA)</label>
					  <input name="cout" type="integer" class="form-control" value="{{ old('cout', $projet->cout) }}">
					</div>
					
					<div class="col-md-9">
						<div class="mb-3">
							<label class="form-label">Coût du projet (DEVlSE)</label>
							<div class="input-group">
								<input type="number" class="form-control" name="cout_devise" placeholder="Saisir le montant" value="{{ old('cout_devise', $projet->cout_devise) }}">
								<select name="devise_id" class="form-select @error('priorite') is-invalid @enderror">
									<option value="">-- Sélectionner la dévise --</option>
									@foreach($devises as $devise)
										<option value="{{ $devise->id }}"
											{{ old('devise_id', $projet->devise->id ?? '') == $devise->id ? 'selected' : '' }}>
											{{ $devise->intitule }}
										</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="execution_projet col-md-4" style="display: {{ $projet->statut_projet_id == 3 ? 'block' : 'none' }}">
					  <label class="form-label">PTFs </label>
					  <input name="partenaires" type="text" class="form-control" value="{{ old('partenaires', $projet->partenaires) }}">
					</div>
					<div  class="execution_projet col-md-4" style="display: {{ $projet->statut_projet_id == 3 ? 'block' : 'none' }}">
					  <label class="form-label">période prorogation (si applicable)</label>
					  <input name="periode_prorogation" type="date" class="form-control" value="{{ old('periode_prorogation', $projet->periode_prorogation) }}">
					</div>
					<div  class="execution_projet col-md-4" style="display: {{ $projet->statut_projet_id == 3 ? 'block' : 'none' }}">
					  <label class="form-label">durée prorogation (si applicable)</label>
					  <input name="duree_prorogation" type="date" class="form-control" value="{{ old('duree_prorogation', $projet->duree_prorogation) }}">
					</div>
				</div>
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
						  <label class="form-label">Projet lié</label>
						   <select name="projet_id" class="form-select @error('projet') is-invalid @enderror">
								<option value="">-- Sélectionner le projet --</option>
								@foreach($projets as $cur_project)
									<option value="{{ $cur_project->id }}"
										{{ old('projet_id', $projet->id ?? '') == $cur_project->id ? 'selected' : '' }}>
										{{ $cur_project->intitule }}
									</option>
								@endforeach
							</select>
							
						</div>
					</div>
				</div>
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
							<label class="form-label">Zones d'intervention</label>
							<input id="zone_ids" name="zone_ids" type="hidden" class="form-control" readonly value="{{ old('zone_ids', $zoneIds ?? '') }}" />
							<div class="input-group">
								<input id="zone_names" name="zone_names" type="text" class="form-control" readonly  onclick="showZone();" value="{{ old('zone_names', $zoneNames ?? '') }}"/>
								<span class="input-group-append">
								  <button type="button" class="btn btn-sm btn-primary" id="menuBtn" href="#" onclick="showZone(); return false;"><i class="fa fa-search"></i></button>
								</span>
							</div>
							
							<div id="zoneContent" class="zoneContent" style="display:none;">
								<ul id="liste_zone" class="ztree" style="margin-top:0;"></ul>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
							<label class="form-label">Positionnement stratégique</label>
							<input id="chaine_logique_ids" name="chaine_logique_ids" type="hidden" class="form-control" readonly value="{{ old('chaine_logique_ids', $chaineLogiqueIds ?? '') }}"/>
							<div class="input-group">
								<input id="chaine_logique_names" name="chaine_logique_names" type="text" class="form-control" readonly onclick="showChaineLogique();" value="{{ old('chaine_logique_names', $chaineLogiqueNames ?? '') }}"/>
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
    $.fn.zTree.init($("#liste_zone"), settingZone, zNodesZone);
	$.fn.zTree.init($("#liste_chaine_logique"), settingChaineLogique, zNodesChaineLogique);
	$('#statut_projet_id').change(function(){
		if($(this).val() == 1)
		{
			$('#div_date_debut_prevue,#div_date_fin_prevue,.execution_projet').css('display','none');
			$('#annee_demarrage').css('display','block');
			
		}
		else if($(this).val() == 2)
		{
			$('#div_date_debut_prevue,#div_date_fin_prevue').css('display','block');
			$('#annee_demarrage,.execution_projet').css('display','none');
		}
		else if($(this).val() == 3)
		{
			$('.execution_projet').css('display','block');
			$('#annee_demarrage,#div_date_debut_prevue,#div_date_fin_prevue').css('display','none');
		}
	});
});
</script>
  </div>
  
@endsection
