<?php
$this->pageTitle=Yii::app()->name . ' - 商品';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/cloud-zoom/cloud-zoom.css');
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/product.less');
?>
<article class="container">
<nav class="breadcrumbs">
<ul>
	<li class="first">
	<a href="" style="z-index: 9;">
		<span class="left_yarn" style="z-index: 11;"></span>
		首页
	</a>
	</li>
	<li>
	<a href="" style="z-index: 8;">首页</a>
	</li>
</ul>
</nav>
<section>
	<section id="image_section">
		<?php
			// prepare preview images
			$images = $product->getImageTriples();
			$imageBaseUrl = $product->getImageBaseUrl();
		?>
		<div id="image_preview_box" class="ad-image-wrapper">
			<a class="cloud-zoom" href="<?php echo $imageBaseUrl . '/' . $images[0]['large']?>" 
				rel="adjustX: 10, adjustY: -4" id="preview_image">
				<img src="<?php echo $imageBaseUrl . '/' . $images[0]['small'] ?>" title="">
			</a>
		</div><!-- image preview box -->
		<div id="product_thumbs">
			<ul>
				<?php foreach($images as $image): ?>
				<li>
					<a href="<?php echo  $imageBaseUrl . '/' . $image['large'] ?>" class="cloud-zoom-gallery"
						rel="useZoom: 'preview_image', smallImage: '<?php echo  $imageBaseUrl . '/' . $image['small'] ?>' ">
						<img src="<?php echo  $imageBaseUrl . '/' . $image['tiny'] ?>" />
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div><!-- product thumbs -->
	</section><!-- image section -->
	<section id="product_brief_section">
		<ul>
			<li>
				<h3><?php echo $product->name ?></h3>
			</li>
			<li>
				<div id="product_id">
					商品编号: 
					<span>
						<?php echo $product->id ?>
					</span>
				</div>
			</li>
			<li>
				<div id="product_price">
					商品价格: 
					<span><?php echo $product->price ?></span>
				</div>
			</li>
			<li class="last">
				<div id="product_score">
					<?php
						// compute the average score of the product
						$score = 0;
						$product_num = count($product->evaluations);
						foreach($product->evaluations as $evaluation)
						{
							$score += $evaluation->score;
						}
						if($product_num != 0)
						{
							$score = round($score / $product_num);
						}
					?>
					<span class="pull-left">商品评分: </span>
					<div class="star star<?php echo $score ?> pull-left"></div>
					<a href="#comments">(已有<?php echo count($product->evaluations) ?>人评价)</a>
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
		<div id="social_share" class="bshare-custom icon-medium"><a title="分享到新浪微博" class="bshare-sinaminiblog" href="javascript:void(0);"></a><a title="分享到人人网" class="bshare-renren" href="javascript:void(0);"></a><a title="分享到腾讯微博" class="bshare-qqmb" href="javascript:void(0);"></a><a title="分享到花瓣" class="bshare-huaban" href="javascript:void(0);"></a><a title="分享到豆瓣" class="bshare-douban" href="javascript:void(0);"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span class="BSHARE_COUNT bshare-share-count" style="font-size: 11px; top: 0px; left: 0px; color: rgb(51, 51, 51); float: none; ">2.93K</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
	</section><!-- product_action_section -->
	<span class="clearfix" />
</section>
<section id="product_detail_section">
	<div class="tabbable">
		<?php
			$showDesc = ($product->description != null && $product->description != '');
			$showHowToUse = ($product->howToUse != null && $product->howToUse != '');
			$showAdditionalSpec = ($product->additionalSpec != null && $product->additionalSpec != '');
		?>
		<ul class="nav nav-tabs">
			<?php if ($showDesc): ?>
			<li class="active">
				<a href="#product_description" data-toggle="tab">产品描述</a>
			</li>
			<?php endif; ?>
			<?php if ($showHowToUse) : ?>
			<li>
				<a href="#product_how_to_use" data-toggle="tab">使用说明</a>
			</li>
			<?php endif; ?>
			<?php if ($showAdditionalSpec): ?>
			<li>
				<a href="#product_additional_spec" data-toggle="tab">附加说明</a>
			</li>
			<?php endif; ?>
		</ul>
		<div class="tab-content">
			<?php if ($showDesc): ?>
			<div class="tab-pane active" id="product_description">
				<?php echo $product->description; ?>
			</div>
			<?php endif; ?>
			<?php if ($showHowToUse) : ?>
			<div class="tab-pane" id="product_how_to_use">
				<?php echo $product->howToUse; ?>
			</div>
			<?php endif; ?>
			<?php if ($showAdditionalSpec): ?>
			<div class="tab-pane" id="product_additional_spec">
				<?php echo $product->additionalSpec; ?>
			</div> 
			<?php endif; ?>
		</div>
	</div>
