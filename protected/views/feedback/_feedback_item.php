<div class="feedback_item <?php echo ($index == 0)? 'first' : '' ?>">
	<div class="avatar pull-left">
		<img src="<?php echo Yii::app()->baseUrl?>/images/avatar.gif"></img>
	</div>
	<div class="body pull-left">
		<p><span class="name"><?php echo $data->client->name ?></span> <?php echo $data->time ?></p>
		<p><?php echo $data->content ?></p>
	</div>
	<span class="clearfix"></span>
</div>