<?php // Define all functions that will be used in the installation process

/**
 * Init database and fill default value
 * @return true for success and false for failure
 */
function init_database($dbType, $dbHost, $dbPort, $dbUser, $dbPassword, $dbName, $adminEmail, $adminPassword)
{
	ini_set("max_execution_time",3600);
	// connect to database
	echo "<li>开始连接数据库.............";
	flush();
	ob_flush();

	$dbConnect = mysql_connect($dbHost, $dbUser, $dbPassword);
	if(!$dbConnect)
	{
		echo "<span class='failure'>[ERROR: " . mysql_error() . "]</span></li>";
		return false;
	}
	else
	{
		echo "<span class='success'>[OK]</span></li>";
		flush();
		ob_flush();

		// create database, drop if exists
		echo "<li>开始创建新数据库.............";
		flush();
		ob_flush();

		$result = mysql_query("drop database if exists $dbName");
		$result = $result && mysql_query("create database if not exists $dbName CHARACTER SET utf8 COLLATE utf8_general_ci;");
		if(!$result)
		{
			echo "<span class='failure'>[ERROR: " . mysql_error() . "]</span></li>";
			return false;
		}
		else
		{
			echo "<span class='success'>[OK]</span></li>";

			// create tables and fill default values
			echo "<li>开始创建数据库表并填充默认数据.............";
			flush();
			ob_flush();

			$result = mysql_query("use $dbName");
			$result = $result && executeSqlFile('obuy.sql');
			$adminPassword = md5($adminPassword);
			if(!$result ||
				!mysql_query("insert into client (name, email, password) values ('admin', '$adminEmail', '$adminPassword')")
				|| !mysql_query("insert into admin (clientId) values (LAST_INSERT_ID())"))
			{
				echo "<span class='failure'>[ERROR: " . mysql_error() . "]</span></li>";
				return false;
			}
			else
			{
				echo "<span class='success'>[OK]</span></li>";
			}
		}
	}

	// disconnect database
	echo "<li>断开数据库连接.............";
	$result = mysql_close($dbConnect);
	if(!$result)
	{
		echo "<span class='failure'>[ERROR: " . mysql_error() . "]</span></li>";
		return false;
	}
	else
	{
		echo "<span class='success'>[OK]</span></li>";
	}
	return true;
}

/**
 * Update Yii config file
 * @return true for success and false for failure
 */
function update_config_file($dbType, $dbHost, $dbPort, $dbUser, $dbPassword, $dbName)
{
	// open config file
	echo "<li>读取配置文件.............";
	flush();
	ob_flush();

	$filename = 'main.php';

	$fileContent = @file_get_contents($filename);
	if(!$fileContent)
	{
		$error = error_get_last();
		echo "<span class='failure'>[ERROR: " . $error['message'] . "]</span></li>";
		return false;
	}
	else
	{
		echo "<span class='success'>[OK]</span></li>";

		// update config file
		echo "<li>修改配置文件.............";
		flush();
		ob_flush();

		$fileContent = preg_replace('/:dbHost/', $dbHost, $fileContent, 1);
		$fileContent = preg_replace('/:dbName/', $dbName, $fileContent, 1);
		$fileContent = preg_replace('/:dbUser/', $dbUser, $fileContent, 1);
		$fileContent = preg_replace('/:dbPassword/', $dbPassword, $fileContent, 1);
		if(($fileContent != null) && @file_put_contents($filename, $fileContent))
		{
			echo "<span class='success'>[OK]</span></li>";
		}
		else
		{
			$error = error_get_last();
			echo "<span class='failure'>[ERROR: " . $error['message'] . "]</span></li>";
			return false;
		}
	}

	return true;
}

/**
 *	execute a sql file containing several commands
 *  NOTE: the comments in the sql file cannot contain any ';' because the function preg_split with ';'
 */
function executeSqlFile($filename){
	$sql_filename = $filename;
	$sql_contents = file_get_contents($sql_filename);
	$sql_querys = preg_split('@;@', $sql_contents, NULL, PREG_SPLIT_NO_EMPTY);

	foreach ($sql_querys as $query) {
		if (strlen(trim($query)) != 0) // remove those strings contain only whitespace
			if(!mysql_query($query))
			{
				return false;
			}
	}

	return true;
}