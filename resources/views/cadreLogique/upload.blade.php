<html>
<head>
	<meta charset="utf-8" />
</head>
<body>
	<div> 
		<div class="modal fade" id="myModal" tabindex="-1">
		 	<div class="modal-dialog modal-lg">
		    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" >Import Cadre Logique</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
		      <div class="modal-body">
		     	<form  action="{{ route('cadre_developpements.cadres_logiques.upload',$cadreDeveloppement->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<input name="cadre_developpement_id" type="hidden" class="form-control" value="{{ $cadreDeveloppement->id }}">
						<label for="fichier">Selectionner le fichier <span class="text-danger">*</span></label>
						<br/>
						<input type="file" name="fichier"  required class="form-control filestyle" data-btnClass="btn-primary">
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
</body>
</html>
