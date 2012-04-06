<?php 
$this->pageTitle=Yii::app()->name . ' - 用户信息';
Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', Yii::app()->baseUrl.'/css/client.less');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/assets/jquery-notice/jquery.notice.css');
?>
<article class="container">
	<section id="my_count_header">
		<span id="my_count_hint">我的账号</span>
		<ul id="my_count_action">
			<li><a href="#" id="modify_client_count">修改</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('site/logout') ?>">退出</a></li>
			<li class="last"><a href="<?php echo Yii::app()->createUrl('site/logoff') ?>">注销</a></li>
		</ul>
		<span class="clearfix"></span>
	</section>
	<section id="my_count_content">
		<div id="client_email">
			<span>用户邮箱：</span>
			<span><?php echo $client->email ?></span>
		</div>
		<div id="client_name">
			<span>用户名称：</span>
			<span><?php echo $client->name ?></span>
		</div>
		<div id="client_password">
			<span>用户密码：</span>
			<a id="modify_client_password" href="#">修改</a>
		</div>
		<div id="delivery_address">
			<span>送货地址：</span>
			<span><?php echo $client->deliveryAddresses[0]->toString() ?></span>
		</div>
	</section>
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
