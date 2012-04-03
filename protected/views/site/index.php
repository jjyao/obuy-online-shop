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
			<div class="product_section_title_end">
			</div>
		</div><!-- product_section_title -->
		<ul class="product_list">
			<?php for($i = 0; $i < 4; $i++): ?>
			<li class="first">
				<div class="product_img">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$hotestProducts[$i]->id)) ?>" target="_blank">
						<img src="<?php  echo ($hotestProducts[$i]->getImageBaseUrl() . '/preview.jpg')?>" width="100" height="100">
					</a>
				</div>
				<div class="product_name">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$hotestProducts[$i]->id)) ?>" target="_blank">
						<?php echo $hotestProducts[$i]->name ?>
					</a>
				</div>
				<div class="product_price">
					价格：<strong>￥<?php echo $hotestProducts[$i]->price ?></strong>
				</div>
			</li>
			<?php endfor; ?>
			<?php for($i = 4; $i < count($hotestProducts); $i++): ?>
			<li>
				<div class="product_img">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$hotestProducts[$i]->id)) ?>" target="_blank">
						<img src="<?php  echo ($hotestProducts[$i]->getImageBaseUrl() . '/preview.jpg')?>" width="100" height="100">
					</a>
				</div>
				<div class="product_name">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$hotestProducts[$i]->id)) ?>" target="_blank">
						<?php echo $hotestProducts[$i]->name ?>
					</a>
				</div>
				<div class="product_price">
					价格：<strong>￥<?php echo $hotestProducts[$i]->price ?></strong>
				</div>
			</li>
			<?php endfor; ?>
			<span class="clearfix"></span>
		<ul>
		<span class="clearfix"></span>			
	</section>
	<section class="product_section">
		<div class="product_section_title">
			<h2>新品上架</h2>
			<div class="product_section_title_end">
			</div>			
		</div><!-- product_section_title -->
		<ul class="product_list">
			<?php for($i = 0; $i < 4; $i++): ?>
			<li class="first">
				<div class="product_img">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$newestProducts[$i]->id)) ?>" target="_blank">
						<img src="<?php  echo ($newestProducts[$i]->getImageBaseUrl() . '/preview.jpg')?>" width="100" height="100">
					</a>
				</div>
				<div class="product_name">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$newestProducts[$i]->id)) ?>" target="_blank">
						<?php echo $newestProducts[$i]->name ?>
					</a>
				</div>
				<div class="product_price">
					价格：<strong>￥<?php echo $newestProducts[$i]->price ?></strong>
				</div>
			</li>
			<?php endfor; ?>
			<?php for($i = 4; $i < count($newestProducts); $i++): ?>
			<li>
				<div class="product_img">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$newestProducts[$i]->id)) ?>" target="_blank">
						<img src="<?php  echo ($newestProducts[$i]->getImageBaseUrl() . '/preview.jpg')?>" width="100" height="100">
					</a>
				</div>
				<div class="product_name">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$newestProducts[$i]->id)) ?>" target="_blank">
						<?php echo $newestProducts[$i]->name ?>
					</a>
				</div>
				<div class="product_price">
					价格：<strong>￥<?php echo $newestProducts[$i]->price ?></strong>
				</div>
			</li>
			<?php endfor; ?>
			<span class="clearfix"></span>
		</ul>
		<span class="clearfix"></span>			
	</section>
	<section class="product_section">
		<div class="product_section_title">
			<h2>推荐商品</h2>
			<div class="product_section_title_end">
			</div>
		</div><!-- product_section_title -->	
		<ul class="product_list">
			<?php for($i = 0; $i < 4; $i++): ?>
			<li class="first">
				<div class="product_img">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$recommendedProducts[$i]->id)) ?>" target="_blank">
						<img src="<?php  echo ($recommendedProducts[$i]->getImageBaseUrl() . '/preview.jpg')?>" width="100" height="100">
					</a>
				</div>
				<div class="product_name">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$recommendedProducts[$i]->id)) ?>" target="_blank">
						<?php echo $recommendedProducts[$i]->name ?>
					</a>
				</div>
				<div class="product_price">
					价格：<strong>￥<?php echo $recommendedProducts[$i]->price ?></strong>
				</div>
			</li>
			<?php endfor; ?>
			<?php for($i = 4; $i < count($recommendedProducts); $i++): ?>
			<li>
				<div class="product_img">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$recommendedProducts[$i]->id)) ?>" target="_blank">
						<img src="<?php  echo ($recommendedProducts[$i]->getImageBaseUrl() . '/preview.jpg')?>" width="100" height="100">
					</a>
				</div>
				<div class="product_name">
					<a href="<?php echo Yii::app()->createUrl("product/view", array('id'=>$recommendedProducts[$i]->id)) ?>" target="_blank">
						<?php echo $recommendedProducts[$i]->name ?>
					</a>
				</div>
				<div class="product_price">
					价格：<strong>￥<?php echo $recommendedProducts[$i]->price ?></strong>
				</div>
			</li>
			<?php endfor; ?>
			<span class="clearfix"></span>
		<ul>
		<span class="clearfix"></span>		
	</section>
</div><!-- main area -->
</article>