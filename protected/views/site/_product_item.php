<div class="product_item <?php echo ($index < 4) ? 'first' : '' ?>">
	<div class="product_img">
		<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$data->id)) ?>" target="_blank">
			<img src="<?php  echo ($data->getImageBaseUrl() . '/preview.jpg')?>" width="100" height="100">
		</a>
	</div>
	<div class="product_name">
		<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$data->id)) ?>" target="_blank">
			<?php echo $data->name ?>
		</a>
	</div>
	<div class="product_price">
		价格：<strong>￥<?php echo $data->price ?></strong>
	</div>
</div>