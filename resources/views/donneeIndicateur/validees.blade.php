@extends('layouts.app')

@section('content')
<div class="container-fluid p-3" style="background:#fff">
    <div class="row mb-3">
        <div class="col-md-12">
            <h4 class="mb-3">
                <i class="fas fa-check-double text-success"></i> Données Indicateurs Validées
            </h4>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-table"></i> Liste des Données Validées ({{ $donnees->total() }})
                </div>
                <div class="card-body">
                    @if($donnees->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Indicateur</th>
                                        <th>Zone</th>
                                        <th>Période</th>
                                        <th>Valeur</th>
                                        <th>Nature</th>
                                        <th>Source</th>
                                        <th>Unité</th>
                                        <th>Désagrégations</th>
                                        <th>Validé le</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($donnees as $donnee)
                                        <tr>
                                            <td>{{ $donnee->id }}</td>
                                            <td>{{ $donnee->indicateur->intitule ?? 'N/A' }}</td>
                                            <td>{{ $donnee->zone->intitule ?? 'N/A' }}</td>
                                            <td>{{ $donnee->periode->intitule ?? 'N/A' }}</td>
                                            <td><strong>{{ $donnee->valeur }}</strong></td>
                                            <td>{{ $donnee->natureDonnee->intitule ?? 'N/A' }}</td>
                                            <td>{{ $donnee->sourceIndicateur->intitule ?? 'N/A' }}</td>
                                            <td>{{ $donnee->uniteIndicateur->intitule ?? 'N/A' }}</td>
                                            <td>
                                                @if($donnee->desagregations->count() > 0)
                                                    <small>
                                                        {{ $donnee->desagregations->pluck('intitule')->implode(', ') }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $donnee->updated_at->format('d/m/Y H:i') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $donnees->links() }}
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> Aucune donnée validée pour le moment.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endsection
