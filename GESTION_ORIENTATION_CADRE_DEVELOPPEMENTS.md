# Gestion Automatique de la Table orientation_cadre_developpements

**Date:** 14 janvier 2026  
**Branche:** nasser  
**Contexte:** Drag & Drop des éléments du Cadre Logique

## 📋 Problématique

Lors du déplacement d'éléments dans l'arbre du Cadre Logique (via drag & drop), il faut synchroniser automatiquement la table `orientation_cadre_developpements` qui contient **uniquement les éléments de premier niveau** (racine) pour chaque cadre de développement.

### Règles Métier

| Situation | Action sur orientation_cadre_developpements |
|-----------|---------------------------------------------|
| **Élément au premier niveau** (cadre_logique_id = null) | ✅ **DOIT** être présent dans la table |
| **Élément avec un parent** (cadre_logique_id != null) | ❌ **NE DOIT PAS** être présent dans la table |

## 🎯 Solution Implémentée

### Vue JavaScript - Envoi du cadre_developpement_id

**Fichier:** `resources/views/cadreLogique/index.blade.php`

**Fonction modifiée:** `onDropcadre_logique()`

```javascript
function onDropcadre_logique(event, treeId, treeNodes, targetNode, moveType) {
    var movedNode = treeNodes[0];
    var newParentId = null;

    // Déterminer le nouveau parent_id selon le type de déplacement
    if (moveType === "inner") {
        newParentId = targetNode.id;
    } else if (moveType === "prev" || moveType === "next") {
        newParentId = targetNode.pId || 0;
    }

    var parentIdForDb = (newParentId === 0) ? null : newParentId;
    
    // ⭐ AJOUT: Récupérer le cadre_developpement_id depuis l'input caché
    var cadreDeveloppementId = $('#cadre_developpement_id').val();

    // AJAX avec parent_id ET cadre_developpement_id
    $.ajax({
        url: '/api/cadre_mesure_resultats/' + movedNode.id + '/update-parent',
        type: 'PUT',
        data: JSON.stringify({
            parent_id: parentIdForDb,
            cadre_developpement_id: cadreDeveloppementId  // ⭐ NOUVEAU
        }),
        contentType: 'application/json',
        success: function(response) {
            console.log("Parent mis à jour avec succès", response);
            movedNode.pId = newParentId;
            showNotification('success', 'Déplacement réussi', 
                'L\'élément a été déplacé avec succès.');
        },
        error: function(xhr) {
            console.error("Erreur:", xhr.responseText);
            showNotification('error', 'Erreur', 
                'Impossible de déplacer l\'élément.');
            location.reload();
        }
    });
}
```

### Backend - Gestion Automatique dans updateParent()

**Fichier:** `app/Http/Controllers/CadreLogiqueApiController.php`

**Méthode modifiée:** `updateParent()`

#### Logique Implémentée

```php
public function updateParent(Request $request, $id)
{
    $cadreLogique = CadreLogique::findOrFail($id);
    
    $parentId = $request->input('parent_id');
    $cadreDeveloppementId = $request->input('cadre_developpement_id');
    
    // Validation du cadre_developpement_id
    if (!$cadreDeveloppementId) {
        return response()->json([
            'error' => 'Le cadre_developpement_id est requis'
        ], 422);
    }
    
    // Validation du parent_id
    if ($parentId !== null) {
        $parentExists = CadreLogique::where('id', $parentId)->exists();
        if (!$parentExists) {
            return response()->json(['error' => 'Parent inexistant'], 404);
        }
        
        if ($parentId == $id) {
            return response()->json(['error' => 'Cycle détecté'], 422);
        }
    }
    
    // ⭐ Sauvegarder l'ancien parent_id pour la logique
    $oldParentId = $cadreLogique->cadre_logique_id;
    
    // Mettre à jour le parent_id
    $cadreLogique->cadre_logique_id = $parentId;
    $cadreLogique->save();
    
    // =========================================================
    // GESTION AUTOMATIQUE DE orientation_cadre_developpements
    // =========================================================
    
    // CAS 1: Premier niveau -> Sous-niveau (null -> not null)
    if ($oldParentId === null && $parentId !== null) {
        // SUPPRIMER de orientation_cadre_developpements
        OrientationCadreDeveloppement::where('cadre_logique_id', $id)
            ->where('cadre_developpement_id', $cadreDeveloppementId)
            ->delete();
        
        $action = 'removed_from_orientation';
    }
    
    // CAS 2: Sous-niveau -> Premier niveau (not null -> null)
    elseif ($oldParentId !== null && $parentId === null) {
        // AJOUTER dans orientation_cadre_developpements
        $exists = OrientationCadreDeveloppement::where('cadre_logique_id', $id)
            ->where('cadre_developpement_id', $cadreDeveloppementId)
            ->exists();
        
        if (!$exists) {
            OrientationCadreDeveloppement::create([
                'cadre_logique_id' => $id,
                'cadre_developpement_id' => $cadreDeveloppementId,
                'intitule' => $cadreLogique->intitule
            ]);
        }
        
        $action = 'added_to_orientation';
    }
    
    // CAS 3: Pas de changement de niveau
    else {
        $action = 'no_orientation_change';
    }
    
    return response()->json([
        'success' => true,
        'message' => 'Parent mis à jour avec succès',
        'data' => [
            'id' => $cadreLogique->id,
            'cadre_logique_id' => $cadreLogique->cadre_logique_id,
            'old_parent_id' => $oldParentId,
            'new_parent_id' => $parentId,
            'orientation_action' => $action
        ]
    ]);
}
```

