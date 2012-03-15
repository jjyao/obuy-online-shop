<?php
$this->pageTitle=Yii::app()->name . ' - 商品分类';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/jquery-easyui/themes/default/easyui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/jquery-easyui/themes/icon.css');
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/category.less');
?>
<article>
	<section id="action_panel">
		<button id='create' class="btn btn-primary">新建分类</button>
		<button id='delete_no_cascade' class="btn btn-primary">删除分类</button>
		<button id='delete_cascade' class="btn btn-primary">删除分类及子分类</button>
		<button id='cancel_selection' class="btn btn-primary">取消选中</button>
	</section>
	<div class="row-fluid">
		<ul id="category_tree" class="easyui-tree span7"></ul>
		<section id="tips" class="span4 well">
			<h3>Tips</h3>
			<ul>
				<li>新建分类：如果当前有选中的分类，则新建的分类会成为其子类。否则成为顶级分类</li>
				<li>删除分类：仅仅删除选中分类，其子分类自动依附于其父类</li>
				<li>删除分类及子分类：除了选中分类，其所有子类都将被删除</li>
				<li>取消选中：不选中任何分类，这在创建顶级分类时有用</li>
				<li>双击修改：双击某个分类，就可以修改分类名称</li>
				<li>拖动调整：拖动分类来调整父子关系</li>
			</ul>
		</section> 
	</div>
</article>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/jquery-easyui/jquery.easyui.min.js"></script>
<script type="text/javascript">
	// global variable
	var oldName;

	$('#category_tree').tree({
		dnd: true,
		url: '<?php echo Yii::app()->getUrlManager()->createUrl("admin/category/get")?>',
		animate: true,
		onDblClick: function(node){
			oldName = node.text;
			$('#category_tree').tree('beginEdit', node.target);
		},
		onAfterEdit: function(node){
			modifyCategory(node);
		},
		onDrop: function(target, source, point){
			moveCategory(target, source, point);
		},
	});

	// declare action functions
	function createCategory(){		
		var node = $('#category_tree').tree('getSelected');

		// update server
		$.ajax({
			url: '<?php echo Yii::app()->getUrlManager()->createUrl("admin/category/create")?>',
			type: 'post',
			dataType: 'json',
			data: {
				parentId: (node? node.id : null),
			},
			success: function(result){
				$('#category_tree').tree('append', {
					parent: (node? node.target : null),
					data: [{
						id: result.id, 
						text: result.text,
						state: 'open',
					}]
				});
			},
			error: function(request, status, error){
				alert(status + ": " + error);
			}
		});		
	}

	function deleteCategory(isCascade){
		var node = $('#category_tree').tree('getSelected');
		if(!node){
			alert("未选中任何分类");
		}
		else{
			// update server
			$.ajax({
				url: '<?php echo Yii::app()->getUrlManager()->createUrl("admin/category/delete")?>',
				type: 'post',
				dataType: 'json',
				data: {
					categoryId: node.id,
					isCascade: isCascade,
				},
				success: function(result){
					$('#category_tree').tree('reload'); // simplest way
				},
				error: function(request, status, error){
					alert(status + ": " + error);
				}
			});	
		}
	}

	function modifyCategory(node){
		if(node.text != ''){
			$.ajax({
				url: '<?php echo Yii::app()->getUrlManager()->createUrl("admin/category/modify")?>',
				type: 'post',
				dataType: 'json',
				data: {
					categoryId: node.id,
					name: node.text,
				},
				error: function(request, status, error){
					alert(status + ": " + error);
				}
			});	
		}
		else
		{
			alert("分类名称不能为空");
			node.text = oldName; // restore the name
			$('#category_tree').tree('update', node);
		}
	}

	function moveCategory(target, sourceNode, point){
		var targetNode = $('#category_tree').tree('getNode', target);
	
		$.ajax({
			url: '<?php echo Yii::app()->getUrlManager()->createUrl("admin/category/move")?>',
			type: 'post',
			dataType: 'json',
			data: {
				sourceId: sourceNode.id,
				targetId: targetNode.id,
				point: point,
			},
			error: function(request, status, error){
				alert(status + ": " + error);
			}
		});
	}

	function cancelSelection(){
		var node = $('#category_tree').tree('getSelected');
		if(node){
			$(node.target).removeClass('tree-node-selected');
		}
	}

	// register listener
	$('#create').on('click', function(e){
		createCategory();
	});
	$('#delete_no_cascade').on('click', function(e){
		deleteCategory(false);
	});
	$('#delete_cascade').on('click', function(e){
		deleteCategory(true);
	});
	$('#cancel_selection').on('click', function(e){
		cancelSelection();
	})
</script>
