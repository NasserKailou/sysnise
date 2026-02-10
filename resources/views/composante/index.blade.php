@extends('layouts.app')
@section('content')
<div class="page-header d-flex align-items-center">
    <div class="page-title" style="width: 100%;">
        {{ $projet->intitule }}
    </div>

    <a href="{{ route('projets.show', $projet->id) }}" class="btn btn-secondary ms-auto" style="width: 100px;margin-top:-15px">
        <i class="fa fa-arrow-left"></i> Retour
    </a>
</div>

<div class="container-fluid" style="background:#fff">
	<input type="hidden" id="projet_id" name="projet_id" value="{{ old('projet_id', $projet->id) }}" >
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
		</style>
		
		<script type="text/javascript">
	  var zNodesProduit =[
		  { id:0, pId:0, name:"/", open:true}
	  ];
	  var zNodescomposante =[
			{ id:0, pId:0, name:"/", open:true}
			
		];
	  
	  var zNodesProduitSelectionnes =[];
	</script>

	<script>
		@foreach($produits as $produit)
			zNodesProduit.push({
				id: {{ $produit->id }},
				pId: 0,
				name: @json($produit->intitule)
			});
		@endforeach

		@foreach($composantes as $composante)
			zNodescomposante.push({
				id: {{ $composante->id }},
				pId: {{ $composante->composante_id ?? 0 }},
				name: @json($composante->intitule)
			});
		@endforeach
	</script>


	
	<script type="text/javascript">
			
			var tempNode = null;
			var settingcomposante = {
					view: {
						showIcon: showIconForTree,
						addHoverDom: addHoverDomcomposante,
						removeHoverDom: removeHoverDomcomposante
					},
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
					},
					callback: {
						beforeClick: beforeClickcomposante,
						onClick: onClickcomposante,
						beforeEditName: beforeEditNamecomposante,
						beforeRemove: beforeRemovecomposante,
						beforeRename: beforeRenamecomposante,
						onRemove: onRemovecomposante,
						onRename: onRenamecomposante,
						onRightClick: OnRightClick
					}
				};
				
				
				
				function beforeClickcomposante(treeId, treeNode, clickFlag) {
					return (treeNode.click != false);
				}
				function onClickcomposante(event, treeId, treeNode, clickFlag) {
					projet_id = $('#projet_id').val();
					$.ajax({
						url: '/api/composante_produits/'+projet_id+'/' + treeNode.id + '/produits',
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

							// Liste des produits sélectionnés et non sélectionnés
							var selectedProducts = data.selected.map(function (item) {
								return {
									id: item.id,
									pId: 0, // sous la racine
									name: item.intitule
								};
							});

							var notSelectedProducts = data.notSelected.map(function (item) {
								return {
									id: item.id,
									pId: 0, // sous la racine
									name: item.intitule
								};
							});

							// Fusion des noeuds racine + enfants
							selectedProducts.unshift(rootNode);
							notSelectedProducts.unshift(rootNode);

							// Activation de l’édition
							var editableSetting = $.extend(true, {}, settingProduit, {
								edit: {
									enable: false,
									/*editNameSelectAll: true,
									showRemoveBtn: true,
									showRenameBtn: true*/
								},
								data: {
									simpleData: {
										enable: true
									}
								}
							});

							//Initialisation des arbres
							$.fn.zTree.init($("#liste_produit_selectionnes"), editableSetting, selectedProducts);
							$.fn.zTree.init($("#liste_produit"), editableSetting, notSelectedProducts);
						},
						error: function (xhr) {
							console.error("Erreur :", xhr.responseText);
						}
					});
				}

				var log, className = "dark";
				function beforeEditNamecomposante(treeId, treeNode) {
					var zTree = $.fn.zTree.getZTreeObj("liste_composante");
					zTree.selectNode(treeNode);
					setTimeout(function() {
							zTree.editName(treeNode);
							
						}, 0);
					return false;
				}
				function beforeRenamecomposante(treeId, treeNode, newName, isCancel) {
					className = (className === "dark" ? "":"dark");
					if (newName.length == 0) {
						setTimeout(function() {
							var zTree = $.fn.zTree.getZTreeObj("liste_composante");
							zTree.cancelEditName();
							alert("le libelle ne doit pas être vide");
						}, 0);
						return false;
					}
						
					return true;
				}
				function onRenamecomposante(e, treeId, treeNode, isCancel) {
					
					if(tempNode != null)
					{
						projet_id = $('#projet_id').val();
						$.ajax({
							url: '/api/composantes/',
							type: 'POST',
							data: {
								id: treeNode.id,
								intitule: treeNode.name,
								composante_id: treeNode.pId,
								projet_id:projet_id
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
						projet_id = $('#projet_id').val();
						$.ajax({
							url: '/api/composantes/' + treeNode.id,
							type: 'PUT',
							data: {
								id: treeNode.id,
								intitule: treeNode.name,
								composante_id: treeNode.pId,
								projet_id:projet_id
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
				function beforeRemovecomposante(treeId, treeNode) {
					className = (className === "dark" ? "":"dark");
					var zTree = $.fn.zTree.getZTreeObj("liste_composante");
					zTree.selectNode(treeNode);
					return confirm("Confirmer la suppression du composante : " + treeNode.name);
				}
				function onRemovecomposante(e, treeId, treeNode) {
					/*typecomposante_code = $('#typecomposante_code').val();*/
					$.ajax({
							url: '/api/composantes/' + treeNode.id,
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
				function addHoverDomcomposante(treeId, treeNode) {
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
						var zTree = $.fn.zTree.getZTreeObj("liste_composante");
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
				function removeHoverDomcomposante(treeId, treeNode) {
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
				function addHoverDomcomposante(treeId, treeNode) {
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
						var zTree = $.fn.zTree.getZTreeObj("liste_composante");
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
				function removeHoverDomcomposante(treeId, treeNode) {
					$("#addBtn_"+treeNode.tId).unbind().remove();
				};
				
			var settingProduit = {
				view: {
					showIcon: showIconForTree
					/*addHoverDom: addHoverDomProduit,
					removeHoverDom: removeHoverDomProduit*/
					
				},
				data: {
					simpleData: {
						enable: true
					}
				},
				edit: {
					enable: false,
					/*editNameSelectAll: true,
					showRemoveBtn: true,
					showRenameBtn: true*/
				},
				callback: {
					beforeClick: beforeClickProduit,
					onClick: onClickProduit,
					beforeDblClick : beforeDblClickProduit,
					onDblClick: onDblClickProduit,
					beforeEditName: beforeEditNameProduit,
					beforeRemove: beforeRemoveProduit,
					beforeRename: beforeRenameProduit,
					onRemove: onRemoveProduit,
					onRename: onRenameProduit
					
					
				}
			};
			
			
			
			
			function beforeClickProduit(treeId, treeNode, clickFlag) {
				return (treeNode.click != false);
			}
			function onClickProduit(event, treeId, treeNode, clickFlag) {
				
			}
			function beforeDblClickProduit(treeId, treeNode) {
				return (treeNode.click != false);
			};
			
			function onDblClickProduit(event, treeId, treeNode) {
				var composanteTreeObj = $.fn.zTree.getZTreeObj("liste_composante");
				var composanteTreeNodes = composanteTreeObj.getSelectedNodes();
				var composanteLength = composanteTreeNodes.length;
				if(treeId == "liste_produit")
				{
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_produit");
					var treeNodes = sourceTreeObj.getSelectedNodes();

					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_produit_selectionnes");
					
					var params =[];
					
					if(composanteLength > 0)
					{
						
							var produit = treeNodes[0];
							if(produit.name != "/")
							{
								destinationTreeObj.addNodes(null, produit);
								sourceTreeObj.removeNode(produit);
								$.ajax({
									url: '/api/composante_produits/',
									type: 'POST',
									data: {
										produit_id: produit.id,
										composante_id:composanteTreeNodes[0].id
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
				else if(treeId == "liste_produit_selectionnes")
				{
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_produit_selectionnes");
					var treeNodes = sourceTreeObj.getSelectedNodes();

					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_produit");
					
					var params =[];
					
					if(composanteLength > 0)
					{
						
							var produit = treeNodes[0];
							/*destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0], produit);
							sourceTreeObj.removeNode(produit);*/
							
							destinationTreeObj.addNodes(null, produit);
							sourceTreeObj.removeNode(produit);
							
							$.ajax({
								url: '/api/composante_produits/'+composanteTreeNodes[0].id+'/'+produit.id,
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
			
			function beforeEditNameProduit(treeId, treeNode) {
				var zTree = $.fn.zTree.getZTreeObj("liste_produit");
				zTree.selectNode(treeNode);
				setTimeout(function() {
						zTree.editName(treeNode);
					}, 0);
				return false;
			}
			function beforeRenameProduit(treeId, treeNode, newName, isCancel) {
				className = (className === "dark" ? "":"dark");
				if (newName.length == 0) {
					setTimeout(function() {
						var zTree = $.fn.zTree.getZTreeObj("liste_produit");
						zTree.cancelEditName();
						alert("le libelle ne doit pas être vide");
					}, 0);
					return false;
				}
					
				return true;
			}
			function onRenameProduit(e, treeId, treeNode, isCancel) {
				
				if(tempNode != null)
				{
					$.ajax({
						url: '/api/produits/',
						type: 'POST',
						data: {
							id: treeNode.id,
							intitule: treeNode.name,
							type_produit_id: 2
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
						url: '/api/produits/' + treeNode.id,
						type: 'PUT',
						data: {
							id: treeNode.id,
							intitule: treeNode.name,
							type_produit_id: 2
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
			function beforeRemoveProduit(treeId, treeNode) {
				className = (className === "dark" ? "":"dark");
				var zTree = $.fn.zTree.getZTreeObj("liste_produit");
				zTree.selectNode(treeNode);
				return confirm("Confirmer la suppression de l'produit : " + treeNode.name);
			}
			function onRemoveProduit(e, treeId, treeNode) {
				$.ajax({
						url: '/api/produits/' + treeNode.id,
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
			function addHoverDomProduit(treeId, treeNode) {
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
					var zTree = $.fn.zTree.getZTreeObj("liste_produit");
					var newNode_name = "nouveau produit";
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
			function removeHoverDomProduit(treeId, treeNode) {
				$("#addBtn_"+treeNode.tId).unbind().remove();
			};
			
			function OnRightClick(event, treeId, treeNode) {
				// Vérifie que le clic droit concerne uniquement le zTree du cadre logique
				if (treeId !== "liste_composante") {
					return; // on ignore les clics droits sur les autres arbres
				}

				var zTree = $.fn.zTree.getZTreeObj("liste_composante");
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
				// On n'affiche le menu contextuel que pour les nœuds de composante
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
		@if(session('failed_produits'))
		<script>
			$(function () {
				@foreach(session('failed_produits') as $produit)
					$(document).Toasts('create', {
						class: 'bg-danger',
						title: 'Import échoué',
						body: `
							<strong>Code :</strong> {{ $produit['code'] }}<br>
							<strong>Intitulé :</strong> {{ $produit['intitule'] }}<br>
							<strong>Raison :</strong> {{ $produit['raison'] }}
						`,
						autohide: false
					});
				@endforeach
			});
		</script>
		@endif


		<table id="tab" style="width:100%;">
			<thead>
				<tr >
					<th style="width:32%;padding:10px;"> Composantes
					<span class="float-right">
							<a href="#" id="uploadComposante"><i class="fas fa-file-upload" style="padding-right:15px"></i></a>
						</span>
					</th>
					<th style="width:40%;padding:10px;">Produits disponibles
						<span class="float-right">
							<!--<a href="#" id="uniteProduitDisponible" data-toggle="tooltip" data-placement="top" title="" data-original-title="Définir les unités d'un produit selectionné"><i class="fas fa-scale-balanced" style="padding-right:15px"></i></a>
							<a href="#" id="desagregationProduitDisponible" data-toggle="tooltip" data-placement="top" title="" data-original-title="Définir les sous groupes d'un produit selectionné"><i class="fas fa-sitemap" style="padding-right:15px"></i></a>
							-->
							<a href="#" id="uploadProduit"><i class="fas fa-file-upload" style="padding-right:15px"></i></a>
							<a href="#" id="infosProduitDisponible"><i class="fas fa-info" style="padding-right:15px"></i></a>
							<a href="#" id="transfererProduitDisponibleVersSelectionne"><i class="fas fa-angle-right" style="padding-right:15px"></i></a>
						</span>
					</th>
					<th style="width:28%;padding:10px;">Produits associés
						<span class="float-right">
							<a href="#" id="infosProduitSelectionne"><i class=" fas fa-info" style="padding-right:15px"></i></a>
							<a href="#" id="transfererProduitSelectionneVersDisponible"><i class="fas fa-angle-left" style="padding-right:15px"></i></a>
						</span>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="vertical-align: top;border-right: solid 3px #f8f9fa">
						<div class="input-group">
				           <input type="text" id="search_composante" name="search_composante" class="form-control form-control-sm" placeholder="Search">
				       		<span class="input-group-append">
	                       		<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
	                       </span>
				       	</div>
						<ul id="liste_composante" class="ztree"></ul>
					</td>
					<td style="vertical-align: top;border-right: solid 3px #f8f9fa">
						<div class="input-group">
				           <input type="text" id="search_produit" name="search_produit" class="form-control form-control-sm" placeholder="Search">
				       		<span class="input-group-append">
	                       		<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
	                       </span>
				       	</div>
						<ul id="liste_produit" class="ztree"></ul>
					</td>
					<td style="vertical-align: top;">
						<div class="input-group">
				           <input type="text" id="search_produit_selectionnes" name="search_produit_selectionnes" class="form-control form-control-sm" placeholder="Search">
				       		<span class="input-group-append">
	                       		<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
	                       </span>
				       	</div>
						<ul id="liste_produit_selectionnes" class="ztree"></ul>
					</td>
				</tr>
			</tbody>
		</table>
		
		<script>
			var zTree, rMenu;
			$(document).ready(function () {
				$.fn.zTree.init($("#liste_produit"), settingProduit, zNodesProduit);
				$.fn.zTree.init($("#liste_composante"), settingcomposante, zNodescomposante);
				$.fn.zTree.init($("#liste_produit_selectionnes"), settingProduit, zNodesProduitSelectionnes);
				rMenu = $("#rMenu");
				zTree = $.fn.zTree.getZTreeObj("liste_composante");
				$(".toast").toast();
				
				$('#search_composante').keypress(function(){
			    	 if($(this).val() != "")
			    	 { 
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_composante");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_composante"), settingcomposante, nodes); 
			    	 }else
			    	{
			    		$.fn.zTree.init($("#liste_composante"), settingcomposante, zNodescomposante);
			    	}
					 
			      });
				$('#search_produit').keypress(function(){
			    	 if($(this).val() != "")
			    	 { 
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_produit");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_produit"), settingProduit, nodes); 
			    	 }else
			    	{
			    		 $.fn.zTree.init($("#liste_produit"), settingProduit, zNodesProduit);
			    	}
					 
			      });
				$('#search_produit_selectionnes').keypress(function(){
			    	 if($(this).val() != "")
			    	 { 
			    		 var treeObj = $.fn.zTree.getZTreeObj("liste_produit_selectionnes");
					      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
					      $.fn.zTree.init($("#liste_produit_selectionnes"), settingProduit, nodes); 
			    	 }else
			    	{
			    		 $.fn.zTree.init($("#liste_produit_selectionnes"), settingProduit, zNodesProduitSelectionnes);
							
			    	}
					 
			      });
				
				
				$('#transfererProduitDisponibleVersSelectionne').click(function(){
					var composanteTreeObj = $.fn.zTree.getZTreeObj("liste_composante");
					var composanteTreeNodes = composanteTreeObj.getSelectedNodes();
					var composanteLength = composanteTreeNodes.length;
					
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_produit");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var l=treeNodes.length;
					
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_produit_selectionnes");
					
					
					if(composanteLength > 0)
					{
				
						let associations = [];
						let composanteId = composanteTreeNodes[0].id;
						while (l>0) {
							var produit = treeNodes[l-1];
							destinationTreeObj.addNodes(null, produit);
							sourceTreeObj.removeNode(produit);
							l--;
							
							associations.push({
								produit_id: produit.id,
								composante_id: composanteId
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
				
				$('#transfererProduitSelectionneVersDisponible').click(function(){
					var composanteTreeObj = $.fn.zTree.getZTreeObj("liste_composante");
					var composanteTreeNodes = composanteTreeObj.getSelectedNodes();
					var composanteLength = composanteTreeNodes.length;
					
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_produit_selectionnes");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var l=treeNodes.length;
					
					var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_produit");
					
					var params =[];
					var p = 0;
					
					if(composanteLength > 0)
					{
						let associations = [];
						let composanteId = composanteTreeNodes[0].id;
						while (l>0) {
							var produit = treeNodes[l-1];
							destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0], produit);
							sourceTreeObj.removeNode(produit);
							l--;
							associations.push({
								produit_id: produit.id,
								composante_id: composanteId
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
				
				$('#infosProduitDisponible').click(function(){
					/*typecomposante_code = $('#typecomposante_code').val();*/
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_produit");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var produit = treeNodes[0];
					/*$.get('/ajouterFicheTechnique/'+produit.id+'/'+typecomposante_code,function(dat){*/
					$.get('/ajouterFicheTechnique/'+produit.id,function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});
					
				});
				
				
				$('#uniteProduitDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_produit");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var produit = treeNodes[0];
					$.get('/ajouterUniteProduit/'+produit.id,function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});
					
				});
				
				$('#desagregationProduitDisponible').click(function(){
					var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_produit");
					var treeNodes = sourceTreeObj.getSelectedNodes();
					var produit = treeNodes[0];
					$.get('/produits/'+produit.id+'/desagregation',function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});
					
				});
				
				$('#uploadProduit').click(function(){
					
					$.get('/produits/upload',function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});
					
				});
				
				$('#uploadComposante').click(function(){
					projet_id = $('#projet_id').val();
					$.get('/projets/'+projet_id+'/composantes_upload',function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});
					
				});
			
		  });

		</script>  
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