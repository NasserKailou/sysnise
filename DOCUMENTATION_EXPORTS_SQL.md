# Documentation des Requêtes SQL - Fichiers Plats

## 1. Fichier Plat des Projets

### Description
Cette requête génère un fichier plat où chaque ligne représente un projet avec toutes ses informations consolidées.

### Colonnes exportées
- **Informations projet** : ID, sigle, intitulé, dates, durée, coût
- **Relations** : Statut, priorité, institution, cadre de développement
- **Listes agrégées** : Secteurs, zones d'intervention, bailleurs (séparés par ";")
- **Finances** : Montant plan financement, budgets prévus et dépensés
- **Pilotage** : Organe de pilotage, audits, problèmes et solutions

### Requête SQL

```sql
SELECT 
    p.id as projet_id,
    p.sigle as projet_sigle,
    p.intitule as projet_intitule,
    p.annee_demarrage,
    p.date_debut_prevue,
    p.date_fin_prevue,
    p.date_debut_effective,
    p.date_fin_effective,
    p.duree,
    p.cout as cout_total,
    d.sigle as devise,
    sp.intitule as statut_projet,
    pr.intitule as priorite,
    it.intitule as institution_tutelle,
    cd.intitule as cadre_developpement,
    GROUP_CONCAT(DISTINCT s.intitule SEPARATOR '; ') as secteurs,
    GROUP_CONCAT(DISTINCT z.intitule SEPARATOR '; ') as zones_intervention,
    GROUP_CONCAT(DISTINCT b.intitule SEPARATOR '; ') as bailleurs,
    COALESCE(SUM(ppf.montant), 0) as montant_plan_financement,
    COALESCE(
        (SELECT SUM(pba1.montant) 
         FROM projet_budget_annuels pba1 
         WHERE pba1.plan_financement_id IN (
             SELECT id FROM projet_plan_financements WHERE projet_id = p.id
         ) AND pba1.statut_budget_id = 1), 
        0
    ) as budget_prevu_total,
    COALESCE(
        (SELECT SUM(pba2.montant) 
         FROM projet_budget_annuels pba2 
         WHERE pba2.plan_financement_id IN (
             SELECT id FROM projet_plan_financements WHERE projet_id = p.id
         ) AND pba2.statut_budget_id = 2), 
        0
    ) as budget_depense_total,
    p.dispose_organe_pilotage,
    p.a_audit_regulier,
    p.problemes_rencontres,
    p.solutions_proposees,
    p.recommandations
FROM projets p
LEFT JOIN statut_projets sp ON p.statut_projet_id = sp.id
LEFT JOIN priorites pr ON p.priorite_id = pr.id
LEFT JOIN institution_tutelles it ON p.institution_tutelle_id = it.id
LEFT JOIN cadre_developpements cd ON p.cadre_developpement_id = cd.id
LEFT JOIN devises d ON p.devise_id = d.id
LEFT JOIN projet_secteur ps ON p.id = ps.projet_id
LEFT JOIN secteurs s ON ps.secteur_id = s.id
LEFT JOIN projet_zone pz ON p.id = pz.projet_id
LEFT JOIN zones z ON pz.zone_id = z.id
LEFT JOIN projet_plan_financements ppf ON p.id = ppf.projet_id
LEFT JOIN bailleurs b ON ppf.bailleur_id = b.id
GROUP BY p.id, p.sigle, p.intitule, p.annee_demarrage, p.date_debut_prevue, 
         p.date_fin_prevue, p.date_debut_effective, p.date_fin_effective, 
         p.duree, p.cout, d.sigle, sp.intitule, pr.intitule, it.intitule, 
         cd.intitule, p.dispose_organe_pilotage, p.a_audit_regulier, 
         p.problemes_rencontres, p.solutions_proposees, p.recommandations
ORDER BY p.id;
```

### Utilisation
- **Route** : `/dashboard/export/projets`
- **Format** : CSV
- **Encodage** : UTF-8

