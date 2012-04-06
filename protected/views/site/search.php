<?php
$this->pageTitle=Yii::app()->name . ' - 商品搜索';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/search.less');
?>
<article class="container">
<nav class="breadcrumbs">
<ul>
	<li class="first">
	<a href="#" style="z-index: 1;">
		<span class="left_yarn" style="z-index: 2;"></span>
		搜索结果
	</a>	
	</li>
</ul>
</nav>
<div id="product_number">
	共查询到<?php echo $dataProvider->totalItemCount ?>件商品
</div>
<span class="clearfix"></span>
<?php if($dataProvider->totalItemCount > 0): ?>
<div class="product_list">
<?php
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_product_item',
		'template'=>"{items}\n{pager}",
		'pager'=>array(
			'header'=>'',
		),
	));
?>
<span class="clearfix"></span>
</div>
<?php else: ?>
<div id="product_not_found_hint">
抱歉，未找到任何商品
</div>
<?php endif; ?>
</article>