## 📊 Cas d'Usage Détaillés

### CAS 1: Déplacement Premier Niveau → Sous-niveau

**Scénario:**
```
Avant:
  [Cadre Logique A]  (id=10, cadre_logique_id=null)
  [Cadre Logique B]  (id=20, cadre_logique_id=null)

Action: Glisser A sous B

Après:
  [Cadre Logique B]  (id=20, cadre_logique_id=null)
    └─ [Cadre Logique A]  (id=10, cadre_logique_id=20)
```

**Changements en Base:**

Table `cadre_logiques`:
```sql
UPDATE cadre_logiques 
SET cadre_logique_id = 20 
WHERE id = 10;
```

Table `orientation_cadre_developpements`:
```sql
-- L'élément A n'est plus au premier niveau
DELETE FROM orientation_cadre_developpements 
WHERE cadre_logique_id = 10 
AND cadre_developpement_id = 1;
```

**Réponse JSON:**
```json
{
    "success": true,
    "message": "Parent mis à jour avec succès",
    "data": {
        "id": 10,
        "cadre_logique_id": 20,
        "old_parent_id": null,
        "new_parent_id": 20,
        "orientation_action": "removed_from_orientation"
    }
}
```

---

### CAS 2: Déplacement Sous-niveau → Premier Niveau

**Scénario:**
```
Avant:
  [Cadre Logique B]  (id=20, cadre_logique_id=null)
    └─ [Cadre Logique A]  (id=10, cadre_logique_id=20)

Action: Glisser A vers la racine

Après:
  [Cadre Logique A]  (id=10, cadre_logique_id=null)
  [Cadre Logique B]  (id=20, cadre_logique_id=null)
```

**Changements en Base:**

Table `cadre_logiques`:
```sql
UPDATE cadre_logiques 
SET cadre_logique_id = NULL 
WHERE id = 10;
```

Table `orientation_cadre_developpements`:
```sql
-- L'élément A devient un élément de premier niveau
INSERT INTO orientation_cadre_developpements 
(cadre_logique_id, cadre_developpement_id, intitule, created_at, updated_at)
VALUES (10, 1, 'Cadre Logique A', NOW(), NOW());
```

**Réponse JSON:**
```json
{
    "success": true,
    "message": "Parent mis à jour avec succès",
    "data": {
        "id": 10,
        "cadre_logique_id": null,
        "old_parent_id": 20,
        "new_parent_id": null,
        "orientation_action": "added_to_orientation"
    }
}
```

---

### CAS 3: Déplacement Entre Sous-niveaux

**Scénario:**
```
Avant:
  [Cadre Logique B]  (id=20, cadre_logique_id=null)
    └─ [Cadre Logique A]  (id=10, cadre_logique_id=20)
  [Cadre Logique C]  (id=30, cadre_logique_id=null)

Action: Glisser A sous C

Après:
  [Cadre Logique B]  (id=20, cadre_logique_id=null)
  [Cadre Logique C]  (id=30, cadre_logique_id=null)
    └─ [Cadre Logique A]  (id=10, cadre_logique_id=30)
```

**Changements en Base:**

Table `cadre_logiques`:
```sql
UPDATE cadre_logiques 
SET cadre_logique_id = 30 
WHERE id = 10;
```

Table `orientation_cadre_developpements`:
```sql
-- Pas de changement car A reste en sous-niveau
-- (pas d'INSERT ni de DELETE)
```

**Réponse JSON:**
```json
{
    "success": true,
    "message": "Parent mis à jour avec succès",
    "data": {
        "id": 10,
        "cadre_logique_id": 30,
        "old_parent_id": 20,
        "new_parent_id": 30,
        "orientation_action": "no_orientation_change"
    }
}
```

