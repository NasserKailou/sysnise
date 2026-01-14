@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Nouvelle désagrégation</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('desagregations.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
						  <label class="form-label">Intitulé</label>
						  <input name="intitule" type="text" class="form-control">
						</div>
						<div class="col-md-12">
						  <label class="form-label">type désagrégation</label>
						   <select name="type_desagregation_id" class="form-select @error('typeDesagregation') is-invalid @enderror">
								<option value="">-- Sélectionner un type --</option>
								@foreach($typeDesagregations as $type)
									<option value="{{ $type->id }}">
										{{ $type->intitule }}
									</option>
								@endforeach
							</select>
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
                    <strong>Désagrégations</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Intitulé</th>
								<th class="text-left">type</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($desagregations as $desagregation)
                            <tr>
                                <td class="text-left">{{ $desagregation->intitule }}</td>
								<td class="text-left">{{ $desagregation->typeDesagregation->intitule }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('desagregations.edit', $desagregation->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('desagregations.destroy',$desagregation->id) }}" method="POST" style="display:inline-block;">
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