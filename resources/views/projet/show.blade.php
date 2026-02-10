@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
        <div class="col-md-12 mb-2 text-center">
			<div class="btn-group mb-2" role="group" aria-label="Basic outlined example">
			  <a href="{{ route('projets.populationCibles', ['projet' => $projet->id]) }}" class="btn btn-outline-secondary">Population Cible</a>
			  <a href="#" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Etudes </a>
				<ul class="dropdown-menu">
				  <li><a class="dropdown-item" href="{{ route('projets.etudeDisponibles', ['projet' => $projet->id]) }}">Etudes Disponibles</a></li>
				  <li><a class="dropdown-item" href="{{ route('projets.etudeEnvisagees', ['projet' => $projet->id]) }}">Etudes Envisagées</a></li>
				  
				</ul>
			  <a href="#" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Cadre de résultat</a>
				<ul class="dropdown-menu">
				  @if (!$projet->cadreDeveloppement)<li><a class="dropdown-item" href="{{ route('projets.cadreProjet', ['projet' => $projet->id]) }}">Initialisation du cadre</a></li>@endif
				  @if ($projet->cadreDeveloppement)<li><a class="dropdown-item" href="{{ route('projets.editCadreProjet', ['projet' => $projet->id]) }}">Modification du cadre</a></li>@endif
				  @if ($projet->cadreDeveloppement)<li><a class="dropdown-item" href="{{ route('cadre_developpements.cadres_logiques.index', ['cadre_developpement' => $projet->cadreDeveloppement->id]) }}">Edition du cadre logique</a></li>@endif
				</ul>
			  <a href="{{ route('projets.composantes.index', ['projet' => $projet->id]) }}" class="btn btn-outline-secondary">Composantes et Produits</a>
			  <a href="#" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Situation Financière</a>
				<ul class="dropdown-menu">
				  <li><a class="dropdown-item" href="{{ route('projets.rechercheFinancements', ['projet' => $projet->id]) }}">Recherche Financement</a></li>
				  <li><a class="dropdown-item" href="{{ route('projets.financementParComposante', ['projet' => $projet->id]) }}">Financement par Composante</a></li>
				  <li><a class="dropdown-item" href="{{ route('projets.financementParCategorieDepense', ['projet' => $projet->id]) }}">Financement par Catégorie de dépense</a></li>
				  <li><a class="dropdown-item" href="{{ route('projets.financementParBailleur', ['projet' => $projet->id]) }}">Financement par Bailleur</a></li>
				  
				
				</ul>
			  <a href="{{ route('projets.clotureProjets', ['projet' => $projet->id]) }}"" class="btn btn-outline-secondary">Clôture </a>
			  @if ($projet->statutProjet->id == 4)<a href="#" class="btn btn-outline-secondary">Evaluation </a>@endif
			</div>
			
		</div>
	</div>
    <div class="row">
        <div class="col-md-12 col-lg-12">
		<!-- Détails du projet -->
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Détails du Projet</strong>
                </div>
                <div class="card-body">
                    <div class="row">
						<div class="row mb-3">
							<div class="col-md-6">
								<p><strong>Intitulé :</strong> {{ $projet?->intitule ?? '—' }}</p>
								<p><strong>Priorité :</strong> {{ $projet->priorite?->intitule  ?? '—' }}</p>
								<p><strong>Tutelle :</strong> {{ $projet->institutionTutelle?->intitule ?? '—' }}</p>
								<p><strong>Secteur :</strong> {{ $projet->secteur?->intitule ?? '—' }}</p>
								<p><strong>Direction/Agence :</strong> {{ $projet->direction_agence  ?? '—' }}</p>
								<p><strong>Contact :</strong> {{ $projet->contact ?? '—' }}</p>
								<p><strong>Projet liée :</strong> {{ $projet->parent?->intitule ?? '—' }}</p>
								<p><strong>Statut :</strong> {{ $projet->statutProjet?->intitule  ?? '—' }}</p>
							</div>
							<div class="col-md-6">
								<p><strong>Année Démarrage :</strong> {{ $projet->annee_demarrage ?? '—' }}</p>
								<p><strong>Date Début prévue :</strong> {{ $projet->date_debut_prevue }}</p>
								<p><strong>Date Fin prévue :</strong> {{ $projet->date_fin_prevue }}</p>
								<p><strong>Durée Travaux (prévu) :</strong> {{ $projet->duree }}</p>
								<p><strong>Coût :</strong> {{ $projet->cout }}</p>
								<p><strong>Zones d'intervention :</strong> {{ $zoneInterventions }}</p>
								<p><strong>Positionnements Strategiques :</strong> {{ $positionnementStrategiques }}</p>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>

        <!-- Formulaire pour pièces jointes -->
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Ajouter une Pièce Jointe</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('projets.piece_jointe_projets.store', $projet->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Intitulé</label>
                                <input name="intitule" type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fichier</label>
                                <input name="fichier" type="file" class="form-control" required>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tableau des pièces jointes -->
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Pièces Jointes</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Intitulé</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->pieceJointeProjets as $piece)
                            <tr>
                                <td>{{ $piece->intitule }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ asset('storage/'.$piece->fichier) }}" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-download"></i></a>
									<form action="{{ route('projets.piece_jointe_projets.destroy', [$projet->id, $piece->id]) }}" method="POST" style="display:inline-block;">
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
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#piecesTable').DataTable({
        "ordering": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        }
    });
});
</script>
@endpush
@endsection
