<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="language" content="en">
	<meta name="description" content="买么事-专业的网上购物商城，繁多的商品，良好的服务，为您提供愉悦的网上商城购物体验!">
	<meta name="Keywords" content="网上购物,网上商城,手机,笔记本,电脑,MP3,CD,VCD,DV,相机,数码,配件,手表,存储卡,图书">

	<!-- bootstrap CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/css/bootstrap.css" />

	<!-- jquery js -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/jquery/jquery-1.7.1.min.js"></script>

	<!-- css and less files -->
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.less" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/header.less" />
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div id="container_without_footer">
		<nav id="my_nav_wrapper">
			<div id="my_nav" class="container">
				<p id="login_info" class="pull-left">
					亲，买么事啦！
					<?php if (Yii::app()->user->isGuest): ?>
					<span>
						<a href="<?php echo Yii::app()->getUrlManager()->createUrl("site/login") ?>">[请登录]</a>
						, 新用户？
						<a href="<?php echo Yii::app()->getUrlManager()->createUrl("site/register") ?>">[免费注册]</a>
					</span>
					<?php else: ?>
					<span>
						<a href="#"><?php echo Yii::app()->user->name; ?></a>
						<a href="<?php echo Yii::app()->getUrlManager()->createUrl("site/logout") ?>">[退出]</a>
					</span>
					<?php endif; ?>
				</p>
				<ul id="my_menu" class="pull-right">
					<li class="last dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							会员服务
							<b class="caret"></b>
						</a>	
						<ul id="client_service_dropdown" class="dropdown-menu">
							<li><a href="#">个人信息修改</a></li>
							<li><a href="<?php echo '#' ?>">注销</a></li>
							<li><a href="<?php echo Yii::app()->createUrl('site/login') ?>">登录</a></li>
							<li><a href="<?php echo Yii::app()->createUrl('site/register') ?>">注册</a></li>
							<li><a href="<?php echo Yii::app()->createUrl('site/logout') ?>">退出</a></li>								
						</ul>				
					</li>					
					<li>
						<a href="<?php echo Yii::app()->createUrl('order/view') ?>">我的订单</a>
					</li>
					<li>
						<a href="<?php echo Yii::app()->createUrl('shopcart/view') ?>">我的购物车</a>
					</li>					
				</ul>
				<span class="clearfix"></span>			
			</div><!-- my_nav -->
		</nav>

		<?php echo $content; ?>
		<div class="clearfooter"></div>
	</div>
	
	<footer>
		<div id="flinks">
			<a href="#">关于我们</a>
			|
			<a href="#">联系我们</a>
			|
			<a href="#">论坛</a>
		</div>
		<div id="copyright_declar">
			<p>南京市公安局鼓楼分局备案编号：000000000000 宁ICP证101010号</p>
			<p>Copyright &copy;2012 买么事 版权所有</p>
		</div>
	</footer>

	<div id="back_to_top" onclick="window.scrollTo(0, 0); return false;">
	</div>
	<script>
		/**
		 * control the appearence and disappearance of #back_to_top
		 */
		var $win = $(window)
		var $back_to_top = $('#back_to_top')
		var isShow = 0

		$win.on('scroll', function(e){
			var scrollTop = $win.scrollTop()
			if(scrollTop > 40 && !isShow){
				isShow = 1
				$back_to_top.show()
			}else if(scrollTop <= 40 && isShow){
				isShow = 0
				$back_to_top.hide()
			}

		})
	</script>
	<!-- less js -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/less/less-1.2.2.min.js"></script>
	<!-- bootstrap js-->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-dropdown.js"></script>
</body>
</html>
