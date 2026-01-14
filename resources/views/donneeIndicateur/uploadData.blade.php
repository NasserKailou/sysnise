@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Import données indicateurs</strong>
		  </div>
		  <div class="card-body">
			<form  action="{{ route('donnee_indicateurs.uploadData') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="form-group">
					<label for="file">Selectionner le fichier <span class="text-danger">*</span></label>
					<br/>
					<input type="file" name="file"  required class="form-control filestyle" data-btnClass="btn-primary">
				</div>
				
				<div class="form-group text-right mb-0">
					<button class="btn btn-primary waves-effect waves-light mr-1" type="submit">Valider</button>
					<button data-dismiss="modal" class="btn btn-danger waves-effect">Annuler</button>
				</div>

			</form>
		  </div>
		</div>
	  </div>
	  
    </div>
</div>

@endsection