<?php
$this->pageTitle=Yii::app()->name . ' - 用户列表';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/client.less');
?>
<article>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'client_grid_view',
	'dataProvider'=>$client->search(),
	'filter'=>$client,
	'columns'=>array(
		array(
			'name'=>'id',
			'sortable'=>true,
			'id'=>'id_title',
			'htmlOptions'=>array(
				'class'=>'client_id_display',
			),
		),
		array(
			'name'=>'name',
			'sortable'=>false,
			'id'=>'name_title',
			'htmlOptions'=>array(
				'class'=>'client_name_display',
			),
		),
		array(
			'name'=>'email',
			'sortable'=>false,
			'id'=>'email_title',
			'htmlOptions'=>array(
				'class'=>'client_email_display',
			),
		),
		array(
			'name'=>'isActive',
			'filter'=>$client->statusLabels(),
			'value'=>'$data->getStatusLabel($data->isActive)',
			'id'=>'status_title',
			'htmlOptions'=>array(
				'class'=>'client_isActive_display',
			),
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>"{update}\n{delete}",
			'buttons'=>array(
				'update'=>array(
					'url'=>'"#"',
					'options'=>array(
						'class'=>'modify_client',
					),
					'click'=>'js:modify_client_click_handler',
				),
				'delete'=>array(
					'url'=>'Yii::app()->createUrl("admin/client/delete", array("id"=>$data->id))',
					'label'=>'注销',
				),
			),
			'deleteConfirmation'=>'确定要注销该用户吗',
			'header'=>'可选操作',
		),
	),
	'pager'=>array(
		'header'=>'',
	),
	));
?>

<section class="modal fade" id="client_modal">
	<section class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>用户信息</h3>
	</section>
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id'=>'update_client_form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	));?>
	<section class="modal-body">
		<?php $attributesArray = $client->attributeLabels(); ?>
		<div id = "update_client_error_alert" class="alert alert-error">
			<p>请更正下列输入错误:</p>
			<ul></ul>		
		</div>
		<div class="row-fluid">
			<div class="span6">
				<label>
					<?php echo $attributesArray['id']; ?>
				</label>
				<span id="modal_client_id_dispaly" class='uneditable-input'></span>

				<label>
					<?php echo $attributesArray['name']; ?>
				</label>
				<?php echo $form->textField($client, 'name', array('id'=>'modal_client_name_input')); ?>
			</div>
			<div class="span6">
				<label>
					<?php echo $attributesArray['email']; ?>
				</label>
				<?php echo $form->textField($client, 'email', array('id'=>'modal_client_email_input')); ?>

				<label>
					<?php echo $attributesArray['isActive']; ?>
				</label>
				<?php echo $form->dropDownList($client, 'isActive', $client->statusLabels(), array('id'=>'modal_client_status_input')) ?>
			</div>

			<label>
				<?php echo $attributesArray['password'] . ' (如果不想更改密码，此项可以不填)' ?>
			</label>
			<?php echo $form->passwordField($client, 'password', array('id'=>'modal_client_password_input')); ?>

	</section><!-- modal-body -->
	<section class="modal-footer">
		<a href="#" id="modal_close" class="btn">关闭</a>
		<a href="#" id="submit_client_update" class="btn btn-primary">保存并关闭</a>
	</section><!-- modal-footer -->
	<?php $this->endWidget(); ?><!-- form -->
</section><!-- modal -->
</article>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-modal.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-transition.js"></script>
<script type="text/javascript">
	function modify_client_click_handler(e){
		/**
		 * collect client info from html
		 */
		var clientId = $(this).parent().siblings('.client_id_display').text();
		var clientName = $(this).parent().siblings('.client_name_display').text();
		var clientEmail = $(this).parent().siblings('.client_email_display').text();
		var clientStatus = $(this).parent().siblings('.client_isActive_display').text();

		var statusArray = new Array();
		var statusVal;
		var statusLabel;
		var i;
		for(i = 2; i<=3; i++){
			statusVal = $('#client_grid_view select option:nth-child(' + i + ')').val();
			statusLabel = $('#client_grid_view select option:nth-child(' + i + ')').text();
			statusArray[statusLabel] = statusVal;
		}

		// fill client modal with collected data
		$('#modal_client_id_dispaly').text(clientId);
		$('#modal_client_name_input').val(clientName);
		$('#modal_client_email_input').val(clientEmail);
		$('#modal_client_password_input').val('');
		$('#modal_client_status_input').val(statusArray[clientStatus]);

		$('#client_modal').modal('show');
	}

	$('#modal_close').on('click', function(e){
		$('#client_modal').modal('hide');
	});

	$('#submit_client_update').on('click', function(e){
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("admin/client/update") ?>',
			type: 'post',
			dataType: 'json',
			data: {
				'<?php echo get_class($client) . '[id]' ?>' : $('#modal_client_id_dispaly').text(),
				'<?php echo get_class($client) . '[name]' ?>': $('#modal_client_name_input').val(),
				'<?php echo get_class($client) . '[email]' ?>': $('#modal_client_email_input').val(),
				'<?php echo get_class($client) . '[password]' ?>': $('#modal_client_password_input').val(),
				'<?php echo get_class($client) . '[isActive]' ?>': $('#modal_client_status_input').val(),
			},
			success: function(data){
				if(data.result == 'success'){
					$('#client_modal').modal('hide');
					$('#update_client_error_alert').hide();
					$('#client_grid_view').yiiGridView.update('client_grid_view');
				}
				else{
					$('#update_client_error_alert ul').children().remove();
					var i;
					var j;
					for(i in data.errors){
						for(j in data.errors[i]){
							$('#update_client_error_alert ul').append('<li>' + (data.errors[i])[j] + '</li>');
						}
						$('#update_client_error_alert').show();
					}
				}
			},
			error: function(request, status, error){
				alert(status + ": " + error);
			}
		});
	});
</script>