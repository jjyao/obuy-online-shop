<?php
$this->pageTitle=Yii::app()->name . ' - 修改商品';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/jquery-easyui/themes/default/easyui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/jquery-easyui/themes/icon.css');
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/admin/product.less');
?>

<article>
<div class="row-fluid">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'update_product_form',
	'action'=> Yii::app()->createUrl('admin/product/update', array('id'=>$product->id)),
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
		<?php echo $attributesArray['isOnSale']; ?>
	</label>
	<?php echo $form->dropDownList($product, 'isOnSale', $product->statusLabels()) ?>

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

	<label>
		<?php echo $attributesArray['categoryId']; ?>
	</label>
	<?php echo $form->textArea($product, 'categoryId', array('id'=>'categoryIdInput', 'style'=>'display: none;')); ?>

	<ul id="category_tree" class="easyui-tree"></ul>
	<button type="submit" class="btn btn-primary btn-large pull-right">保存修改</button>

	<span class="clearfix"></span>
<?php $this->endWidget(); ?>

<section id="create_product_tips" class="span3 well">
	<h3>Tips</h3>
	<ul>
		<li>名称：需要是唯一的</li>
		<li>价格：最多小数点后两位。例子：35.90; 45.9; 34</li>
		<li>图片：只支持zip包，里面仅能放jpg, png图片文件。图片命名规则：商品名_宽_高.后缀</li>
		<li>描述：可选，但最好提供，以給用户更好的说明</li>
		<li>使用说明：可选，但推荐填写</li>
		<li>附加说明：可选</li>
		<li>分类：选择分类树中的一条</li>
	</ul>
<section>
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
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true
});
</script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/jquery-easyui/jquery.easyui.min.js"></script>
<script type="text/javascript">
	$('#category_tree').tree({
		dnd: false,
		url: '<?php echo Yii::app()->getUrlManager()->createUrl("admin/category/get")?>',
		animate: true,
		onSelect: function(node){
			$('#categoryIdInput').val(node.id);
		},
	});
</script>
<?php if(Yii::app()->user->hasFlash('product_update_success')): ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/assets/jquery-notice/jquery.notice.css'); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/jquery-notice/jquery.notice.js"></script>
<script type="text/javascript">
	jQuery.noticeAdd({
		text: '<?php echo Yii::app()->user->getFlash("product_update_success"); ?>',
		stay: false,
		type: 'success',
	});
</script>
<?php endif; ?>
</article>

