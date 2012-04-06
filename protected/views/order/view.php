<?php 
$this->pageTitle=Yii::app()->name . ' - 我的订单';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/order.less');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/star-rating/jquery.rating.css');
?>
<article class="container">
<section id="my_order">
	<div id="my_order_header">
		<span>我的订单</span>
	</div>
	<div id="my_order_content">
		<?php $this->widget('zii.widgets.CListView', array(
			'id'=>'my_order_list_view',
			'dataProvider'=>$dataProvider,
			'itemView'=>'_order_item',
			'sortableAttributes'=>array(
				'status',
				'time',
				'unitPrice',
				'count',
			),
			'pager'=>array(
				'header'=>'',
			),
			));
		?>
	</div>
</section>

<section class="modal fade" id="order_evaluation_modal">
	<section class="modal-header">
		<a class="close" data-dismiss="modal">x</a>
		<h3>商品评价</h3>
	</section>
	<section class="modal-body">
		<div id="evaluation_product_name">
			<span class="label_name">商品名称：</span>
			<span id="name_display"></span>
			<span class="clearfix"></span>
		</div>
		<div id="evaluation_product_score">
			<span class="label_name">商品评分：</span>
			<input name="socre" type="radio" class="star required" value="1" title="很差"></input>
			<input name="socre" type="radio" class="star" value="2" title="差"></input>
			<input name="socre" type="radio" class="star" value="3" title="一般" checked="checked"></input>
			<input name="socre" type="radio" class="star" value="4" title="好"></input>
			<input name="socre" type="radio" class="star" value="5" title="很好"></input>
			<span class="clearfix"></span>
		</div>
		<div id="evaluation_product_comment">
			<span class="label_name">商品评论：</span>
			<textarea id="comment_input"></textarea>
			<span class="clearfix"></span>
		</div>
	</section><!-- modal-body -->
	<section class="modal-footer">
		<a href="#" id="modal_close" class="btn">关闭</a>
		<a href="#" id="submit_order_evaluation" class="btn btn-primary">保存并关闭</a>
	</section><!-- modal-footer -->
</section><!-- modal -->
</article>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-modal.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-transition.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/star-rating/jquery.rating.pack.js"></script>
<script type="text/javascript">
	var orderItemId;
	var selectButton;
	$('.order_evaluation a.evaluation').on('click', function(e){
		orderItemId = $(this).attr('order_item_id');
		selectButton = $(this);
		var productName = $(this).parent().siblings('.product_name').children().text();
		$('#name_display').text(productName);
		$('#evaluation_product_score input.star').rating('select', 2);
		$('#comment_input').val('');
		$('#order_evaluation_modal').modal('show');
	});

	$('#modal_close').on('click', function(e){
		$('#order_evaluation_modal').modal('hide');
	});

	$('#submit_order_evaluation').on('click', function(e){
		var stars = $('#evaluation_product_score .star-rating-control .star-rating-on');
		var productScore = $(stars[stars.length - 1]).children().text();
		var productComment = $('#comment_input').val();
		if(productComment == ''){
			alert('评论不能为空');
		}
		else{
			$.ajax({
				url: '<?php echo Yii::app()->createUrl("order/evaluate") ?>',
				type: 'post',
				dataType: 'json',
				data: {
					orderItemId: orderItemId,
					productScore: productScore,
					productComment: productComment,
				},
				success: function(result){
					$.fn.yiiListView.update('my_order_list_view');
					/*selectButton.removeClass('clickable');
					selectButton.addClass('disabled');
					selectButton.text('');
					selectButton.append('<i class="icon-ok icon-white"></i>');
					selectButton.append('已评价');
					selectButton.off('click');*/
					$('#order_evaluation_modal').modal('hide');
				},
				error: function(request, status, error){
					alert(status + ": " + error);
				},
			});
		}
	});
</script>

<script type="text/javascript">
	$('.order_evaluation a.cancel').on('click', function(e){
		orderItemId = $(this).attr('order_item_id');
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("order/cancel") ?>',
			type: 'post',
			dataType: 'json',
			data: {
				orderItemId: orderItemId,
			},
			success: function(result){
				$.fn.yiiListView.update('my_order_list_view');
			},
			error: function(request, status, error){
				alert(status + ": " + error);
			},
		});
	});
</script>