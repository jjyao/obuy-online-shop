<?php 
$this->pageTitle=Yii::app()->name . ' - 确认订单';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/shopcart.less');
?>
<article class="container">
<section id="shopcart_header">
	<ul class="order_process step2">
		<li id="step1">1. 我的购物车</li>
		<li id="step2" class="active">2. 结算中心确认订单</li>
		<li id="step3">3. 成功提交订单</li>
	</ul>
</section>
<section id="my_shopcart_order">
	<div id="my_shopcart_order_header">
		<span>检查订单</span>
	</div>
	<div id="my_shopcart_order_content">
		<div class="wrapper">
			<div id="my_shopcart_order_summary">
				<div id="my_shopcart_order_summary_header">
					<span>订单信息</span>
				</div>
				<div id="delivery_address">
					<?php
						// get the default delivery address
						$client = Client::model()->findByPk(Yii::app()->user->id);
						$address = $client->deliveryAddresses[0]; // first address is default
					?>
					<span>送货地址：</span>
					<?php echo $address->city->name ?>市 <?php echo $address->address ?>
				</div>
				<div id="payment_way">
					<span>付款方式：</span>
					货到付款
				</div>
				<div id="order_money">
					<?php
						// calculate total money
						$sum = 0;
						foreach($dataProvider->data as $shopcartItem)
						{
							$sum = $sum + $shopcartItem->product->price * $shopcartItem->count;
						}
					?>
					<span>总计金额：</span>
					<span class="label label-important">￥<?php echo number_format($sum, 2) ?></span>
				</div>
			</div>
			<div id="my_shopcart_order_action">	
				<a id="modify_shopcart" class="btn btn-middle btn-warning" href="<?php echo Yii::app()->createUrl('shopcart/view') ?>">
					<i class="icon-arrow-left icon-white"></i>回购物车修改
				</a>
				<a id="confirm_order" class="btn btn-middle btn-primary" href="<?php echo Yii::app()->createUrl('shopcart/purchase', array('address'=>$address->id)) ?>">
					下单<i class="icon-arrow-right icon-white"></i>
				</a>
				<span class="clearfix"></span>
			</div>
			<span class="clearfix"></span>
		</div>
		
		<div class="wrapper">
		<div id="my_shopcart_product_summary">
			<div id="my_shopcart_product_summary_header">
					<span>选购商品信息</span>
			</div>
			<?php
				$this->widget('zii.widgets.CListView', array(
					'id'=>'shopcart_order_item_list',
					'dataProvider'=>$dataProvider,
					'itemView'=>'_shopcart_order_item',
					'template'=>'{items}',
				));
			?>
		</div>
	</div>
</div>
	
</section>
</article>