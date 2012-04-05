<div class="shopcart_order_item">
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

<div class="product_sumPrice">
<span class="label label-info">￥<?php echo number_format(($data->product->price * $data->count), 2); ?></span>
</div>

<div class="product_number">
<span class="label"><?php echo $data->count ?>件</span>
</div>

<span class="multiply">x</span>

<div class="product_unitPrice">
<span class="label">￥<?php echo number_format($data->product->price, 2); ?></span>
</div>

<span class="clearfix"></span>
</div>