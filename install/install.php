<?php
	/**
	 *	This is the auto-install script for this online shop
	 */
	require_once('install_functions.php');
	error_reporting(E_ERROR);

	$start_installation = false;
	$dbTypes = Array('MYSQL');
	$form_invalid = false;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="language" content="en">
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="install.css" />
		<title>安装</title>
	</head>
	<body>
		<header>
			<h1 id="install_header">网上商店自动安装</h1>
			<p>这是obuy网上商店的自动安装脚本, by <a href="http://www.jjyao.me" target="_blank">jjyao</a></p>
		</header>
		<article>
			<?php if(isset($_POST['ConfigForm'])): ?>
			<?php 
				// config form has been submitted, so validate it and start installation 
				$errors = array();
				$form = $_POST['ConfigForm'];

				if(!isset($form['dbType']) || !in_array($form['dbType'], $dbTypes))
				{
					$form['dbType'] = '数据库类型不支持';
					$form_invalid = true;
				}
				if(!isset($form['dbHost']) || trim($form['dbHost']) == '')
				{
					$errors['dbHost'] = '数据库主机不能为空白';
					$form_invalid = true;
				}
				if(!isset($form['dbPort']) || !is_numeric($form['dbPort']))
				{
					$errors['dbPort'] = '数据库端口不正确';
					$form_invalid = true;
				}
				if(!isset($form['dbUser']) || trim($form['dbUser']) == '')
				{
					$errors['dbUser'] = '数据库用户不能为空白';
					$form_invalid = true;
				}
				if(!isset($form['dbPassword']) || trim($form['dbPassword']) == '')
				{
					$errors['dbPassword'] = '数据库密码不能为空白';
					$form_invalid = true;
				}
				if(!isset($form['dbName']) || trim($form['dbName']) == '')
				{
					$errors['dbName'] = '数据库名称不能为空白';
					$form_invalid = true;
				}

				if(!isset($form['adminEmail']) || trim($form['adminEmail']) == '')
				{
					$errors['adminEmail'] = '管理员邮箱不能为空白';
					$form_invalid = true;
				}

				if(!isset($form['adminPassword']) || trim($form['adminPassword']) == '')
				{
					$errors['adminPassword'] = '管理员密码不能为空白';
					$form_invalid = true;
				}

				if(!$form_invalid)
				{
					// it is valid so start installing
					echo "<p>开始安装Obuy网上商店，请耐心等待</p>";
					flush();
					ob_flush();

					echo "<ul class='log'>";

					// install database				
					echo "<li>开始安装数据库.......................<span class='success'>[OK]</span></li>";	
					flush();
					ob_flush();

					echo "<ul class='log'>";
					init_database($form['dbType'], $form['dbHost'], $form['dbPort'], 
						$form['dbUser'], $form['dbPassword'], $form['dbName'], $form['adminEmail'], $form['adminPassword']) or die;
					echo "</ul>";

					// update Yii configuration file
					echo "<li>开始更新配置文件....................<span class='success'>[OK]</span></li>";
					flush();
					ob_flush();
					
					echo "<ul class='log'>";
					update_config_file($form['dbType'], $form['dbHost'], $form['dbPort'], $form['dbUser'], $form['dbPassword'], $form['dbName']) or die;
					echo "</ul>";

					echo "<li>部署完成....................<span class='success'>[OK]</span></li>";
					echo "</ul>";
				}
			?>
			<?php endif; ?>

			<?php if(!isset($_POST['ConfigForm']) || $form_invalid): ?>		
			<?php // display config form when user doesn't submit it or submit an invalid form ?>
				<form method="post">
					<?php if($form_invalid): ?>
						<div id = "config_form_error_alert" class="alert alert-error">
							<p>请更正下列输入错误:</p>
							<ul>
								<?php foreach($errors as $error): ?>
									<li><?php echo $error ?></li>
								<?php endforeach; ?>
							</ul>		
						</div>
					<?php endif; ?>
					<label>
						数据库类型 (database type)
					</label>
					<select name="ConfigForm[dbType]">
						<?php foreach($dbTypes as $key=>$value): ?>
							<option value=<?php echo $value ?> 
							<?php 
								if(isset($_POST['ConfigForm']['dbType']) && $_POST['ConfigForm']['dbType'] == $value)
								{
									echo ' selected="selected"';
								}
							?>
						>
								<?php echo $value ?>
							</option>
						<?php endforeach; ?>
					</select>

					<label>
						数据库主机 (database host)
					</label>
					<input name="ConfigForm[dbHost]" type="text">

					<label>
						数据库端口 (database port)
					</label>
					<input name="ConfigForm[dbPort]" type="number" min="0">
					
					<label>
						数据库用户 (database user)
					</label>
					<input name="ConfigForm[dbUser]" type="text">
					
					<label>
						数据库密码 (database password)
					</label>
					<input name="ConfigForm[dbPassword]" type="password">
					
					<label>
						数据库名称 (database name)
					</label>
					<input name="ConfigForm[dbName]" type="text">
					
					<label>
						管理员邮箱 (administrator email)
					</label>
					<input name="ConfigForm[adminEmail]" type="email">

					<label>
						管理员密码 (administrator password)
					</label>
					<input name="ConfigForm[adminPassword]" type="password">

					<button id="start_install" type="submit" class="btn btn-primary btn-small">开始安装</button>
				</form>
			<?php endif; ?>
		</article>
	</body>
</html>
