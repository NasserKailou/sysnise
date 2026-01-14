@extends('layouts.app')
@section('content')
<div class="page-title">{{ $cadreDeveloppement->intitule }}</div>
<div class="container-fluid" style="background:#fff">
	<input type="hidden" id="cadre_developpement_id" name="cadre_developpement_id" value="{{ old('cadre_developpement_id', $cadreDeveloppement->id) }}" >
  <style>
		    label.invalid{font-size:12.8px;font-size:.8rem;font-weight:500;color:red!important;top:50px!important}label.invalid.active{-webkit-transform:translateY(0)!important;-ms-transform:translateY(0)!important;transform:translateY(0)!important}ul.stepper .wait-feedback{left:0;right:0;top:0;z-index:2;position:absolute;width:100%;height:100%;text-align:center;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center}ul.stepper .step{position:relative;list-style:none}ul.stepper .step.feedbacking .step-new-content>:not(.wait-feedback){opacity:.1;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=10)"}ul.stepper .step:not(:last-of-type).active{margin-bottom:2.25rem}ul.stepper .step:before{position:absolute;top:.75rem;counter-increment:section;content:counter(section);height:1.75rem;width:1.75rem;color:#fff;background-color:rgba(0,0,0,.3);-webkit-border-radius:100%;border-radius:100%;text-align:center;line-height:1.75rem;font-weight:400}ul.stepper .step.done:before,ul.stepper .step.wrong:before{font-family:'Font Awesome 5 free';font-weight:900}ul.stepper .step.active:before{background-color:#4285f4}ul.stepper .step.done:before{content:'\f00c';font-size:1rem;background-color:#00c851}ul.stepper .step.wrong:before{content:'\f071';font-size:1.1rem;background-color:#ff3547}ul.stepper>li:not(:last-of-type){margin-bottom:.625rem;-webkit-transition:margin-bottom .4s;-o-transition:margin-bottom .4s;transition:margin-bottom .4s}ul.stepper .step-title{margin:0 -1.3rem;cursor:pointer;padding:.9688rem 2.75rem 1.5rem 4rem;display:block}ul.stepper .step-title:after{content:attr(data-step-label);display:block;position:absolute;font-size:.8rem;color:#424242;font-weight:400}ul.stepper .step-title:hover{background-color:rgba(0,0,0,.06)}ul.stepper .step.active .step-title{font-weight:500}ul.stepper .step-new-content{position:relative;display:none;height:calc(100% - 132px);width:inherit;overflow:visible;margin-left:41px;margin-right:24px}ul.stepper>.step:not(:last-of-type):after{content:'';position:absolute;top:3.125rem;left:.8438rem;width:.0625rem;height:40%;height:calc(100% - 38px);background-color:rgba(0,0,0,.1);-webkit-transition:all .4s;-o-transition:all .4s;transition:all .4s}ul.stepper>.step.active:not(:last-child):after{height:93%;height:calc(100% - 12px)}ul.stepper>.step[data-last=true]{margin-bottom:0}ul.stepper>.step[data-last=true]:after{height:0;width:0}ul.stepper .step-actions{display:-webkit-box;-webkit-box-pack:start}ul.stepper .step-actions .btn-flat:not(:last-child),ul.stepper .step-actions .btn-large:not(:last-child),ul.stepper .step-actions .btn:not(:last-child){margin-right:.3125rem}ul.stepper .step-new-content .row{margin-bottom:.4375rem}ul.stepper .md-form label{left:.875rem}ul.stepper .md-form .validate{margin-bottom:0}@media only screen and (min-width:993px){ ul.stepper.horizontal{position:relative;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;-ms-flex-pack:justify;justify-content:space-between;min-height:20rem;margin-left:-1.5rem;margin-right:-1.5rem;padding-left:1.5rem;padding-right:1.5rem;overflow:hidden} ul.stepper.horizontal:before{content:'';background-color:transparent;width:100%;min-height:5.25rem;position:absolute;left:-3px;-webkit-border-top-left-radius:2px;border-top-left-radius:2px} ul.stepper.horizontal:first-child{margin-top:-2.7rem} ul.stepper.horizontal .step{position:static;margin:0;width:100%;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;height:5.25rem!important} ul.stepper.horizontal .step:not(:last-of-type):after{content:'';position:static;display:inline-block;width:100%;height:.0625rem} ul.stepper.horizontal>.step:last-of-type, ul.stepper.horizontal>.step[data-last=true]{width:auto!important} ul.stepper.horizontal>.step.active:not(:last-of-type):after{content:'';position:static;display:inline-block;width:100%;height:.0625rem} ul.stepper.horizontal .step.active .step-title:before{background-color:#4285f4} ul.stepper.horizontal .step.done .step-title:before{font-family:'Font Awesome 5 Free';font-weight:900;content:'\f00c';font-size:1rem;background:#00c851} ul.stepper.horizontal .step.wrong .step-title:before{font-family:'Font Awesome 5 Free';font-weight:900;content:'\f071';font-size:1.1rem;background-color:#ff3547} ul.stepper.horizontal .step-title{line-height:5.25rem;height:5.25rem;margin:0;padding:0 1.5625rem 0 4.0625rem;display:inline-block;max-width:13.75rem;white-space:nowrap;overflow:hidden;-o-text-overflow:ellipsis;text-overflow:ellipsis;-ms-flex-negative:0;-webkit-flex-shrink:0;flex-shrink:0} ul.stepper.horizontal .step:before{content:none} ul.stepper.horizontal .step .step-title:before{position:absolute;top:1.7813rem;left:1.1875rem;counter-increment:section;content:counter(section);height:1.75rem;width:1.75rem;color:#fff;background-color:rgba(0,0,0,.3);-webkit-border-radius:100%;border-radius:100%;text-align:center;line-height:1.75rem;font-weight:400} ul.stepper.horizontal .step-title:after{top:.9375rem} ul.stepper.horizontal .step-new-content{position:absolute;height:calc(100% - 84px);top:6rem;left:0;width:100%;overflow-y:auto;overflow-x:hidden;margin:0;padding:1.25rem 1.25rem 4.75rem} ul.stepper.horizontal .step-actions{position:absolute;bottom:0;left:0;width:100%;padding:20px;-webkit-box-orient:horizontal;-webkit-box-direction:reverse;-webkit-flex-direction:row-reverse;-ms-flex-direction:row-reverse;flex-direction:row-reverse} ul.stepper.horizontal .step-actions .btn-flat:not(:last-child), ul.stepper.horizontal .step-actions .btn-large:not(:last-child), ul.stepper.horizontal .step-actions .btn:not(:last-child){margin-left:.3125rem;margin-right:0} ul.stepper.horizontal .step-actions, ul.stepper.horizontal .step-new-content{padding-left:2.5rem;padding-right:2.5rem}}
		    ul.horizontal-fix li a {
		        padding: .84rem 2.14rem;
		        }

		.ztree li span.button.add {margin-left:2px; margin-right: -1px; background-position:-144px 0; vertical-align:top; *vertical-align:middle}

		.ztree{
			overflow-y: scroll;
			height: 500px;
			scrollbar-width: thin;
		}
		/* Augmenter la taille du texte */
		.ztree li span {
			font-size: 16px; /* par défaut ~12px */
		}

		/* Augmenter l’espacement vertical entre les lignes */
		/*.ztree li {
			line-height: 18px;
			padding: 4px 3;
			white-space: normal !important
		}*/
		.ztree li span.node_name {
			white-space: normal; /* autorise le retour à la ligne */
			display: inline-block; /* garde l'alignement avec l'icône */
			word-break: break-word; /* coupe les mots trop longs */
		}

		/* Champ de saisie lors de l’édition */
		.ztree li input.rename {
			font-size: 16px;
			width: 250px;
			height: 28px;
			padding: 4px 8px;
		}

		div#rMenu {position:absolute; visibility:hidden; top:0; background-color: #555;text-align: left;padding: 2px;width: 200px;height: 130px;}
		div#rMenu ul li{
			margin: 1px 0;
			padding: 0 5px;
			cursor: pointer;
			list-style: none outside none;
			background-color: #DFDFDF;
			margin-left: -32px

		}
		div#rMenu li:hover {
			background-color: #007bff; /* ou ta couleur de choix */
			color: #fff; /* texte blanc sur fond bleu */
		}

		/* ========================================
		   NOUVEAU STYLE POUR LES ZONES REDIMENSIONNABLES
		   ======================================== */

		.resize-container {
			display: flex;
			width: 100%;
			height: calc(100vh - 250px);
			min-height: 600px;
			border: 1px solid #dee2e6;
			border-radius: 8px;
			overflow: hidden;
			background: #fff;
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		}

		.resize-panel {
			position: relative;
			display: flex;
			flex-direction: column;
			overflow: hidden;
			background: #fff;
		}

		.resize-panel-header {
			padding: 15px;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			font-weight: 600;
			font-size: 16px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-bottom: 3px solid #f8f9fa;
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		}

		.resize-panel-header.panel-1 {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		}

		.resize-panel-header.panel-2 {
			background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
		}

		.resize-panel-header.panel-3 {
			background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
		}

		.resize-panel-body {
			flex: 1;
			overflow: auto;
			padding: 10px;
		}

		.resize-handle {
			width: 8px;
			background: #e9ecef;
			cursor: col-resize;
			position: relative;
			flex-shrink: 0;
			transition: background 0.2s;
		}

		.resize-handle:hover {
			background: #007bff;
		}

		.resize-handle::before {
			content: '';
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			width: 3px;
			height: 40px;
			background: rgba(0,0,0,0.1);
			border-radius: 2px;
		}

		.header-icons {
			display: flex;
			gap: 10px;
		}

		.header-icons a {
			color: white;
			text-decoration: none;
			font-size: 18px;
			transition: transform 0.2s;
		}

		.header-icons a:hover {
			transform: scale(1.2);
		}

		.search-box {
			margin-bottom: 10px;
		}

		.search-box input {
			border-radius: 20px;
			border: 1px solid #dee2e6;
			padding: 8px 15px;
		}

		.search-box .btn {
			border-radius: 0 20px 20px 0;
		}

		/* Amélioration du zTree */
		.ztree {
			overflow-y: auto;
			height: calc(100% - 50px);
			scrollbar-width: thin;
			scrollbar-color: #007bff #f1f1f1;
		}

		.ztree::-webkit-scrollbar {
			width: 8px;
		}

		.ztree::-webkit-scrollbar-track {
			background: #f1f1f1;
			border-radius: 10px;
		}

		.ztree::-webkit-scrollbar-thumb {
			background: #007bff;
			border-radius: 10px;
		}

		.ztree::-webkit-scrollbar-thumb:hover {
			background: #0056b3;
		}

		/* Animation pour le drag & drop */
		.tmpzTreeMove_arrow {
			opacity: 0.8;
		}

		.ztree li a.curSelectedNode {
			background-color: #007bff !important;
			color: white !important;
			border: 1px solid #0056b3;
		}

		.page-title {
			font-size: 24px;
			font-weight: 700;
			color: #333;
			padding: 15px 20px;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			border-radius: 8px;
			margin-bottom: 20px;
			box-shadow: 0 4px 6px rgba(0,0,0,0.1);
		}
		</style>

		<script type="text/javascript">
	  var zNodesIndicateur =[
		  { id:0, pId:0, name:"/", open:true}
	  ];
	  var zNodescadre_logique =[
			{ id:0, pId:0, name:"/", open:true}

		];

	  var zNodesIndicateurSelectionnes =[];
	</script>

	<script>
		@foreach($indicateurs as $indicateur)
			zNodesIndicateur.push({
				id: {{ $indicateur->id }},
				pId: 0,
				name: @json($indicateur->intitule)
			});
		@endforeach

		@foreach($cadre_logiques as $cadre_logique)
			zNodescadre_logique.push({
				id: {{ $cadre_logique->id }},
				pId: {{ $cadre_logique->cadre_logique_id ?? 0 }},
				name: @json($cadre_logique->intitule)
			});
		@endforeach
	</script>



	<script type="text/javascript">

			var tempNode = null;
			var settingcadre_logique = {
					view: {
						showIcon: showIconForTree,
						addHoverDom: addHoverDomcadre_logique,
						removeHoverDom: removeHoverDomcadre_logique
					},
					edit: {
						enable: true,
						editNameSelectAll: true,
						showRemoveBtn: true,
						showRenameBtn: true,
						drag: {
							autoExpandTrigger: true,
							isCopy: false,
							isMove: true,
							prev: true,
							next: true,
							inner: true
						}
					},
					data: {
						simpleData: {
							enable: true
						}
					},
					callback: {
						beforeClick: beforeClickcadre_logique,
						onClick: onClickcadre_logique,
						beforeEditName: beforeEditNamecadre_logique,
						beforeRemove: beforeRemovecadre_logique,
						beforeRename: beforeRenamecadre_logique,
						onRemove: onRemovecadre_logique,
						onRename: onRenamecadre_logique,
						onRightClick: OnRightClick,
						beforeDrag: beforeDragcadre_logique,
						beforeDrop: beforeDropcadre_logique,
						onDrop: onDropcadre_logique
					}
				};

				// Fonction avant le drag
				function beforeDragcadre_logique(treeId, treeNodes) {
					// Empêcher de déplacer la racine
					for (var i=0,l=treeNodes.length; i<l; i++) {
						if (treeNodes[i].id === 0) {
							return false;
						}
					}
					return true;
				}

				// Fonction avant le drop
				function beforeDropcadre_logique(treeId, treeNodes, targetNode, moveType) {
					// Empêcher de déposer sur la racine
					if (!targetNode) return false;
					if (targetNode.id === 0 && moveType === "inner") {
						return true; // Autoriser le dépôt sous la racine
					}
					return true;
				}

				// Fonction après le drop - Mise à jour en base de données
				function onDropcadre_logique(event, treeId, treeNodes, targetNode, moveType) {
					var movedNode = treeNodes[0];
					var newParentId = null;

					// Déterminer le nouveau parent_id
					if (moveType === "inner") {
						// Déposé à l'intérieur d'un nœud
						newParentId = targetNode.id;
					} else if (moveType === "prev" || moveType === "next") {
						// Déposé avant ou après un nœud (même niveau)
						newParentId = targetNode.pId || 0;
					}

					// Si déposé sous la racine (id=0), le parent_id doit être null en base
					var parentIdForDb = (newParentId === 0) ? null : newParentId;

					console.log("Déplacement du nœud:", {
						nodeId: movedNode.id,
						nodeName: movedNode.name,
						oldParentId: movedNode.pId,
						newParentId: newParentId,
						moveType: moveType
					});

					// Mettre à jour en base de données via AJAX
					$.ajax({
						url: '/api/cadre_mesure_resultats/' + movedNode.id + '/update-parent',
						type: 'PUT',
						data: JSON.stringify({
							parent_id: parentIdForDb
						}),
						contentType: 'application/json',
						success: function(response) {
							console.log("Parent mis à jour avec succès", response);
							// Mettre à jour le nœud local
							movedNode.pId = newParentId;

							// Afficher une notification de succès
							showNotification('success', 'Déplacement réussi', 'L\'élément a été déplacé avec succès.');
						},
						error: function(xhr) {
							console.error("Erreur lors de la mise à jour du parent:", xhr.responseText);
							// Afficher une notification d'erreur
							showNotification('error', 'Erreur', 'Impossible de déplacer l\'élément. ' + xhr.responseText);

							// Recharger l'arbre pour annuler le déplacement visuel
							location.reload();
						}
					});
				}

				// Fonction pour afficher des notifications
				function showNotification(type, title, message) {
					// Utiliser un simple alert pour l'instant (peut être remplacé par un toast)
					if (type === 'error') {
						alert(title + ': ' + message);
					} else {
						// Notification discrète pour le succès
						console.log(title + ': ' + message);
					}
				}



				function beforeClickcadre_logique(treeId, treeNode, clickFlag) {
					return (treeNode.click != false);
				}
				function onClickcadre_logique(event, treeId, treeNode, clickFlag) {
					$.ajax({
						url: '/api/cadre_mesure_resultats/' + treeNode.id + '/indicateurs',
						type: 'GET',
						success: function (data) {
							// Construction du noeud racine "/"
							var rootNode = {
								id: 0,
								pId: null,
								name: "/",
								open: true, // affiché par défaut
								isParent: true
							};

							// Liste des indicateurs sélectionnés et non sélectionnés
							var selectedIndicators = data.selected.map(function (item) {
								return {
									id: item.id,
									pId: 0, // sous la racine
									name: item.intitule
								};
							});

							var notSelectedIndicators = data.notSelected.map(function (item) {
								return {
									id: item.id,
									pId: 0, // sous la racine
									name: item.intitule
								};
							});

							// Fusion des noeuds racine + enfants
							selectedIndicators.unshift(rootNode);
							notSelectedIndicators.unshift(rootNode);

							// Activation de l’édition
							var editableSetting = $.extend(true, {}, settingIndicateur, {
								edit: {
									enable: true,
									editNameSelectAll: true,
									showRemoveBtn: true,
									showRenameBtn: true
								},
								data: {
									simpleData: {
										enable: true
									}
								}
							});

							//Initialisation des arbres
							$.fn.zTree.init($("#liste_indicateur_selectionnes"), editableSetting, selectedIndicators);
							$.fn.zTree.init($("#liste_indicateur"), editableSetting, notSelectedIndicators);
						},
						error: function (xhr) {
							console.error("Erreur :", xhr.responseText);
						}
					});
				}

				/*function onClickcadre_logique(event, treeId, treeNode, clickFlag) {

					$.ajax({
						url: '/api/cadre_mesure_resultats/'+treeNode.id+'/indicateurs',
						type: 'GET',
						success: function (data) {
							var selectedIndicators = data.selected.map(function(item) {
								return {
									id: item.id,
									pId: 0,               // racine
									name: item.intitule   // affichage
								};
							});

							var notSelectedIndicators = data.notSelected.map(function(item) {
								return {
									id: item.id,
									pId: 0,               // racine
									name: item.intitule   // affichage
								};
							});

							$.fn.zTree.init($("#liste_indicateur_selectionnes"), settingIndicateur, selectedIndicators);
							$.fn.zTree.init($("#liste_indicateur"), settingIndicateur, notSelectedIndicators);

						},
						error: function (xhr) {
							console.error("Erreur :", xhr.responseText);
						}
					});

				}*/
				var log, className = "dark";
				function beforeEditNamecadre_logique(treeId, treeNode) {
					var zTree = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					zTree.selectNode(treeNode);
					setTimeout(function() {
							zTree.editName(treeNode);

						}, 0);
					return false;
				}
				function beforeRenamecadre_logique(treeId, treeNode, newName, isCancel) {
					className = (className === "dark" ? "":"dark");
					if (newName.length == 0) {
						setTimeout(function() {
							var zTree = $.fn.zTree.getZTreeObj("liste_cadre_logique");
							zTree.cancelEditName();
							alert("le libelle ne doit pas être vide");
						}, 0);
						return false;
					}

					return true;
				}
				function onRenamecadre_logique(e, treeId, treeNode, isCancel) {

					if(tempNode != null)
					{
						cadre_developpement_id = $('#cadre_developpement_id').val();
						$.ajax({
							url: '/api/cadre_logiques/',
							type: 'POST',
							data: {
								id: treeNode.id,
								intitule: treeNode.name,
								cadre_logique_id: treeNode.pId,
								cadre_developpement_id:cadre_developpement_id
							},
							success: function (id) {
								console.log("Ajout réussie :", id);
								treeNode.id = id;
							},
							error: function (xhr) {
								console.error("Erreur :", xhr.responseText);
							}
						});

						tempNode = null;
					}
					else
					{
						cadre_developpement_id = $('#cadre_developpement_id').val();
						$.ajax({
							url: '/api/cadre_logiques/' + treeNode.id,
							type: 'PUT',
							data: {
								id: treeNode.id,
								intitule: treeNode.name,
								cadre_logique_id: treeNode.pId,
								cadre_developpement_id:cadre_developpement_id
							},
							success: function (id) {
								console.log("Mise à jour réussie :", id);
								treeNode.id = id;
							},
							error: function (xhr) {
								console.error("Erreur :", xhr.responseText);
							}
						});

					}
				}
				function beforeRemovecadre_logique(treeId, treeNode) {
					className = (className === "dark" ? "":"dark");
					var zTree = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					zTree.selectNode(treeNode);
					return confirm("Confirmer la suppression du cadre_logique : " + treeNode.name);
				}
				function onRemovecadre_logique(e, treeId, treeNode) {
					/*typecadre_logique_code = $('#typecadre_logique_code').val();*/
					$.ajax({
							url: '/api/cadre_logiques/' + treeNode.id,
							type: 'DELETE',
							data: {
								id: treeNode.id
							},
							success: function (id) {
								console.log("Suppression réussie :");

							},
							error: function (xhr) {
								console.error("Erreur :", xhr.responseText);
							}
						});


				}
				var newCount = 0;
				function addHoverDomcadre_logique(treeId, treeNode) {
					var sObj = $("#" + treeNode.tId + "_span");
					if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;
					var addStr = "<span class='button add' id='addBtn_" + treeNode.tId
						+ "' title='ajouter un élément' onfocus='this.blur();'></span>";
					sObj.after(addStr);
					var btn = $("#addBtn_"+treeNode.tId);

					if (btn) btn.bind("click", function(){
						if(treeNode.children != null)
							var indice = treeNode.children.length;
						else
							var indice = 0;
						var zTree = $.fn.zTree.getZTreeObj("liste_cadre_logique");
						var newNode_name = "nouveau";
						newCount++;
						var newNode = {id:newCount, pId:treeNode.id, name:newNode_name};
						zTree.addNodes(treeNode, newNode);
						tempNode = newNode;

						last_node = treeNode.children[indice];
						zTree.selectNode(last_node);
						setTimeout(function(dat) {
									zTree.editName(last_node);
								}, 0);

						return false;

					});


				};
				function removeHoverDomcadre_logique(treeId, treeNode) {
					$("#addBtn_"+treeNode.tId).unbind().remove();
				};

				function showRemoveBtn(treeId, treeNode) {
					return !treeNode.isFirstNode;
				}
				function showRenameBtn(treeId, treeNode) {
					return !treeNode.isLastNode;
				}
				function showLog(str) {
					if (!log) log = $("#log");
					log.append("<li class='"+className+"'>"+str+"</li>");
					if(log.children("li").length > 8) {
						log.get(0).removeChild(log.children("li")[0]);
					}
				}
				function getTime() {
					var now= new Date(),
					h=now.getHours(),
					m=now.getMinutes(),
					s=now.getSeconds(),
					ms=now.getMilliseconds();
					return (h+":"+m+":"+s+ " " +ms);
				}
				var newCount = 0;
				function addHoverDomcadre_logique(treeId, treeNode) {
					var sObj = $("#" + treeNode.tId + "_span");
					if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;
					var addStr = "<span class='button add' id='addBtn_" + treeNode.tId
						+ "' title='ajouter un élément' onfocus='this.blur();'></span>";
					sObj.after(addStr);
					var btn = $("#addBtn_"+treeNode.tId);

					if (btn) btn.bind("click", function(){
						if(treeNode.children != null)
							var indice = treeNode.children.length;
						else
							var indice = 0;
						var zTree = $.fn.zTree.getZTreeObj("liste_cadre_logique");
						var newNode_name = "nouveau";
						newCount++;
						var newNode = {id:newCount, pId:treeNode.id, name:newNode_name};
						zTree.addNodes(treeNode, newNode);
						tempNode = newNode;

						last_node = treeNode.children[indice];
						zTree.selectNode(last_node);
						setTimeout(function(dat) {
									zTree.editName(last_node);
								}, 0);

						return false;

					});


				};
				function removeHoverDomcadre_logique(treeId, treeNode) {
					$("#addBtn_"+treeNode.tId).unbind().remove();
				};

			var settingIndicateur = {
				view: {
					showIcon: showIconForTree,
					addHoverDom: addHoverDomIndicateur,
					removeHoverDom: removeHoverDomIndicateur

				},
				data: {
					simpleData: {
						enable: true
					}
				},
				edit: {
					enable: true,
					editNameSelectAll: true,
					showRemoveBtn: true,
					showRenameBtn: true
				},
				callback: {
					beforeClick: beforeClickIndicateur,
					onClick: onClickIndicateur,
					beforeDblClick : beforeDblClickIndicateur,
					onDblClick: onDblClickIndicateur,
					beforeEditName: beforeEditNameIndicateur,
					beforeRemove: beforeRemoveIndicateur,
					beforeRename: beforeRenameIndicateur,
					onRemove: onRemoveIndicateur,
					onRename: onRenameIndicateur


				}
			};




			function beforeClickIndicateur(treeId, treeNode, clickFlag) {
				return (treeNode.click != false);
			}
			function onClickIndicateur(event, treeId, treeNode, clickFlag) {

			}
			function beforeDblClickIndicateur(treeId, treeNode) {
				return (treeNode.click != false);
			};

			function onDblClickIndicateur(event, treeId, treeNode) {
				var cadre_logiqueTreeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
				var cadre_logiqueTreeNodes = cadre_logiqueTreeObj.getSelectedNodes();
				var cadre_logiqueLength = cadre_logiqueTreeNodes.length;
				if(treeId == "liste_indicateur")
				{
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					var treeNodes = sourceTreeObj.getSelectedNodes();

					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur_selectionnes");

					var params =[];

					if(cadre_logiqueLength > 0)
					{

							var indicateur = treeNodes[0];
							if(indicateur.name != "/")
							{
								destinationTreeObj.addNodes(null, indicateur);
								sourceTreeObj.removeNode(indicateur);
								$.ajax({
									url: '/api/cadre_mesure_resultats/',
									type: 'POST',
									data: {
										indicateur_id: indicateur.id,
										cadre_logique_id:cadre_logiqueTreeNodes[0].id
									},
									success: function (id) {
										console.log("Ajout réussie :", id);
										treeNode.id = id;
									},
									error: function (xhr) {
										console.error("Erreur :", xhr.responseText);
									}
								});

							}

					}

				}
				else if(treeId == "liste_indicateur_selectionnes")
				{
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur_selectionnes");
					var treeNodes = sourceTreeObj.getSelectedNodes();

					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");

					var params =[];

					if(cadre_logiqueLength > 0)
					{

							var indicateur = treeNodes[0];
							/*destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0], indicateur);
							sourceTreeObj.removeNode(indicateur);*/

							destinationTreeObj.addNodes(null, indicateur);
							sourceTreeObj.removeNode(indicateur);

							$.ajax({
								url: '/api/cadre_mesure_resultats/'+cadre_logiqueTreeNodes[0].id+'/'+indicateur.id,
								type: 'DELETE',
								success: function (id) {
									console.log("Suppression réussie :", id);
									treeNode.id = id;
								},
								error: function (xhr) {
									console.error("Erreur :", xhr.responseText);
								}
							});

					}

				}

			};

			function showIconForTree(treeId, treeNode) {
				/*return !treeNode.isParent;*/
			};

			function beforeEditNameIndicateur(treeId, treeNode) {
				var zTree = $.fn.zTree.getZTreeObj("liste_indicateur");
				zTree.selectNode(treeNode);
				setTimeout(function() {
						zTree.editName(treeNode);
					}, 0);
				return false;
			}
			function beforeRenameIndicateur(treeId, treeNode, newName, isCancel) {
				className = (className === "dark" ? "":"dark");
				if (newName.length == 0) {
					setTimeout(function() {
						var zTree = $.fn.zTree.getZTreeObj("liste_indicateur");
						zTree.cancelEditName();
						alert("le libelle ne doit pas être vide");
					}, 0);
					return false;
				}

				return true;
			}
			function onRenameIndicateur(e, treeId, treeNode, isCancel) {

				if(tempNode != null)
				{
					$.ajax({
						url: '/api/indicateurs/',
						type: 'POST',
						data: {
							id: treeNode.id,
							intitule: treeNode.name
						},
						success: function (id) {
							console.log("Ajout réussie :", id);
							treeNode.id = id;
						},
						error: function (xhr) {
							console.error("Erreur :", xhr.responseText);
						}
					});

					tempNode = null;
				}
				else
				{
					$.ajax({
						url: '/api/indicateurs/' + treeNode.id,
						type: 'PUT',
						data: {
							id: treeNode.id,
							intitule: treeNode.name
						},
						success: function (id) {
							console.log("Mise à jour réussie :", id);
							treeNode.id = id;
						},
						error: function (xhr) {
							console.error("Erreur :", xhr.responseText);
						}
					});

				}
			}
			function beforeRemoveIndicateur(treeId, treeNode) {
				className = (className === "dark" ? "":"dark");
				var zTree = $.fn.zTree.getZTreeObj("liste_indicateur");
				zTree.selectNode(treeNode);
				return confirm("Confirmer la suppression de l'indicateur : " + treeNode.name);
			}
			function onRemoveIndicateur(e, treeId, treeNode) {
				$.ajax({
						url: '/api/indicateurs/' + treeNode.id,
						type: 'DELETE',
						data: {
							id: treeNode.id,
							intitule: treeNode.name
						},
						success: function (response) {
							console.log("Suppression réussie :", response);
						},
						error: function (xhr) {
							console.error("Erreur :", xhr.responseText);
						}
					});
			}

			var newCount = 0;
			function addHoverDomIndicateur(treeId, treeNode) {
				if(treeNode.id == 0){
				var sObj = $("#" + treeNode.tId + "_span");
				if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;
				var addStr = "<span class='button add' id='addBtn_" + treeNode.tId
					+ "' title='ajouter un élément' onfocus='this.blur();'></span>";
				sObj.after(addStr);
				var btn = $("#addBtn_"+treeNode.tId);

				if (btn) btn.bind("click", function(){
					if(treeNode.children != null)
						var indice = treeNode.children.length;
					else
						var indice = 0;
					var zTree = $.fn.zTree.getZTreeObj("liste_indicateur");
					var newNode_name = "nouveau indicateur";
					newCount++;
					var newNode = {id:newCount, pId:treeNode.id, name:newNode_name};
					zTree.addNodes(treeNode, 0, newNode);
					tempNode = newNode;
					last_node = treeNode.children[0];
					zTree.selectNode(last_node);
					setTimeout(function() {
						zTree.editName(last_node);
					}, 0);

					return false;

				});

			}
			};
			function removeHoverDomIndicateur(treeId, treeNode) {
				$("#addBtn_"+treeNode.tId).unbind().remove();
			};

			function OnRightClick(event, treeId, treeNode) {
				// Vérifie que le clic droit concerne uniquement le zTree du cadre logique
				if (treeId !== "liste_cadre_logique") {
					return; // on ignore les clics droits sur les autres arbres
				}

				var zTree = $.fn.zTree.getZTreeObj("liste_cadre_logique");
				if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
					// Aucun nœud cliqué
					zTree.cancelSelectedNode();
					hideRMenu(); // ne rien afficher
				} else if (treeNode && !treeNode.noR) {
					// Sélection du nœud et affichage du menu contextuel
					zTree.selectNode(treeNode);
					showRMenu("node", event.clientX, event.clientY);
				}
			}

			function showRMenu(type, x, y) {
				// On n'affiche le menu contextuel que pour les nœuds de cadre_logique
				if (type !== "node") {
					hideRMenu();
					return;
				}

				$("#rMenu ul").show();
				$("#m_del").show();
				$("#m_check").show();
				$("#m_unCheck").show();

				// Positionner le menu
				y += document.body.scrollTop || document.documentElement.scrollTop;
				x += document.body.scrollLeft || document.documentElement.scrollLeft;

				$("#rMenu").css({
					"top": y + "px",
					"left": x + "px",
					"visibility": "visible"
				});

				$("body").bind("mousedown", onBodyMouseDown);
			}

			function hideRMenu() {
				$("#rMenu").css({"visibility": "hidden"});
				$("body").unbind("mousedown", onBodyMouseDown);
			}

			function onBodyMouseDown(event) {
				if (!(event.target.id == "rMenu" || $(event.target).parents("#rMenu").length > 0)) {
					hideRMenu();
				}
			}

		</script>
		@if(session('failed_indicateurs'))
		<script>
			$(function () {
				@foreach(session('failed_indicateurs') as $indicateur)
					$(document).Toasts('create', {
						class: 'bg-danger',
						title: 'Import échoué',
						body: `
							<strong>Code :</strong> {{ $indicateur['code'] }}<br>
							<strong>Intitulé :</strong> {{ $indicateur['intitule'] }}<br>
							<strong>Raison :</strong> {{ $indicateur['raison'] }}
						`,
						autohide: false
					});
				@endforeach
			});
		</script>
		@endif


		<!-- Zone redimensionnable moderne avec 3 panneaux -->
		<div class="resize-container">

			<!-- PANNEAU 1 : Cadre de Résultat -->
			<div class="resize-panel" id="panel-1" style="flex: 1;">
				<div class="resize-panel-header panel-1">
					<span><i class="fas fa-project-diagram mr-2"></i>Cadre de Résultat</span>
					<div class="header-icons">
						<a href="#" id="uploadCadreLogique" title="Upload Cadre Logique">
							<i class="fas fa-file-upload"></i>
						</a>
					</div>
				</div>
				<div class="resize-panel-body">
					<div class="search-box">
						<div class="input-group">
							<input type="text" id="search_cadre_logique" class="form-control form-control-sm" placeholder="Rechercher...">
							<div class="input-group-append">
								<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
					<ul id="liste_cadre_logique" class="ztree"></ul>
				</div>
			</div>

			<!-- Séparateur redimensionnable 1 -->
			<div class="resize-handle" data-panel="1"></div>

			<!-- PANNEAU 2 : Indicateurs disponibles -->
			<div class="resize-panel" id="panel-2" style="flex: 1.3;">
				<div class="resize-panel-header panel-2">
					<span><i class="fas fa-chart-line mr-2"></i>Indicateurs disponibles</span>
					<div class="header-icons">
						<a href="#" id="uploadIndicateur" title="Upload Indicateur">
							<i class="fas fa-file-upload"></i>
						</a>
						<a href="#" id="infosIndicateurDisponible" title="Infos Indicateur">
							<i class="fas fa-info-circle"></i>
						</a>
						<a href="#" id="transfererIndicateurDisponibleVersSelectionne" title="Transférer vers associés">
							<i class="fas fa-angle-double-right"></i>
						</a>
					</div>
				</div>
				<div class="resize-panel-body">
					<div class="search-box">
						<div class="input-group">
							<input type="text" id="search_indicateur" class="form-control form-control-sm" placeholder="Rechercher...">
							<div class="input-group-append">
								<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
					<ul id="liste_indicateur" class="ztree"></ul>
				</div>
			</div>

			<!-- Séparateur redimensionnable 2 -->
			<div class="resize-handle" data-panel="2"></div>

			<!-- PANNEAU 3 : Indicateurs associés -->
			<div class="resize-panel" id="panel-3" style="flex: 1;">
				<div class="resize-panel-header panel-3">
					<span><i class="fas fa-link mr-2"></i>Indicateurs associés</span>
					<div class="header-icons">
						<a href="#" id="infosIndicateurSelectionne" title="Infos Indicateur">
							<i class="fas fa-info-circle"></i>
						</a>
						<a href="#" id="transfererIndicateurSelectionneVersDisponible" title="Transférer vers disponibles">
							<i class="fas fa-angle-double-left"></i>
						</a>
					</div>
				</div>
				<div class="resize-panel-body">
					<div class="search-box">
						<div class="input-group">
							<input type="text" id="search_indicateur_selectionnes" class="form-control form-control-sm" placeholder="Rechercher...">
							<div class="input-group-append">
								<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
					<ul id="liste_indicateur_selectionnes" class="ztree"></ul>
				</div>
			</div>

		</div>

		<script>
		// Script pour le redimensionnement des panneaux
		document.addEventListener('DOMContentLoaded', function() {
			const handles = document.querySelectorAll('.resize-handle');

			handles.forEach(handle => {
				let isResizing = false;
				let startX = 0;
				let startWidthLeft = 0;
				let startWidthRight = 0;
				let leftPanel = null;
				let rightPanel = null;

				handle.addEventListener('mousedown', function(e) {
					isResizing = true;
					startX = e.clientX;

					// Détermine les panneaux à gauche et à droite
					leftPanel = handle.previousElementSibling;
					rightPanel = handle.nextElementSibling;

					if (leftPanel && rightPanel &&
					    leftPanel.classList.contains('resize-panel') &&
					    rightPanel.classList.contains('resize-panel')) {
						startWidthLeft = leftPanel.offsetWidth;
						startWidthRight = rightPanel.offsetWidth;

						// Ajoute un overlay pour éviter les problèmes avec iframe/zTree
						document.body.style.cursor = 'col-resize';
						document.body.style.userSelect = 'none';
					}
				});

				document.addEventListener('mousemove', function(e) {
					if (!isResizing || !leftPanel || !rightPanel) return;

					const diff = e.clientX - startX;
					const newWidthLeft = startWidthLeft + diff;
					const newWidthRight = startWidthRight - diff;

					// Largeurs minimales : 250px
					if (newWidthLeft >= 250 && newWidthRight >= 250) {
						const totalWidth = newWidthLeft + newWidthRight;
						leftPanel.style.flex = `0 0 ${newWidthLeft}px`;
						rightPanel.style.flex = `0 0 ${newWidthRight}px`;
					}
				});

				document.addEventListener('mouseup', function() {
					if (isResizing) {
						isResizing = false;
						document.body.style.cursor = '';
						document.body.style.userSelect = '';
						leftPanel = null;
						rightPanel = null;
					}
				});
			});
		});
		</script>

		<script>
			var zTree, rMenu;
			$(document).ready(function () {
				$.fn.zTree.init($("#liste_indicateur"), settingIndicateur, zNodesIndicateur);
				$.fn.zTree.init($("#liste_cadre_logique"), settingcadre_logique, zNodescadre_logique);
				$.fn.zTree.init($("#liste_indicateur_selectionnes"), settingIndicateur, zNodesIndicateurSelectionnes);
				rMenu = $("#rMenu");
				zTree = $.fn.zTree.getZTreeObj("liste_cadre_logique");
				$(".toast").toast();

				$('#search_cadre_logique').keypress(function(){
			    	 if($(this).val() != "")
			    	 {
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_cadre_logique"), settingcadre_logique, nodes);
			    	 }else
			    	{
			    		$.fn.zTree.init($("#liste_cadre_logique"), settingcadre_logique, zNodescadre_logique);
			    	}

			      });
				$('#search_indicateur').keypress(function(){
			    	 if($(this).val() != "")
			    	 {
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_indicateur"), settingIndicateur, nodes);
			    	 }else
			    	{
			    		 $.fn.zTree.init($("#liste_indicateur"), settingIndicateur, zNodesIndicateur);
			    	}

			      });
				$('#search_indicateur_selectionnes').keypress(function(){
			    	 if($(this).val() != "")
			    	 {
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_indicateur_selectionnes");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_indicateur_selectionnes"), settingIndicateur, nodes);
			    	 }else
			    	{
			    		 $.fn.zTree.init($("#liste_indicateur_selectionnes"), settingIndicateur, zNodesIndicateurSelectionnes);

			    	}

			      });


				$('#transfererIndicateurDisponibleVersSelectionne').click(function(){
					var cadre_logiqueTreeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					var cadre_logiqueTreeNodes = cadre_logiqueTreeObj.getSelectedNodes();
					var cadre_logiqueLength = cadre_logiqueTreeNodes.length;

					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var l=treeNodes.length;

					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur_selectionnes");


					if(cadre_logiqueLength > 0)
					{

						let associations = [];
						let cadreLogiqueId = cadre_logiqueTreeNodes[0].id;
						while (l>0) {
							var indicateur = treeNodes[l-1];
							destinationTreeObj.addNodes(null, indicateur);
							sourceTreeObj.removeNode(indicateur);
							l--;

							associations.push({
								indicateur_id: indicateur.id,
								cadre_logique_id: cadreLogiqueId
							});

						}


						$.ajax({
							url: '/api/cadre_mesure_resultats/storeBatch',
							type: 'POST',
							data: JSON.stringify({ associations: associations }),
							contentType: 'application/json',
							success: function(dat) {
								console.log("Associations enregistrées avec succès", dat);
							},
							error: function(xhr) {
								console.error("Erreur :", xhr.responseText);
							}
						});
					}

				});

				$('#transfererIndicateurSelectionneVersDisponible').click(function(){
					var cadre_logiqueTreeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					var cadre_logiqueTreeNodes = cadre_logiqueTreeObj.getSelectedNodes();
					var cadre_logiqueLength = cadre_logiqueTreeNodes.length;

					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur_selectionnes");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var l=treeNodes.length;

					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");

					var params =[];
					var p = 0;

					if(cadre_logiqueLength > 0)
					{
						let associations = [];
						let cadreLogiqueId = cadre_logiqueTreeNodes[0].id;
						while (l>0) {
							var indicateur = treeNodes[l-1];
							destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0], indicateur);
							sourceTreeObj.removeNode(indicateur);
							l--;
							associations.push({
								indicateur_id: indicateur.id,
								cadre_logique_id: cadreLogiqueId
							});
						}
						$.ajax({
							url: '/api/cadre_mesure_resultats/deleteBatch',
							type: 'POST',
							data: JSON.stringify({ associations: associations }),
							contentType: 'application/json',
							success: function(dat) {
								console.log("Associations enregistrées avec succès", dat);
							},
							error: function(xhr) {
								console.error("Erreur :", xhr.responseText);
							}
						});
					}

				});

				$('#infosIndicateurDisponible').click(function(){
					/*typecadre_logique_code = $('#typecadre_logique_code').val();*/
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var indicateur = treeNodes[0];
					/*$.get('/ajouterFicheTechnique/'+indicateur.id+'/'+typecadre_logique_code,function(dat){*/
					$.get('/ajouterFicheTechnique/'+indicateur.id,function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});

				});


				$('#uniteIndicateurDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var indicateur = treeNodes[0];
					$.get('/ajouterUniteIndicateur/'+indicateur.id,function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});

				});

				$('#desagregationIndicateurDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var indicateur = treeNodes[0];
					$.get('/indicateurs/'+indicateur.id+'/desagregation',function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});

				});

				$('#uploadIndicateur').click(function(){

					$.get('/indicateurs/upload',function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});

				});

				$('#uploadCadreLogique').click(function(){
					cadre_developpement_id = $('#cadre_developpement_id').val();
					$.get('/cadre_developpements/'+cadre_developpement_id+'/cadres_logiques_upload',function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});

				});

			$('#showHypotheseRique').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var cadre_logique = treeNodes[0];
					window.location.href = '/cadre_logiques/'+cadre_logique.id+'/hypothese_risques/';

				});
			$('#showProduit').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var cadre_logique = treeNodes[0];
					window.location.href = '/cadre_logiques/'+cadre_logique.id+'/produits/';

				});
			$('#showActivite').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var cadre_logique = treeNodes[0];
					window.location.href = '/cadre_logiques/'+cadre_logique.id+'/activites/';

				});

		  });

		</script>
</div>
<div id="rMenu">
	<ul>
		<li id="showHypotheseRique">Hypothèses et Risques</li>
		<li id="showProduit">Produits</li>
		<li id="showActivite">Activités</li>
		<li id="showAxe">Axes</li>
	</ul>
</div>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/zTree.v3/3.5.42/js/jquery.ztree.all.min.js" integrity="sha512-7sGF7QJRDdvZna4GfwsdoY6a8jxCFZTAlL2OFKjmEXZ9mPwzHbKnwDiIy9RI1hYZv+XLtbOew+6slAJahxaH+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
-->
<script>
$(document).Toasts('create', {
  class: 'bg-info',
  title: 'Test',
  body: 'Toast OK'
});
</script>
@endsection
