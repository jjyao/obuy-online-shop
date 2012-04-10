<?php
$this->pageTitle=Yii::app()->name . ' - 留言列表';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/feedback.less');
?>
<article>
<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'feedback_grid_view',
		'dataProvider'=>$feedback->search(),
		'filter'=>$feedback,
		'ajaxUrl'=>Yii::app()->createUrl('admin/feedback/index'),
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
				'value'=>'CHtml::link($data->clientId . "  " . $data->client->email ,
					Yii::app()->createUrl("/admin/client/index", array("id"=>$data->clientId)),
					array("target"=>"_blank"))',
				'id'=>'client_title',
			),
			array(
				'name'=>'time',
				'sortable'=>true,
				'id'=>'time_title',
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{delete}',
				'header'=>'可选操作',
			),
		),
		'pager'=>array(
			'header'=>'',
		),
	));
?>
</article>