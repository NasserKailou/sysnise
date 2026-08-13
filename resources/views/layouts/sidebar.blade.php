<aside class="main-sidebar sidebar-dark-primary elevation-4 sys-sidebar" style="background: #0d3351">
    <div class="sidebar-brand">
        <a href="{{ url('/') }}" class="brand-link">
            <img src="/img/logo.png" class="brand-image opacity-75 shadow" alt="SysNISE"/>
            <span class="brand-text fw-light">SysNISE</span>
        </a>
    </div>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">

                {{-- Tableau de bord --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                       class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Tableau de Bord</p>
                    </a>
                </li>

                <li class="nav-header">GESTION</li>

                {{-- Référentiel --}}
                @php
                    $referentielPaths = [
                        'nature_donnees', 'source_indicateurs', 'type_desagregations',
                        'desagregations', 'periodes', 'unite_indicateurs', 'zones',
                        'statut_produits', 'type_produits', 'statut_activites',
                        'type_activites', 'commentaire_valeur_indicateurs',
                        'institution_tutelles', 'secteurs', 'statut_projets',
                        'population_cibles', 'etudes', 'source_financements',
                        'devises', 'bailleurs', 'statut_financements',
                        'categorie_depenses', 'nature_financements'
                    ];
                    $referentielActive = collect($referentielPaths)->contains(fn($path) => request()->is($path) || request()->is($path.'/*'));
                @endphp
                <li class="nav-item {{ $referentielActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $referentielActive ? 'active' : '' }}">
                        <i class="nav-icon bi bi-list"></i>
                        <p>Référentiel <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="/nature_donnees" class="nav-link {{ request()->is('nature_donnees*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Natures Données</p></a></li>
                        <li class="nav-item"><a href="/source_indicateurs" class="nav-link {{ request()->is('source_indicateurs*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Sources</p></a></li>
                        <li class="nav-item"><a href="/type_desagregations" class="nav-link {{ request()->is('type_desagregations*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Types Désagrégation</p></a></li>
                        <li class="nav-item"><a href="/desagregations" class="nav-link {{ request()->is('desagregations*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Désagrégations</p></a></li>
                        <li class="nav-item"><a href="/periodes" class="nav-link {{ request()->is('periodes*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Périodes</p></a></li>
                        <li class="nav-item"><a href="/unite_indicateurs" class="nav-link {{ request()->is('unite_indicateurs*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Unités</p></a></li>
                        <li class="nav-item"><a href="/zones" class="nav-link {{ request()->is('zones*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Zones Géographiques</p></a></li>
                        <li class="nav-item"><a href="/statut_produits" class="nav-link {{ request()->is('statut_produits*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Statuts Produit</p></a></li>
                        <li class="nav-item"><a href="/type_produits" class="nav-link {{ request()->is('type_produits*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Types Produit</p></a></li>
                        <li class="nav-item"><a href="/statut_activites" class="nav-link {{ request()->is('statut_activites*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Statuts Activité</p></a></li>
                        <li class="nav-item"><a href="/type_activites" class="nav-link {{ request()->is('type_activites*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Types Activité</p></a></li>
                        <li class="nav-item"><a href="/commentaire_valeur_indicateurs" class="nav-link {{ request()->is('commentaire_valeur_indicateurs*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Commentaires valeur</p></a></li>
                        <li class="nav-item"><a href="/institution_tutelles" class="nav-link {{ request()->is('institution_tutelles*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Institutions Tutelle</p></a></li>
                        <li class="nav-item"><a href="/secteurs" class="nav-link {{ request()->is('secteurs*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Secteurs</p></a></li>
                        <li class="nav-item"><a href="/statut_projets" class="nav-link {{ request()->is('statut_projets*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Statuts Projet</p></a></li>
                        <li class="nav-item"><a href="/population_cibles" class="nav-link {{ request()->is('population_cibles*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Populations Cible</p></a></li>
                        <li class="nav-item"><a href="/etudes" class="nav-link {{ request()->is('etudes*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Études</p></a></li>
                        <li class="nav-item"><a href="/source_financements" class="nav-link {{ request()->is('source_financements*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Sources Financement</p></a></li>
                        <li class="nav-item"><a href="/devises" class="nav-link {{ request()->is('devises*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Devises</p></a></li>
                        <li class="nav-item"><a href="/bailleurs" class="nav-link {{ request()->is('bailleurs*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Bailleurs</p></a></li>
                        <li class="nav-item"><a href="/statut_financements" class="nav-link {{ request()->is('statut_financements*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Statuts Financement</p></a></li>
                        <li class="nav-item"><a href="/categorie_depenses" class="nav-link {{ request()->is('categorie_depenses*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Catégories Dépense</p></a></li>
                        <li class="nav-item"><a href="/nature_financements" class="nav-link {{ request()->is('nature_financements*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Natures Financement</p></a></li>
                    </ul>
                </li>

                {{-- Cadres stratégiques --}}
                @php $cadreActive = request()->is('cadre_developpements*') || request()->is('export_data_template') || request()->is('donnee_indicateurs/*'); @endphp
                <li class="nav-item {{ $cadreActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $cadreActive ? 'active' : '' }}">
                        <i class="nav-icon bi bi-list"></i>
                        <p>Cadres stratégiques <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="/cadre_developpements/create" class="nav-link {{ request()->is('cadre_developpements/create') ? 'active' : '' }}"><i class="nav-icon bi bi-plus"></i><p>Nouveau</p></a></li>
                        <li class="nav-item"><a href="/cadre_developpements" class="nav-link {{ request()->is('cadre_developpements') || request()->is('cadre_developpements/*') ? 'active' : '' }}"><i class="nav-icon bi bi-list"></i><p>Liste des cadres</p></a></li>
                        <li class="nav-item"><a href="{{ asset('storage/modele/cadre_resultat_PRR.xlsx') }}" class="nav-link"><i class="nav-icon bi bi-download"></i><p>Fiche Cadre Résultat</p></a></li>
                        <li class="nav-item"><a href="{{ asset('storage/modele/Indicateur_PRR.xlsx') }}" class="nav-link"><i class="nav-icon bi bi-download"></i><p>Fiche Indicateurs</p></a></li>
                        <li class="nav-item"><a href="/export_data_template" class="nav-link {{ request()->is('export_data_template') ? 'active' : '' }}"><i class="nav-icon bi bi-download"></i><p>Modèle de chargement</p></a></li>
                        <li class="nav-item"><a href="/donnee_indicateurs/uploadData" class="nav-link {{ request()->is('donnee_indicateurs/uploadData') ? 'active' : '' }}"><i class="nav-icon bi bi-upload"></i><p>Chargement de données</p></a></li>
                        <li class="nav-item"><a href="/donnee_indicateurs/create" class="nav-link {{ request()->is('donnee_indicateurs/create') ? 'active' : '' }}"><i class="nav-icon bi bi-journal-text"></i><p>Saisie de données</p></a></li>
                        <li class="nav-item"><a href="/donnee_indicateurs/parametreSaisie" class="nav-link {{ request()->is('donnee_indicateurs/parametreSaisie') ? 'active' : '' }}"><i class="nav-icon bi bi-journal-text"></i><p>Saisie réalisation</p></a></li>

                        <li class="nav-header">VALIDATION DES DONNÉES</li>
                        <li class="nav-item"><a href="/donnee_indicateurs/validation" class="nav-link {{ request()->is('donnee_indicateurs/validation') ? 'active' : '' }}"><i class="nav-icon fas fa-clock text-warning"></i><p>Données en attente</p></a></li>
                        <li class="nav-item"><a href="/donnee_indicateurs/validees" class="nav-link {{ request()->is('donnee_indicateurs/validees') ? 'active' : '' }}"><i class="nav-icon fas fa-check-circle text-success"></i><p>Données validées</p></a></li>
                        <li class="nav-item"><a href="/donnee_indicateurs/rejetees" class="nav-link {{ request()->is('donnee_indicateurs/rejetees') ? 'active' : '' }}"><i class="nav-icon fas fa-times-circle text-danger"></i><p>Données rejetées</p></a></li>

                        <li class="nav-header">EXTRACTION</li>
                        <li class="nav-item"><a href="/donnee_indicateurs/extractionDonnees" class="nav-link {{ request()->is('donnee_indicateurs/extractionDonnees') ? 'active' : '' }}"><i class="nav-icon bi bi-graph-up"></i><p>Extraction de données</p></a></li>
                    </ul>
                </li>

                {{-- Projet --}}
                @php $projetActive = request()->is('projets*'); @endphp
                <li class="nav-item {{ $projetActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $projetActive ? 'active' : '' }}">
                        <i class="nav-icon bi bi-list"></i>
                        <p>Projet <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="/projets/create" class="nav-link {{ request()->is('projets/create') ? 'active' : '' }}"><i class="nav-icon bi bi-plus"></i><p>Nouveau</p></a></li>
                        <li class="nav-item"><a href="/projets" class="nav-link {{ request()->is('projets') || request()->is('projets/*') ? 'active' : '' }}"><i class="nav-icon bi bi-list"></i><p>Liste des projets</p></a></li>
                        <li class="nav-item"><a href="{{ asset('storage/modele/Indicateur_PRR.xlsx') }}" class="nav-link"><i class="nav-icon bi bi-download"></i><p>Fiche Indicateurs</p></a></li>
                        <li class="nav-item"><a href="/export_data_template" class="nav-link {{ request()->is('export_data_template') ? 'active' : '' }}"><i class="nav-icon bi bi-download"></i><p>Modèle de chargement</p></a></li>
                        <li class="nav-item"><a href="/donnee_indicateurs/uploadData" class="nav-link {{ request()->is('donnee_indicateurs/uploadData') ? 'active' : '' }}"><i class="nav-icon bi bi-upload"></i><p>Chargement de données</p></a></li>
                        <li class="nav-item"><a href="/donnee_indicateurs/create" class="nav-link {{ request()->is('donnee_indicateurs/create') ? 'active' : '' }}"><i class="nav-icon bi bi-journal-text"></i><p>Saisie de données</p></a></li>
                        <li class="nav-item"><a href="/donnee_indicateurs/parametreSaisie" class="nav-link {{ request()->is('donnee_indicateurs/parametreSaisie') ? 'active' : '' }}"><i class="nav-icon bi bi-journal-text"></i><p>Saisie réalisation</p></a></li>
                        <li class="nav-header">EXTRACTION</li>
                        <li class="nav-item"><a href="/donnee_indicateurs/extractionDonnees" class="nav-link {{ request()->is('donnee_indicateurs/extractionDonnees') ? 'active' : '' }}"><i class="nav-icon bi bi-graph-up"></i><p>Extraction de données</p></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
