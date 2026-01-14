<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="sidebar-brand">
	  <!--begin::Brand Link-->
	  <a href="{{ url('/') }}" class="brand-link">
		<!--begin::Brand Image-->
		<img src="/img/logo.png"class="brand-image opacity-75 shadow"/>
		<!--end::Brand Image-->
		<!--begin::Brand Text-->
		<span class="brand-text fw-light" style="font-family: cursive">SysNISE</span>
		<!--end::Brand Text-->
	  </a>
	  <!--end::Brand Link-->
	</div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			  <li class="nav-item">
                <a href="#" class="nav-link">
				  <i class="nav-icon bi bi-list"></i>
                  <p>Reférentiel<i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/nature_donnees" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Natures Données</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/source_indicateurs" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sources</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/type_desagregations" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Types Désagrégation</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/desagregations" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Désagrégations</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/periodes" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Périodes</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/unite_indicateurs" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>unités</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/zones" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Zones Géographiques</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/statut_produits" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Statuts Produit</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/type_produits" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Types Produit</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/statut_activites" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Statuts Activité</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/type_activites" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Types Activité</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/commentaire_valeur_indicateurs" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Commentaires valeur</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/institution_tutelles" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Institutions Tutelle</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/statut_projets" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Statuts Projet</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/population_cibles" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Populations Cible</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/etudes" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Etudes</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/source_financements" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sources Financement</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/bailleurs" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Bailleurs</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/statut_financements" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Statuts Financement</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/categorie_depenses" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Catégories Dépense</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/nature_financements" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Natures Financement</p>
                    </a>
                  </li>
				  
                </ul>
              </li>
			  
			  <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-list"></i>
				  <p>Cadres stratégiques<i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/cadre_developpements/create" class="nav-link">
                      <i class="nav-icon bi bi-plus"></i>
                      <p>Nouveau</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/cadre_developpements" class="nav-link">
                      <i class="nav-icon bi bi-list"></i>
                      <p>Liste des cadres</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="{{ asset('storage/modele/Indicateur_PRR.xlsx') }}" class="nav-link">
                      <i class="nav-icon bi bi-download"></i>
                      <p>Fiche Indicateurs</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/export_data_template" class="nav-link">
                      <i class="nav-icon bi bi-download"></i>
                      <p>Modèle de chargement</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/donnee_indicateurs/uploadData" class="nav-link">
                      <i class="nav-icon bi bi-upload"></i>
                      <p>Chargement de données</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/donnee_indicateurs/create" class="nav-link">
                      <i class="nav-icon bi bi-journal-text"></i>
                      <p>Saisie de données</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/donnee_indicateurs/parametreSaisie" class="nav-link">
                      <i class="nav-icon bi bi-journal-text"></i>
                      <p>Saisie réalisation</p>
                    </a>
                  </li>
				  
				  <!-- Nouveau : Menus de validation des données -->
				  <li class="nav-header">VALIDATION DES DONNÉES</li>
				  
				  <li class="nav-item">
                    <a href="/donnee_indicateurs/validation" class="nav-link">
                      <i class="nav-icon fas fa-clock text-warning"></i>
                      <p>Données en attente</p>
                    </a>
                  </li>
				  
				  <li class="nav-item">
                    <a href="/donnee_indicateurs/validees" class="nav-link">
                      <i class="nav-icon fas fa-check-circle text-success"></i>
                      <p>Données validées</p>
                    </a>
                  </li>
				  
				  <li class="nav-item">
                    <a href="/donnee_indicateurs/rejetees" class="nav-link">
                      <i class="nav-icon fas fa-times-circle text-danger"></i>
                      <p>Données rejetées</p>
                    </a>
                  </li>
				  
				  <li class="nav-header">EXTRACTION</li>
				  
				  <li class="nav-item">
                    <a href="/donnee_indicateurs/extractionDonnees" class="nav-link">
                      <i class="nav-icon bi bi-graph-up"></i>
                      <p>Extraction de données</p>
                    </a>
                  </li>
                </ul>
              </li>
			  
			  <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-list"></i>
				  <p>Projet<i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/projets/create" class="nav-link">
                      <i class="nav-icon bi bi-plus"></i>
                      <p>Nouveau</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="/projets" class="nav-link">
                      <i class="nav-icon bi bi-list"></i>
                      <p>Liste des projets</p>
                    </a>
                  </li>
				 
                </ul>
              </li>
             
            </ul>
        </nav>
    </div>
</aside>