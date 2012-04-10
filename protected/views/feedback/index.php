<?php 
$this->pageTitle=Yii::app()->name . ' - 留言板';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/feedback.less');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/assets/jquery-notice/jquery.notice.css');
?>

<article class="container">

<section id="feedback_input">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'create_feedback_form',
)); ?>
		<?php echo $form->textArea($feedback, 'content', array('id'=>'feedback_content_input', 'placeholder'=>" 想对我们说些什么")); ?>
		<a class="btn btn-primary" id="submit_feedback">发布</a>
<?php $this->endWidget(); ?>
</section>

<section id="feedback_display_section">
	<?php $this->widget('zii.widgets.CListView', array(
			'id'=>'feedback_list_view',
			'dataProvider'=>$dataProvider,
			'itemView'=>'_feedback_item',
			'template'=>"{items}\n{pager}",
			'pager'=>array(
				'header'=>'',
			),
		));
	?>
</section>
</article>

<script type="text/javascript">
	$('#submit_feedback').on('click', function(e){
		if($('#feedback_content_input').val().trim() != ''){
			$.ajax({
				url: '<?php echo Yii::app()->createUrl("feedback/create") ?>',
				type: 'post',
				dataType: 'json',
				data: {
					'<?php echo get_class($feedback) . '[content]' ?>' : $('#feedback_content_input').val(),
				},
				success: function(data){
					if(data.result == 'success'){
						$('#feedback_list_view').yiiListView.update('feedback_list_view');
						$('#feedback_content_input').val('');
					}
				},
				error: function(request, status, error){
					alert(status + ": " + error);
				}
			});
		}
	});
</script>