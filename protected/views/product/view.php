<?php
$this->pageTitle=Yii::app()->name . ' - 商品';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/cloud-zoom/cloud-zoom.css');
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/product.less');
?>
<article class="container">
<section>
	<section id="image_section">
		<div id="image_preview_box" class="ad-image-wrapper">
			<a class="cloud-zoom" href="<?php echo Yii::app()->request->baseUrl?>/protected/data/product_image/2/1_large.jpg" 
				rel="adjustX: 10, adjustY: -4" id="preview_image">
				<img src="<?php echo Yii::app()->request->baseUrl?>/protected/data/product_image/2/1_small.jpg" title="">
			</a>
		</div><!-- image preview box -->
		<div id="product_thumbs">
			<ul>
				<li>
					<a href="/protected/data/product_image/2/1_large.jpg" class="cloud-zoom-gallery"
						rel="useZoom: 'preview_image', smallImage: '/protected/data/product_image/2/1_small.jpg' ">
						<img src="/protected/data/product_image/2/1_tiny.jpg " />
					</a>
				</li>
				<li>
					<a href="/protected/data/product_image/2/1_large.jpg" class="cloud-zoom-gallery"
						rel="useZoom: 'preview_image', smallImage: '/protected/data/product_image/2/1_small.jpg' ">
						<img src="/protected/data/product_image/2/1_tiny.jpg " />
					</a>
				</li>
			</ul>
		</div><!-- product thumbs -->
	</section>
	<section id="product_brief_section">
		<ul>
			<li>
				<h3>格兰仕洗衣机</h3>
			</li>
			<li>
				<div id="product_id">
					商品编号: 
					<span>
						1020
					</span>
				</div>
			</li>
			<li>
				<div id="product_price">
					商品价格: 
					<span>1020</span>
				</div>
			</li>
			<li>
				<div id="product_score">
					<span class="pull-left">商品评分: </span>
					<div class="star star4 pull-left"></div>
					<a href="#comments">(已有2人评价)</a>
				</div>
			</li>
		</ul>
	</section><!-- product_brief_section -->
	<section id="product_action_section">
		<a id="add_cart" class="btn btn-primary btn-large" href="#">
			<i></i>
			加入购物车
		</a>
		<a id="quick_buy" class="btn btn-info btn-large" href="#">
			<i></i>
			一键购买
		</a>
	</section><!-- product_brief_section -->
	<span class="clearfix" />
	<section id="product_detail_section">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#product_description" data-toggle="tab">产品描述</a>
				</li>
				<li>
					<a href="#product_how_to_use" data-toggle="tab">使用说明</a>
				</li>
				<li>
					<a href="#product_additional_spec" data-toggle="tab">附加说明</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="product_description">
					safasfd
				</div>
				<div class="tab-pane" id="product_how_to_use">
					tab2
				</div>
				<div class="tab-pane" id="product_additional_spec">
					tab3
				</div> 
			</div>
		</div>
	</section>
</section>

</article>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-tab.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/cloud-zoom/cloud-zoom.1.0.2.js"></script>
<script type='text/javascript'>
</script>