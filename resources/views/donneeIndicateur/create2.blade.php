@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
		<div class="col-md-12 col-lg-12">

			<h3>Matrice de saisie des données</h3>

			<form id="form-donnees" method="POST" action="{{ route('donnee_indicateurs.store') }}">
				@csrf

				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nature</th>
							<th>Indicateur</th>
							<th>Zone</th>
							<th>Période</th>
							<th>Source</th>
							<th>Unité</th>
							<th>Commentaire</th>
							<th>Valeur</th>
						</tr>
					</thead>

					<tbody>

					@foreach($natures as $nature)
						@foreach($indicateurs as $indicateur)
							@foreach($zones as $zone)
								@foreach($periodes as $periode)
									@foreach($sources as $source)
										@foreach($unites as $unite)
											@foreach($commentaires as $commentaire)

											<tr>
												<td>{{ $nature->intitule }}</td>
												<td>{{ $indicateur->intitule }}</td>
												<td>{{ $zone->intitule }}</td>
												<td>{{ $periode->intitule }}</td>
												<td>{{ $source->intitule }}</td>
												<td>{{ $unite->intitule }}</td>
												<td>{{ $commentaire->intitule }}</td>

												<td>
													<input type="number" name="valeur[]" class="form-control"
														   step="0.01" required>
												</td>

												{{-- Hidden fields --}}
												<input type="hidden" name="nature_donnee_id[]" value="{{ $nature->id }}">
												<input type="hidden" name="indicateur_id[]" value="{{ $indicateur->id }}">
												<input type="hidden" name="zone_id[]" value="{{ $zone->id }}">
												<input type="hidden" name="periode_id[]" value="{{ $periode->id }}">
												<input type="hidden" name="source_indicateur_id[]" value="{{ $source->id }}">
												<input type="hidden" name="unite_indicateur_id[]" value="{{ $unite->id }}">
												<input type="hidden" name="commentaire_valeur_indicateur_id[]" value="{{ $commentaire->id }}">

											</tr>

											@endforeach
										@endforeach
									@endforeach
								@endforeach
							@endforeach
						@endforeach
					@endforeach

					</tbody>
				</table>

				<button type="submit" class="btn btn-primary">Enregistrer</button>

			</form>
		</div>
	</div>
</div>



<script>
$(document).ready(function () {

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
        let clone = $("#table-donnees tbody tr:first").clone();

        clone.find("input").val("");
        clone.find("select").val("");

        $("#table-donnees tbody").append(clone);
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
