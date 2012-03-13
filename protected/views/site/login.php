<?php
$this->pageTitle=Yii::app()->name . ' - 登录';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/login.css');
?>
<article>
<section id="welcome_slogan">
	<p>欢迎回到<a href="<?php echo Yii::app()->getUrlManager()->createUrl("site/index") ?>" >买么事</a>，祝您购物愉快</p>
</section><!--weclome section -->

<section id="login_section" class="well">

<p id="login_hint">请登录</p>

<?php
	/* get proper focus control */
	$focus_control = 'email'; // default focus on email input
	if(is_null($model->getError('email')) && !is_null($model->getError('password')))
	{
		$focus_control = 'password'; // now we need focus on password input
	}
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login_form',
	'focus'=>array($model, $focus_control),
)); ?>

	<?php $attributesArray = $model->attributeLabels(); ?>

	<?php echo $form->errorSummary(array($model), NULL, NULL, array('class'=>'alert alert-error')); ?>

	<label>
		<?php echo $attributesArray['email']; ?>
	</label>
	<?php echo $form->textField($model,'email', array('class'=>'span3')); ?>
		
	<label>
		<?php echo $attributesArray['password']; ?>
	</label>
	<?php echo $form->passwordField($model,'password', array('class'=>'span3')); ?>
	
	<label class="checkbox">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $attributesArray['rememberMe']; ?>
	</label>

	<button type="submit" class="btn btn-large pull-right">登录</button>	

	<span class="clearfix"></span>
<?php $this->endWidget(); ?>

</section><!-- login section -->
<p id="register_link">没有账号？赶快<a href="<?php echo Yii::app()->getUrlManager()->createUrl("site/register") ?>" >注册</a>吧</p>
</article>