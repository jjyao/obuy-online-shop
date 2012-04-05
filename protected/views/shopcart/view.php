<?php 
$this->pageTitle=Yii::app()->name . ' - 购物车';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/shopcart.less');
?>
<article class="container">
<section id="shopcart_header">
	<ul class="order_process">
		<li id="step1" class="active">1. 我的购物车</li>
		<li id="step2">2. 结算中心确认订单</li>
		<li id="step3">3. 成功提交订单</li>
	</ul>
</section>
<section id="my_shopcart">
	<div id="my_shopcart_header">
		<span>我挑选的商品</span>
	</div>
	<div id="my_shopcart_content">
		<?php if($dataProvider->totalItemCount > 0): ?>

			<?php
				$this->widget('zii.widgets.CListView', array(
					'id'=>'shopcart_item_list',
					'dataProvider'=>$dataProvider,
					'itemView'=>'_shopcart_item',
					'template'=>'{items}',
				));
			?>

			
			<div id="clean_shopcart">
				<a href="<?php echo Yii::app()->createUrl('shopcart/empty'); ?>">清空购物车</a>
			</div>
			

			<div id="money_summary">
				<?php
					// calculate total money
					$sum = 0;
					foreach($dataProvider->data as $shopcartItem)
					{
						$sum = $sum + $shopcartItem->product->price * $shopcartItem->count;
					}
				?>
				总计：<span class="label label-important">￥<?php echo number_format($sum, 2) ?></span>
			</div>
			<span class="clearfix"></span>
			<div id="shopcart_action">
				<a id="go_next" class="btn btn-primary btn-middle"><i class="icon-share-alt icon-white"></i>去结算</a>
			</div>
			<span class="clearfix"></span>

		<?php else: ?>
			<div id="shopcart_empty_hint">
				<a href="<?php echo Yii::app()->createUrl('site/index'); ?>" >您的购物车为空，快去选购喜欢的商品吧!</a>
			</div>
		<?php endif; ?>
	</div>
</section>
</article>
<script type="text/javascript">
	$('.product_number input').change(function(){
		var productUnitPrice = $(this).parent().siblings('.product_unitPrice').children();
		var productSumPrice = $(this).parent().siblings('.product_sumPrice').children();
		var moneySummary = $('#money_summary').children();
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("shopcart/modify") ?>',
			type: 'post',
			dataType: 'json',
			data: {
				shopcartItemId: $(this).attr('shopcart_item_id'),
				productNumber: $(this).val(),
			},
			success: function(result){
				productSumPrice.text('￥' + result.productSumPrice);
				productUnitPrice.text('￥' + result.productUnitPrice);
				moneySummary.text('￥' + result.moneySummary);
			},
			error: function(request, status, error){
				alert(status + ": " + error);
			},
		});
	});
</script>