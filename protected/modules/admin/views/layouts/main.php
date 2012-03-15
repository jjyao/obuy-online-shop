<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="language" content="en">

	<!-- bootstrap CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/css/bootstrap.css" />

	<!-- jquery js -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/jquery/jquery-1.7.1.min.js"></script>

	<!-- css and less files -->
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/main.less" />
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<section class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo Yii::app()->getUrlManager()->createUrl("admin/site/index") ?>">管理员面板</a>
				<ul class="nav pull-right">
					<li><a href="<?php echo Yii::app()->getUrlManager()->createUrl("site/logout") ?>">退出</a></li>
				</ul>
			</div>
		</div>
	</section>
	<div id="main_area_container" class="container row-fluid">
		<div class="span3">
			<section id="admin_nav" class="well">
				<ul class="nav nav-list">
					<li class="nav-header">
						商品管理
					</li>
					<li>
						<a href="<?php echo Yii::app()->getUrlManager()->createUrl("admin/product/create") ?>">新建商品</a>
					</li>
					<li class="nav-header">
						分类管理
					</li>
					<li>
						<a href="<?php echo Yii::app()->getUrlManager()->createUrl("admin/category/index") ?>">修改分类</a>
					</li>
				</ul>
			</section>
		</div>
		<div class="span9">
			<?php echo $content; ?>
		</div>
	</div>
<!-- less js -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/less/less-1.2.2.min.js"></script>
</body>
</html>