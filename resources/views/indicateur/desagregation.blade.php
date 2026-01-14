<html>
<head>
	<meta charset="utf-8" />
</head>
<body>
	<div> 
		<div class="modal fade" id="myModal" tabindex="-1">
		 	<div class="modal-dialog modal-xl">
		    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title"> {{ $indicateur->intitule}}</h5>
					<input type="hidden" id="indicateur_id" name="indicateur_id" value="{{ old('indicateur_id', $indicateur->id) }}" >
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
		      <div class="modal-body">
		     	<style>
				    label.invalid{font-size:12.8px;font-size:.8rem;font-weight:500;color:red!important;top:50px!important}label.invalid.active{-webkit-transform:translateY(0)!important;-ms-transform:translateY(0)!important;transform:translateY(0)!important}ul.stepper .wait-feedback{left:0;right:0;top:0;z-index:2;position:absolute;width:100%;height:100%;text-align:center;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center}ul.stepper .step{position:relative;list-style:none}ul.stepper .step.feedbacking .step-new-content>:not(.wait-feedback){opacity:.1;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=10)"}ul.stepper .step:not(:last-of-type).active{margin-bottom:2.25rem}ul.stepper .step:before{position:absolute;top:.75rem;counter-increment:section;content:counter(section);height:1.75rem;width:1.75rem;color:#fff;background-color:rgba(0,0,0,.3);-webkit-border-radius:100%;border-radius:100%;text-align:center;line-height:1.75rem;font-weight:400}ul.stepper .step.done:before,ul.stepper .step.wrong:before{font-family:'Font Awesome 5 free';font-weight:900}ul.stepper .step.active:before{background-color:#4285f4}ul.stepper .step.done:before{content:'\f00c';font-size:1rem;background-color:#00c851}ul.stepper .step.wrong:before{content:'\f071';font-size:1.1rem;background-color:#ff3547}ul.stepper>li:not(:last-of-type){margin-bottom:.625rem;-webkit-transition:margin-bottom .4s;-o-transition:margin-bottom .4s;transition:margin-bottom .4s}ul.stepper .step-title{margin:0 -1.3rem;cursor:pointer;padding:.9688rem 2.75rem 1.5rem 4rem;display:block}ul.stepper .step-title:after{content:attr(data-step-label);display:block;position:absolute;font-size:.8rem;color:#424242;font-weight:400}ul.stepper .step-title:hover{background-color:rgba(0,0,0,.06)}ul.stepper .step.active .step-title{font-weight:500}ul.stepper .step-new-content{position:relative;display:none;height:calc(100% - 132px);width:inherit;overflow:visible;margin-left:41px;margin-right:24px}ul.stepper>.step:not(:last-of-type):after{content:'';position:absolute;top:3.125rem;left:.8438rem;width:.0625rem;height:40%;height:calc(100% - 38px);background-color:rgba(0,0,0,.1);-webkit-transition:all .4s;-o-transition:all .4s;transition:all .4s}ul.stepper>.step.active:not(:last-child):after{height:93%;height:calc(100% - 12px)}ul.stepper>.step[data-last=true]{margin-bottom:0}ul.stepper>.step[data-last=true]:after{height:0;width:0}ul.stepper .step-actions{display:-webkit-box;-webkit-box-pack:start}ul.stepper .step-actions .btn-flat:not(:last-child),ul.stepper .step-actions .btn-large:not(:last-child),ul.stepper .step-actions .btn:not(:last-child){margin-right:.3125rem}ul.stepper .step-new-content .row{margin-bottom:.4375rem}ul.stepper .md-form label{left:.875rem}ul.stepper .md-form .validate{margin-bottom:0}@media only screen and (min-width:993px){ ul.stepper.horizontal{position:relative;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;-ms-flex-pack:justify;justify-content:space-between;min-height:20rem;margin-left:-1.5rem;margin-right:-1.5rem;padding-left:1.5rem;padding-right:1.5rem;overflow:hidden} ul.stepper.horizontal:before{content:'';background-color:transparent;width:100%;min-height:5.25rem;position:absolute;left:-3px;-webkit-border-top-left-radius:2px;border-top-left-radius:2px} ul.stepper.horizontal:first-child{margin-top:-2.7rem} ul.stepper.horizontal .step{position:static;margin:0;width:100%;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;height:5.25rem!important} ul.stepper.horizontal .step:not(:last-of-type):after{content:'';position:static;display:inline-block;width:100%;height:.0625rem} ul.stepper.horizontal>.step:last-of-type, ul.stepper.horizontal>.step[data-last=true]{width:auto!important} ul.stepper.horizontal>.step.active:not(:last-of-type):after{content:'';position:static;display:inline-block;width:100%;height:.0625rem} ul.stepper.horizontal .step.active .step-title:before{background-color:#4285f4} ul.stepper.horizontal .step.done .step-title:before{font-family:'Font Awesome 5 Free';font-weight:900;content:'\f00c';font-size:1rem;background:#00c851} ul.stepper.horizontal .step.wrong .step-title:before{font-family:'Font Awesome 5 Free';font-weight:900;content:'\f071';font-size:1.1rem;background-color:#ff3547} ul.stepper.horizontal .step-title{line-height:5.25rem;height:5.25rem;margin:0;padding:0 1.5625rem 0 4.0625rem;display:inline-block;max-width:13.75rem;white-space:nowrap;overflow:hidden;-o-text-overflow:ellipsis;text-overflow:ellipsis;-ms-flex-negative:0;-webkit-flex-shrink:0;flex-shrink:0} ul.stepper.horizontal .step:before{content:none} ul.stepper.horizontal .step .step-title:before{position:absolute;top:1.7813rem;left:1.1875rem;counter-increment:section;content:counter(section);height:1.75rem;width:1.75rem;color:#fff;background-color:rgba(0,0,0,.3);-webkit-border-radius:100%;border-radius:100%;text-align:center;line-height:1.75rem;font-weight:400} ul.stepper.horizontal .step-title:after{top:.9375rem} ul.stepper.horizontal .step-new-content{position:absolute;height:calc(100% - 84px);top:6rem;left:0;width:100%;overflow-y:auto;overflow-x:hidden;margin:0;padding:1.25rem 1.25rem 4.75rem} ul.stepper.horizontal .step-actions{position:absolute;bottom:0;left:0;width:100%;padding:20px;-webkit-box-orient:horizontal;-webkit-box-direction:reverse;-webkit-flex-direction:row-reverse;-ms-flex-direction:row-reverse;flex-direction:row-reverse} ul.stepper.horizontal .step-actions .btn-flat:not(:last-child), ul.stepper.horizontal .step-actions .btn-large:not(:last-child), ul.stepper.horizontal .step-actions .btn:not(:last-child){margin-left:.3125rem;margin-right:0} ul.stepper.horizontal .step-actions, ul.stepper.horizontal .step-new-content{padding-left:2.5rem;padding-right:2.5rem}}
				    ul.horizontal-fix li a {
				        padding: .84rem 2.14rem;
				        }
				        
					.ztree li span.button.add {margin-left:2px; margin-right: -1px; background-position:-144px 0; vertical-align:top; *vertical-align:middle}
				</style>
		
				<script type="text/javascript">
				  var zNodesTypeDesagregation =[
					  { id:0, pId:0, name:"/", open:true}
				  ];
				  
				  var zNodesDesagregation =[
					  { id:0, pId:0, name:"/", open:true}
				  ];
				  
				  var zNodesDesagregationSelectionnes =[];
				</script>

				<script>
					@foreach($typeDesagregations as $typeDesagregation)
						zNodesTypeDesagregation.push({
							id: {{ $typeDesagregation->id }},
							pId: 0,
							name: @json($typeDesagregation->intitule)
						});
					@endforeach
					
					@foreach($desagregations as $desagregation)
						zNodesDesagregation.push({
							id: {{ $desagregation->id }},
							pId: 0,
							name: @json($desagregation->intitule)
						});
					@endforeach
					
					@foreach($desagregationsIndicateur as $desagregationIndicateur)
						zNodesDesagregationSelectionnes.push({
							id: {{ $desagregationIndicateur->id }},
							pId: 0,
							name: @json($desagregationIndicateur->intitule)
						});
					@endforeach
				  

				</script>
				<script type="text/javascript" th:inline="javascript">
					var tempNode = null;
					var log, className = "dark";
					var newCount = 0;
					
					
					var settingTypeDesagregation = {
						view: {
							showIcon: showIconForTree,
							addHoverDom: addHoverDomTypeDesagregation,
							removeHoverDom: removeHoverDomTypeDesagregation
							
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
							beforeClick: beforeClickTypeDesagregation,
							onClick: onClickTypeDesagregation,
							beforeEditName: beforeEditNameTypeDesagregation,
							beforeRemove: beforeRemoveTypeDesagregation,
							beforeRename: beforeRenameTypeDesagregation,
							onRemove: onRemoveTypeDesagregation,
							onRename: onRenameTypeDesagregation
							
						}
					};
					
					var settingDesagregation = {
						view: {
							showIcon: showIconForTree,
							addHoverDom: addHoverDomDesagregation,
							removeHoverDom: removeHoverDomDesagregation
							
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
							beforeClick: beforeClickDesagregation,
							onClick: onClickDesagregation,
							beforeDblClick : beforeDblClickDesagregation,
							onDblClick: onDblClickDesagregation,
							beforeEditName: beforeEditNameDesagregation,
							beforeRemove: beforeRemoveDesagregation,
							beforeRename: beforeRenameDesagregation,
							onRemove: onRemoveDesagregation,
							onRename: onRenameDesagregation
							
						}
					};
					
					function beforeClickDesagregation(treeId, treeNode, clickFlag) {
						return (treeNode.click != false);
					}
					function onClickDesagregation(event, treeId, treeNode, clickFlag) {
						
					}
					function beforeDblClickDesagregation(treeId, treeNode) {
						return (treeNode.click != false);
					};
					
					function onDblClickDesagregation(event, treeId, treeNode) {
						
						if(treeId == "liste_desagregation")
						{
							source = $.fn.zTree.getZTreeObj("liste_desagregation");
							destination = $.fn.zTree.getZTreeObj("liste_desagregation_selectionnes");
							selectNode(source.getSelectedNodes()[0], source, destination);
									
							
						}
						else if(treeId == "liste_desagregation_selectionnes")
						{
							indicateurId = $('#indicateur').val();
							var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_desagregation_selectionnes");
							var treeNodes = sourceTreeObj.getSelectedNodes();
		
							var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_desagregation");				
							var params =[];	
							var desagregation = treeNodes[0];
							sourceTreeObj.removeNode(desagregation);
							params[0] = desagregation.id;
								
							$.post('/suppressionDesagregationIndicateur',{params:params,indicateurId:indicateurId},function(dat){
							});
							
							
						}
						
					};
					
					function showIconForTree(treeId, treeNode) {
						/*return !treeNode.isParent;*/
					};
					
					function beforeEditNameDesagregation(treeId, treeNode) {
						var zTree = $.fn.zTree.getZTreeObj("liste_desagregation");
						zTree.selectNode(treeNode);
						setTimeout(function() {
								zTree.editName(treeNode);
							}, 0);
						return false;
					}
					function beforeRenameDesagregation(treeId, treeNode, newName, isCancel) {
						className = (className === "dark" ? "":"dark");
						if (newName.length == 0) {
							setTimeout(function() {
								var zTree = $.fn.zTree.getZTreeObj("liste_desagregation");
								zTree.cancelEditName();
								alert("le libelle ne doit pas être vide");
							}, 0);
							return false;
						}
							
						return true;
					}
					function onRenameDesagregation(e, treeId, treeNode, isCancel) 
					{
						var typeTreeObj = $.fn.zTree.getZTreeObj("liste_type_desagregation");
						var typeDesagregationNodes = typeTreeObj.getSelectedNodes();
						if(tempNode != null)
						{
							
							$.ajax({
								url: '/api/desagregations/',
								type: 'POST',
								data: {
									id: treeNode.id,
									intitule: treeNode.name,
									type_desagregation_id: typeDesagregationNodes[0].id
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
								url: '/api/desagregations/' + treeNode.id,
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
					function beforeRemoveDesagregation(treeId, treeNode) {
						className = (className === "dark" ? "":"dark");
						var zTree = $.fn.zTree.getZTreeObj("liste_desagregation");
						zTree.selectNode(treeNode);
						return confirm("Confirmer la suppression de l'desagregation : " + treeNode.name);
					}
					function onRemoveDesagregation(e, treeId, treeNode) {
						$.ajax({
							url: '/api/desagregations/' + treeNode.id,
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
					function addHoverDomDesagregation(treeId, treeNode) {
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
							var zTree = $.fn.zTree.getZTreeObj("liste_desagregation");
							var newNode_name = "nouveau desagregation";
							newCount++;
							var newNode = {id:newCount, pId:treeNode.id, name:newNode_name};
							zTree.addNodes(treeNode,0, newNode);
							
							tempNode = newNode;
							
							last_node = treeNode.children[0];
							zTree.selectNode(last_node);
							setTimeout(function(dat) {
										zTree.editName(last_node);
									}, 0);
									
							return false;
							
						});
						
					}	
					};
					
					function removeHoverDomDesagregation(treeId, treeNode) {
						$("#addBtn_"+treeNode.tId).unbind().remove();
					};
					
					
					function beforeClickTypeDesagregation(treeId, treeNode, clickFlag) {
						return (treeNode.click != false);
					}
					function onClickTypeDesagregation(event, treeId, treeNode, clickFlag) {
						indicateur_id = $('#indicateur_id').val();
						$.ajax({
						url: '/api/indicateurs/'+indicateur_id+'/'+treeNode.id,
						type: 'GET',
						success: function (data) {
							alert(data);
							var selectedDesagregations = data.selected.map(function(item) {
								return {
									id: item.id,
									pId: 0,               // racine
									name: item.intitule   // affichage
								};
							});
							
							var notSelectedDesagregations = data.notSelected.map(function(item) {
								return {
									id: item.id,
									pId: 0,               // racine
									name: item.intitule   // affichage
								};
							}); 
							
							$.fn.zTree.init($("#liste_desagregation_selectionnes"), settingDesagregation, selectedDesagregations);
							$.fn.zTree.init($("#liste_desagregation"), settingDesagregation, notSelectedDesagregations);
							
						},
						error: function (xhr) {
							console.error("Erreur :", xhr.responseText);
						}
					});
						
					}
					
					
					
					function beforeEditNameTypeDesagregation(treeId, treeNode) {
						var zTree = $.fn.zTree.getZTreeObj("liste_type_desagregation");
						zTree.selectNode(treeNode);
						setTimeout(function() {
								zTree.editName(treeNode);
							}, 0);
						return false;
					}
					function beforeRenameTypeDesagregation(treeId, treeNode, newName, isCancel) {
						className = (className === "dark" ? "":"dark");
						if (newName.length == 0) {
							setTimeout(function() {
								var zTree = $.fn.zTree.getZTreeObj("liste_type_desagregation");
								zTree.cancelEditName();
								alert("le libelle ne doit pas être vide");
							}, 0);
							return false;
						}
							
						return true;
					}
					function onRenameTypeDesagregation(e, treeId, treeNode, isCancel) 
					{
						if(tempNode != null)
						{
							$.ajax({
								url: '/api/type_desagregations/',
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
								url: '/api/type_desagregations/' + treeNode.id,
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
					function beforeRemoveTypeDesagregation(treeId, treeNode) {
						className = (className === "dark" ? "":"dark");
						var zTree = $.fn.zTree.getZTreeObj("liste_type_desagregation");
						zTree.selectNode(treeNode);
						return confirm("Confirmer la suppression de l'typeDesagregation : " + treeNode.name);
					}
					function onRemoveTypeDesagregation(e, treeId, treeNode) {
						
						$.ajax({
							url: '/api/type_desagregations/' + treeNode.id,
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
					function addHoverDomTypeDesagregation(treeId, treeNode) {
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
							var zTree = $.fn.zTree.getZTreeObj("liste_type_desagregation");
							var newNode_name = "nouveau type désagrégation";
							newCount++;
							var newNode = {id:newCount, pId:treeNode.id, name:newNode_name};
							zTree.addNodes(treeNode,0, newNode);
							
							tempNode = newNode;
							last_node = treeNode.children[0];
							zTree.selectNode(last_node);
							setTimeout(function(dat) {
										zTree.editName(last_node);
									}, 0);
									
							
							return false;
							
						});
						
					}	
					};
					function removeHoverDomTypeDesagregation(treeId, treeNode) {
						$("#addBtn_"+treeNode.tId).unbind().remove();
					};
				</script>
				<input id="indicateur" type="hidden" th:attr="value=${indicateur.id}" >
				<table id="tb_strategie" style="width:100%;min-height:90%">
					<thead>
						<tr style="background:#f8f9fa">
							<th style="width:33%;padding:10px;">Types Désagrégation
								<span class="float-right">
									<a href="#"><i class="mdi mdi-file-upload" style="padding-right:15px"></i></a>
								</span>
							</th>
							<th style="width:34%;padding:10px;">Désagrégations disponibles
								<span class="float-right">
									<a href="#"><i class="mdi mdi-file-upload" style="padding-right:15px"></i></a>
									<a href="#" id="transfererDesagregationDisponibleVersSelectionne"><i class="fas fa-angle-right" style="padding-right:15px"></i></a>
								</span>
							</th>
							<th style="width:33%;padding:10px;">Désagrégations sélectionnées
								<span class="float-right">
									<a href="#" id="transfererDesagregationSelectionneVersDisponible"><i class="fas fa-angle-left" style="padding-right:15px"></i></a>
								</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="vertical-align: top;border-right: solid 3px #f8f9fa">
								<div class="input-group">
						           <input type="text" id="search_desagregation" name="search" class="form-control form-control-sm" placeholder="Search">
						       		<span class="input-group-append">
			                       		<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
			                       </span>
						       	</div>
								<ul id="liste_type_desagregation" class="ztree"></ul>
							</td>
							<td style="vertical-align: top;border-right: solid 3px #f8f9fa">
								<div class="input-group">
						           <input type="text" id="search_desagregation" name="search" class="form-control form-control-sm" placeholder="Search">
						       		<span class="input-group-append">
			                       		<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
			                       </span>
						       	</div>
								<ul id="liste_desagregation" class="ztree"></ul>
							</td>
							<td style="vertical-align: top;">
								<div class="input-group">
						           <input type="text" id="search_desagregation_selectionnes" name="search" class="form-control form-control-sm" placeholder="Search">
						       		<span class="input-group-append">
			                       		<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
			                       </span>
						       	</div>
								<ul id="liste_desagregation_selectionnes" class="ztree"></ul>
							</td>
						</tr>
					</tbody>
				</table>
					
		
				<script>
				
					function selectNode(node, source, destination)
					{
						if(node.isParent)
							{
								children = node.children;
								l=children.length;
								while (l>0)
									{
										selectNode(children[children.length -l],source, destination);
										l--;
									}
								
							}
						else 
							{
								if(node.name != "/")
								{ 
									indicateurId = $('#indicateur').val();
									var params =[];
									var index = destination.getNodeByParam("name", node.name, null);
									if(index == null){
										destination.addNodes(null, node);
									}
									params[0] = node.id;
									if(index == null){
										$.post('/ajoutDesagregationIndicateur',{params:params,indicateurId:indicateurId},function(dat){
										});
									}
								}
							}
						
					}
					$(document).ready(function () {
						$.fn.zTree.init($("#liste_type_desagregation"), settingTypeDesagregation, zNodesTypeDesagregation);
						$.fn.zTree.init($("#liste_desagregation"), settingDesagregation, zNodesDesagregation);
						$.fn.zTree.init($("#liste_desagregation_selectionnes"), settingDesagregation, zNodesDesagregationSelectionnes);
						
						$('#search_desagregation').keypress(function(){
					    	 if($(this).val() != "")
					    	 { 
					    		 var treeObj = $.fn.zTree.getZTreeObj("liste_desagregation");
							      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
							      $.fn.zTree.init($("#liste_desagregation"), settingDesagregation, nodes); 
					    	 }else
					    	{
					    		 $.fn.zTree.init($("#liste_desagregation"), settingDesagregation, zNodesDesagregation);
					    	}
							 
					      });
						$('#search_desagregation_selectionnes').keypress(function(){
					    	 if($(this).val() != "")
					    	 { 
					    		 var treeObj = $.fn.zTree.getZTreeObj("liste_desagregation_selectionnes");
							      var nodes = treeObj.getNodesByParamFuzzy("name", $(this).val(), null);
							      $.fn.zTree.init($("#liste_desagregation_selectionnes"), settingDesagregation, nodes); 
					    	 }else
					    	{
					    		 $.fn.zTree.init($("#liste_desagregation_selectionnes"), settingDesagregation, zNodesDesagregationSelectionnes);
									
					    	}
							 
					      });
						
						
						$('#transfererDesagregationDisponibleVersSelectionne').click(function(){
							indicateurId = $('#indicateur').val();
							source = $.fn.zTree.getZTreeObj("liste_desagregation");
							destination = $.fn.zTree.getZTreeObj("liste_desagregation_selectionnes");
							var l=source.getSelectedNodes().length;
							while (l>0) {
								selectNode(source.getSelectedNodes()[l-1], source, destination);
								l--;
							}
							
							
						});
						
						$('#transfererDesagregationSelectionneVersDisponible').click(function(){
							indicateurId = $('#indicateur').val();
							var sourceTreeObj = $.fn.zTree.getZTreeObj("liste_desagregation_selectionnes");
							var treeNodes = sourceTreeObj.getSelectedNodes();
							var l=treeNodes.length;
							
							var destinationTreeObj = $.fn.zTree.getZTreeObj("liste_desagregation");
							
							var params =[];
							var p = 0;
							while (l>0) {
								var desagregation = treeNodes[l-1];
								/*destinationTreeObj.addNodes(destinationTreeObj.getNodes()[0], desagregation);*/
								sourceTreeObj.removeNode(desagregation);
								l--;
								
								params[p] = desagregation.id;
								p++;
							}
							$.post('/suppressionDesagregationIndicateur',{params:params,indicateurId:indicateurId},function(dat){
							});
							
							
						});
						 
				  });
		
				</script>

		      </div>
		    </div>   
		  </div>
		</div>
	</div>
</body>
</html>
