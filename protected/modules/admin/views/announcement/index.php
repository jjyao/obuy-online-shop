<?php
$this->pageTitle=Yii::app()->name . ' - 商品列表';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/announcement.less');
?>
<article>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'announcement_grid_view',
	'dataProvider'=>$announcement->search(),
	'filter'=>$announcement,
	'ajaxUrl'=>Yii::app()->createUrl('admin/announcement/index'),
	'columns'=>array(
		array(
			'name'=>'id',
			'sortable'=>false,
			'id'=>'id_title',
		),
		array(
			'name'=>'title',
			'sortable'=>false,
			'id'=>'title_title',
		),
		array(
			'name'=>'time',
			'sortable'=>true,
			'id'=>'time_title',
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}{delete}',
			'buttons'=>array(
				'view'=>array(
					'url'=>'Yii::app()->createUrl("announcement/view", array("id"=>$data->id))',
					'options'=>array(
						'target'=>'_blank',
					),
				),
			),
			'header'=>'可选操作',
		),
	),
	'pager'=>array(
		'header'=>'',
	),
	));
?>
</article>