---

## 2. Fichier Plat des Cadres Stratégiques

### Description
Cette requête génère un fichier plat où chaque ligne représente un indicateur avec toute la hiérarchie remontant jusqu'au cadre stratégique.

### Structure hiérarchique
```
Cadre Stratégique (niveau 0)
  └─ Impact (niveau 1)
      └─ Effet (niveau 2)
          └─ Produit (niveau 3)
              └─ Indicateur
```

### Colonnes exportées
- **Cadre** : ID, intitulé, structure responsable, période
- **Impact** : ID, intitulé, niveau (répété pour chaque indicateur)
- **Effet** : ID, intitulé, niveau (peut être NULL)
- **Produit** : ID, intitulé, niveau (peut être NULL)
- **Indicateur** : ID, code, intitulé, définition, méthode de calcul, périodicité, unité
- **Désagrégations** : Liste des désagrégations (séparées par ";")
- **Valeurs annuelles** : Format "année:valeur" séparées par ";"
- **Métadonnées** : Source, unité

### Requête SQL

```sql
SELECT 
    cd.id as cadre_id,
    cd.intitule as cadre_intitule,
    cd.structure_responsable,
    cd.annee_debut as cadre_annee_debut,
    cd.annee_fin as cadre_annee_fin,
    cl_impact.id as impact_id,
    cl_impact.intitule as impact_intitule,
    cl_impact.niveau as impact_niveau,
    cl_effet.id as effet_id,
    cl_effet.intitule as effet_intitule,
    cl_effet.niveau as effet_niveau,
    cl_produit.id as produit_id,
    cl_produit.intitule as produit_intitule,
    cl_produit.niveau as produit_niveau,
    ind.id as indicateur_id,
    ind.code as indicateur_code,
    ind.intitule as indicateur_intitule,
    ind.definition as indicateur_definition,
    ind.methode_calcul,
    ind.periodicite,
    ind.unite,
    GROUP_CONCAT(DISTINCT d.intitule SEPARATOR '; ') as desagregations,
    GROUP_CONCAT(DISTINCT CONCAT(di.annee, ':', di.valeur) SEPARATOR '; ') as valeurs_annuelles,
    si.intitule as source_indicateur,
    ui.intitule as unite_indicateur
FROM cadre_developpements cd
-- Récupérer les orientations (impacts - niveau 1)
INNER JOIN orientation_cadre_developpements ocd ON cd.id = ocd.cadre_developpement_id
INNER JOIN cadre_logiques cl_impact ON ocd.cadre_logique_id = cl_impact.id AND cl_impact.niveau = 1
-- Récupérer les effets (niveau 2)
LEFT JOIN cadre_logiques cl_effet ON cl_effet.cadre_logique_id = cl_impact.id AND cl_effet.niveau = 2
-- Récupérer les produits (niveau 3)
LEFT JOIN cadre_logiques cl_produit ON cl_produit.cadre_logique_id = cl_effet.id AND cl_produit.niveau = 3
-- Récupérer les indicateurs liés aux différents niveaux
LEFT JOIN cadre_mesure_resultats cmr ON cmr.cadre_logique_id IN (cl_impact.id, cl_effet.id, cl_produit.id)
LEFT JOIN indicateurs ind ON cmr.indicateur_id = ind.id
-- Désagrégations
LEFT JOIN desagregation_indicateur di_rel ON ind.id = di_rel.indicateur_id
LEFT JOIN desagregations d ON di_rel.desagregation_id = d.id
-- Données des indicateurs
LEFT JOIN donnee_indicateurs di ON ind.id = di.indicateur_id
-- Autres informations
LEFT JOIN source_indicateurs si ON ind.source = si.id
LEFT JOIN unite_indicateurs ui ON ind.unite = ui.id
WHERE cd.type_cadre_developpement_id = 1
GROUP BY cd.id, cd.intitule, cd.structure_responsable, cd.annee_debut, cd.annee_fin,
         cl_impact.id, cl_impact.intitule, cl_impact.niveau,
         cl_effet.id, cl_effet.intitule, cl_effet.niveau,
         cl_produit.id, cl_produit.intitule, cl_produit.niveau,
         ind.id, ind.code, ind.intitule, ind.definition, ind.methode_calcul, 
         ind.periodicite, ind.unite, si.intitule, ui.intitule
ORDER BY cd.id, cl_impact.id, cl_effet.id, cl_produit.id, ind.id;
```

