@extends('layouts.app')
@section('content') 
<div id="contenu_page" class="p-3 container-fluid" style="background:#fff">
	
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
			background-color: #007bff; /* ou ta couleur de choix */
			color: #fff; /* texte blanc sur fond bleu */
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
				id: @json((string) $cadre_logique->id),
				pId: @json((string) ($cadre_logique->parent_id ?? '0')),
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
									pId: 0,               // racine
									name: item.intitule   // affichage
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
				// Vérifie que le clic droit concerne uniquement le zTree du cadre logique
				if (treeId !== "liste_cadre_logique") {
					 // on ignore les clics droits sur les autres arbres
					return;
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

					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur_selectionnes");
					var params =[];
					if(cadre_logiqueLength > 0)
					{
						
							var indicateur = treeNodes[0];
							if(indicateur.name != "/")
							{
								destinationTreeObj.addNodes(null, indicateur);
								sourceTreeObj.removeNode(indicateur);
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
							destinationTreeObj.addNodes(null, indicateur);
							sourceTreeObj.removeNode(indicateur);
							
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
            var destinationTreeObj = $.fn.zTree.getZTreeObj(
              "liste_periode_selectionnes"
            );
            var periode = treeNodes[0];
            if (periode.name != "/") {
              destinationTreeObj.addNodes(null, periode);
              sourceTreeObj.removeNode(periode);
            }
          } else if (treeId == "liste_periode_selectionnes") {
            var sourceTreeObj = $.fn.zTree.getZTreeObj(
              "liste_periode_selectionnes"
            );
            var treeNodes = sourceTreeObj.getSelectedNodes();
            var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_periode");
            var periode = treeNodes[0];
            destinationTreeObj.addNodes(
              destinationTreeObj.getNodes()[0],
              periode
            );
            sourceTreeObj.removeNode(periode);
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
            var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_zone_selectionnes");
            var zone = treeNodes[0];
            if (zone.name != "/") {
              var nodeClone = {
					id: zone.id,
					name: zone.name,
					pId:zone.pId,
				};
				destinationTreeObj.addNodes(null, nodeClone);
			  
            }
          } else if (treeId == "liste_zone_selectionnes") {
            var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_zone_selectionnes");
            var treeNodes = sourceTreeObj.getSelectedNodes();
            var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_zone");
            var zone = treeNodes[0];
            sourceTreeObj.removeNode(zone);
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
            var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee_selectionnes");
            var nature_donnee = treeNodes[0];
            if (nature_donnee.name != "/") {
              destinationTreeObj.addNodes(null, nature_donnee);
              sourceTreeObj.removeNode(nature_donnee);
            }
          } else if (treeId == "liste_nature_donnee_selectionnes") {
            var sourceTreeObj = $.fn.zTree.getZTreeObj(
              "liste_nature_donnee_selectionnes"
            );
            var treeNodes = sourceTreeObj.getSelectedNodes();
            var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee");
            var nature_donnee = treeNodes[0];
            destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0],nature_donnee);
            sourceTreeObj.removeNode(nature_donnee);
          }
        }
		</script>
		
		<div class="row">
			<div class="col-12">
			  <div class="d-flex align-items-center justify-content-between">
				  <ul class="nav nav-tabs mb-0" id="etape_saisie">
					<li class="nav-item">
					  <a href="#etape1" tab_id="1" class="nav-link" data-toggle="tab">
						<i class="mdi mdi-alpha-i-circle" style="padding-right: 10px"></i>
						Indicateur
					  </a>
					</li>
					<li class="nav-item">
					  <a href="#etape2" tab_id="2" class="nav-link" data-toggle="tab">
						<i class="mdi mdi-calendar" style="padding-right: 10px"></i>
						Période
					  </a>
					</li>
					<li class="nav-item">
					  <a href="#etape3" tab_id="3" class="nav-link" data-toggle="tab">
						<i class="mdi mdi-earth" style="padding-right: 10px"></i>
						Zone
					  </a>
					</li>
					<li class="nav-item">
					  <a href="#etape4" tab_id="4" class="nav-link" data-toggle="tab">
						<i class="mdi mdi-earth" style="padding-right: 10px"></i>
						Nature Donnée
					  </a>
					</li>
				  </ul>

				  <div class="ml-3">
					<button disabled id="btn_prev" class="btn btn-sm btn-light waves-effect">
					  <i class="mdi mdi-arrow-left" style="padding-right: 10px; padding-left: 10px"></i>
					  Précédent
					</button>
					<button id="btn_next" class="btn btn-sm btn-light waves-effect">
					  Suivant
					  <i class="mdi mdi-arrow-right" style="padding-left: 10px; padding-right: 10px"></i>
					</button>
					<button disabled id="btn_submit" class="btn btn-sm btn-success waves-effect px-3">
					  Valider
					</button>
				  </div>
				</div>


			  <div class="tab-content">
				<div class="tab-pane fade" id="etape1">
				  <table
					class="table_etape_saisie"
					style="width: 100%; border: solid 3px #f8f9fa"
				  >
					<thead>
					  <tr style="background: #f8f9fa">
						<th style="width: 33%; padding: 10px">
						  Cadre de Résultat
						</th>
						<th style="width: 37%; padding: 10px">
						  Indicateurs disponibles
						  <span class="float-right">
							<a href="#" id="infosIndicateurDisponible"
							  ><i
								class="mdi mdi-information-outline"
								style="padding-right: 15px"
							  ></i
							></a>
							<a
							  href="#"
							  id="transfererIndicateurDisponibleVersSelectionne"
							  ><i
								class="fas fa-angle-right"
								style="padding-right: 15px"
							  ></i
							></a>
							<a
							  href="#"
							  id="transfererToutIndicateurDisponibleVersSelectionne"
							  ><i
								class="fas fa-angle-double-right"
								style="padding-right: 15px"
							  ></i
							></a>
						  </span>
						</th>
						<th style="width: 30%; padding: 10px">
						  Indicateurs selectionnés
						  <span class="float-right">
							<a href="#" id="infosIndicateurSelectionne"
							  ><i
								class="mdi mdi-information-outline"
								style="padding-right: 15px"
							  ></i
							></a>
							<a
							  href="#"
							  id="transfererIndicateurSelectionneVersDisponible"
							  ><i
								class="fas fa-angle-left"
								style="padding-right: 15px"
							  ></i
							></a>
							<a
							  href="#"
							  id="transfererToutIndicateurSelectionneVersDisponible"
							  ><i
								class="fas fa-angle-double-left"
								style="padding-right: 15px"
							  ></i
							></a>
						  </span>
						</th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td
						  style="
							vertical-align: top;
							border-right: solid 3px #f8f9fa;
						  "
						>
						  <div class="input-group">
							<input
							  type="text"
							  id="search_classification"
							  name="search_classification"
							  class="form-control form-control-sm"
							  placeholder="Recherche"
							/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary">
								<i class="fa fa-search"></i>
							  </button>
							</span>
						  </div>
						  <ul id="liste_cadre_logique" class="ztree"></ul>
						</td>
						<td
						  style="
							vertical-align: top;
							border-right: solid 3px #f8f9fa;
						  "
						>
						  <div class="input-group">
							<input
							  type="text"
							  id="search_indicateur"
							  name="search_indicateur"
							  class="form-control form-control-sm"
							  placeholder="Recherche"
							/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary">
								<i class="fa fa-search"></i>
							  </button>
							</span>
						  </div>
						  <ul id="liste_indicateur" class="ztree"></ul>
						</td>
						<td style="vertical-align: top">
						  <div class="input-group">
							<input
							  type="text"
							  id="search_indicateur_selectionnes"
							  name="search_indicateur_selectionnes"
							  class="form-control form-control-sm"
							  placeholder="Recherche"
							/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary">
								<i class="fa fa-search"></i>
							  </button>
							</span>
						  </div>
						  <ul id="liste_indicateur_selectionnes" class="ztree"></ul>
						</td>
					  </tr>
					</tbody>
				  </table>
				</div>

				<div class="tab-pane fade" id="etape2">
				  <table
					class="table_etape_saisie"
					style="width: 100%; border: solid 3px #f8f9fa"
				  >
					<thead>
					  <tr style="background: #f8f9fa">
						<th style="width: 37%; padding: 10px">
						  Periodes disponibles
						  <span class="float-right">
							<a
							  href="#"
							  id="transfererPeriodeDisponibleVersSelectionne"
							  ><i
								class="fas fa-angle-right"
								style="padding-right: 15px"
							  ></i
							></a>
							<a
							  href="#"
							  id="transfererToutPeriodeDisponibleVersSelectionne"
							  ><i
								class="fas fa-angle-double-right"
								style="padding-right: 15px"
							  ></i
							></a>
						  </span>
						</th>
						<th style="width: 30%; padding: 10px">
						  Periodes selectionnés
						  <span class="float-right">
							<a
							  href="#"
							  id="transfererPeriodeSelectionneVersDisponible"
							  ><i
								class="fas fa-angle-left"
								style="padding-right: 15px"
							  ></i
							></a>
							<a
							  href="#"
							  id="transfererToutPeriodeSelectionneVersDisponible"
							  ><i
								class="fas fa-angle-double-left"
								style="padding-right: 15px"
							  ></i
							></a>
						  </span>
						</th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td
						  style="
							vertical-align: top;
							border-right: solid 3px #f8f9fa;
						  "
						>
						  <div class="input-group">
							<input
							  type="text"
							  id="search_periode"
							  name="search_periode"
							  class="form-control form-control-sm"
							  placeholder="Recherche"
							/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary">
								<i class="fa fa-search"></i>
							  </button>
							</span>
						  </div>
						  <ul id="liste_periode" class="ztree"></ul>
						</td>
						<td style="vertical-align: top">
						  <div class="input-group">
							<input
							  type="text"
							  id="search_periode_selectionnes"
							  name="search_periode_selectionnes"
							  class="form-control form-control-sm"
							  placeholder="Recherche"
							/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary">
								<i class="fa fa-search"></i>
							  </button>
							</span>
						  </div>
						  <ul id="liste_periode_selectionnes" class="ztree"></ul>
						</td>
					  </tr>
					</tbody>
				  </table>
				</div>
				<div class="tab-pane fade" id="etape3">
				  <table
					class="table_etape_saisie"
					style="width: 100%; border: solid 3px #f8f9fa"
				  >
					<thead>
					  <tr style="background: #f8f9fa">
						<th style="width: 37%; padding: 10px">
						  Zones disponibles
						  <span class="float-right">
							<a href="#" id="transfererZoneDisponibleVersSelectionne"
							  ><i
								class="fas fa-angle-right"
								style="padding-right: 15px"
							  ></i
							></a>
							<a
							  href="#"
							  id="transfererToutZoneDisponibleVersSelectionne"
							  ><i
								class="fas fa-angle-double-right"
								style="padding-right: 15px"
							  ></i
							></a>
						  </span>
						</th>
						<th style="width: 30%; padding: 10px">
						  Zones selectionnés
						  <span class="float-right">
							<a href="#" id="transfererZoneSelectionneVersDisponible"
							  ><i
								class="fas fa-angle-left"
								style="padding-right: 15px"
							  ></i
							></a>
							<a
							  href="#"
							  id="transfererToutZoneSelectionneVersDisponible"
							  ><i
								class="fas fa-angle-double-left"
								style="padding-right: 15px"
							  ></i
							></a>
						  </span>
						</th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td
						  style="
							vertical-align: top;
							border-right: solid 3px #f8f9fa;
						  "
						>
						  <div class="input-group">
							<input
							  type="text"
							  id="search_zone"
							  name="search_zone"
							  class="form-control form-control-sm"
							  placeholder="Recherche"
							/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary">
								<i class="fa fa-search"></i>
							  </button>
							</span>
						  </div>
						  <ul id="liste_zone" class="ztree"></ul>
						</td>
						<td style="vertical-align: top">
						  <div class="input-group">
							<input
							  type="text"
							  id="search_zone_selectionnes"
							  name="search_zone_selectionnes"
							  class="form-control form-control-sm"
							  placeholder="Recherche"
							/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary">
								<i class="fa fa-search"></i>
							  </button>
							</span>
						  </div>
						  <ul id="liste_zone_selectionnes" class="ztree"></ul>
						</td>
					  </tr>
					</tbody>
				  </table>
				</div>
				<div class="tab-pane fade" id="etape4">
				  <table
					class="table_etape_saisie"
					style="width: 100%; border: solid 3px #f8f9fa"
				  >
					<thead>
					  <tr style="background: #f8f9fa">
						<th style="width: 37%; padding: 10px">
						  Natures données disponibles
						  <span class="float-right">
							<a href="#" id="transfererNatureDonneeDisponibleVersSelectionne"
							  ><i
								class="fas fa-angle-right"
								style="padding-right: 15px"
							  ></i
							></a>
							<a
							  href="#"
							  id="transfererToutNatureDonneeDisponibleVersSelectionne"
							  ><i
								class="fas fa-angle-double-right"
								style="padding-right: 15px"
							  ></i
							></a>
						  </span>
						</th>
						<th style="width: 30%; padding: 10px">
						  Natures données selectionnés
						  <span class="float-right">
							<a href="#" id="transfererNatureDonneeSelectionneVersDisponible"
							  ><i
								class="fas fa-angle-left"
								style="padding-right: 15px"
							  ></i
							></a>
							<a
							  href="#"
							  id="transfererToutNatureDonneeSelectionneVersDisponible"
							  ><i
								class="fas fa-angle-double-left"
								style="padding-right: 15px"
							  ></i
							></a>
						  </span>
						</th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td
						  style="
							vertical-align: top;
							border-right: solid 3px #f8f9fa;
						  "
						>
						  <div class="input-group">
							<input
							  type="text"
							  id="search_nature_donnee"
							  name="search_nature_donnee"
							  class="form-control form-control-sm"
							  placeholder="Recherche"
							/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary">
								<i class="fa fa-search"></i>
							  </button>
							</span>
						  </div>
						  <ul id="liste_nature_donnee" class="ztree"></ul>
						</td>
						<td style="vertical-align: top">
						  <div class="input-group">
							<input
							  type="text"
							  id="search_nature_donnee_selectionnes"
							  name="search_nature_donnee_selectionnes"
							  class="form-control form-control-sm"
							  placeholder="Recherche"
							/>
							<span class="input-group-append">
							  <button type="button" class="btn btn-sm btn-primary">
								<i class="fa fa-search"></i>
							  </button>
							</span>
						  </div>
						  <ul id="liste_nature_donnee_selectionnes" class="ztree"></ul>
						</td>
					  </tr>
					</tbody>
				  </table>
				</div>
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
				$.fn.zTree.init($("#liste_indicateur_selectionnes"), settingIndicateur, zNodesIndicateurSelectionnes);
				
				zTree = $.fn.zTree.getZTreeObj("liste_cadre_logique");
				
				rMenu = $("#rMenu");
				
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
				  
				  $('#search_periode').keypress(function(){
			    	 if($(this).val() != "")
			    	 { 
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_periode");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_periode"), settingPeriode, nodes); 
			    	 }else
			    	{
			    		 $.fn.zTree.init($("#liste_periode"), settingPeriode, zNodesPeriode);
			    	}
					 
			      });
				$('#search_periode_selectionnes').keypress(function(){
			    	 if($(this).val() != "")
			    	 { 
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_periode_selectionnes");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_periode_selectionnes"), settingPeriode, nodes); 
			    	 }else
			    	{
			    		 $.fn.zTree.init($("#liste_indicateur_selectionnes"), settingPeriode, zNodesPeriodeSelectionnes);
							
			    	}
					 
			      });
				  
				  $('#search_zone').keypress(function(){
			    	 if($(this).val() != "")
			    	 { 
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_zone");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_zone"), settingZone, nodes); 
			    	 }else
			    	{
			    		 $.fn.zTree.init($("#liste_zone"), settingZone, zNodesZone);
			    	}
					 
			      });
				$('#search_zone_selectionnes').keypress(function(){
			    	 if($(this).val() != "")
			    	 { 
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_zone_selectionnes");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_zone_selectionnes"), settingZone, nodes); 
			    	 }else
			    	{
			    		 $.fn.zTree.init($("#liste_zone_selectionnes"), settingZone, zNodesZoneSelectionnes);
							
			    	}
					 
			      });
				  
				  $('#search_nature_donnee').keypress(function(){
			    	 if($(this).val() != "")
			    	 { 
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_nature_donnee"), settingNatureDonnee, nodes); 
			    	 }else
			    	{
			    		 $.fn.zTree.init($("#liste_nature_donnee"), settingNatureDonnee, zNodesNatureDonnee);
			    	}
					 
			      });
				$('#search_nature_donnee_selectionnes').keypress(function(){
			    	 if($(this).val() != "")
			    	 { 
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee_selectionnes");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_nature_donnee_selectionnes"), settingNatureDonnee, nodes); 
			    	 }else
			    	{
			    		 $.fn.zTree.init($("#liste_nature_donnee_selectionnes"), settingNatureDonnee, zNodesNatureDonneeSelectionnes);
							
			    	}
					 
			      });
				
				
				$('#transfererPeriodeDisponibleVersSelectionne').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_periode");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var destinationTreeObj = $.fn.zTree.getZTreeObj(
					  "liste_periode_selectionnes"
					);
					var periode = treeNodes[0];
					if (periode.name != "/") {
					  destinationTreeObj.addNodes(null, periode);
					  sourceTreeObj.removeNode(periode);
					}
				});
				
				$('#transfererPeriodeSelectionneVersDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_periode_selectionnes");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_periode");
					var periode = treeNodes[0];
					destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0],periode);
					sourceTreeObj.removeNode(periode);
				});
				
				$('#transfererToutPeriodeDisponibleVersSelectionne').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_periode");
					var treeNodes = sourceTreeObj.getNodes()[0].children;
					
					var l=treeNodes.length;
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_periode_selectionnes");
					
					while (l>0) {
						var periode = treeNodes[l-1];
						if(periode.name != "/")
						{ 
							destinationTreeObj.addNodes(null, periode);
							sourceTreeObj.removeNode(periode);
						}
						l--;
						
					}
				});
				
				$('#transfererToutPeriodeSelectionneVersDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_periode_selectionnes");
					var treeNodes = sourceTreeObj.getNodes();
					var l=treeNodes.length;
					
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_periode");
					
					while (l>0) {
						var periode = treeNodes[l-1];
						destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0], periode);
						sourceTreeObj.removeNode(periode);
						l--;
						
					}
				});
				/*------------------------------------------------------------*/
				$('#transfererZoneDisponibleVersSelectionne').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_zone");
					var treeNodes = sourceTreeObj.getNodes()[0].children;
					/*var treeNodes = sourceTreeObj.getSelectedNodes();*/
					var destinationTreeObj = $.fn.zTree.getZTreeObj(
					  "liste_zone_selectionnes"
					);
					var zone = treeNodes[0];
					if (zone.name != "/") {
					  var nodeClone = {
							id: zone.id,
							name: zone.name,
							pId:zone.pId,
						};
						destinationTreeObj.addNodes(null, nodeClone);
					  
					}
					
				});
				
				$('#transfererZoneSelectionneVersDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_zone_selectionnes");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var zone = treeNodes[0];
					sourceTreeObj.removeNode(zone);
				});
				
				$('#transfererToutZoneDisponibleVersSelectionne').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_zone");
					var treeNodes = sourceTreeObj.getNodes()[0].children;
					
					var l=treeNodes.length;
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_zone_selectionnes");
					
					while (l>0) {
						var zone = treeNodes[l-1];
						if(zone.name != "/")
						{ 
							var nodeClone = {
								id: zone.id,
								name: zone.name,
								pId:zone.pId,
							};
							destinationTreeObj.addNodes(null, nodeClone);
				
						}
						l--;
						
					}
				});
				
				$('#transfererToutZoneSelectionneVersDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_zone_selectionnes");
					var treeNodes = sourceTreeObj.getNodes();
					var l=treeNodes.length;
					
					while (l>0) {
						var zone = treeNodes[l-1];
						sourceTreeObj.removeNode(zone);
						l--;
						
					}
				});
				/*--------------------------------------------------------------*/
				$('#transfererNatureDonneeDisponibleVersSelectionne').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee");
					var treeNodes = sourceTreeObj.getNodes()[0].children;
					var destinationTreeObj = $.fn.zTree.getZTreeObj(
					  "liste_nature_donnee_selectionnes"
					);
					var natureDonnee = treeNodes[0];
					if (natureDonnee.name != "/") {
					  destinationTreeObj.addNodes(null, natureDonnee);
					  sourceTreeObj.removeNode(natureDonnee);
					}
				});
				
				$('#transfererNatureDonneeSelectionneVersDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_nature_donneeselectionnes");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_natureDonnee");
					var natureDonnee = treeNodes[0];
					destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0],natureDonnee);
					sourceTreeObj.removeNode(natureDonnee);
				});
				
				$('#transfererToutNatureDonneeDisponibleVersSelectionne').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee");
					var treeNodes = sourceTreeObj.getNodes()[0].children;
					
					var l=treeNodes.length;
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee_selectionnes");
					
					while (l>0) {
						var natureDonnee = treeNodes[l-1];
						if(natureDonnee.name != "/")
						{ 
							destinationTreeObj.addNodes(null, natureDonnee);
							sourceTreeObj.removeNode(natureDonnee);
						}
						l--;
						
					}
				});
				
				$('#transfererToutNatureDonneeSelectionneVersDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee_selectionnes");
					var treeNodes = sourceTreeObj.getNodes();
					var l=treeNodes.length;
					
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee");
					
					while (l>0) {
						var natureDonnee = treeNodes[l-1];
						destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0], natureDonnee);
						sourceTreeObj.removeNode(natureDonnee);
						l--;
						
					}
					
				});
				/*-------------------------------------------------------------*/
				$('#transfererIndicateurDisponibleVersSelectionne').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var destinationTreeObj = $.fn.zTree.getZTreeObj(
					  "liste_indicateur_selectionnes"
					);
					var indicateur = treeNodes[0];
					if (indicateur.name != "/") {
					  destinationTreeObj.addNodes(null, indicateur);
					  sourceTreeObj.removeNode(indicateur);
					}
				});
				
				$('#transfererIndicateurSelectionneVersDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur_selectionnes");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					var indicateur = treeNodes[0];
					/*destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0],indicateur);*/
					destinationTreeObj.addNodes(null,indicateur);
					sourceTreeObj.removeNode(indicateur);
				});
				
				$('#transfererToutIndicateurDisponibleVersSelectionne').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					var treeNodes = sourceTreeObj.getNodes()[0].children;
					/*var treeNodes = sourceTreeObj.getNodes();*/
					
					var l=treeNodes.length;
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur_selectionnes");
					
					while (l>0) {
						var indicateur = treeNodes[l-1];
						if(indicateur.name != "/")
						{ 
							destinationTreeObj.addNodes(null, indicateur);
							sourceTreeObj.removeNode(indicateur);
						}
						l--;
						
					}
				});
				
				$('#transfererToutIndicateurSelectionneVersDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur_selectionnes");
					var treeNodes = sourceTreeObj.getNodes();
					var l=treeNodes.length;
					
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur");
					
					while (l>0) {
						var indicateur = treeNodes[l-1];
						destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0], indicateur);
						/*destinationTreeObj.addNodes(null, indicateur);*/
						sourceTreeObj.removeNode(indicateur);
						l--;
						
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
				
				/*------------------------------------*/
				  $.fn.zTree.init($("#liste_periode"), settingPeriode, zNodesPeriode);
				  $.fn.zTree.init(
					$("#liste_periode_selectionnes"),
					settingPeriode,
					zNodesPeriodeSelectionnes
				  );

				  $.fn.zTree.init($("#liste_zone"), settingZone, zNodesZone);
				  $.fn.zTree.init(
					$("#liste_zone_selectionnes"),
					settingZone,
					zNodesZoneSelectionnes
				  );
				  
				  $.fn.zTree.init($("#liste_nature_donnee"), settingNatureDonnee, zNodesNatureDonnee);
				  $.fn.zTree.init(
					$("#liste_nature_donnee_selectionnes"),
					settingNatureDonnee,
					zNodesNatureDonneeSelectionnes
				  );
				  /*-----------------------------------*/
				  // Initialisation du premier onglet
				  const firstTab = document.querySelector("#etape_saisie a:first-child");
				  const firstBootstrapTab = new bootstrap.Tab(firstTab);
				  firstBootstrapTab.show();

				  // Bouton suivant
				  $("#btn_next").click(function () {
					const activeTab = $("#etape_saisie a.nav-link.active");
					let tabId = parseInt(activeTab.attr("tab_id"));
					if (!tabId) return; // sécurité

					const nextTabId = tabId + 1;
					const nextTab = $(`#etape_saisie a[tab_id='${nextTabId}']`);

					if (nextTab.length) {
					  new bootstrap.Tab(nextTab[0]).show();
					  $("#btn_prev").removeAttr("disabled");

					  if (nextTabId === 4) {
						$("#btn_next").attr("disabled", "disabled");
						$("#btn_submit").removeAttr("disabled");
					  } else {
						$("#btn_submit").attr("disabled", "disabled");
					  }
					}
				  });

				  // Bouton précédent
				  $("#btn_prev").click(function () {
					const activeTab = $("#etape_saisie a.nav-link.active");
					let tabId = parseInt(activeTab.attr("tab_id"));
					if (!tabId) return;

					const prevTabId = tabId - 1;
					const prevTab = $(`#etape_saisie a[tab_id='${prevTabId}']`);

					if (prevTab.length) {
					  new bootstrap.Tab(prevTab[0]).show();
					  $("#btn_next").removeAttr("disabled");
					  $("#btn_submit").attr("disabled", "disabled");

					  if (prevTabId === 1) {
						$("#btn_prev").attr("disabled", "disabled");
					  }
					}
				  });

				  // Gestion des clics manuels sur les onglets
				  $("#etape_saisie a").on("shown.bs.tab", function (e) {
					const tabId = parseInt($(e.target).attr("tab_id"));
					if (tabId === 4) {
					  $("#btn_next").attr("disabled", "disabled");
					  $("#btn_submit").removeAttr("disabled");
					} else if (tabId === 1) {
					  $("#btn_prev").attr("disabled", "disabled");
					  $("#btn_next").removeAttr("disabled");
					  $("#btn_submit").attr("disabled", "disabled");
					} else {
					  $("#btn_prev").removeAttr("disabled");
					  $("#btn_next").removeAttr("disabled");
					  $("#btn_submit").attr("disabled", "disabled");
					}
				  });

				  $("#btn_submit").click(function(){
						var indicateurTreeObj = $.fn.zTree.getZTreeObj("liste_indicateur_selectionnes");
						var indicateurNodes = indicateurTreeObj.getNodes();
						var paramIndicateur =[];
						var p = 0;
						if(indicateurNodes){ 
							var l=indicateurNodes.length;
							while (l>0) {
								paramIndicateur[p] = indicateurNodes[l-1].id;
								p++;
								l--;
								
							} 
						}
						var periodeTreeObj = $.fn.zTree.getZTreeObj("liste_periode_selectionnes");
						var periodeNodes = periodeTreeObj.getNodes();
						var paramPeriode =[];
						var p = 0;
						if(periodeNodes){ 
							var l=periodeNodes.length;
							while (l>0) {
								paramPeriode[p] = periodeNodes[l-1].id;
								p++;
								l--;
								
							}
						}
						paramPeriode.sort(function(a, b){return a - b});
						var zoneTreeObj = $.fn.zTree.getZTreeObj("liste_zone_selectionnes");
						var zoneNodes = zoneTreeObj.getNodes();
						var paramZone =[];
						var p = 0;
						if(zoneNodes){ 
						var l=zoneNodes.length;
							while (l>0) {
								paramZone[p] = zoneNodes[l-1].id;
								p++;
								l--;
								
							}
						}
						
						var natureDonneeTreeObj = $.fn.zTree.getZTreeObj("liste_nature_donnee_selectionnes");
						var natureDonneeNodes = natureDonneeTreeObj.getNodes();
						var paramNatureDonnee =[];
						var p = 0;
						if(natureDonneeNodes){ 
						var l=natureDonneeNodes.length;
							while (l>0) {
								paramNatureDonnee[p] = natureDonneeNodes[l-1].id;
								p++;
								l--;
								
							}
						}
						
						if(paramIndicateur.length <=0)
						{
							alert("indicateur vide");
							$('a[href="#etape1"]').click();
						}
						else if(paramPeriode.length <=0)
						{
							alert("periode vide");
							$('a[href="#etape2"]').click();
						}
						else if(paramZone.length <=0)
						{
							alert("zone vide");
							$('a[href="#etape3"]').click();
						}
						else if(paramNatureDonnee.length <=0)
						{
							alert("nature de donnée vide");
							$('a[href="#etape4"]').click();
						}
						
						else
						{
							$.post('/donnee_indicateurs/extractionDonnees',{paramIndicateur:paramIndicateur,paramZone:paramZone,paramPeriode:paramPeriode,paramNatureDonnee:paramNatureDonnee},function(data){
								// Vérifier si on a bien des données
								if (!data || data.length === 0) {
									$('#contenu_page').html('<div class="alert alert-warning text-center">Aucune donnée trouvée.</div>');
									return;
								}

								// Construire le tableau Bootstrap
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

								// Injecter le tableau dans la div existante
								$('#contenu_page').html(tableHTML);
								
								// Initialiser DataTables avec recherche et export
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
					
				$('#showDonneesCadre').click(function() {
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					var treeNodes = sourceTreeObj.getSelectedNodes();

					// Vérifie qu'un nœud est bien sélectionné
					if (!treeNodes || treeNodes.length === 0) {
						alert("Veuillez sélectionner un cadre de développement.");
						return;
					}

					var cadre = treeNodes[0];

					// Vérifie si c'est un cadre de développement (pId nul, vide ou 0)
					if (cadre.pId === null || cadre.pId === '' || cadre.pId === 0) {
						window.location.href = '/afficher_cmr/' + cadre.id;
					} else {
						alert("Seuls les cadres de développement peuvent être affichés ici.");
					}
				});
				
				$('#downloadDonneesCadre').click(function() {
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_cadre_logique");
					var treeNodes = sourceTreeObj.getSelectedNodes();

					// Vérifie qu'un nœud est bien sélectionné
					if (!treeNodes || treeNodes.length === 0) {
						alert("Veuillez sélectionner un cadre de développement.");
						return;
					}

					var cadre = treeNodes[0];

					// Vérifie si c'est un cadre de développement (pId nul, vide ou 0)
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