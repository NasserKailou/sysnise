@extends('layouts.app')
@section('content')
<div id="contenu_page" class="p-3 container-fluid" style="background:#fff">
	
  <style>
		    label.invalid{font-size:12.8px;font-size:.8rem;font-weight:500;color:red!important;top:50px!important}label.invalid.active{-webkit-transform:translateY(0)!important;-ms-transform:translateY(0)!important;transform:translateY(0)!important}ul.stepper .wait-feedback{left:0;right:0;top:0;z-index:2;position:absolute;width:100%;height:100%;text-align:center;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center}ul.stepper .step{position:relative;list-style:none}ul.stepper .step.feedbacking .step-new-content>:not(.wait-feedback){opacity:.1;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=10)"}ul.stepper .step:not(:last-of-type).active{margin-bottom:2.25rem}ul.stepper .step:before{position:absolute;top:.75rem;counter-increment:section;content:counter(section);height:1.75rem;width:1.75rem;color:#fff;background-color:rgba(0,0,0,.3);-webkit-border-radius:100%;border-radius:100%;text-align:center;line-height:1.75rem;font-weight:400}ul.stepper .step.done:before,ul.stepper .step.wrong:before{font-family:'Font Awesome 5 free';font-weight:900}ul.stepper .step.active:before{background-color:#4285f4}ul.stepper .step.done:before{content:'\f00c';font-size:1rem;background-color:#00c851}ul.stepper .step.wrong:before{content:'\f071';font-size:1.1rem;background-color:#ff3547}ul.stepper>li:not(:last-of-type){margin-bottom:.625rem;-webkit-transition:margin-bottom .4s;-o-transition:margin-bottom .4s;transition:margin-bottom .4s}ul.stepper .step-title{margin:0 -1.3rem;cursor:pointer;padding:.9688rem 2.75rem 1.5rem 4rem;display:block}ul.stepper .step-title:after{content:attr(data-step-label);display:block;position:absolute;font-size:.8rem;color:#424242;font-weight:400}ul.stepper .step-title:hover{background-color:rgba(0,0,0,.06)}ul.stepper .step.active .step-title{font-weight:500}ul.stepper .step.active .step-title:after{font-weight:500}ul.stepper .step-new-content{position:relative;display:none;height:auto;overflow:visible;width:100%;padding:2rem}ul.stepper .step.active .step-new-content{display:block;overflow-y:auto;overflow-x:hidden}ul.stepper .step-actions{display:none;margin:1.5rem 0 0}ul.stepper .step.active .step-actions{display:block}ul.stepper .step-new-content .row{margin-bottom:1.4rem}ul.stepper .step-new-content .row:last-child{margin-bottom:0}ul.stepper .md-form label{position:absolute;-webkit-transition:.2s ease-out;-o-transition:.2s ease-out;transition:.2s ease-out}ul.stepper .md-form label.active{-webkit-transform:translateY(-140%);-ms-transform:translateY(-140%);transform:translateY(-140%);font-size:.8rem}ul.horizontal-fix li a{padding:.84rem 2.14rem}
		    
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

		/* Augmenter l'espacement vertical entre les lignes */
		.ztree li span.node_name {
			white-space: normal; /* autorise le retour à la ligne */
			display: inline-block; /* garde l'alignement avec l'icône */
			word-break: break-word; /* coupe les mots trop longs */
		}
		
		/* Champ de saisie lors de l'édition */
		.ztree li input.rename {
			font-size: 16px;
			width: 250px;
			height: 28px;
			padding: 4px 8px;
		}
		
		div#rMenu {position:absolute; visibility:hidden; top:0; background-color: #555;text-align: left;padding: 2px;width: 200px;height: 103px;}
		div#rMenu ul li{
			margin: 1px 0;
			padding: 0 5px;
			cursor: pointer;
			list-style: none outside none;
			background-color: #DFDFDF;
			margin-left: -32px
			
		}
		div#rMenu li:hover {
			background-color: #007bff;
			color: #fff;
		}
		
		/* ========== Nouveau style World Bank ========== */
		.wb-sidebar {
			width: 280px;
			border-right: 2px solid #e0e0e0;
			background: #fafafa;
			height: calc(100vh - 150px);
			overflow-y: auto;
			padding: 0;
		}
		
		.wb-section {
			border-bottom: 1px solid #e0e0e0;
		}
		
		.wb-section-header {
			padding: 12px 16px;
			background: #ffffff;
			border-bottom: 1px solid #e0e0e0;
			cursor: pointer;
			display: flex;
			justify-content: space-between;
			align-items: center;
			font-weight: 600;
			color: #333;
			transition: background-color 0.2s;
		}
		
		.wb-section-header:hover {
			background: #f5f5f5;
		}
		
		.wb-section-header.active {
			background: #e8f4f8;
			color: #0071bc;
		}
		
		.wb-section-icon {
			font-size: 18px;
			transition: transform 0.3s;
		}
		
		.wb-section-header.active .wb-section-icon {
			transform: rotate(180deg);
		}
		
		.wb-section-content {
			padding: 16px;
			background: #fff;
			display: none;
		}
		
		.wb-section-content.active {
			display: block;
		}
		
		.wb-counter {
			color: white;
			border-radius: 12px;
			padding: 2px 8px;
			font-size: 12px;
			font-weight: 600;
			margin-left: 8px;
		}
		
		/* Couleurs des compteurs selon la section */
		#count-indicateur {
			background: #2196f3;
		}
		
		#count-periode {
			background: #ff9800;
		}
		
		#count-zone {
			background: #4caf50;
		}
		
		#count-naturedonnee {
			background: #9c27b0;
		}
		
		.wb-main-content {
			flex: 1;
			padding: 20px;
			background: #fff;
		}
		
		.wb-preview-box {
			border: 2px solid #e0e0e0;
			border-radius: 4px;
			padding: 20px;
			min-height: 300px;
			background: #fafafa;
		}
		
		.wb-selection-item {
			padding: 8px 12px;
			margin-bottom: 8px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-radius: 4px;
			border-left: 4px solid;
			transition: all 0.2s;
		}
		
		/* Couleurs par type d'élément - Palette harmonieuse */
		.wb-selection-item[data-type="indicateur"] {
			background: #e3f2fd;
			border-color: #2196f3;
			color: #1565c0;
		}
		
		.wb-selection-item[data-type="periode"] {
			background: #fff3e0;
			border-color: #ff9800;
			color: #e65100;
		}
		
		.wb-selection-item[data-type="zone"] {
			background: #e8f5e9;
			border-color: #4caf50;
			color: #2e7d32;
		}
		
		.wb-selection-item[data-type="naturedonnee"] {
			background: #f3e5f5;
			border-color: #9c27b0;
			color: #6a1b9a;
		}
		
		.wb-selection-item:hover {
			transform: translateX(2px);
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		}
		
		.wb-selection-item .remove-btn {
			color: #666;
			cursor: pointer;
			font-size: 20px;
			font-weight: bold;
			opacity: 0.6;
			transition: all 0.2s;
		}
		
		.wb-selection-item .remove-btn:hover {
			color: #d32f2f;
			opacity: 1;
			transform: scale(1.2);
		}
		
		.wb-action-buttons {
			display: flex;
			justify-content: flex-end;
			gap: 10px;
			margin-top: 20px;
			padding: 15px;
			background: #f8f9fa;
			border-top: 2px solid #e0e0e0;
		}
		
		/* Style pour les ztree dans la sidebar */
		.wb-section-content .ztree {
			height: 350px;
			background: #fff;
		}
		
		.wb-search-box {
			margin-bottom: 10px;
		}
		
		.wb-search-box input {
			width: 100%;
			padding: 8px 12px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 14px;
		}
		
		.selection-count-badge {
			display: inline-block;
			margin-left: 10px;
			font-size: 12px;
		}
		</style>
		
		<script type="text/javascript">
		
	  var zNodesIndicateur =[
		  { id:0, pId:0, name:"/", open:true}
	  ];
	  var zNodescadre_logique =[
			{ id:0, pId:0, name:"/", open:true}
		];
	  var zNodesZone = [
			{ id:0, pId:0, name:"/", open: true}
		];
	  var zNodesPeriode = [
			{ id: 0, pId: 0, name: "/", open: true }
		];

	  var zNodesNatureDonnee = [
			{ id: 0, pId: 0, name: "/", open: true }
		];
	  
	  var zNodesIndicateurSelectionnes =[];
	  var zNodesPeriodeSelectionnes = [];
	  var zNodesZoneSelectionnes = [];
	  var zNodesNatureDonneeSelectionnes = [];
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
				pId: {{ $cadre_logique->parent_id ?? 0 }},
				name: @json($cadre_logique->intitule)
			});
		@endforeach
		
		@foreach($periodes as $periode)
			zNodesPeriode.push({
				id: {{ $periode->id }},
				pId: {{ $periode->periode_id ?? 0 }},
				name: @json($periode->intitule)
			});
		@endforeach
		
		@foreach($zones as $zone)
			zNodesZone.push({
				id: {{ $zone->id }},
				pId: {{ $zone->zone_id ?? 0 }},
				name: @json($zone->intitule)
			});
		@endforeach
		
		@foreach($nature_donnees as $nature_donnee)
			zNodesNatureDonnee.push({
				id: {{ $nature_donnee->id }},
				pId: 0,
				name: @json($nature_donnee->intitule)
			});
		@endforeach
	</script>

	<script type="text/javascript">
			
			var tempNode = null;
			var settingcadre_logique = {
					view: {
						showIcon: false
					},
					data: {
						simpleData: {
							enable: true
						}
					},
					callback: {
						beforeClick: beforeClickcadre_logique,
						onClick: onClickcadre_logique,
						onRightClick: OnRightClick
					}
				};
				
				
				
				function beforeClickcadre_logique(treeId, treeNode, clickFlag) {
					return (treeNode.click != false);
				}
				function onClickcadre_logique(event, treeId, treeNode, clickFlag) {
					
					$.ajax({
						url: '/api/cadre_mesure_resultats/'+treeNode.id+'/indicateursSelected',
						type: 'GET',
						success: function (data) {
							var selectedIndicators = data.map(function(item) {
								return {
									id: item.id,
									pId: 0,
									name: item.intitule
								};
							});
							selectedIndicators.push({
								id: 0,
								pId: null,
								name: '/',
								open:true
							});
							
							$.fn.zTree.init($("#liste_indicateur"), settingIndicateur, selectedIndicators);
							
						},
						error: function (xhr) {
							console.error("Erreur :", xhr.responseText);
						}
					});
					
				}
				function OnRightClick(event, treeId, treeNode) {
				if (treeId !== "liste_cadre_logique") {
					return;
				}

				var zTree = $.fn.zTree.getZTreeObj("liste_cadre_logique");
				if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
					zTree.cancelSelectedNode();
					hideRMenu();
				} else if (treeNode && !treeNode.noR) {
					zTree.selectNode(treeNode);
					showRMenu("node", event.clientX, event.clientY);
				}
			}

			function showRMenu(type, x, y) {
				if (type !== "node") {
					hideRMenu();
					return;
				}

				$("#rMenu ul").show();
				$("#m_del").show();
				$("#m_check").show();
				$("#m_unCheck").show();

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
				
			var settingIndicateur = {
				view: {
					showIcon: false,
					
				},
				data: {
					simpleData: {
						enable: true
					}
				},
				callback: {
					beforeClick: beforeClickIndicateur,
					onClick: onClickIndicateur,
					beforeDblClick : beforeDblClickIndicateur,
					onDblClick: onDblClickIndicateur
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

					var indicateur = treeNodes[0];
					if(cadre_logiqueLength > 0 && indicateur.name != "/")
					{
						addSelectionItem('indicateur', indicateur.id, indicateur.name);
						zNodesIndicateurSelectionnes.push(indicateur);
						updateSelectionCounts();
					}
					
				}
				
			};
			
			function showIconForTree(treeId, treeNode) {
				/*return !treeNode.isParent;*/
			};
			

		/*------------------------------------------------------*/
		var settingPeriode = {
          view: {
            showIcon: false,
          },
          data: {
            simpleData: {
              enable: true,
            },
          },
          edit: {
            enable: false,
          },
          callback: {
            beforeClick: beforeClickPeriode,
            onClick: onClickPeriode,
            beforeDblClick: beforeDblClickPeriode,
            onDblClick: onDblClickPeriode
          },
        };

        function beforeClickPeriode(treeId, treeNode, clickFlag) {
          return treeNode.click != false;
        }
        function onClickPeriode(event, treeId, treeNode, clickFlag) {}
        function beforeDblClickPeriode(treeId, treeNode) {
          return treeNode.click != false;
        }

        function onDblClickPeriode(event, treeId, treeNode) {
          if (treeId == "liste_periode") {
            var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_periode");
            var treeNodes = sourceTreeObj.getSelectedNodes();
            var periode = treeNodes[0];
            if (periode.name != "/") {
              addSelectionItem('periode', periode.id, periode.name);
				zNodesPeriodeSelectionnes.push(periode);
				updateSelectionCounts();
            }
          }
        }

        var settingZone = {
          view: {
            showIcon: false,
          },
          data: {
            simpleData: {
              enable: true,
            },
          },
          edit: {
            enable: false,
          },
          callback: {
            beforeClick: beforeClickZone,
            onClick: onClickZone,
            beforeDblClick: beforeDblClickZone,
            onDblClick: onDblClickZone
          },
        };

        function beforeClickZone(treeId, treeNode, clickFlag) {
          return treeNode.click != false;
        }
        function onClickZone(event, treeId, treeNode, clickFlag) {}
        function beforeDblClickZone(treeId, treeNode) {
          return treeNode.click != false;
        }

        function onDblClickZone(event, treeId, treeNode) {
          if (treeId == "liste_zone") {
            var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_zone");
            var treeNodes = sourceTreeObj.getSelectedNodes();
            var zone = treeNodes[0];
            if (zone.name != "/") {
              var nodeClone = {
					id: zone.id,
					name: zone.name,
					pId:zone.pId,
				};
				addSelectionItem('zone', zone.id, zone.name);
				zNodesZoneSelectionnes.push(nodeClone);
				updateSelectionCounts();
            }
          }
        }
		
		/*------------------------------------------------------*/
		var settingNatureDonnee = {
          view: {
            showIcon: false,
          },
          data: {
            simpleData: {
              enable: true,
            },
          },
          edit: {
            enable: false,
          },
          callback: {
            beforeClick: beforeClickNatureDonnee,
            onClick: onClickNatureDonnee,
            beforeDblClick: beforeDblClickNatureDonnee,
            onDblClick: onDblClickNatureDonnee
          },
        };

        function beforeClickNatureDonnee(treeId, treeNode, clickFlag) {
          return treeNode.click != false;
        }
        function onClickNatureDonnee(event, treeId, treeNode, clickFlag) {}
        function beforeDblClickNatureDonnee(treeId, treeNode) {
          return treeNode.click != false;
        }

        function onDblClickNatureDonnee(event, treeId, treeNode) {
          if (treeId == "liste_nature_donnee") {
            var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee");
            var treeNodes = sourceTreeObj.getSelectedNodes();
            var nature_donnee = treeNodes[0];
            if (nature_donnee.name != "/") {
              addSelectionItem('naturedonnee', nature_donnee.id, nature_donnee.name);
				zNodesNatureDonneeSelectionnes.push(nature_donnee);
				updateSelectionCounts();
            }
          }
        }
		
		// ========== Nouvelles fonctions pour le style World Bank ==========
		function updateSelectionCounts() {
			$('#count-indicateur').text(zNodesIndicateurSelectionnes.length);
			$('#count-periode').text(zNodesPeriodeSelectionnes.length);
			$('#count-zone').text(zNodesZoneSelectionnes.length);
			$('#count-naturedonnee').text(zNodesNatureDonneeSelectionnes.length);
		}
		
		function addSelectionItem(type, id, name) {
			// Vérifier si l'élément existe déjà
			if ($('#selection-' + type + '-' + id).length > 0) {
				return; // Déjà ajouté
			}
			
			var html = '<div class="wb-selection-item" id="selection-' + type + '-' + id + '" data-type="' + type + '" data-id="' + id + '">' +
					'<span>' + name + '</span>' +
					'<span class="remove-btn" onclick="removeSelectionItem(\'' + type + '\', ' + id + ')">&times;</span>' +
				'</div>';
			$('#preview-selections').append(html);
		}
		
		function removeSelectionItem(type, id) {
			$('#selection-' + type + '-' + id).remove();
			
			// Supprimer des arrays
			if (type === 'indicateur') {
				zNodesIndicateurSelectionnes = zNodesIndicateurSelectionnes.filter(function(item) {
					return item.id !== id;
				});
			} else if (type === 'periode') {
				zNodesPeriodeSelectionnes = zNodesPeriodeSelectionnes.filter(function(item) {
					return item.id !== id;
				});
			} else if (type === 'zone') {
				zNodesZoneSelectionnes = zNodesZoneSelectionnes.filter(function(item) {
					return item.id !== id;
				});
			} else if (type === 'naturedonnee') {
				zNodesNatureDonneeSelectionnes = zNodesNatureDonneeSelectionnes.filter(function(item) {
					return item.id !== id;
				});
			}
			
			updateSelectionCounts();
		}
		
		function clearAllSelections() {
			$('#preview-selections').empty();
			zNodesIndicateurSelectionnes = [];
			zNodesPeriodeSelectionnes = [];
			zNodesZoneSelectionnes = [];
			zNodesNatureDonneeSelectionnes = [];
			updateSelectionCounts();
		}
		</script>
		
		<div class="d-flex" style="height: calc(100vh - 100px);">
			<!-- Sidebar gauche style World Bank -->
			<div class="wb-sidebar">
				<!-- Section Cadre de Résultat -->
				<div class="wb-section">
					<div class="wb-section-header" data-section="cadre">
						<div>
							<i class="mdi mdi-file-tree"></i>
							Cadre de Résultat
						</div>
						<i class="mdi mdi-chevron-down wb-section-icon"></i>
					</div>
					<div class="wb-section-content" id="section-cadre">
						<div class="wb-search-box">
							<input type="text" id="search_cadre_logique" placeholder="Recherche..." class="form-control form-control-sm">
						</div>
						<ul id="liste_cadre_logique" class="ztree"></ul>
					</div>
				</div>
				
				<!-- Section Indicateurs -->
				<div class="wb-section">
					<div class="wb-section-header" data-section="indicateur">
						<div>
							<i class="mdi mdi-alpha-i-circle"></i>
							Indicateur
							<span class="wb-counter" id="count-indicateur">0</span>
						</div>
						<i class="mdi mdi-chevron-down wb-section-icon"></i>
					</div>
					<div class="wb-section-content" id="section-indicateur">
						<div class="wb-search-box">
							<input type="text" id="search_indicateur" placeholder="Recherche..." class="form-control form-control-sm">
						</div>
						<ul id="liste_indicateur" class="ztree"></ul>
						<small class="text-muted">Double-cliquez pour sélectionner</small>
					</div>
				</div>
				
				<!-- Section Période -->
				<div class="wb-section">
					<div class="wb-section-header" data-section="periode">
						<div>
							<i class="mdi mdi-calendar"></i>
							Période
							<span class="wb-counter" id="count-periode">0</span>
						</div>
						<i class="mdi mdi-chevron-down wb-section-icon"></i>
					</div>
					<div class="wb-section-content" id="section-periode">
						<div class="wb-search-box">
							<input type="text" id="search_periode" placeholder="Recherche..." class="form-control form-control-sm">
						</div>
						<ul id="liste_periode" class="ztree"></ul>
						<small class="text-muted">Double-cliquez pour sélectionner</small>
					</div>
				</div>
				
				<!-- Section Zone -->
				<div class="wb-section">
					<div class="wb-section-header" data-section="zone">
						<div>
							<i class="mdi mdi-earth"></i>
							Zone
							<span class="wb-counter" id="count-zone">0</span>
						</div>
						<i class="mdi mdi-chevron-down wb-section-icon"></i>
					</div>
					<div class="wb-section-content" id="section-zone">
						<div class="wb-search-box">
							<input type="text" id="search_zone" placeholder="Recherche..." class="form-control form-control-sm">
						</div>
						<ul id="liste_zone" class="ztree"></ul>
						<small class="text-muted">Double-cliquez pour sélectionner</small>
					</div>
				</div>
				
				<!-- Section Nature Donnée -->
				<div class="wb-section">
					<div class="wb-section-header" data-section="naturedonnee">
						<div>
							<i class="mdi mdi-database"></i>
							Nature Donnée
							<span class="wb-counter" id="count-naturedonnee">0</span>
						</div>
						<i class="mdi mdi-chevron-down wb-section-icon"></i>
					</div>
					<div class="wb-section-content" id="section-naturedonnee">
						<div class="wb-search-box">
							<input type="text" id="search_nature_donnee" placeholder="Recherche..." class="form-control form-control-sm">
						</div>
						<ul id="liste_nature_donnee" class="ztree"></ul>
						<small class="text-muted">Double-cliquez pour sélectionner</small>
					</div>
				</div>
			</div>
			
			<!-- Contenu principal -->
			<div class="wb-main-content">
				<h4 class="mb-3">Aperçu des sélections</h4>
				<div class="wb-preview-box" id="preview-selections">
					<p class="text-muted text-center">Aucune sélection pour le moment. Double-cliquez sur les éléments dans les sections à gauche pour les ajouter.</p>
				</div>
				
				<div class="wb-action-buttons">
					<button class="btn btn-outline-secondary" onclick="clearAllSelections()">
						<i class="mdi mdi-close-circle"></i> Effacer tout
					</button>
					<button class="btn btn-success" id="btn_submit_wb">
						<i class="mdi mdi-check-circle"></i> Valider et extraire
					</button>
				</div>
			</div>
		</div>
	
	<script>
		var zTree, rMenu;
		$(document).ready(function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			$.fn.zTree.init($("#liste_indicateur"), settingIndicateur, zNodesIndicateur);
			$.fn.zTree.init($("#liste_cadre_logique"), settingcadre_logique, zNodescadre_logique);
			$.fn.zTree.init($("#liste_periode"), settingPeriode, zNodesPeriode);
			$.fn.zTree.init($("#liste_zone"), settingZone, zNodesZone);
			$.fn.zTree.init($("#liste_nature_donnee"), settingNatureDonnee, zNodesNatureDonnee);
			
			zTree = $.fn.zTree.getZTreeObj("liste_cadre_logique");
			rMenu = $("#rMenu");
			
			// Gestion des sections collapsibles
			$('.wb-section-header').click(function() {
				var section = $(this).data('section');
				var content = $('#section-' + section);
				var wasActive = $(this).hasClass('active');
				
				// Fermer toutes les autres sections
				$('.wb-section-header').removeClass('active');
				$('.wb-section-content').removeClass('active').slideUp(200);
				
				// Ouvrir/fermer la section cliquée
				if (!wasActive) {
					$(this).addClass('active');
					content.addClass('active').slideDown(200);
				}
			});
			
			// Ouvrir la première section par défaut
			$('.wb-section-header').first().trigger('click');
			
			// Recherche
			$('#search_cadre_logique').keyup(function(){
				if($(this).val() != "") { 
					var treeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					$.fn.zTree.init($("#liste_cadre_logique"), settingcadre_logique, nodes); 
				}else{
					$.fn.zTree.init($("#liste_cadre_logique"), settingcadre_logique, zNodescadre_logique);
				}
			});
			
			$('#search_indicateur').keyup(function(){
				if($(this).val() != "") { 
					var treeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					$.fn.zTree.init($("#liste_indicateur"), settingIndicateur, nodes); 
				}else{
					$.fn.zTree.init($("#liste_indicateur"), settingIndicateur, zNodesIndicateur);
				}
			});
			
			$('#search_periode').keyup(function(){
				if($(this).val() != "") { 
					var treeObj = $.fn.zTree.getZTreeObj("liste_periode");
					var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					$.fn.zTree.init($("#liste_periode"), settingPeriode, nodes); 
				}else{
					$.fn.zTree.init($("#liste_periode"), settingPeriode, zNodesPeriode);
				}
			});
			
			$('#search_zone').keyup(function(){
				if($(this).val() != "") { 
					var treeObj = $.fn.zTree.getZTreeObj("liste_zone");
					var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					$.fn.zTree.init($("#liste_zone"), settingZone, nodes); 
				}else{
					$.fn.zTree.init($("#liste_zone"), settingZone, zNodesZone);
				}
			});
			
			$('#search_nature_donnee').keyup(function(){
				if($(this).val() != "") { 
					var treeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee");
					var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					$.fn.zTree.init($("#liste_nature_donnee"), settingNatureDonnee, nodes); 
				}else{
					$.fn.zTree.init($("#liste_nature_donnee"), settingNatureDonnee, zNodesNatureDonnee);
				}
			});
			
			// Bouton de validation
			$('#btn_submit_wb').click(function(){
				var paramIndicateur = zNodesIndicateurSelectionnes.map(function(item) { return item.id; });
				var paramPeriode = zNodesPeriodeSelectionnes.map(function(item) { return item.id; }).sort(function(a, b){return a - b});
				var paramZone = zNodesZoneSelectionnes.map(function(item) { return item.id; });
				var paramNatureDonnee = zNodesNatureDonneeSelectionnes.map(function(item) { return item.id; });
				
				if(paramIndicateur.length <=0) {
					alert("Veuillez sélectionner au moins un indicateur");
					$('.wb-section-header[data-section="indicateur"]').trigger('click');
					return;
				}
				else if(paramPeriode.length <=0) {
					alert("Veuillez sélectionner au moins une période");
					$('.wb-section-header[data-section="periode"]').trigger('click');
					return;
				}
				else if(paramZone.length <=0) {
					alert("Veuillez sélectionner au moins une zone");
					$('.wb-section-header[data-section="zone"]').trigger('click');
					return;
				}
				else if(paramNatureDonnee.length <=0) {
					alert("Veuillez sélectionner au moins une nature de donnée");
					$('.wb-section-header[data-section="naturedonnee"]').trigger('click');
					return;
				}
				else {
					$.post('/donnee_indicateurs/extractionDonnees',{
						paramIndicateur:paramIndicateur,
						paramZone:paramZone,
						paramPeriode:paramPeriode,
						paramNatureDonnee:paramNatureDonnee
					},function(data){
						if (!data || data.length === 0) {
							$('#contenu_page').html('<div class="alert alert-warning text-center">Aucune donnée trouvée.</div>');
							return;
						}

						let tableHTML = `
							<table id="tableResultats" class="dataTable table table-bordered table-striped table-hover align-middle">
								<thead class="table-light">
									<tr>
										<th>Indicateur</th>
										<th>Zone</th>
										<th>Désagrégation</th>
										<th>Source</th>
										<th>Unité</th>
										<th>Commentaire</th>
										<th>Nature donnée</th>
										<th>Période</th>
										<th>Valeur</th>
									</tr>
								</thead>
								<tbody>
									${data.map(item => `
										<tr>
											<td>${item.indicateur_intitule}</td>
											<td>${item.zone_intitule}</td>
											<td>${item.desagregations}</td>
											<td>${item.source_indicateur_intitule}</td>
											<td>${item.unite_indicateur_intitule}</td>
											<td>${item.commentaire_intitule}</td>
											<td>${item.nature_donnee_intitule}</td>
											<td>${item.periode_intitule}</td>
											<td class="fw-bold text-end">${item.valeur}</td>
										</tr>
									`).join('')}
								</tbody>
							</table>
						`;

						$('#contenu_page').html(tableHTML);
						
						$('#tableResultats').DataTable({
							dom: '<"d-flex justify-content-between align-items-center mb-2"Bf>rtip',
							buttons: [
								{
									extend: 'excelHtml5',
									text: '<i class="bi bi-file-earmark-excel"></i> Exporter Excel',
									className: 'btn btn-success btn-sm'
								},
								{
									text: '<i class="bi bi-arrow-left"></i> Retour',
									className: 'btn btn-secondary btn-sm ml-2',
									action: function (e, dt, node, config) {
										window.location.href = '/donnee_indicateurs/extractionDonnees';
									}
								}
							]
						});

					}).fail(function() {
						$('#contenu_page').html('<div class="alert alert-danger text-center">Erreur lors de la récupération des données.</div>');
					});
				}
			});
			
			// Menu contextuel
			$('#showDonneesCadre').click(function() {
				var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
				var treeNodes = sourceTreeObj.getSelectedNodes();
				if (!treeNodes || treeNodes.length === 0) {
					alert("Veuillez sélectionner un cadre de développement.");
					return;
				}
				var cadre = treeNodes[0];
				if (cadre.pId === null || cadre.pId === '' || cadre.pId === 0) {
					window.location.href = '/afficher_cmr/' + cadre.id;
				} else {
					alert("Seuls les cadres de développement peuvent être affichés ici.");
				}
			});
			
			$('#downloadDonneesCadre').click(function() {
				var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
				var treeNodes = sourceTreeObj.getSelectedNodes();
				if (!treeNodes || treeNodes.length === 0) {
					alert("Veuillez sélectionner un cadre de développement.");
					return;
				}
				var cadre = treeNodes[0];
				if (cadre.pId === null || cadre.pId === '' || cadre.pId === 0) {
					window.location.href = '/telecharger_cmr/' + cadre.id;
				} else {
					alert("Seuls les cadres de développement peuvent être affichés ici.");
				}
			});
	  });

	</script>
	<div id="rMenu">
		<ul>
			<li id="showDonneesCadre">Afficher toutes les données du cadre</li>
			<li id="downloadDonneesCadre">Télécharger toutes les données du cadre</li>
		</ul>
	</div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/zTree.v3/3.5.42/js/jquery.ztree.all.min.js" integrity="sha512-7sGF7QJRDdvZna4GfwsdoY6a8jxCFZTAlL2OFKjmEXZ9mPwzHbKnwDiIy9RI1hYZv+XLtbOew+6slAJahxaH+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