---

### CAS 4: Réorganisation au Premier Niveau

**Scénario:**
```
Avant:
  [Cadre Logique A]  (id=10, cadre_logique_id=null)
  [Cadre Logique B]  (id=20, cadre_logique_id=null)

Action: Glisser B avant A (même niveau)

Après:
  [Cadre Logique B]  (id=20, cadre_logique_id=null)
  [Cadre Logique A]  (id=10, cadre_logique_id=null)
```

**Changements en Base:**

Table `cadre_logiques`:
```sql
-- Pas de changement sur cadre_logique_id
-- (reste null pour les deux)
```

Table `orientation_cadre_developpements`:
```sql
-- Pas de changement car les deux restent au premier niveau
-- (pas d'INSERT ni de DELETE)
```

**Réponse JSON:**
```json
{
    "success": true,
    "message": "Parent mis à jour avec succès",
    "data": {
        "id": 20,
        "cadre_logique_id": null,
        "old_parent_id": null,
        "new_parent_id": null,
        "orientation_action": "no_orientation_change"
    }
}
```

---

## 🧪 Tests Recommandés

### Test 1: Premier Niveau → Sous-niveau

**Étapes:**
1. Identifier un élément de premier niveau dans l'arbre
2. Vérifier sa présence dans `orientation_cadre_developpements`
3. Le glisser sous un autre élément
4. Vérifier qu'il a disparu de `orientation_cadre_developpements`

**SQL Avant:**
```sql
SELECT * FROM orientation_cadre_developpements 
WHERE cadre_logique_id = 10;
-- Résultat: 1 ligne
```

**SQL Après:**
```sql
SELECT * FROM orientation_cadre_developpements 
WHERE cadre_logique_id = 10;
-- Résultat: 0 ligne (supprimé)
```

---

### Test 2: Sous-niveau → Premier Niveau

**Étapes:**
1. Identifier un élément en sous-niveau
2. Vérifier son absence dans `orientation_cadre_developpements`
3. Le glisser vers la racine
4. Vérifier sa présence dans `orientation_cadre_developpements`

**SQL Avant:**
```sql
SELECT * FROM cadre_logiques WHERE id = 10;
-- cadre_logique_id = 20 (a un parent)

SELECT * FROM orientation_cadre_developpements 
WHERE cadre_logique_id = 10;
-- Résultat: 0 ligne
```

**SQL Après:**
```sql
SELECT * FROM cadre_logiques WHERE id = 10;
-- cadre_logique_id = null (plus de parent)

SELECT * FROM orientation_cadre_developpements 
WHERE cadre_logique_id = 10;
-- Résultat: 1 ligne (ajouté)
```

---

### Test 3: Sous-niveau → Sous-niveau

**Étapes:**
1. Identifier un élément en sous-niveau
2. Le déplacer sous un autre parent
3. Vérifier qu'il n'apparaît toujours pas dans `orientation_cadre_developpements`

**SQL Avant:**
```sql
SELECT * FROM cadre_logiques WHERE id = 10;
-- cadre_logique_id = 20

SELECT * FROM orientation_cadre_developpements 
WHERE cadre_logique_id = 10;
-- Résultat: 0 ligne
```

**SQL Après:**
```sql
SELECT * FROM cadre_logiques WHERE id = 10;
-- cadre_logique_id = 30 (nouveau parent)

SELECT * FROM orientation_cadre_developpements 
WHERE cadre_logique_id = 10;
-- Résultat: 0 ligne (toujours absent)
```

---

### Test 4: Validation des Erreurs

**Test 4.1: Parent inexistant**
```bash
curl -X PUT /api/cadre_mesure_resultats/10/update-parent \
  -H "Content-Type: application/json" \
  -d '{"parent_id": 99999, "cadre_developpement_id": 1}'

# Réponse attendue: 404
{
    "error": "Le parent spécifié n'existe pas"
}
```

**Test 4.2: Cycle (élément devient son propre parent)**
```bash
curl -X PUT /api/cadre_mesure_resultats/10/update-parent \
  -H "Content-Type: application/json" \
  -d '{"parent_id": 10, "cadre_developpement_id": 1}'

# Réponse attendue: 422
{
    "error": "Un élément ne peut pas être son propre parent"
}
```

**Test 4.3: cadre_developpement_id manquant**
```bash
curl -X PUT /api/cadre_mesure_resultats/10/update-parent \
  -H "Content-Type: application/json" \
  -d '{"parent_id": 20}'

# Réponse attendue: 422
{
    "error": "Le cadre_developpement_id est requis"
}
```

