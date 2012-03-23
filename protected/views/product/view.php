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
				rel="adjustX: 10, adjustY: -4" id="preview_iamge">
				<img src="<?php echo Yii::app()->request->baseUrl?>/protected/data/product_image/2/1_small.jpg" title="">
			</a>
		</div><!-- image preview box -->
		<div id="product_thumbs">
			<ul>
				<li>
					<a href="/protected/data/product_image/2/1_large.jpg" class="cloud-zoom-gallery"
						rel="useZoom: 'preview_iamge', smallImage: '/protected/data/product_image/2/1_small.jpg ">
						<img src="/protected/data/product_image/2/1_tiny.jpg " />
					</a>
				</li>
				<li>
					<a href="/protected/data/product_image/2/1_large.jpg" class="cloud-zoom-gallery"
						rel="useZoom: 'preview_iamge', smallImage: '/protected/data/product_image/2/1_small.jpg ">
						<img src="/protected/data/product_image/2/1_tiny.jpg " />
					</a>
				</li>
			</ul>
		</div><!-- product thumbs -->
	</section>
	<section id="product_brief_section">
		<h3>格兰仕洗衣机</h3>
	</section><!-- product_brief_section -->
	<span class="clearfix" />
</section>

</article>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/cloud-zoom/cloud-zoom.1.0.2.js"></script>
<script type='text/javascript'>
</script>