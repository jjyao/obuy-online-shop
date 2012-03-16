<?php
$this->pageTitle=Yii::app()->name . ' - 商品列表';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/product.less');
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'product_grid_view',
		'dataProvider'=>$product->search(),
		'filter'=>$product,
		'columns'=>array(
			array(
				'name'=>'id',
				'sortable'=>false,
			),
			array(
				'name'=>'name',
				'sortable'=>false,
			),
			array(
				'name'=>'price',
				'sortable'=>false,
			),
			array(
				'name'=>'publishTime',
				'sortable'=>true,
			),
			array(
				'name'=>'categoryId',
				'header'=>'分类',
				'filter'=>CHtml::listData(Category::model()->findAll(array('order'=>'name')), 'id', 'name'),
				'value'=>'$data->category->name',
			),
			array(
				'header'=>'是否销售',
				'name'=>'isOnSale',
				'filter'=>array(Product::ON_SALE=>"是", Product::NOT_ON_SALE=>"否"),
				'value'=>'($data->isOnSale == Product::ON_SALE)? "是" : "否"',
			),
			array(
				'class'=>'CButtonColumn',
				'buttons'=>array(
					'view'=>array(
						'url'=>'Yii::app()->createUrl("product/view", array("id"=>$data->id))',
					),
				),
				'header'=>'可选操作',
			),
		),
	));
?>