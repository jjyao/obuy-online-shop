<div class="order_item">
<div class="product_image">
<a href="<?php echo Yii::app()->createUrl('product/view', array('id'=>$data->product->id)); ?>" target="_blank">
	<img src="<?php echo $data->product->getImageBaseUrl() . '/preview.jpg' ?>" width="50" height="50"></img>
</a>
</div>

<div class="product_name">
<a href="<?php echo Yii::app()->createUrl('product/view', array('id'=>$data->product->id)); ?>" target="_blank">
<?php echo $data->product->name; ?>
</a>
</div>

<div class="order_evaluation">
<?php if($data->orderRecord->status == OrderRecord::SUBMIT): ?>
	<a class="btn btn-small btn-primary cancel" order_item_id="<?php echo $data->id ?>">
		<i class="icon-remove icon-white"></i>&nbsp;&nbsp;取消&nbsp;&nbsp;
	</a>
<?php elseif($data->orderRecord->status == OrderRecord::PAYMENT): ?>
		<?php if($data->isEvaluated == OrderItem::EVALUATED): ?>
		<a class="btn disabled btn-small btn-primary"><i class="icon-ok icon-white"></i>已评价</a>
		<?php else: ?>
		<a class="btn btn-small btn-primary evaluation" order_item_id="<?php echo $data->id ?>">
			<i class="icon-comment icon-white"></i>&nbsp;&nbsp;评价&nbsp;&nbsp;
		</a>
		<?php endif; ?>
<?php else: ?>
	<a class="btn disabled btn-small btn-primary"><i class="icon-lock icon-white"></i>未付款</a>
<?php endif; ?>
</div>

<div class="order_status">
<?php
	$statusLabels = $data->orderRecord->statusLabels();
?>
<span class="label label-info"><?php echo $statusLabels[$data->orderRecord->status] ?></span>
</div>

<div class="product_sumPrice">
<span class="label label-important">￥<?php echo number_format(($data->unitPrice * $data->count), 2); ?></span>
</div>

<div class="product_number">
<span class="label"><?php echo $data->count ?>件</span>
</div>

<span class="multiply">x</span>

<div class="product_unitPrice">
<span class="label">￥<?php echo number_format($data->unitPrice, 2); ?></span>
</div>

<div class="order_time">
<span class="label"><?php echo $data->orderRecord->time ?>下单</span>
</div>

<div class="order_record">
<span class="label"><?php echo $data->orderRecord->id ?>号订单</label>
</div>

<span class="clearfix"></span>
</div>