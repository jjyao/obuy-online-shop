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
<?php if($data->status == OrderItem::EVALUATION): ?>
	<a class="btn disabled btn-small btn-primary"><i class="icon-ok icon-white"></i>已评价</a>
<?php elseif($data->status == OrderItem::PAYMENT): ?>
	<a class="btn btn-small btn-primary clickable" order_item_id="<?php echo $data->id ?>">
		<i class="icon-comment icon-white"></i>未评价
	</a>
<?php else: ?>
	<a class="btn disabled btn-small btn-primary"><i class="icon-lock icon-white"></i>未付款</a>
<?php endif; ?>
</div>

<div class="order_status">
<?php
	$statusLabels = $data->statusLabels();
?>
<span class="label label-info"><?php echo $statusLabels[$data->status] ?></span>
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
<span class="label"><?php echo $data->time ?>下单</span>
</div>

<span class="clearfix"></span>
</div>