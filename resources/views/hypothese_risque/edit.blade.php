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
			<form action="{{ route('cadre_logiques.hypothese_risques.update', [$cadre_logique->id, $hypothese_risque->id]) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
						  <label class="form-label">Hypothèse</label>
						  <textarea name="hypothese"  class="form-control" rows="3">{{ old('intitule', $hypothese_risque->hypothese) }}</textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
						  <label class="form-label">Risque</label>
						  <textarea name="risque"  class="form-control" rows="3">{{ old('intitule', $hypothese_risque->risque) }}</textarea>
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
	  
    </div>
</div>

@endsection