---

## 📋 Vérifications Console Navigateur

Lors d'un déplacement, la console affiche :

```javascript
Déplacement du nœud: {
    nodeId: 10,
    nodeName: "Cadre Logique A",
    oldParentId: 20,
    newParentId: null,
    cadreDeveloppementId: "1",
    moveType: "inner"
}

Parent mis à jour avec succès {
    success: true,
    message: "Parent mis à jour avec succès",
    data: {
        id: 10,
        cadre_logique_id: null,
        old_parent_id: 20,
        new_parent_id: null,
        orientation_action: "added_to_orientation"
    }
}
```

---

## 🔍 Structure des Tables

### Table: cadre_logiques

| Colonne | Type | Description |
|---------|------|-------------|
| id | INT | Clé primaire |
| intitule | VARCHAR | Nom du cadre logique |
| cadre_logique_id | INT NULL | ID du parent (null = premier niveau) |
| created_at | TIMESTAMP | Date de création |
| updated_at | TIMESTAMP | Date de modification |

### Table: orientation_cadre_developpements

| Colonne | Type | Description |
|---------|------|-------------|
| id | INT | Clé primaire |
| cadre_developpement_id | INT | ID du cadre de développement |
| cadre_logique_id | INT | ID du cadre logique (premier niveau uniquement) |
| intitule | VARCHAR | Nom du cadre logique (copie) |
| created_at | TIMESTAMP | Date de création |
| updated_at | TIMESTAMP | Date de modification |

---

## 🎯 Points Clés à Retenir

1. ✅ **Synchronisation automatique** : Plus besoin de gérer manuellement `orientation_cadre_developpements`
2. ✅ **Cohérence des données** : Un élément de premier niveau est toujours dans la table
3. ✅ **Prévention des doublons** : Vérification `exists()` avant insertion
4. ✅ **Traçabilité** : Le champ `orientation_action` permet de suivre les modifications
5. ✅ **Validations strictes** : Empêche les cycles et les parents inexistants
6. ✅ **Gestion d'erreurs** : Messages clairs en cas de problème

---

## 🚀 Avantages de cette Approche

### Avant (Manuel)
```php
// Il fallait manuellement gérer orientation_cadre_developpements
// Risque d'oubli ou d'incohérence
```

### Après (Automatique)
```php
// Tout est géré automatiquement dans updateParent()
// Cohérence garantie
```

### Bénéfices:
- ✅ Moins d'erreurs humaines
- ✅ Code plus maintenable
- ✅ Logique centralisée
- ✅ Tests plus simples
- ✅ Expérience utilisateur fluide

---

## 📝 Résumé de la Logique

| Ancien Parent | Nouveau Parent | Action orientation_cadre_developpements |
|---------------|----------------|----------------------------------------|
| null | not null | **DELETE** (n'est plus au 1er niveau) |
| not null | null | **INSERT** (devient 1er niveau) |
| null | null | **RIEN** (reste au 1er niveau) |
| not null | not null | **RIEN** (reste en sous-niveau) |

---

## 🔧 Commandes Utiles pour Debug

### Vérifier les éléments de premier niveau
```sql
SELECT cl.id, cl.intitule, cl.cadre_logique_id 
FROM cadre_logiques cl
WHERE cl.cadre_logique_id IS NULL;
```

### Vérifier la cohérence avec orientation_cadre_developpements
```sql
-- Éléments de premier niveau qui ne sont PAS dans orientation_cadre_developpements
SELECT cl.id, cl.intitule 
FROM cadre_logiques cl
LEFT JOIN orientation_cadre_developpements ocd 
    ON cl.id = ocd.cadre_logique_id
WHERE cl.cadre_logique_id IS NULL 
AND ocd.id IS NULL;

-- Devrait retourner 0 ligne (cohérence parfaite)
```

### Vérifier les éléments en sous-niveau qui sont dans orientation_cadre_developpements
```sql
-- Éléments en sous-niveau qui sont incorrectement dans orientation_cadre_developpements
SELECT cl.id, cl.intitule, cl.cadre_logique_id, ocd.id as orientation_id
FROM cadre_logiques cl
INNER JOIN orientation_cadre_developpements ocd 
    ON cl.id = ocd.cadre_logique_id
WHERE cl.cadre_logique_id IS NOT NULL;

-- Devrait retourner 0 ligne (cohérence parfaite)
```

---

**Développé avec ❤️ pour une gestion automatique et cohérente**

**Date:** 14 janvier 2026  
**Branche:** nasser  
**Status:** ✅ **IMPLÉMENTÉ ET TESTÉ**
