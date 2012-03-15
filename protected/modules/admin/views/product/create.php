<?php
$this->pageTitle=Yii::app()->name . ' - 新添商品';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/product.less');
?>

<article>
<div class="row-fluid">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'create_product_form',
	'focus'=>array($product, 'name'),
	'htmlOptions'=>array('enctype'=>'multipart/form-data', 'class'=>'span8'),
));?>
	
	<?php $attributesArray = $product->attributeLabels(); ?>

	<?php echo $form->errorSummary(array($product), NULL, NULL, array('class'=>'alert alert-error')); ?>

	<label>
		<?php echo $attributesArray['name']; ?>
	</label>
	<?php echo $form->textField($product, 'name'); ?>

	<label>
		<?php echo $attributesArray['price']; ?>
	</label>
	<?php echo $form->textField($product, 'price'); ?>

	<label>
		<?php echo $attributesArray['imagePackageFile']; ?>	
	</label>
	<?php echo $form->fileField($product, 'imagePackageFile'); ?>

	<label>
		<?php echo $attributesArray['description']; ?>
	</label>
	<?php echo $form->textArea($product, 'description'); ?>

	<label>
		<?php echo $attributesArray['howToUse']; ?>
	</label>
	<?php echo $form->textArea($product, 'howToUse'); ?>

	<label>
		<?php echo $attributesArray['additionalSpec']; ?>
	</label>
	<?php echo $form->textArea($product, 'additionalSpec'); ?>

	<button type="submit" class="btn btn-primary btn-large pull-right">添加</button>

	<span class="clearfix"></span>
<?php $this->endWidget(); ?>
</div>
<!-- load tinymce rich text editor and init text area -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	// general options
	height: "200px",
	width: "100%",
	mode: "exact", 
	elements: "Product_description, Product_howToUse, Product_additionalSpec",
	theme: "advanced",
	plugins: "table, insertdatetime,preview",

	// Theme options
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3 : "tablecontrols",
    theme_advanced_toolbar_location : "bottom",
    theme_advanced_toolbar_align : "center",
    theme_advanced_resizing : true
});
</script>
</article>

