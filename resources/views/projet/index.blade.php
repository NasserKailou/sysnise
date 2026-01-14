@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Liste des Projets</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Intitulé</th>
								<th class="text-left">Statut</th>
								<th class="text-left">Priorité</th>
								<th class="text-left">Tutelle</th>
								<th class="text-left">Période</th>
								<th class="text-left">Coût</th>
								<th class="text-left">Zones</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projets as $projet)
                            <tr>
                                <td class="text-left">{{ $projet->intitule }}</td>
								<td class="text-left">{{ $projet->statutProjet->intitule }}</td>
								<td class="text-left">{{ $projet->priorite->intitule }}</td>
								<td class="text-left">{{ $projet->institutionTutelle->intitule }}</td>
								<td class="text-left">@if($projet->date_debut_prevue && $projet->date_fin_prevue){{ \Carbon\Carbon::parse($projet->date_debut_prevue)->format('d/m/Y') }}- {{ \Carbon\Carbon::parse($projet->date_fin_prevue)->format('d/m/Y')}}@endif</td>
								<td class="text-left">{{ $projet->cout }}</td>
								<td class="text-left">{{ $projet->zoneInterventions->pluck('intitule')->implode(', ') }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('projets.show', $projet->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Voir le détail"><i class="fa fa-eye"></i></a>
									<a href="{{ route('projets.edit', $projet->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('projets.destroy',$projet->id) }}" method="POST" style="display:inline-block;">
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