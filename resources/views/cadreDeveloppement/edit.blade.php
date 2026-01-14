@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<style>
		.ztree li span.node_name {
				white-space: normal; /* autorise le retour à la ligne */
				display: inline-block; /* garde l'alignement avec l'icône */
				word-break: break-word; /* coupe les mots trop longs */
			}
		#actionMajeureContent {
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

		#actionMajeureContent ul li {
			padding: 6px 10px;
			cursor: pointer;
		}
		#actionMajeureContent ul li:hover {
			background-color: #e9ecef;
		}
	</style>
	<script type="text/javascript">
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
	</script>
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Modification Cadre de Développement</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('cadre_developpements.update', $cadreDeveloppement->id) }}" method="POST">
			@csrf
			@method('PUT')
			<div class="row">
				<div class="row mb-3">
					<div class="col-md-6">
					  <label class="form-label">Intitulé</label>
					  <input name="intitule" type="text" class="form-control" value="{{ old('intitule', $cadreDeveloppement->intitule) }}">
					</div>
					<div class="col-md-6">
					  <label class="form-label">Structure Responsable</label>
					  <input name="structure_responsable" type="text" class="form-control" value="{{ old('structure_responsable', $cadreDeveloppement->structure_responsable) }}">
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-6">
					  <label class="form-label">Année de début</label>
					  <input name="annee_debut" type="text" class="form-control" value="{{ old('annee_debut', $cadreDeveloppement->annee_debut) }}">
					</div>
					<div class="col-md-6">
					  <label class="form-label">Année de fin</label>
					  <input name="annee_fin" type="text" class="form-control" value="{{ old('annee_fin', $cadreDeveloppement->annee_fin) }}">
					</div>
				</div>
				<div class="row mb-3">
						<div class="col-md-12">
							<label class="form-label">Cadre Stratégique d'alignement</label>
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
				<div class="row mb-3">
					<div class="col-md-12">
					  <label class="form-label">Description</label>
					  <textarea name="description"  class="form-control" rows="3">{{ old('description', $cadreDeveloppement->description) }}</textarea>
					</div>
				</div>
			  </div>
			  <!-- Boutons -->
			  <div class="mt-3 text-end">
				<a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
			  </div>
			</form>
		  </div>
        </div>
      </div>
    </div>
  </div>


<script>
$(document).ready(function() {
    $.fn.zTree.init($("#liste_chaine_logique"), settingChaineLogique, zNodesChaineLogique);
	
});
</script>
@endsection