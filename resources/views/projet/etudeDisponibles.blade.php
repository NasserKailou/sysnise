@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Etude Disponible : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.etudeDisponibles.store',['projet' => $projet->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-6">
						  <label class="form-label">Etude</label>
						   <select name="etude_id" class="form-select @error('Etude') is-invalid @enderror">
								<option value="">-- Sélectionner une étude --</option>
								@foreach($etudes as $etude)
									<option value="{{ $etude->id }}">
										{{ $etude->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
							<label class="form-label">Fichier</label>
							<input name="fichier" type="file" class="form-control" required>
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
                    <strong>Etudes Disponibles</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Etude</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->etudeDisponibles as $ED)
                            <tr>
                                <td class="text-left">{{ $ED->intitule }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ asset('storage/'.$ED->pivot->fichier) }}" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-download"></i></a>
									<form action="{{ route('projets.etudeDisponibles.destroy',[$projet->id,$ED->id]) }}" method="POST" style="display:inline-block;">
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

@endsection