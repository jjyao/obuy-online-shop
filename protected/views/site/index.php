<?php $this->pageTitle=Yii::app()->name; 
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/index.less');
?>

<article class="container row-fluid">
<section id="header_section">
<nav id="category_nav">
	<div id="category_nav_header">商品分类</div>
	<ul id="category_menu">
		<?php 
			$topLevelCategories = Category::model()->findAllByAttributes(array('parentCategoryId'=>null));
			foreach($topLevelCategories as $category)
			{
				echo $category->getMenuRepresent();
			}
		?>
	</ul>
</nav>
<div id="product_slide" class="carousel slide">
	<div class="carousel-inner">
		<div class="active item">
			<img src="<?php echo Yii::app()->baseUrl?>/images/product_slide_1.jpg">
		</div>
		<div class="item">
			<img src="<?php echo Yii::app()->baseUrl?>/images/product_slide_2.jpg">
		</div>
		<div class="item">
			<img src="<?php echo Yii::app()->baseUrl?>/images/product_slide_3.jpg">
		</div>
	</div>
	<a class="left carousel-control" href="#product_slide" data-slide="prev">&lsaquo;</a>
	<a class="right carousel-control" href="#product_slide" data-slide="next">&rsaquo;</a>
</div>
<div id="shop_announcement">
	<div id="shop_announcement_header">商店公告<i class="icon-volume-up icon-white"></i></div>
	<div class="autoScroller-container">
	<ul id="shop_announcement_list">
		<?php $announcements = Announcement::model()->published()->findAll(array('order'=>'time DESC')); ?>
		<?php foreach($announcements as $announcement): ?>
		<li><a href="#"><?php echo $announcement->title ?></a></li>
		<?php endforeach; ?>
	</ul>
	</div>
</div>
<span class="clearfix"></span>
</section>
<div id="main_area">
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
<script type="text/javascript" >
$(document).ready(function(){
	var ultags=document.getElementById('category_menu').getElementsByTagName("ul")
    for (var t=0; t<ultags.length; t++){
    	ultags[t].parentNode.getElementsByTagName("a")[0].className+=" subfolderstyle"
  		if (ultags[t].parentNode.parentNode.id=='category_menu'){ //if this is a first level submenu
   			ultags[t].style.left=ultags[t].parentNode.offsetWidth + "px" //dynamically position first level submenus to be width of main menu item
  		}
  		else{ //else if this is a sub level submenu (ul)
	    	ultags[t].style.left=ultags[t-1].getElementsByTagName("a")[0].offsetWidth+"px" //position menu to the right of menu item that activated it
	    }
	    ultags[t].parentNode.onmouseover=function(){
	    	this.getElementsByTagName("ul")[0].style.display="block"
    	}
    	ultags[t].parentNode.onmouseout=function(){
   			this.getElementsByTagName("ul")[0].style.display="none"
   		}
    }
  	for (var t=ultags.length-1; t>-1; t--){ //loop through all sub menus again, and use "display:none" to hide menus (to prevent possible page scrollbars
  		ultags[t].style.visibility="visible"
  		ultags[t].style.display="none"
  	}
});
</script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-transition.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-carousel.js"></script>
<script type='text/javascript'>
	$('#product_slide').carousel();
</script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/autoScroller/jquery.timers.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/autoScroller/jquery.autoScroller.js"></script>
<script type="text/javascript" >
	$(window).ready(function(){
		autoScroller('shop_announcement_list', 1);
	});
</script>