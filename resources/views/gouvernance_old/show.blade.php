@extends('gouvernance.partials._layout')

@section('title', 'Gouvernance - ' . ($projet->name ?? $projet->id))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Gouvernance du projet : {{ $projet->name ?? $projet->id }}</h3>
        <div>
            <a href="{{ route('projets.gouvernance.edit', $projet) }}" class="btn btn-primary btn-sm">Modifier</a>
            <form action="{{ route('projets.gouvernance.destroy', $projet) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Supprimer définitivement la fiche gouvernance de ce projet ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold">I. Pilotage et audits</div>
        <div class="card-body">
            <h6 class="text-decoration-underline">3.1 Organe d'orientation/pilotage</h6>
            <p>
                Existe : <strong>{{ $gouvernance->organe_pilotage_existe ? 'Oui' : 'Non' }}</strong><br>
                Sessions prévues : <strong>{{ $gouvernance->nb_sessions_prevues ?? '-' }}</strong> —
                Sessions tenues : <strong>{{ $gouvernance->nb_sessions_tenues ?? '-' }}</strong>
            </p>

            <table class="table table-bordered table-sm">
                <thead class="table-light">
                <tr>
                    <th>Date session</th>
                    <th>Recommandations établies</th>
                    <th>Recommandations réalisées</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($gouvernance->sessions as $session)
                    <tr>
                        <td>{{ optional($session->date_session)->format('d/m/Y') }}</td>
                        <td>{{ $session->nb_recommandations_etablies }}</td>
                        <td>{{ $session->nb_recommandations_realisees }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted">Aucune session enregistrée.</td></tr>
                @endforelse
                </tbody>
            </table>

            <h6 class="text-decoration-underline mt-4">3.2 Audits</h6>
            <p>
                Comptes audités régulièrement : <strong>{{ $gouvernance->comptes_audites_regulierement ? 'Oui' : 'Non' }}</strong><br>
                @if ($gouvernance->commentaire_audit)
                    Commentaire : {{ $gouvernance->commentaire_audit }}
                @endif
            </p>

            <table class="table table-bordered table-sm">
                <thead class="table-light">
                <tr>
                    <th>Nb audits réalisés</th>
                    <th>Exercice comptable</th>
                    <th>Certifiés sans réserves ?</th>
                    <th>Recommandations établies</th>
                    <th>Recommandations réalisées</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($gouvernance->audits as $audit)
                    <tr>
                        <td>{{ $audit->nombre_audits_realises }}</td>
                        <td>{{ $audit->exercice_comptable }}</td>
                        <td>{{ $audit->comptes_certifies_sans_reserves ? 'Oui' : 'Non' }}</td>
                        <td>{{ $audit->nb_recommandations_etablies }}</td>
                        <td>{{ $audit->nb_recommandations_realisees }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted">Aucun audit enregistré.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold">II. Problèmes, solutions et recommandations</div>
        <div class="card-body">
            <h6 class="text-decoration-underline">IV.1 Problèmes rencontrés et solutions proposées</h6>
            @forelse ($gouvernance->problems as $problem)
                <div class="mb-2 border-bottom pb-2">
                    <strong>Problème :</strong> {{ $problem->probleme_rencontre }}<br>
                    <strong>Solution :</strong> {{ $problem->solution_proposee ?? '-' }}
                </div>
            @empty
                <p class="text-muted">Aucun problème enregistré.</p>
            @endforelse

            <h6 class="text-decoration-underline mt-4">IV.2 Recommandations</h6>
            @forelse ($gouvernance->recommendations as $reco)
                <div class="mb-2 border-bottom pb-2">
                    <strong>{{ $reco->destinataire }} :</strong> {{ $reco->contenu }}
                </div>
            @empty
                <p class="text-muted">Aucune recommandation enregistrée.</p>
            @endforelse
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p class="mb-0">
                Remplie par : <strong>{{ $gouvernance->rempli_par ?? '-' }}</strong><br>
                Date de remplissage : <strong>{{ optional($gouvernance->date_remplissage)->format('d/m/Y') ?? '-' }}</strong>
            </p>
        </div>
    </div>
@endsection
