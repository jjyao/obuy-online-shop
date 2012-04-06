<?php
$this->pageTitle=Yii::app()->name . ' - 注册';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/register.css');
?>

<article>

<section id="register_section">

<section id="welcome_slogan">
	<p>欢迎注册<a href="<?php echo Yii::app()->getUrlManager()->createUrl("site/index") ?>" >买么事</a>，享受快乐网购生活</p>
</section><!--weclome section -->

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register_form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php $attributesArray = $model->attributeLabels(); ?>

	<label>
		<?php echo $attributesArray['email']; ?>
	</label>
	<?php echo $form->textField($model, 'email', array('class'=>'span3')); ?>
	<?php echo $form->error($model, 'email', array('class'=>'alert alert-error errorMessage')); ?>

	<label>
		<?php echo $attributesArray['password']; ?>
	</label>
	<?php echo $form->passwordField($model,'password', array('class'=>'span3')); ?>
	<?php echo $form->error($model, 'password', array('class'=>'alert alert-error errorMessage')); ?>

	<label>
		<?php echo $attributesArray['confirmPassword']; ?>
	</label>
	<?php echo $form->passwordField($model,'confirmPassword', array('class'=>'span3')); ?>
	<?php echo $form->error($model, 'confirmPassword', array('class'=>'alert alert-error errorMessage')); ?>

	<label>
		<?php echo $attributesArray['username']; ?>
	</label>
	<?php echo $form->textField($model, 'username', array('class'=>'span3')); ?>
	<?php echo $form->error($model, 'username', array('class'=>'alert alert-error errorMessage')); ?>

	<label>
		<?php echo $attributesArray['address']; ?>
	</label>
	<section id="address_section">
		<label id="city_part">
		<?php echo $form->textField($model, 'cityname', array('id'=>'cityname_typeahead','class'=>'span1', 'data-provider'=>'typeahead'))?>
		<?php echo $attributesArray['cityname']; ?>
		</label>
		<?php echo $form->textField($model, 'address', array('class'=>'span3')) ?>
	</section>
	<?php echo $form->error($model, 'address', array('class'=>'alert alert-error errorMessage')); ?>

	<button type="submit" class="btn btn-primary btn-large pull-right">注册</button>

	<span class="clearfix"></span>
<?php $this->endWidget(); ?>

</section><!-- register section -->

<section id="introduction_section">

</section><!-- introduction section -->

</article>

<!-- include bootstrap typeahead js -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-typeahead.js"></script>
<!-- init typeahead plugin -->

<?php
	// get all available city names
	$command= Yii::app()->db->createCommand("SELECT DISTINCT name FROM city");
	$cityArray = $command->queryColumn();
?>

<script type="text/javascript">
		function cityMatcher(item){
			var pattern = new RegExp("^" + this.query);
			return pattern.test(item);
		}
        jQuery(document).ready(function() {
            var allCities = ["<?php echo implode ('","', $cityArray); ?>"].sort();
            $('#cityname_typeahead').typeahead({source: allCities, items:50, matcher: cityMatcher});
        });
</script>