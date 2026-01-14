@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>{{ $cadre_logique->intitule }}</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('cadre_logiques.hypothese_risques.store', $cadre_logique->id) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
						  <label class="form-label">Hypothèse</label>
						  <textarea name="hypothese"  class="form-control" rows="3"></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
						  <label class="form-label">Risque</label>
						  <textarea name="risque"  class="form-control" rows="3"></textarea>
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
                    <strong>Hypothèses et Risques</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Hypothèse</th>
								<th class="text-left">Risques</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hypotheses_risques as $hypothese_risque)
                            <tr>
                                <td class="text-left">{{ $hypothese_risque->hypothese }}</td>
								<td class="text-left">{{ $hypothese_risque->risque }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('cadre_logiques.hypothese_risques.edit',[$cadre_logique->id, $hypothese_risque->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('cadre_logiques.hypothese_risques.destroy',[$cadre_logique->id, $hypothese_risque->id]) }}" method="POST" style="display:inline-block;">
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