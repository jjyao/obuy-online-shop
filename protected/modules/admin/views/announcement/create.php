<?php
$this->pageTitle=Yii::app()->name . ' - 新建公告';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/announcement.less');
?>

<article>
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'create_announcement_form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<?php $attributesArray = $announcement->attributeLabels(); ?>

	<?php echo $form->errorSummary(array($announcement), NULL, NULL, array('class'=>'alert alert-error')); ?>

	<label>
		<?php echo $attributesArray['title']; ?>
	</label>
	<?php echo $form->textField($announcement, 'title'); ?>

	<label>
		<?php echo $attributesArray['content']; ?>
	</label>
	<?php echo $form->textArea($announcement, 'content'); ?>

	<button type="submit" class="btn btn-primary pull-right">新建</button>

<?php $this->endWidget(); ?>

</article>
<!-- load tinymce rich text editor and init text area -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	// general options
	height: "300px",
	width: "100%",
	mode: "textareas", 
	theme: "advanced",
	plugins: "table, insertdatetime,preview",

	// Theme options
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3 : "tablecontrols",
    theme_advanced_toolbar_location : "bottom",
    theme_advanced_toolbar_align : "center",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true
});
</script>

<?php if(Yii::app()->user->hasFlash('announcement_create_success')): ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/assets/jquery-notice/jquery.notice.css'); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/jquery-notice/jquery.notice.js"></script>
<script type="text/javascript">
	jQuery.noticeAdd({
		text: '<?php echo Yii::app()->user->getFlash("announcement_create_success"); ?>',
		stay: false,
		type: 'success',
	});
</script>
<?php endif; ?>