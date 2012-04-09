<?php
$this->pageTitle=Yii::app()->name . ' - 更新订单';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/order.less');
?>

<article>
	<section id="order_summary">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id'=>'update_order_form',
		'htmlOptions'=>array(
		),
	));?>
		<div class="modal-header"><h3>订单信息</h3></div>
		<div class="form_body">
			<div id = "update_order_error_alert" class="alert alert-error">
				<p>请更正下列输入错误:</p>
				<ul></ul>		
			</div>
			<?php $attributesArray = $order->attributeLabels(); ?>
			<div class="row-fluid">
				<div class="span6">
					<label>
						<?php echo $attributesArray['id']; ?>
					</label>
					<span id="orderId_dispaly" class='uneditable-input'><?php echo $order->id ?></span>

					<label>
						<?php echo $attributesArray['time']; ?>
					</label>
					<span id="time_display" class="uneditable-input"><?php echo $order->time ?></span>

					<label>
						<?php echo $attributesArray['status']; ?>
					</label>
					<?php echo $form->dropDownList($order, 'status', $order->statusLabels(), array('id'=>'status_input')); ?>
				</div>
				<div class="span6">
					<label>
						<?php echo $attributesArray['clientId']; ?>
					</label>
					<a id="clientId_display" href="<?php echo Yii::app()->createUrl('admin/client/index', array('id'=>$order->clientId)) ?>"><?php echo $order->client->email ?></a>

					<label>
						<?php echo $attributesArray['deliveryAddress']; ?>
					</label>
					<?php echo $form->textField($order, 'deliveryAddress', array('id'=>'deliveryAddress_input')); ?>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">保存更改</button>
		</div>
	<?php $this->endWidget(); ?><!-- form -->
	</section>

	<section id="order_items">
		<div class="modal-header"><h3>订单商品</h3></div>
		<div class="body">
		<?php foreach($order->orderItems as $item): ?>
		<div class="order_item">
			<div class="product_image">
			<a href="<?php echo Yii::app()->createUrl('admin/product/index', array('id'=>$item->product->id)); ?>" target="_blank">
				<img src="<?php echo $item->product->getImageBaseUrl() . '/preview.jpg' ?>" width="50" height="50"></img>
			</a>
			</div>

			<div class="product_name">
			<a href="<?php echo Yii::app()->createUrl('admin/product/index', array('id'=>$item->product->id)); ?>" target="_blank">
			<?php echo $item->product->name; ?>
			</a>
			</div>

			<div class="product_sumPrice">
			<span class="label label-info">￥<?php echo number_format(($item->product->price * $item->count), 2); ?></span>
			</div>

			<div class="product_number">
			<span class="label"><?php echo $item->count ?>件</span>
			</div>

			<span class="multiply">x</span>

			<div class="product_unitPrice">
			<span class="label">￥<?php echo number_format($item->product->price, 2); ?></span>
			</div>

			<span class="clearfix"></span>
		</div>
		<?php endforeach; ?>
		</div>
	</section>
</article>
<?php if(Yii::app()->user->hasFlash('order_update_success')): ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/assets/jquery-notice/jquery.notice.css'); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/jquery-notice/jquery.notice.js"></script>
<script type="text/javascript">
	jQuery.noticeAdd({
		text: '<?php echo Yii::app()->user->getFlash("order_update_success"); ?>',
		stay: false,
		type: 'success',
	});
</script>
<?php endif; ?>