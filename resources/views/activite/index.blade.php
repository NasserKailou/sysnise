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
		var zNodes = [
			{ id:0, pId:0, name:"/", open: true}
		];
		@foreach($zones as $zone)
			zNodes.push({
				id: {{ $zone->id }},
				pId: {{ $zone->zone_id ?? 0 }},
				name: @json($zone->intitule)
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
			/*$("#zoneContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			*/
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
			<form action="{{ route('cadre_logiques.activites.store', $cadre_logique->id) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-4">
						  <label class="form-label">Intitulé</label>
						  <input name="intitule" type="text" class="form-control">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Type activite</label>
						   <select id="type_activite_id" name="type_activite_id" class="form-select @error('typeActivite') is-invalid @enderror">
								<option value="">-- Sélectionner un type --</option>
								@foreach($typeActivites as $type)
									<option value="{{ $type->id }}">
										{{ $type->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-4">
						  <label class="form-label">Coût en FCFA (prévu)</label>
						  <input name="cout_prevu" type="number" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4">
						  <label class="form-label">Année début (prévu)</label>
						  <input name="annee_debut_prevu" type="number" class="form-control">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Année fin (prévu)</label>
						  <input name="annee_fin_prevu" type="number" class="form-control">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Durée des travaux (mois)</label>
						  <input name="duree_travaux" type="number" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4">
						  <label class="form-label">Responsable</label>
						  <input name="responsable" type="text" class="form-control">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Contact Responsable</label>
						  <input name="contact_responsable" type="text" class="form-control">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Statut activite</label>
						   <select id="statut_activite_id" name="statut_activite_id" class="form-select @error('statutActivite') is-invalid @enderror">
								<option value="">-- Sélectionner un statut --</option>
								@foreach($statutActivites as $statut)
									<option value="{{ $statut->id }}">
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
									<option value="{{ $activity->id }}">
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
				</div>
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
						  <label class="form-label">Description</label>
						  <textarea name="description"  class="form-control" rows="3"></textarea>
						</div>
					</div>
				</div>
				<div class="row infos_realisation">
					<div class="row mb-3">
						<div class="col-md-4">
						  <label class="form-label"> Date début réalisation</label>
						  <input name="date_debut_realisation" type="date" class="form-control">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Date fin réalisation</label>
						  <input name="date_fin_realisation" type="date" class="form-control">
						</div>
						<div class="col-md-4">
						  <label class="form-label">Coût de réalisation (FCFA)</label>
						  <input name="cout_realisation" type="number" class="form-control">
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
	  
	  <!-- Tableau des pièces jointes -->
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Activite</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Intitulé</th>
								<th class="text-left">Année début (prévu)</th>
								<th class="text-left">Année fin (prévu)</th>
								<th class="text-left">Durée pévue (mois)</th>
								<th class="text-left">Coût (prévu)</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activites as $activite)
                            <tr>
                                <td class="text-left">{{ $activite->intitule }}</td>
								<td class="text-left">{{ $activite->annee_debut_prevu }}</td>
								<td class="text-left">{{ $activite->annee_fin_prevu }}</td>
								<td class="text-left">{{ $activite->duree_travaux }}</td>
								<td class="text-left">{{ $activite->cout_prevu }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('cadre_logiques.activites.show',[$cadre_logique->id, $activite->id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Voir les détails"><i class="fa fa-eye"></i></a>
									<a href="{{ route('cadre_logiques.activites.edit',[$cadre_logique->id, $activite->id]) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('cadre_logiques.activites.destroy',[$cadre_logique->id, $activite->id]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimé" onclick="return confirm('Confirmer la suppression ?')"><i class="fa fa-trash"></i></button>
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
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/zTree.v3/3.5.42/js/jquery.ztree.all.min.js" integrity="sha512-7sGF7QJRDdvZna4GfwsdoY6a8jxCFZTAlL2OFKjmEXZ9mPwzHbKnwDiIy9RI1hYZv+XLtbOew+6slAJahxaH+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection