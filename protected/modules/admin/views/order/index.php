<?php
$this->pageTitle=Yii::app()->name . ' - 订单列表';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/order.less');
?>
<article>
<section id="action_panel">
	<button id="update" class="btn btn-primary">查看更新订单</button>
	<button id="delete" class="btn btn-primary">删除订单</button>
</section>
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
			'value'=>'CHtml::link($data->clientId . "  " . $data->client->email ,Yii::app()->createUrl("/admin/client/view", array("id"=>$data->clientId)))',
			'id'=>'client_title',
		),
		array(
			'class'=>'CDataColumn',
			'name'=>'productId',
			'type'=>'raw',
			'sortable'=>false,
			'value'=>'CHtml::link($data->productId . "  " . $data->product->name ,Yii::app()->createUrl("/admin/product/view", array("id"=>$data->productId)))',
			'id'=>'product_title',
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
			'name'=>'deliveryAddress',
			'sortable'=>false,
			'id'=>'deliveryAddress_title',
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

<section class="modal fade" id="order_modal">
	<section class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>订单信息</h3>
	</section>
	
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id'=>'update_order_form',		
	));?>
	<section class="modal-body">
		<?php $attributesArray = $order->attributeLabels(); ?>
		<div id = "update_order_error_alert" class="alert alert-error">
			<p>请更正下列输入错误:</p>
			<ul></ul>		
		</div>
		<div class="row-fluid">
			<div class="span6">
				<label>
					<?php echo $attributesArray['id']; ?>
				</label>
				<span id="orderId_dispaly" class='uneditable-input'></span>

				<label>
					<?php echo $attributesArray['clientId']; ?>
				</label>
				<a id="clientId_display"></a>

				<label>
					<?php echo $attributesArray['count']; ?>
				</label>
				<?php echo $form->textField($order, 'count', array('id'=>'count_input')); ?>

				<label>
					<?php echo $attributesArray['unitPrice']; ?>
				</label>
				<?php echo $form->textField($order, 'unitPrice', array('id'=>'unitPrice_input')); ?>
			</div>
			<div class="span6">
				<label>
					<?php echo $attributesArray['time']; ?>
				</label>
				<span id="time_display" class="uneditable-input"></span>

				<label>
					<?php echo $attributesArray['productId']; ?>
				</label>
				<a id="productId_display"></a>

				<label>
					<?php echo $attributesArray['deliveryAddress']; ?>
				</label>
				<?php echo $form->textField($order, 'deliveryAddress', array('id'=>'deliveryAddress_input')); ?>

				<label>
					<?php echo $attributesArray['status']; ?>
				</label>
				<?php echo $form->dropDownList($order, 'status', $order->statusLabels(), array('id'=>'status_input')); ?>
			</div>
		</div><!-- row flid -->
	</section><!-- modal-body -->
	<section class="modal-footer">
		<a href="#" id="modal_close" class="btn">关闭</a>
		<a href="#" id="sumbit_order_update" class="btn btn-primary">保存并关闭</a>
	</section><!-- modal-footer -->
	<?php $this->endWidget(); ?><!-- form -->
</section><!-- modal -->

