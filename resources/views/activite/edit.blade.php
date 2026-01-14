@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<style>
		#zoneContent {
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

		#zoneContent ul li {
			padding: 6px 10px;
			cursor: pointer;
		}
		#zoneContent ul li:hover {
			background-color: #e9ecef;
		}
	</style>
	<script type="text/javascript">
		// On récupère les IDs des zones déjà associées (depuis Laravel)
		var selectedZoneIds = @json($zoneIds);
	
		var zNodes = [
			{ id:0, pId:0, name:"/", open: true}
		];
		@foreach($zones as $zone)
			zNodes.push({
				id: {{ $zone->id }},
				pId: {{ $zone->zone_id ?? 0 }},
				name: @json($zone->intitule),
				checked: selectedZoneIds.includes({{ $zone->id }}) //coche si déjà sélectionné
			});
		@endforeach
		
		var setting = {
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
				beforeClick: beforeClick,
				onCheck: onCheck
			}
		};
		
		function beforeClick(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_zone");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		function onCheck(e, treeId, treeNode) {
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
	</script>
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>{{ $cadre_logique->intitule }}</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('cadre_logiques.activites.update', [$cadre_logique->id, $activite->id]) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-4">
						  <label class="form-label">Intitulé</label>
						  <input name="intitule" type="text" class="form-control" value="{{ old('intitule', $activite->intitule) }}">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Type activite</label>
						   <select id="type_activite_id" name="type_activite_id" class="form-select @error('typeActivite') is-invalid @enderror">
								<option value="">-- Sélectionner un type --</option>
								@foreach($typeActivites as $type)
									<option value="{{ $type->id }}"
										{{ old('type_activite_id', $activite->type_activite_id ?? '') == $type->id ? 'selected' : '' }}>
										{{ $type->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-4">
						  <label class="form-label">Coût en FCFA (prévu)</label>
						  <input name="cout_prevu" type="number" class="form-control" value="{{ old('cout_prevu', $activite->cout_prevu) }}">
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4">
						  <label class="form-label">Année début (prévu)</label>
						  <input name="annee_debut_prevu" type="number" class="form-control" value="{{ old('annee_debut_prevu', $activite->annee_debut_prevu) }}">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Année fin (prévu)</label>
						  <input name="annee_fin_prevu" type="number" class="form-control" value="{{ old('annee_fin_prevu', $activite->annee_fin_prevu) }}">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Durée des travaux (mois)</label>
						  <input name="duree_travaux" type="number" class="form-control" value="{{ old('duree_travaux', $activite->duree_travaux) }}">
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4">
						  <label class="form-label">Responsable</label>
						  <input name="responsable" type="text" class="form-control" value="{{ old('responsable', $activite->responsable) }}">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Contact Responsable</label>
						  <input name="contact_responsable" type="text" class="form-control" value="{{ old('contact_responsable', $activite->contact_responsable) }}">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Statut activite</label>
						   <select id="statut_activite_id" name="statut_activite_id" class="form-select @error('statutActivite') is-invalid @enderror">
								<option value="">-- Sélectionner un statut --</option>
								@foreach($statutActivites as $statut)
									<option value="{{ $statut->id }}"
										{{ old('statut_activite_id', $activite->statut_activite_id ?? '') == $statut->id ? 'selected' : '' }}>
										{{ $statut->intitule }}
									</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
						  <label class="form-label">Activité liée</label>
						  <select name="activite_id" class="form-select">
								<option value="">-- Sélectionner l'activité --</option>
								@foreach($activites as $activity)
									<option value="{{ $activity->id }}"
										{{ old('activite_id', $activite->activite_id ?? '') == $activity->id ? 'selected' : '' }}>
										{{ $activity->intitule }}
									</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
							<label class="form-label">Zone</label>
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
						  <label class="form-label">Description</label>
						  <textarea name="description"  class="form-control" rows="3">{{ old('description', $activite->description) }}</textarea>
						</div>
					</div>
				</div>
				<div class="row infos_realisation">
					<div class="row mb-3">
						<div class="col-md-4">
						  <label class="form-label"> Date début réalisation</label>
						  <input name="date_debut_realisation" type="date" class="form-control" value="{{ old('date_debut_realisation', $activite->date_debut_realisation) }}">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Date fin réalisation</label>
						  <input name="date_fin_realisation" type="date" class="form-control" value="{{ old('date_fin_realisation', $activite->date_fin_realisation) }}">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Coût de réalisation (FCFA)</label>
						  <input name="cout_realisation" type="number" class="form-control" value="{{ old('cout_realisation', $activite->cout_realisation) }}">
						</div>
					</div>
				</div>
				<div class="mt-3 text-end">
					<a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
				</div>
			</form>
		  </div>
		</div>
	  </div>
	  
    </div>
	<script>
			
		$(document).ready(function () {
			$.fn.zTree.init($("#liste_zone"), setting, zNodes);
			$('#statut_activite_id').change(function(){
				if($(this).val() != 3)
				{
					$('.infos_realisation').css('display','none');
				}
				else
				{
					$('.infos_realisation').css('display','block');
				}
			});
		});
	</script>
</div>

@endsection