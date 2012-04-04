<?php $this->beginContent('//layouts/main'); ?>
<header class="container">
	<figure id="logo">
		<a id="logo_link" href="<?php echo Yii::app()->getUrlManager()->createUrl("site/index") ?>">买么事</a>
	</figure>
	<section id="search_section">
		<div class="search_bar">
			<form target="_top" name="search" action="<?php echo Yii::app()->getUrlManager()->createUrl("site/search") ?>" method="get" id="search_form">
				<div class="search_text_wrapper">
					<input type="text" id="search_text" name="query" x-webkit-speech x-webkit-grammar="builtin: translate">
				</div>
				<button type="submit" id="search_submit">
				</button>
				<span class="clearfix"></span>
			</form>
		</div>
		<div id="search_hot">
			<span id="search_hotword">
				<a href="#">牛奶</a>
				<a href="#">防辐装</a>
				<a href="#">碘盐</a>
				<a href="#">雪地靴</a>
				<a href="#">电脑</a>
				<a href="#">手机</a>
				<a href="#">内衣</a>
				<a href="#">手表</a>
			</span>
			<a href="#">
				更多>>
			</a>
			<b class="gradient_left"></b>
			<b class="gradient_right"></b>
		</div>					
	</section><!-- search section -->
	<span class="clearfix"></span>
	<nav id="site_nav">
		<div id="site_nav_inner" class="container row-fluid">
		<div id="categories" class="span2 pull-left">
			<div id="categories_inner">
			<a href="#">全部商品分类</a>
			</div>
		</div>
		<ul id="navitems" class="span7 pull-left">
			<li class="<?php echo (((Yii::app()->controller->getId().'/'.Yii::app()->controller->getAction()->getId()) == 'site/index')? 'active' : '' )?>">
				<a href="<?php echo Yii::app()->getUrlManager()->createUrl("site/index") ?>" >首页</a>
			</li>
			<li>
				<a href="#">团购</a>
			</li>
			<li>
				<a href="#">年货专场</a>
			</li>						
			<li class="last">
				<a href="#">品牌直销</a>
			</li>
		</ul>
		<ul id="shopcart" class="pull-right">
			<a class="btn btn-primary" href="#">
				<i class="icon-shopping-cart icon-white"></i>
				去结算
			</a>
		</ul>
		<span class="clearfix"></span>
		</div>
	</nav>
</header>
<?php echo $content; ?>

<script>
	/* *
	 * fix site navbar on scroll 
	 * code from bootstrap docs
	 */
	 var $win = $(window)
	 var $nav = $('#site_nav')
	 var navTop = $('#site_nav').offset().top - 40
	 var isFixed = 0

	 processScroll()

	 $win.on('scroll', processScroll)

	 function processScroll(){
	 	var i, scrollTop = $win.scrollTop()
	 	if(scrollTop >= navTop && !isFixed){
	 		isFixed = 1
	 		$nav.addClass('fixed')
	 	} else if(scrollTop <= navTop && isFixed){
	 		isFixed = 0
	 		$nav.removeClass('fixed')
	 	}
	 }

</script>
<?php $this->endContent(); ?>