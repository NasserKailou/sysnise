@extends('layouts.app')
@section('content')
<div class="container-fluid">
	
    <div class="row">
	  <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Plan de Financement du projet : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.financementParCategorieDepense.store',['projet' => $projet->id]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
						  <label class="form-label">Catégorie de dépense 
							<span style="color: red;">*</span>
						  </label>
						   <select name="categorie_depense_id" id="categorieDepenseSelect" class="form-select @error('categorieDepense') is-invalid @enderror" required>
								<option value="">-- Sélectionner une catégorie --</option>
								@foreach($categorieDepenses as $categorie)
									<option value="{{ $categorie->id }}">
										{{ $categorie->intitule }}
									</option>
								@endforeach
								<option value="0">Autre à préciser</option>
							</select>
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
					<a href="{{ route('projets.show', $projet->id) }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
				</div>
			</form>
		  </div>
		</div>
	  </div>
	  
	  <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Plan de Financement</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Catégorie de dépense</th>
								<th class="text-left">Financement Total PAD</th>
								<th class="text-left">Financement annuel cumulé à date</th>
								<th class="text-left">Montant Budgetisé cumulé à date</th>
								<th class="text-left">Montant Dépensé cumulé à date</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($planFinancements as $financement)
                            <tr>
                                <td class="text-left">{{ $financement->categorieDepense->intitule ?? '-'  }}</td>
								<td class="text-left">{{ $financement->montant ?? '-' }}</td>
                                <td class="text-left">{{ $financement?->budgetsAnnuelsPrevus()->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $financement?->budgetsAnnuels()->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $financement?->budgetsAnnuelsDepenses()->sum('montant') ?? 0  }}</td>
								
								<td class="text-center table-icons">
                                    <a href="{{ route('projets.financementParCategorieDepense.edit', [$projet->id,$financement?->categorieDepense->id]) }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier"><i class="fa fa-edit"></i></a>
									<a href="{{ route('projets.planFinancements.budgetAnnuelPrevu', [$projet->id,$financement?->id]) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant prévu"><i class="fa fa-money-bill-wave"></i></a>
									<a href="{{ route('projets.planFinancements.budgetAnnuel', [$projet->id,$financement?->id]) }}" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant budgétisé"><i class="fa fa-hand-holding-dollar"></i></a>
									<a href="{{ route('projets.planFinancements.budgetAnnuelDepense', [$projet->id,$financement?->id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant dépensé"><i class="fa fa-arrow-trend-down"></i></a>
									<form action="{{ route('projets.financementParCategorieDepense.destroy',[$projet->id,$financement?->categorieDepense->id]) }}" method="POST" style="display:inline-block;">
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

<div class="modal fade" id="addCategorieModal" tabindex="-1" aria-labelledby="addCategorieModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategorieModalLabel">Nouvelle catégorie de dépense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content-body p-3">
                <form id="ajaxCategorieForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Intitulé de la catégorie</label>
                        <input name="intitule" id="newCategorieIntitule" type="text" class="form-control" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Détecter le choix "Autre à préciser"
    $('#categorieDepenseSelect').on('change', function() {
        if ($(this).val() === '0') {
            // Afficher le modal Bootstrap
            var myModal = new bootstrap.Modal(document.getElementById('addCategorieModal'));
            myModal.show();
        }
    });

    // Envoi du formulaire de création de catégorie en AJAX
    $('#ajaxCategorieForm').on('submit', function(e) {
        e.preventDefault();

        let intitule = $('#newCategorieIntitule').val();
        let token = $("input[name='_token']").val();

        $.ajax({
            url: "{{ route('categorie_depenses.store') }}",
            type: "POST",
            data: {
                _token: token,
                intitule: intitule
            },
            success: function(response) {
                if(response.success) {
                    // 1. Ajouter la nouvelle catégorie au select juste avant "Autre à préciser"
                    $('#categorieDepenseSelect option[value="0"]').before(
                        `<option value="${response.data.id}" selected>${response.data.intitule}</option>`
                    );
                    
                    // 2. Réinitialiser le formulaire et masquer le modal
                    $('#ajaxCategorieForm')[0].reset();
                    var modalElement = document.getElementById('addCategorieModal');
                    var modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
                } else {
                    alert("Une erreur est survenue lors de l'enregistrement.");
                }
            },
            error: function(xhr) {
                alert("Erreur serveur : Impossible d'ajouter la catégorie de dépense.");
            }
        });
    });

    // Si le modal est fermé sans enregistrement, on réinitialise la sélection
    $('#addCategorieModal').on('hidden.bs.modal', function () {
        if($('#categorieDepenseSelect').val() === '0'){
            $('#categorieDepenseSelect').val('');
        }
    });
});
</script>
@endsection