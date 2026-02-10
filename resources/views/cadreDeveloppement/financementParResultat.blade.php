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
			<strong>Financement par resultat du cadre de développement : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('cadre_developpements.financementParResultat.store',['cadre_developpement' => $cadreDeveloppement->id]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
							<label class="form-label">Résultat</label>
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
						
						<div class="col-md-12">
						  <label class="form-label">Montant (FCFA) 
							<span style="color: red;">*</span>
						  </label>
						  <input name="montant" type="number" class="form-control" required>
						</div>
						
					</div>
				</div>
				<div class="mt-3 text-end">
					<a href="{{ route('cadre_developpements.show', $cadreDeveloppement->id) }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
				</div>
			</form>
		  </div>
		</div>
	  </div>
	  
	  <!-- Tableau des pièces jointes -->
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Financements du cadre de développement</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Resultat</th>
								<th class="text-left">Coût</th>
								<th class="text-left">Montant mobilisé</th>
								<th class="text-left">Montant consommé</th>
								<th class="text-left">Montant à rechercher</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financementParResultats as $financement)
                            <tr>
                                <td class="text-left">{{ $financement->cadreLogique->intitule ?? '-'  }}</td>
								<td class="text-left">{{ $financement->montant ?? '-' }}</td>
                                <td class="text-left">{{ $financement?->montantMobilises()->whereNull('deleted_on')->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $financement?->montantConsommes()->whereNull('deleted_on')->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $financement?->montantRecherches()->whereNull('deleted_on')->sum('montant') ?? 0  }}</td>
								
								<td class="text-center table-icons">
                                    <a href="{{ route('cadre_developpements.financementParResultat.edit', [$cadreDeveloppement->id,$financement?->id]) }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier"><i class="fa fa-edit"></i></a>
									<a href="{{ route('cadre_developpements.financementParResultat.montantMobilise', [$cadreDeveloppement->id,$financement?->id]) }}" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant mobilisé"><i class="fa fa-money-bill-wave"></i></a>
									<a href="{{ route('cadre_developpements.financementParResultat.montantConsomme', [$cadreDeveloppement->id,$financement?->id]) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant consommé"><i class="fa fa-arrow-trend-down"></i></a>
									<a href="{{ route('cadre_developpements.financementParResultat.montantRecherche', [$cadreDeveloppement->id,$financement?->id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant à rechercher"><i class="fa fa-hand-holding-dollar"></i></a>
									<form action="{{ route('cadre_developpements.financementParResultat.destroy',[$cadreDeveloppement->id,$financement?->id]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	  
    </div>
	
	<script>
$(document).ready(function() {
    $.fn.zTree.init($("#liste_chaine_logique"), settingChaineLogique, zNodesChaineLogique);
	
});
</script>
</div>

@endsection