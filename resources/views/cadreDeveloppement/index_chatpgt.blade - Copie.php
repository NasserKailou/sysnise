@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="form-section">
                <div class="section-title d-flex justify-content-between">
                    <span>Liste des cadres de développement</span>
                    <a href="{{ url('/cadre_developpements/create/') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Nouveau
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="dataTable table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Intitulé</th>
                                <th>Responsable</th>
                                <th>Période</th>
                                <th class="text-center table-icons">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cadreDeveloppements as $cadre)
                            <tr>
                                <td>{{ $cadre->intitule }}</td>
                                <td>{{ $cadre->structure_responsable }}</td>
                                <td>{{ $cadre->annee_debut }} - {{ $cadre->annee_fin }}</td>
                                <td class="text-center table-icons">

                                    <a href="{{ route('cadre_developpements.show', $cadre->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="{{ route('cadre_developpements.cadres_logiques.index', $cadre->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-list"></i>
                                    </a>

                                    <a href="{{ route('cadre_developpements.edit', $cadre->id) }}" class="btn btn-success btn-sm">
                                        <i class="fa fa-pen"></i>
                                    </a>

                                    <a href="{{ route('export_cadre_data_template', $cadre->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-download"></i>
                                    </a>

                                    <!-- Modal dynamique -->
                                    <button class="btn btn-dark btn-sm open-modal"
                                        data-id="{{ $cadre->id }}"
                                        data-intitule="{{ $cadre->intitule }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewAssociationsModal">
                                        <i class="fa fa-list-alt"></i>
                                    </button>

                                    <!-- Association -->
                                    <button class="btn btn-secondary btn-sm open-association-modal"
                                        data-id="{{ $cadre->id }}"
                                        data-intitule="{{ $cadre->intitule }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#associationModal">
                                        <i class="fa fa-link"></i>
                                    </button>

                                    <form action="{{ route('cadre_developpements.destroy', $cadre->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet élément ?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
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

<!-- ===================== -->
<!-- MODALE UNIQUE (VIEW) -->
<!-- ===================== -->
<div class="modal fade" id="viewAssociationsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                Chargement...
            </div>
        </div>
    </div>
</div>

<!-- ===================== -->
<!-- MODALE UNIQUE (ASSOCIER) -->
<!-- ===================== -->
<div class="modal fade" id="associationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('cadre_developpements.associer') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 id="associationTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="cadre_developpement_id" id="cadre_id">

                    <div class="mb-3">
                        <label class="form-label">Utilisateur</label>
                        <select class="form-select" name="user_id" required>
                            <option value="">Sélectionner un utilisateur</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="associationWarning"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Associer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Modal VIEW
    document.querySelectorAll(".open-modal").forEach(btn => {
        btn.addEventListener("click", function () {

            let id = this.dataset.id;
            let intitule = this.dataset.intitule;

            document.getElementById("modalTitle").innerText =
                'Associations de "' + intitule + '"';

            fetch(`/cadre_developpements/${id}/associations`)
                .then(res => res.text())
                .then(data => {
                    document.getElementById("modalContent").innerHTML = data;
                });
        });
    });

    // Modal ASSOCIER
    document.querySelectorAll(".open-association-modal").forEach(btn => {
        btn.addEventListener("click", function () {

            let id = this.dataset.id;
            let intitule = this.dataset.intitule;

            document.getElementById("associationTitle").innerText =
                'Associer "' + intitule + '" à un utilisateur';

            document.getElementById("cadre_id").value = id;
        });
    });

});
</script>
@endsection
