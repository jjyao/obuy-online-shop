<?php 
$this->pageTitle=Yii::app()->name . ' - 成功下单';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/shopcart.less');
?>
<article class="container">
<section id="shopcart_header">
	<ul class="order_process step3">
		<li id="step1">1. 我的购物车</li>
		<li id="step2">2. 结算中心确认订单</li>
		<li id="step3" class="active">3. 成功提交订单</li>
	</ul>
</section>
	<div id="purchase_success_hint">
		您已经成功下单，您可以现在
		<a href="<?php echo Yii::app()->createUrl('order/view') ?>">查看订单</a>
		或者<a href="<?php echo Yii::app()->createUrl('site/index') ?>">继续购物</a>
	</div>
</article>