### Format du fichier
- **Une ligne par indicateur**
- **Répétition** : Le cadre, l'impact, et l'effet sont répétés sur chaque ligne d'indicateur
- **Séparateurs** : Point-virgule (;) pour les listes multiples
- **Format valeurs** : `annee:valeur` (exemple: `2023:150; 2024:200`)

### Utilisation
- **Route** : `/dashboard/export/cadres`
- **Format** : CSV
- **Encodage** : UTF-8

### Exemple de résultat

| cadre_intitule | impact_intitule | effet_intitule | produit_intitule | indicateur_intitule | valeurs_annuelles |
|----------------|-----------------|----------------|------------------|---------------------|-------------------|
| SCAPP 2021-2025 | Amélioration éducation | Accès renforcé | Infrastructures construites | Nombre d'écoles | 2021:10; 2022:15; 2023:20 |
| SCAPP 2021-2025 | Amélioration éducation | Accès renforcé | Infrastructures construites | Nombre de salles de classe | 2021:50; 2022:75; 2023:100 |
| SCAPP 2021-2025 | Amélioration éducation | Qualité améliorée | Enseignants formés | Nombre d'enseignants formés | 2021:200; 2022:250; 2023:300 |

---

## 3. Utilisation dans l'application

### Contrôleur
Le contrôleur `DashboardController` gère les exports :

```php
// Export projets
Route::get('/dashboard/export/projets', [DashboardController::class, 'exportProjetsFichierPlat'])
    ->name('dashboard.export.projets');

// Export cadres
Route::get('/dashboard/export/cadres', [DashboardController::class, 'exportCadresFichierPlat'])
    ->name('dashboard.export.cadres');
```

### Téléchargement
Les fichiers sont générés dynamiquement au format CSV avec :
- **Nom automatique** : Inclut la date et l'heure de génération
- **Téléchargement direct** : Le fichier est supprimé après téléchargement
- **Encodage UTF-8** : Compatible avec Excel et autres outils

### Exemples de noms de fichiers
- `projets_fichier_plat_2026-07-16_155030.csv`
- `cadres_strategiques_fichier_plat_2026-07-16_155045.csv`

---

## 4. Notes techniques

### Performance
- Les requêtes utilisent des `LEFT JOIN` pour gérer les données manquantes
- `GROUP_CONCAT` est limité par `group_concat_max_len` (augmenter si nécessaire)
- Pour de grandes bases, considérer la pagination ou l'export asynchrone

### Désagrégations
Les désagrégations multiples sont concaténées avec le séparateur "; "

### Valeurs nulles
- Les champs sans données apparaissent comme vides dans le CSV
- `COALESCE` est utilisé pour remplacer NULL par 0 dans les montants

### Encodage
- UTF-8 pour supporter les caractères accentués français
- BOM optionnel pour une meilleure compatibilité Excel

---

## 5. Maintenance

### Ajouter une colonne projet
1. Modifier la requête dans `getSQLProjetsFichierPlat()`
2. Ajouter le champ dans le SELECT
3. Ajouter dans le GROUP BY si nécessaire

### Ajouter une colonne cadre
1. Modifier la requête dans `getSQLCadresFichierPlat()`
2. Ajouter le champ dans le SELECT
3. Ajouter dans le GROUP BY

### Changer le séparateur
Modifier `fputcsv($file, ...)` pour utiliser un séparateur personnalisé (ex: `;` pour Excel européen)
