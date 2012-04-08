<?php $this->pageTitle=Yii::app()->name . ' - 公告';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/announcement.less');
?>
<article class="container">
	<div id="title">
		<?php echo $announcement->title ?>
	</div>
	<div id="content">
		<?php echo $announcement->content ?>
	</div>
</article>