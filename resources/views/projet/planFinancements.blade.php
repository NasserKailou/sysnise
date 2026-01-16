@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<style>
		.ztree li span.node_name {
				white-space: normal; /* autorise le retour à la ligne */
				display: inline-block; /* garde l'alignement avec l'icône */
				word-break: break-word; /* coupe les mots trop longs */
			}
		#composanteContent {
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

		#composanteContent ul li {
			padding: 6px 10px;
			cursor: pointer;
		}
		#composanteContent ul li:hover {
			background-color: #e9ecef;
		}
	</style>
	<script type="text/javascript">
		var zNodesComposante = [
			{ id:0, pId:0, name:"/", open: true}
		];
		
		@foreach($composantes as $composante)
			zNodesComposante.push({
				id: {{ $composante->id }},
				pId: {{ $composante->composante_id ?? 0 }},
				name: @json($composante->intitule)
			});
		@endforeach
		
		var settingComposante = {
			check: {
				enable: true,
				chkStyle: "radio",     // passage en mode choix unique
				radioType: "all"       // un seul choix possible sur tout l’arbre
				// radioType: "level"  // (optionnel) un seul choix par niveau
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
				beforeClick: beforeClickComposante,
				onCheck: onCheckComposante
			}
		};
		
		function beforeClickComposante(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_composante");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		function onCheckComposante(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_composante"),
			nodes = zTree.getCheckedNodes(true),
			composante_names = "";composante_ids = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				composante_names += nodes[i].name + ",";
				composante_ids += nodes[i].id + ",";
			}
			if (composante_names.length > 0 ){
				composante_names = composante_names.substring(0, composante_names.length-1);
				composante_ids = composante_ids.substring(0, composante_ids.length-1);
				}
			var cityObj_names = $("#composante_names");
				cityObj_ids = $("#composante_ids");
			cityObj_names.attr("value", composante_names);
			cityObj_ids.attr("value", composante_ids);
		}

		function showComposante() {
			var cityObj = $("#composante_names");
			var cityOffset = $("#composante_names").offset();
			$("#composanteContent").slideDown("fast");

			$("body").bind("mousedown", onBodyDown);
		}
		function hideComposante() {
			$("#composanteContent").fadeOut("fast");
			$("body").unbind("mousedown", onBodyDown);
		}
		function onBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "composante_names" || event.target.id == "composanteContent" || $(event.target).parents("#composanteContent").length>0)) {
				hideComposante();
			}
		}
		
	</script>
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Plan de Financement du projet : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.planFinancements.store',['projet' => $projet->id]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
							<label class="form-label">Composante 
								<span style="color: red;">*</span>
							</label>
							<input id="composante_ids" name="composante_ids" type="hidden" class="form-control" readonly value=""/>
							<div class="input-group">
								<input id="composante_names" name="composante_names" type="text" class="form-control" readonly value="" onclick="showComposante();" required />
								<span class="input-group-append">
								  <button type="button" class="btn btn-sm btn-primary" id="menuBtn" href="#" onclick="showComposante(); return false;"><i class="fa fa-search"></i></button>
								</span>
							</div>
							
							<div id="composanteContent" class="composanteContent" style="display:none;">
								<ul id="liste_composante" class="ztree" style="margin-top:0;"></ul>
							</div>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Source de Financement 
							<span style="color: red;">*</span>
						  </label>
						   <select name="source_financement_id" class="form-select @error('Etude') is-invalid @enderror" required>
								<option value="">-- Sélectionner une source de financement --</option>
								@foreach($sourceFinancements as $source)
									<option value="{{ $source->id }}">
										{{ $source->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Nature Financement 
							<span style="color: red;">*</span>
						  </label>
						   <select name="nature_financement_id" class="form-select @error('natureFinancement') is-invalid @enderror" required>
								<option value="">-- Sélectionner une nature --</option>
								@foreach($natureFinancements as $nature)
									<option value="{{ $nature->id }}">
										{{ $nature->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Bailleur 
							<span style="color: red;">*</span>
						  </label>
						   <select name="bailleur_id" class="form-select @error('PFT') is-invalid @enderror" required>
								<option value="">-- Sélectionner un Bailleur --</option>
								@foreach($bailleurs as $bailleur)
									<option value="{{ $bailleur->id }}">
										{{ $bailleur->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Statut Financement 
							<span style="color: red;">*</span>
						  </label>
						   <select name="statut_financement_id" class="form-select @error('statutFinancement') is-invalid @enderror" required>
								<option value="">-- Sélectionner un statut --</option>
								@foreach($statutFinancements as $statut)
									<option value="{{ $statut->id }}">
										{{ $statut->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Catégorie de dépense 
							<span style="color: red;">*</span>
						  </label>
						   <select name="categorie_depense_id" class="form-select @error('categorieDepense') is-invalid @enderror" required>
								<option value="">-- Sélectionner une catégorie --</option>
								@foreach($categorieDepenses as $categorie)
									<option value="{{ $categorie->id }}">
										{{ $categorie->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Montant (FCFA) 
							<span style="color: red;">*</span>
						  </label>
						  <input name="montant" type="number" class="form-control" required>
						</div>
						
					</div>
				</div>
				<div class="mt-3 text-end">
					<a href="{{ route('projets.show', $projet->id) }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
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
                    <strong>Financements du projet</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Composante</th>
								<th class="text-left">Bailleur</th>
								<th class="text-left">Nature</th>
								<th class="text-left">Coût</th>
								<th class="text-left">Mont. Budgétisé</th>
								<th class="text-left">Mont. PTBA</th>
								<th class="text-left">Mont. Dépensé</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->planFinancements as $financement)
                            <tr>
                                <td class="text-left">{{ $financement->pivot->composante->intitule ?? '-'  }}</td>
								<td class="text-left">{{ $financement->pivot->bailleur->intitule ?? '-' }}</td>
								<td class="text-left">{{ $financement->pivot->natureFinancement->intitule ?? '-' }}</td>
								<td class="text-left">{{ $financement->pivot->montant ?? '-' }}</td>
                                
								@php
									$planFinancement = \App\Models\PlanFinancement::where([
										'projet_id'             => $projet->id,
										'source_financement_id' => $financement->id,
										'bailleur_id'           => $financement->pivot->bailleur->id,
										'statut_financement_id' => $financement->pivot->statutFinancement->id,
										'nature_financement_id' => $financement->pivot->natureFinancement->id,
										'composante_id'         => $financement->pivot->composante->id,
										'categorie_depense_id'  => $financement->pivot->categorieDepense->id,
										
									])->first();
								@endphp
								<td class="text-left">{{ $planFinancement?->budgetsAnnuels()->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $planFinancement?->budgetsAnnuelsPrevus()->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $planFinancement?->budgetsAnnuelsDepenses()->sum('montant') ?? 0  }}</td>
								
								<td class="text-center table-icons">
                                    <a href="{{ route('projets.planFinancements.edit', [$projet->id,$financement->pivot->composante_id,$financement->pivot->source_financement_id,$financement->pivot->bailleur_id,$financement->pivot->categorie_depense_id,$financement->pivot->nature_financement_id,$financement->pivot->statut_financement_id]) }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier"><i class="fa fa-edit"></i></a>
									<a href="{{ route('projets.planFinancements.budgetAnnuel', [$projet->id,$financement->pivot->composante_id,$financement->pivot->source_financement_id,$financement->pivot->bailleur_id,$financement->pivot->categorie_depense_id,$financement->pivot->nature_financement_id,$financement->pivot->statut_financement_id]) }}" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant budgétisé"><i class="fa fa-hand-holding-dollar"></i></a>
									<a href="{{ route('projets.planFinancements.budgetAnnuelPrevu', [$projet->id,$financement->pivot->composante_id,$financement->pivot->source_financement_id,$financement->pivot->bailleur_id,$financement->pivot->categorie_depense_id,$financement->pivot->nature_financement_id,$financement->pivot->statut_financement_id]) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant prévu"><i class="fa fa-money-bill-wave"></i></a>
									<a href="{{ route('projets.planFinancements.budgetAnnuelDepense', [$projet->id,$financement->pivot->composante_id,$financement->pivot->source_financement_id,$financement->pivot->bailleur_id,$financement->pivot->categorie_depense_id,$financement->pivot->nature_financement_id,$financement->pivot->statut_financement_id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant dépensé"><i class="fa fa-arrow-trend-down"></i></a>
									<form action="{{ route('projets.planFinancements.destroy',[$projet->id,$financement->pivot->composante_id,$financement->pivot->source_financement_id,$financement->pivot->bailleur_id,$financement->pivot->categorie_depense_id,$financement->pivot->nature_financement_id,$financement->pivot->statut_financement_id]) }}" method="POST" style="display:inline-block;">
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
		$.fn.zTree.init($("#liste_composante"), settingComposante, zNodesComposante);
		
	});
	</script>
</div>

@endsection