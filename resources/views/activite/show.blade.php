@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Détails du Cadre de Développement -->
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Détails du Activite</strong>
                </div>
                <div class="card-body">
					<div class="row">
						<div class="row mb-3">
							<div class="col-md-6">
								<p><strong>Intitulé :</strong> {{ $activite?->intitule ?? '—' }}</p>
								<p><strong>Type activite :</strong> {{ $activite->typeActivite?->intitule ?? '—' }}</p>
								<p><strong>Année Début (prévu) :</strong> {{ $activite->annee_debut_prevu }}</p>
								<p><strong>Année Fin (prévu) :</strong> {{ $activite->annee_fin_prevu }}</p>
								<p><strong>Durée Travaux (prévu) :</strong> {{ $activite->duree_travaux }}</p>
								
							</div>
							<div class="col-md-6">
								<p><strong>Coût en FCFA (prévu) :</strong> {{ $activite->cout_prevu }}</p>
								<p><strong>Zones :</strong> {{ $zonesActivite }}</p>
								<p><strong>Responsable :</strong> {{ $activite->responsable }}</p>
								<p><strong>Contact Responsable :</strong> {{ $activite->contact_responsable }}</p>
								<p><strong>Statut activite :</strong> {{ $activite->statutActivite?->intitule ?? '—' }}</p>
								<p><strong>Activité liée :</strong> {{ $activite->parent?->intitule ?? '—' }}</p>
								
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-12">
								<p><strong>Description :</strong> {{ $activite->description }}</p>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-12">
								<p><strong>Date début réalisation :</strong> {{ $activite->date_debut_realisation }}</p>
								<p><strong>Date fin réalisation :</strong> {{ $activite->date_fin_realisation }}</p>
								<p><strong>Coût de réalisation (FCFA) :</strong> {{ $activite->cout_realisation }}</p>
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
                    <form action="{{ route('activites.piece_jointe_activites.store', $activite->id) }}" method="POST" enctype="multipart/form-data">
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
                            @foreach($activite->pieceJointeActivites as $piece)
                            <tr>
                                <td>{{ $piece->intitule }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ asset('storage/'.$piece->fichier) }}" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-download"></i></a>
									<form action="{{ route('activites.piece_jointe_activites.destroy', [$activite->id, $piece->id]) }}" method="POST" style="display:inline-block;">
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
