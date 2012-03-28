<div class="product_comment_item <?php echo ($index % 2) ? 'odd' : 'even' ?>">
<div class="comment_user_name">
	评论用户: 
	<?php echo $data->client->name ?>
</div>
<div class="evaluation_score">
	<span class="pull-left">商品评分: </span>
	<div class="star star<?php echo $data->score ?> pull-left"></div>
</div>
<span class="clearfix" />
<div class="comment">
	评论: 
	<?php echo $data->comment ?>
</div>
<div class="comment_time">
	评论时间:
	<?php echo $data->time ?>
</div>
</div>