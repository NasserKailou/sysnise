@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Chaine de résultat : {{ $cadreDeveloppement->intitule }}</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Cadre résultat</th>
								<th class="text-left">Indicateur</th>
								<th class="text-left">Nature donnée</th>
								<th class="text-left">Zone</th>
								<th class="text-left">Désagrégation</th>
								<th class="text-left">Source</th>
								<th class="text-left">Unité</th>
								<th class="text-left">Période</th>
								<th class="text-left">Valeur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($CMR as $data)
                            <tr>
                                <td class="text-left">{{ $data->cadre_intitule }}</td>
								<td class="text-left">{{ $data->indicateur_intitule }}</td>
								<td class="text-left">{{ $data->nature_donnee_intitule }}</td>
								<td class="text-left">{{ $data->zone_intitule }}</td>
                                <td class="text-left">{{ $data->desagregations }}</td>
								<td class="text-left">{{ $data->source_intitule }}</td>
								<td class="text-left">{{ $data->unite_intitule }}</td>
								<td class="text-left">{{ $data->periode_intitule }}</td>
								<td class="text-left">{{ $data->valeur }}</td>
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