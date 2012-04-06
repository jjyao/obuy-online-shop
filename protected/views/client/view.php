<?php 
$this->pageTitle=Yii::app()->name . ' - 用户信息';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/client.less');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/assets/jquery-notice/jquery.notice.css');
?>
<article class="container">
	<section id="my_account_header">
		<span id="my_account_hint">我的账号</span>
		<ul id="my_account_action">
			<li><a href="#" id="modify_client_account">修改</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('site/logout') ?>">退出</a></li>
			<li class="last"><a href="<?php echo Yii::app()->createUrl('client/logoff') ?>">注销</a></li>
		</ul>
		<span class="clearfix"></span>
	</section><!--my_account_header-->

	<section id="my_account_content">
		<div id="client_email">
			<span>用户邮箱：</span>
			<span id="client_email_display"><?php echo $client->email ?></span>
			<input type="email" id="client_email_input" value="<?php echo $client->email ?>" style="display: none"></input>
			<span id="client_email_error" class="error_hint" style="display: none"></span>
		</div>

		<div id="client_name">
			<span>用户名称：</span>
			<span id="client_name_display"><?php echo $client->name ?></span>
			<input type="text" id="client_name_input" value="<?php echo $client->name ?>" style="display: none"></input>
			<span id="client_name_error" class="error_hint" style="display: none"></span>
		</div>

		<div id="client_password">
			<span>用户密码：</span>
			<a id="modify_client_password" href="#">修改</a>
		</div>

		<div id="delivery_address">
			<span>送货地址：</span>
			<span id="delivery_address_display"><?php echo $client->deliveryAddresses[0]->toString() ?></span>
			<div id="delivery_address_input" style="display: none">
				<input type="text" id="city_input" class="span1" data-provider="typehead" 
						value="<?php echo $client->deliveryAddresses[0]->city->name  ?>">
				</input>
				<span>市</span>
				<input type="text" id="address_input" value="<?php echo $client->deliveryAddresses[0]->address ?>">
				</input>
			</div>
			<span id="delivery_address_error" class="error_hint" style="display: none"></span>
		</div>

		<a class="btn btn-primary" id="submit_account_modification" style="display: none">保存修改</a>
	</section><!--my_account_content-->

	<section class="modal fade" id="modify_password_modal">
		<section class="modal-header">
			<a class="close" data-dismiss="modal">x</a>
			<h3>修改密码</h3>
		</section>
		<section class="modal-body">
			<form>
				<label>当前密码</label>
				<input id="current_password_input" type="password"></input>
				<span id="current_password_error" class="help-inline error_hint"></span>

				<label>新密码</label>
				<input id="new_password_input" type="password"></input>
				<span id="new_password_error" class="help-inline error_hint"></span>

				<label>确认新密码</label>
				<input id="new_confirm_password_input" type="password"></input>
				<span id="new_confirm_password_error" class="help-inline error_hint"></span>
			</form>
		</section><!-- modal-body -->
		<section class="modal-footer">
			<a href="#" id="modify_password_modal_close" class="btn">关闭</a>
			<a href="#" id="submit_password_modification" class="btn btn-primary">保存并关闭</a>
		</section><!-- modal-footer -->
	</section><!-- modal -->

