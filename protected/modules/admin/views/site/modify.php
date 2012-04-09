<?php
$this->pageTitle=Yii::app()->name . ' - 商店信息';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/site.less');
?>

<article>

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'modify_website_form',
))?>
	<div class="modal-header">
		<h3>商店基本信息</h3>
	</div><!-- header -->
	<div class="form_body">
		<?php $attributesArray = $website->attributeLabels(); ?>
		<label>
			<?php echo $attributesArray['name']; ?>
		</label>
		<?php echo $form->textField($website, 'name'); ?>
		<?php echo $form->error($website, 'name', array('class'=>'help-inline error_hint')); ?>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">保存修改</button>
	</div>
<?php $this->endWidget(); ?>

</article>

<?php if(Yii::app()->user->hasFlash('website_modify_success')): ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/assets/jquery-notice/jquery.notice.css'); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/jquery-notice/jquery.notice.js"></script>
<script type="text/javascript">
	jQuery.noticeAdd({
		text: '<?php echo Yii::app()->user->getFlash("website_modify_success"); ?>',
		stay: false,
		type: 'success',
	});
</script>
<?php endif; ?>