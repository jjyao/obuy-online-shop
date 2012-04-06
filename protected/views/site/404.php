<?php
$this->pageTitle=Yii::app()->name . ' - 404'; 
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/error.less');
?>
<article class="container">
	<img src="<?php echo Yii::app()->baseUrl ?>/images/face_sad.gif" id="error_image" />
	<h1 id="error_slogan">我们很抱歉</h1>
	<p id="error_message"><?php echo $message ?></p>
	<p><a href="<?php echo Yii::app()->createUrl('site/index') ?>" id="return_link">回到首页</a></p>
</article>