</article>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/jquery-notice/jquery.notice.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-modal.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/bootstrap/js/bootstrap-transition.js"></script>
<script type="text/javascript">
/*--------------------------- modify password part -------------------------------------------*/
	// init variables
	var currentPasswordInput = $('#current_password_input');
	var newPasswordInput = $('#new_password_input');
	var newConfirmPasswordInput = $('#new_confirm_password_input');
	var currentPasswordError = $('#current_password_error');
	var newPasswordError = $('#new_password_error');
	var newConfirmPasswordError = $('#new_confirm_password_error');

	$('#modify_client_password').on('click', function(e){
		currentPasswordInput.val('');
		newPasswordInput.val('');
		newConfirmPasswordInput.val('');
		currentPasswordError.text('');
		newPasswordError.text('');
		newConfirmPasswordError.text('');
		$('#modify_password_modal').modal('show');
	});

	$('#modify_password_modal_close').on('click', function(e){
		$('#modify_password_modal').modal('hide');
	});

	$('#submit_password_modification').on('click', function(e){
		// client validation
		var isValid = true;
		if(currentPasswordInput.val().trim() == ''){
			currentPasswordError.text('密码不能为空白');
			isValid = false;
		}
		if(newPasswordInput.val().trim() == ''){
			newPasswordError.text('密码不能为空白');
			isValid = false;
		}

		if(newPasswordInput.val() != newConfirmPasswordInput.val()){
			newConfirmPasswordError.text('密码不一致');
			isValid = false;
		}
		if(isValid){
			$.ajax({
				url: '<?php echo Yii::app()->createUrl("client/modifyPassword") ?>',
				type: 'post',
				dataType: 'json',
				data: {
					oldPassword: currentPasswordInput.val(),
					newPassword: newPasswordInput.val(),
				},
				success: function(result){
					if(result.success == 'true'){
						$('#modify_password_modal').modal('hide');
						jQuery.noticeAdd({
							text: '成功更改密码',
							stay: false,
							type: 'success',
						});
					}
					else{
						alert(result.error);
					}
				},
				error: function(request, status, error){
					alert(status + ": " + error);
				},
			});
		}
	});
/*--------------------------------------------------------------------------------------------*/
</script>

<script type="text/javascript">
/*--------------------------- modify account part -------------------------------------------*/
	$('#modify_client_account').on('click', function(e){
		// hide account display part and show input part
		$('#client_email_display').hide();
		$('#client_email_input').show();
		$('#client_email_error').show();

		$('#client_name_display').hide();
		$('#client_name_input').show();
		$('#client_name_error').show();

		$('#delivery_address_display').hide();
		$('#delivery_address_input').show();
		$('#delivery_address_error').show();

		$('#submit_account_modification').show();
	});
/*--------------------------------------------------------------------------------------------*/
</script>

<script type="text/javascript">
/*--------------------------- save account modification -------------------------------------------*/
	$('#submit_account_modification').on('click', function(e){
		var isValid = true;
		// client validation
		if($('#client_email_input').val().trim() == ''){
			isValid = false;
			$('#client_email_error').text('用户邮箱不能为空白');
		}
		else{
			if(!($('#client_email_input').val().match(/^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/))){
				isValid = false;
				$('#client_email_error').text('不是有效的电子邮件地址');
			}
		}
		if($('#client_name_input').val().trim() == ''){
			isValid = false;
			$('#client_name_error').text('用户名不能为空白');
		}
		if($('#city_input').val().trim() == ''){
			isValid = false;
			$('#delivery_address_error').text('城市名不能为空');
		}
		if($('#address_input').val().trim() == ''){
			isValid = false;
			$('#delivery_address_error').text('地址不能为空');
		}

		if(isValid){
			$.ajax({
				url: '<?php echo Yii::app()->createUrl("client/modify") ?>',
				type: 'post',
				dataType: 'json',
				data: {
					email: $('#client_email_input').val(),
					name: $('#client_name_input').val(),
					city: $('#city_input').val(),
					address: $('#address_input').val(),
				},
				success: function(result){
					if(result.success == 'true'){
						// clean all errors
						$('#client_email_error').text('');
						$('#client_name_error').text('');
						$('#delivery_address_error').text('');
						
						jQuery.noticeAdd({
							text: '成功更改用户信息',
							stay: false,
							type: 'success',
						});
					}
					else{
						$('#client_email_error').text(result.email);
						$('#client_name_error').text(result.name);
						$('#delivery_address_error').text(result.address);
					}
				},
				error: function(request, status, error){
					alert(status + ": " + error);
				}, 
			});
		}
	});
/*--------------------------------------------------------------------------------------------*/
</script>

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
            $('#city_input').typeahead({source: allCities, items:50, matcher: cityMatcher});
        });
</script>