</section><!-- product_detail_section -->
<section id="product_evaluation_section">
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#product_comments" data-toggle="tab">全部评论(<?php echo count($product->evaluations) ?>)</a>
			</li>
			<li>
				<?php
					// get good comments number
					$good_comment_num = Evaluation::model()->count('productId = :productId AND (score = 5 || score = 4)', 
															  array(
															  	'productId' => $product->id,
															  	));
				?>
				<a href="#product_good_comments" data-toggle="tab">好评(<?php echo $good_comment_num ?>)</a>
			</li>
			<li>
				<?php
					// get medium comments number
					$medium_comment_num = Evaluation::model()->count('productId = :productId AND (score = 3)',
																array(
																	'productId' => $product->id,
																));
				?>
				<a href="#product_medium_comments" data-toggle="tab">中评(<?php echo $medium_comment_num ?>)</a>
			</li>
			<li>
				<?php
					// get bad comments number
					$bad_comment_num = Evaluation::model()->count('productId = :productId AND (score = 2 || score = 1)',
																array(
																	'productId' => $product->id,
																));
				?>
				<a href="#product_bad_comments" data-toggle="tab">差评(<?php echo $bad_comment_num ?>)</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="product_comments">
				<?php if(count($product->evaluations) > 0): ?>
					<?php
						$criteria = new CDbCriteria;
						$criteria->compare('productId', $product->id, false);				
						$dataProvider = new CActiveDataProvider('Evaluation', array(
							'criteria'=>$criteria,
							'sort'=>array(
								'defaultOrder'=>'time DESC',
							),
							'pagination'=>array(
								'pageSize'=>10,
							),
						));

						$this->widget('zii.widgets.CListView', array(
							'dataProvider'=>$dataProvider,
							'itemView'=>'_comment_item',
							'template'=>"{items}\n{pager}",
						));
					?>
				<?php else: ?>
					<div class="no_comment_hint">暂无评论</div>
				<?php endif; ?>
			</div>

			<div class="tab-pane" id="product_good_comments">
				<?php if ($good_comment_num > 0): ?>
					<?php
						$criteria = new CDbCriteria;
						$criteria->compare('productId', $product->id, false);
						$criteria->addCondition("score = 5 || score = 4");				
						$dataProvider = new CActiveDataProvider('Evaluation', array(
							'criteria'=>$criteria,
							'sort'=>array(
								'defaultOrder'=>'time DESC',
							),
							'pagination'=>array(
								'pageSize'=>10,
							),
						));

						$this->widget('zii.widgets.CListView', array(
							'dataProvider'=>$dataProvider,
							'itemView'=>'_comment_item',
							'template'=>"{items}\n{pager}",
						));
					?>
				<?php else: ?>
					<div class="no_comment_hint">暂无好评</div>
				<?php endif; ?>
			</div>
			<div class="tab-pane" id="product_medium_comments">
				<?php if ($medium_comment_num > 0): ?>
					<?php
						$criteria = new CDbCriteria;
						$criteria->compare('productId', $product->id, false);
						$criteria->addCondition("score = 3");				
						$dataProvider = new CActiveDataProvider('Evaluation', array(
							'criteria'=>$criteria,
							'sort'=>array(
								'defaultOrder'=>'time DESC',
							),
							'pagination'=>array(
								'pageSize'=>10,
							),
						));

						$this->widget('zii.widgets.CListView', array(
							'dataProvider'=>$dataProvider,
							'itemView'=>'_comment_item',
							'template'=>"{items}\n{pager}",
						));
					?>
				<?php else: ?>
					<div class="no_comment_hint">暂无中评</div>
				<?php endif; ?>
			</div>
			<div class="tab-pane" id="product_bad_comments">
				<?php if ($bad_comment_num > 0): ?>
					<?php
						$criteria = new CDbCriteria;
						$criteria->compare('productId', $product->id, false);
						$criteria->addCondition("score = 1 || score = 2");				
						$dataProvider = new CActiveDataProvider('Evaluation', array(
							'criteria'=>$criteria,
							'sort'=>array(
								'defaultOrder'=>'time DESC',
							),
							'pagination'=>array(
								'pageSize'=>10,
							),
						));

						$this->widget('zii.widgets.CListView', array(
							'dataProvider'=>$dataProvider,
							'itemView'=>'_comment_item',
							'template'=>"{items}\n{pager}",
						));
					?>
				<?php else: ?>
					<div class="no_comment_hint">暂无差评</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section><!-- product_evaluation_section -->
</article>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-tab.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/cloud-zoom/cloud-zoom.1.0.2.js"></script>
<script type='text/javascript'>
</script>