</article>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-modal.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-transition.js"></script>
<script type="text/javascript">
	$('#update').on('click', function(e){
		if($('#order_grid_view tr.selected').length == 0){
			alert("未选中任何订单");
		}
		else{
			/**
			 * collect order info from html
			 * another approach is to send an ajax request to get info from server
			 */
			var orderId = $('#order_grid_view tr.selected td::nth-child(1)').text();
			
			var clientInfo = $('#order_grid_view tr.selected td::nth-child(2)').text();
			clientInfo = clientInfo.split(/\s+/);
			var clientId = clientInfo[0];
			var clientEmail = clientInfo[1];

			var productInfo = $('#order_grid_view tr.selected td::nth-child(3)').text();
			productInfo = productInfo.split(/\s+/);
			var productId = productInfo[0];
			var productName = productInfo[1];

			var count = $('#order_grid_view tr.selected td::nth-child(4)').text();
			var unitPrice = $('#order_grid_view tr.selected td::nth-child(5)').text();
			var deliveryAddress = $('#order_grid_view tr.selected td::nth-child(6)').text();
			var time = $('#order_grid_view tr.selected td::nth-child(7)').text();
			var status = $('#order_grid_view tr.selected td::nth-child(8)').text();

			var statusArray = new Array();
			var statusVal; 
			var statusLabel;
			var i;
			for(i = 2; i <= 5; i++){
				statusVal = $('#order_grid_view select option:nth-child(' + i + ')').val();
				statusLabel = $('#order_grid_view select option:nth-child(' + i + ')').text();
				statusArray[statusLabel] = statusVal;
			}

			// fill order modal with collected data
			var baseUrl = '<?php echo Yii::app()->getUrlManager()->createUrl("admin/order/update")?>';
			var clientBaseUrl = '<?php echo Yii::app()->getUrlManager()->createUrl("admin/client")?>';
			var productBaseUrl = '<?php echo Yii::app()->getUrlManager()->createUrl("admin/product")?>';

			$('#update_order_form').get(0).setAttribute('action', baseUrl + "/" + orderId);
			$('#orderId_dispaly').text(orderId);

			$('#clientId_display').text(clientEmail);
			$('#clientId_display').get(0).setAttribute('href', clientBaseUrl + "/" + clientId);

			$('#count_input').val(count);
			$('#unitPrice_input').val(unitPrice);
			$('#time_display').text(time);

			$('#productId_display').text(productName);
			$('#productId_display').get(0).setAttribute('href', productBaseUrl + "/" + productId);

			$('#deliveryAddress_input').val(deliveryAddress);
			$('#status_input').val(statusArray[status]);

			$('#order_modal').modal('show');

		}
	});
	
	$('#modal_close').on('click', function(e){
		$('#order_modal').modal('hide');
	});

	$('#sumbit_order_update').on('click', function(e){
		$.ajax({
			url: '<?php echo Yii::app()->getUrlManager()->createUrl("admin/order/update")?>',
			type: 'post',
			dataType: 'json',
			data: {
				'<?php echo get_class($order) . '[id]' ?>' : $('#orderId_dispaly').text(),
				'<?php echo get_class($order) . '[count]' ?>' : $('#count_input').val(),
				'<?php echo get_class($order) . '[unitPrice]' ?>' : $('#unitPrice_input').val(),
				'<?php echo get_class($order) . '[deliveryAddress]' ?>' : $('#deliveryAddress_input').val(),
				'<?php echo get_class($order) . '[status]' ?>' : $('#status_input').val(),
			},
			success: function(data){
				if(data.result == 'success'){
					$('#order_modal').modal('hide');
					$('#update_order_error_alert').hide();
					$('#order_grid_view').yiiGridView.update('order_grid_view');
				}
				else{
					$('#update_order_error_alert ul').children().remove();
					var i;
					var j;
					for(i in data.errors){
						for(j in data.errors[i]){
							$('#update_order_error_alert ul').append('<li>' + (data.errors[i])[j] + '</li>');
						}
					}
					$('#update_order_error_alert').show();
				}
			},
			error: function(request, status, error){
				alert(status + ": " + error);
			}
		});
	});

	$('#delete').on('click', function(e){
		if($('#order_grid_view tr.selected').length == 0){
			alert("未选中任何订单");
		}
		else{		
			$.ajax({
				url: '<?php echo Yii::app()->getUrlManager()->createUrl("admin/order/delete")?>',
				type: 'post',
				dataType: 'json',
				data: {
					id: $('#order_grid_view tr.selected td::nth-child(1)').text(),
				},
				success: function(data){
					$('#order_grid_view').yiiGridView.update('order_grid_view');
				},
				error: function(request, status, error){
					alert(status + ": " + error);
				}
			});
		}
	});
</script>