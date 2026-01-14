@extends('layouts.app')
@section('content')
<div class="container-fluid">
	
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
		</style>
		
		<script type="text/javascript">
	  var zNodesZone = [
			{ id:0, pId:0, name:"/",niveau:0, open: true}
		];
		
		@foreach($zones as $zone)
			zNodesZone.push({
				id: {{ $zone->id }},
				niveau: {{ $zone->niveau ?? 0 }},
				pId: {{ $zone->zone_id ?? 0 }},
				name: @json($zone->intitule)
			});
		@endforeach
		var tempNode = null;
		var settingZone = {
				view: {
					showIcon: showIconForTree,
					addHoverDom: addHoverDomZone,
					removeHoverDom: removeHoverDomZone
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
					/*beforeClick: beforeClickZone,
					onClick: onClickZone,*/
					beforeEditName: beforeEditNameZone,
					beforeRemove: beforeRemoveZone,
					beforeRename: beforeRenameZone,
					onRemove: onRemoveZone,
					onRename: onRenameZone
				}
			};
		var log, className = "dark";
		function showIconForTree(treeId, treeNode) {
				/*return !treeNode.isParent;*/
			};
		function beforeEditNameZone(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("liste_zone");
			zTree.selectNode(treeNode);
			setTimeout(function() {
					zTree.editName(treeNode);
					
				}, 0);
			return false;
		}
		function beforeRenameZone(treeId, treeNode, newName, isCancel) {
			className = (className === "dark" ? "":"dark");
			if (newName.length == 0) {
				setTimeout(function() {
					var zTree = $.fn.zTree.getZTreeObj("liste_zone");
					zTree.cancelEditName();
					alert("le libelle ne doit pas être vide");
				}, 0);
				return false;
			}
				
			return true;
		}
		function onRenameZone(e, treeId, treeNode, isCancel) {
			
			if(tempNode != null)
			{
				$.ajax({
					url: '/api/zones/',
					type: 'POST',
					data: {
						id: treeNode.id,
						intitule: treeNode.name,
						zone_id: treeNode.pId,
						/*zone_id: treeNode.getParentNode().id,*/
						niveau: treeNode.getParentNode().niveau + 1
						/*niveau: parseInt(treeNode.getParentNode().niveau || 0, 10) + 1*/
					},
					success: function (id) {
						console.log("Ajout réussie :", id);
						treeNode.id = id;
					},
					error: function (xhr) {
						alert("erreur");
						console.error("Erreur :", xhr.responseText);
					}
				});
				
				tempNode = null;
			}
			else
			{
				$.ajax({
					url: '/api/zones/' + treeNode.id,
					type: 'PUT',
					data: {
						id: treeNode.id,
						niveau: treeNode.niveau,
						intitule: treeNode.name,
						zone_id: treeNode.pId
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
		function beforeRemoveZone(treeId, treeNode) {
			className = (className === "dark" ? "":"dark");
			var zTree = $.fn.zTree.getZTreeObj("liste_zone");
			zTree.selectNode(treeNode);
			return confirm("Confirmer la suppression du Zone : " + treeNode.name);
		}
		function onRemoveZone(e, treeId, treeNode) {
			$.ajax({
					url: '/api/zones/' + treeNode.id,
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
		function addHoverDomZone(treeId, treeNode) {
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
				var zTree = $.fn.zTree.getZTreeObj("liste_zone");
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
		function removeHoverDomZone(treeId, treeNode) {
			$("#addBtn_"+treeNode.tId).unbind().remove();
		};
		
		function showRemoveBtn(treeId, treeNode) {
			return !treeNode.isFirstNode;
		}
		function showRenameBtn(treeId, treeNode) {
			return !treeNode.isLastNode;
		}
		
		</script>
		
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
				  <div class="card-header d-flex  align-items-center">
					<strong>Zones</strong>
					<a id="uploadZones" href="#" class="ms-auto text-muted" title="Importer">
						<i class="fas fa-file-upload"></i>
					</a>
					
				  </div>
				  <div class="card-body">
					<ul id="liste_zone" class="ztree"></ul>
				  </div>
				</div>
			</div>
		</div>
		
		<script>
			/*var zTree;*/
			$(document).ready(function () {
				var zTree;
				$.fn.zTree.init($("#liste_zone"), settingZone, zNodesZone);
				
				$('#uploadZones').click(function(){
					$.get('/zones/upload',function(dat){
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zTree.v3/3.5.42/js/jquery.ztree.all.min.js" integrity="sha512-7sGF7QJRDdvZna4GfwsdoY6a8jxCFZTAlL2OFKjmEXZ9mPwzHbKnwDiIy9RI1hYZv+XLtbOew+6slAJahxaH+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endsection