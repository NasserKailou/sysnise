@extends('layouts.app')
@section('content')
<style>

</style>

<div class="container-fluid">
    <div class="row">
		<div class="col-md-12 col-lg-12">

			<h5>Saisie des données</h5>

			<form id="form-donnees" method="POST" action="{{ route('donnee_indicateurs.store') }}">
				@csrf
				<div style="overflow-x: auto; width: 100%;">
				<table id="table-donnees" class="table table-bordered">
					<thead>
						<tr>
							<th>Nature</th>
							<th>Indicateur</th>
							<th>Zone</th>
							<th>Désag.</th>
							<th>Période</th>
							<th>Source</th>
							<th>Unité</th>
							<th>Commentaire</th>
							<th>Valeur</th>
							<th class="text-center table-icons">Actions</th>
						</tr>
					</thead>

					<tbody>

						{{-- Modèle de ligne (sera cloné) --}}
						<tr class="ligne">
							<td>
								<select name="nature_donnee_id[]" class="form-control select2" required style="width:100px">
									<option value="">----</option> 
									@foreach($natures as $n)
										<option value="{{ $n->id }}">{{ $n->intitule }}</option>
									@endforeach
								</select>
							</td>

							<td>
								<select name="indicateur_id[]" class="form-control select2" required style="width:180px">
									<option value="">----</option>
									@foreach($indicateurs as $i)
										<option value="{{ $i->id }}">{{ $i->intitule }}</option>
									@endforeach
								</select>
							</td>

							<td>
								<select name="zone_id[]" class="form-control select2" required style="width:100px">
									<option value="">----</option>
									@foreach($zones as $z)
										<option value="{{ $z->id }}">{{ $z->intitule }}</option>
									@endforeach
								</select>
							</td>
							
							<td>
								<select name="desagregation_id[]" class="form-control select2" required style="width:100px">
									<option value="">----</option>
									@foreach($desagregations as $d)
										<option value="{{ $d->id }}">{{ $d->intitule }}</option>
									@endforeach
								</select>
							</td>

							<td>
								<select name="periode_id[]" class="form-control select2" required style="width:80px">
									<option value="">----</option>
									@foreach($periodes as $p)
										<option value="{{ $p->id }}">{{ $p->intitule }}</option>
									@endforeach
								</select>
							</td>

							<td>
								<select name="source_indicateur_id[]" class="form-control select2" required style="width:180px">
									<option value="">----</option>
									@foreach($sources as $s)
										<option value="{{ $s->id }}">{{ $s->intitule }}</option>
									@endforeach
								</select>
							</td>

							<td>
								<select name="unite_indicateur_id[]" class="form-control select2" required style="width:80px">
									<option value="">----</option>
									@foreach($unites as $u)
										<option value="{{ $u->id }}">{{ $u->intitule }}</option>
									@endforeach
								</select>
							</td>

							<td>
								<select name="commentaire_valeur_indicateur_id[]" class="form-control select2" style="width:80px">
									<option value="">----</option>
									@foreach($commentaires as $c)
										<option value="{{ $c->id }}">{{ $c->intitule }}</option>
									@endforeach
								</select>
							</td>

							<td>
								<input type="number" step="any" name="valeur[]" class="form-control" required style="width:80px">
							</td>

							<td class="text-center table-icons">
								<span class="btn btn-sm btn-success btn-add"><i class="fa fa-plus"></i></span>
								<span class="btn btn-sm btn-danger btn-del"><i class="fa fa-remove"></i></span>
							</td>
						</tr>

					</tbody>
				</table>
				</div>
				<button type="submit" class="btn btn-primary">Enregistrer</button>

			</form>
		</div>
	</div>
</div>



<script>
$(document).ready(function () {

	$('.select2').select2();
    function refreshButtons() {
        $("#table-donnees tbody tr").each(function (index) {
            let btnAdd = $(this).find(".btn-add");
            let btnDel = $(this).find(".btn-del");

            if (index === $("#table-donnees tbody tr").length - 1) {
                btnAdd.show();
            } else {
                btnAdd.hide();
            }

            if ($("#table-donnees tbody tr").length === 1) {
                btnDel.hide();
            } else {
                btnDel.show();
            }
        });
    }
	
    // Ajouter une ligne
    $(document).on("click", ".btn-add", function () {
        let $lastRow = $('#table-donnees tbody tr:last');
		// 1. Détruire Select2 AVANT de cloner
		$lastRow.find('select.select2').each(function () {
			$(this).select2('destroy');
		});

		// 2. Cloner la ligne propre
		let $newRow = $lastRow.clone();

		// 3. Réinitialiser les champs dans la nouvelle ligne
		$newRow.find('input').val('');
		$newRow.find('select').val('');

		// 4. Réinstaller Select2 dans LES DEUX lignes (l’ancienne et la nouvelle)
		$lastRow.find('select.select2').select2();
		$newRow.find('select.select2').select2();

		// 5. Ajouter la nouvelle ligne
		$('#table-donnees tbody').append($newRow);
			refreshButtons();
			
		});

		// Supprimer une ligne
		$(document).on("click", ".btn-del", function () {
			$(this).closest("tr").remove();
			refreshButtons();
		});

    refreshButtons();
});
</script>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

