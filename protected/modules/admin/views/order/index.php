<?php
$this->pageTitle=Yii::app()->name . ' - 订单列表';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/order.less');
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order_grid_view',
	'dataProvider'=>$order->search(),
	'filter'=>$order,
	'columns'=>array(
		array(
			'name'=>'id',
			'sortable'=>false,
			'id'=>'id_title',
		),
		array(
			'class'=>'CDataColumn',
			'name'=>'clientId',
			'type'=>'raw',
			'sortable'=>false,
			'value'=>'CHtml::link($data->clientId . " " . $data->client->email ,Yii::app()->createUrl("/admin/client/view", array("id"=>$data->clientId)))',
		),
		array(
			'class'=>'CDataColumn',
			'name'=>'productId',
			'type'=>'raw',
			'sortable'=>false,
			'value'=>'CHtml::link($data->productId . " " . $data->product->name ,Yii::app()->createUrl("/admin/product/view", array("id"=>$data->productId)))',
		),
		array(
			'name'=>'count',
			'sortable'=>true,
			'id'=>'count_title',
		),
		array(
			'name'=>'unitPrice',
			'sortable'=>true,
			'id'=>'unitPrice_title',
		),
		array(
			'name'=>'time',
			'sortable'=>true,
			'id'=>'time_title',
		),
		array(
			'name'=>'status',
			'filter'=>$order->statusLabels(),
			'value'=>'$data->getStatusLabel($data->status)',
			'id'=>'status_title',
		),
	),

	));
?>