<div class="container-fluid">
    <div class="row">
		<div class="col-md-12 col-lg-12">

			<h5>Saisie des données</h5>

			<form id="form-donnees" method="POST" action="{{ route('donneeIndicateur.matriceSaisie.store') }}">
				@csrf
				<div style="overflow-x: auto; width: 100%;">
					<table class="table table-bordered table-sm">
						<thead>
							<tr>
								<th>Nature</th>
								<th>Indicateur</th>
								<th>Zone</th>
								<th>Source</th>
								<th>Unité</th>
								<th>Commentaire</th>

								@foreach($periodesData as $p)
									<th>{{ $p->intitule }}</th>
								@endforeach
							</tr>
						</thead>

						<tbody>
							@foreach($matrice as $m)

								@php
									$key = implode('_', [
										$m['nature_donnee_id'],
										$m['indicateur_id'],
										$m['zone_id'],
										$m['source_indicateur_id'],
										$m['unite_indicateur_id'],
										$m['commentaire_valeur_indicateur_id']
									]);
								@endphp

								<tr>
									<td>{{ $natureDonnees[$m['nature_donnee_id']] }}</td>
									<td>{{ $indicateursData[$m['indicateur_id']] }}</td>
									<td>{{ $zones[$m['zone_id']] }}</td>
									<td>{{ $sources[$m['source_indicateur_id']] }}</td>
									<td>{{ $unites[$m['unite_indicateur_id']] }}</td>
									<td>{{ $commentaires[$m['commentaire_valeur_indicateur_id']] }}</td>

									@foreach($periodesData as $p)
										<td>
											<input type="number"
												   class="form-control form-control-sm"
												   name="valeurs[{{ $key }}][{{ $p->id }}]"
												   value="">
										</td>
									@endforeach

								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<button type="submit" class="btn btn-primary">Enregistrer</button>

			</form>
		</div>
	</div>
</div>
