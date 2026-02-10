@extends('layouts.app')
@section('content')
<div class="container-fluid">

	<span style="color: red; font-size: 24px;">
		@if (session('error'))
        	{{ session('error') }}
    	@endif
</span>

<div class="row">
        <!-- Détails du Cadre de Développement -->
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Détails du Cadre de Développement</strong>
                </div>
                <div class="card-body">
                    <p><strong>Intitulé :</strong> {{ $cadreDeveloppement->intitule }}</p>
                    <p><strong>Structure Responsable :</strong> {{ $cadreDeveloppement->structure_responsable }}</p>
                    <p><strong>Période :</strong> {{ $cadreDeveloppement->annee_debut }} - {{ $cadreDeveloppement->annee_fin }}</p>
                    <p><strong>Coût total du financement :</strong> {{ $cadreDeveloppement->cout_total_financement }}</p>
					<p><strong>Description :</strong> {{ $cadreDeveloppement->description }}</p>
					<div class="d-flex gap-2 mt-3">
						<a href="{{ route('cadre_developpements.financementParBailleur', $cadreDeveloppement->id) }}"
						   class="btn btn-primary w-50"> 
							<i class="fa fa-building ms-1"></i>
							Coût par bailleur
						</a>

						<a href="{{ route('cadre_developpements.financementParResultat', $cadreDeveloppement->id) }}"
						   class="btn btn-primary w-50">
							<i class="fa fa-list"></i>
							Coût par résultat
						</a>
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
                    <form action="{{ route('cadre_developpements.piece_jointes.store', $cadreDeveloppement->id) }}" method="POST" enctype="multipart/form-data">
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
                            @foreach($cadreDeveloppement->pieceJointes as $piece)
                            <tr>
                                <td>{{ $piece->intitule }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ asset('storage/'.$piece->fichier) }}" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-download"></i></a>
									<!--<a href="{{ route('cadre_developpements.piece_jointes.edit', [$cadreDeveloppement->id, $piece->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>-->
                                    <form action="{{ route('cadre_developpements.piece_jointes.destroy', [$cadreDeveloppement->id, $piece->id]) }}" method="POST" style="display:inline-block;">
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
