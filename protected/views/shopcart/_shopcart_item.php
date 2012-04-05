<div class="shopcart_item">
<div class="product_image">
<a href="<?php echo Yii::app()->createUrl('product/view', array('id'=>$data->product->id)); ?>" target="_blank">
	<img src="<?php echo $data->product->getImageBaseUrl() . '/preview.jpg' ?>" width="100" height="100"></img>
</a>
</div>
<div class="product_name">
<a href="<?php echo Yii::app()->createUrl('product/view', array('id'=>$data->product->id)); ?>" target="_blank">
<?php echo $data->product->name; ?>
</a>
</div>

<a href="<?php echo Yii::app()->createUrl('shopcart/delete', array('id'=>$data->id))?>" class="shopcart_item_remove">
删除
</a>

<div class="product_sumPrice">
<span class="label label-info">￥<?php echo number_format(($data->product->price * $data->count), 2); ?></span>
</div>

<div class="product_number">
<input type="number" min="1" value="<?php echo $data->count ?>" shopcart_item_id="<?php echo $data->id ?>" />
件
</div>

<span class="multiply">x</span>

<div class="product_unitPrice">
<span class="label">￥<?php echo number_format($data->product->price, 2); ?></span>
</div>

<span class="clearfix"></span>
</div>