<?php $this->pageTitle=Yii::app()->name; 
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/index.less');
?>

<article class="container row-fluid">
<div id="left_column" class= "span2">
	<nav id="category_nav">
		<?php for($i = 1; $i < 10; $i++): ?>
		<div class="category_item">
			<span>
				<h4>
					<a href="#">图书</a>
					、
					<a href="#">音乐</a>
					、
					<a href="#">影视</a>
				</h4>
				<b></b>
			</span>
		</div>
		<?php endfor; ?>
	</nav>
</div><!-- left column -->
<div id="main_area" class= "span10">
	<section class="product_section">
		<div class="product_section_title">
			<h2>全场热销</h2>
			<div class="more_product">
				<a href="#">更多>></a>
			</div>
		</div>			
	</section>
	<section class="product_section">
		<div class="product_section_title">
			<h2>新品上架</h2>
			<div class="more_product">
				<a href="#">更多>></a>
			</div>
		</div>			
	</section>
	<section class="product_section">
		<div class="product_section_title">
			<h2>推荐商品</h2>
			<div class="more_product">
				<a href="#">更多>></a>
			</div>
		</div>			
	</section>
</div><!-- main area -->
</article>