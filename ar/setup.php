<?php
include_once 'constants.php';
$prefs = get_preferences();
if(isset($prefs['initialized'])) {
	//echo '<script>window.location.assign("index.php");</script>';
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Warranty Managment System</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	</head>

	<body>
		<div class="setup_wrapper">
			<div class="header">
				<p> Welcome to the W.M.S. Setup Wizard</p>
			</div>
			<div class="body_wrapper">
				<form class="body" method="POST">
					<?php
					$ini_file = 'preferences.ini';
					include_once 'constants.php';
						if(isset($_POST['back'])) {
							echo '<script>window.history.go(-2)</script>';
						} else if(isset($_POST['accept_terms_submit']) && isset($_POST['accept_terms'])) {
							echo '
								<p> Setup the database </p>
								<div class="content">
									<table>
										<tr>
											<th><text>Mysql Host:</text></th>
											<th><input type="text" name="setup_mysql_host" value="localhost"/></th>
										</tr>
										<tr>
											<th><text>Database Name:</text></th>
											<th><input type="text" name="setup_mysql_database"/></th>
										</tr>
										<tr>
											<th><text>Mysql Username:</text></th>
											<th><input type="text" name="setup_mysql_username"/></th>
										</tr>
										<tr>
											<th><text>Mysql Password:</text></th>
											<th><input type="password" name="setup_mysql_password"/></th>
										</tr>
									</table>
									<br/>
									<input type="submit" value="Back" name="back" style="float: left;">
									<input type="submit" value="Next" name="setup_mysql_submit" style="float: right;">
								</div>
							';
						} else if(isset($_POST['setup_mysql_submit'])) {
							/*$database_array = array('mysql_host'=>$_POST('setup_mysql_host'),
								'mysql_database'=>$_POST['setup_mysql_database'], 'mysql_username'=>$_POST['setup_mysql_username'],
								'mysql_password'=>$_POST['setup_mysql_password']);
							write_php_ini($database_array, $ini_file);
							include_once 'mysql_connect.php';
							db_query("Setup", "
								CREATE TABLE IF NOT EXISTS `log`;
								CREATE TABLE `log` (
								  `id` int(11) NOT NULL,
								  `entry_table` varchar(20) NOT NULL DEFAULT 'warranties',
								  `entry_action` varchar(50) NOT NULL,
								  `entry_id` varchar(50) NOT NULL,
								  `entry_log` text NOT NULL,
								  `changed_by` varchar(50) NOT NULL,
								  `date` date NOT NULL
								) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
								CREATE TABLE IF NOT EXISTS `users`;
								CREATE TABLE `users` (
								  `id` int(11) NOT NULL,
								  `email` varchar(50) NOT NULL,
								  `username` varchar(50) NOT NULL,
								  `permission` varchar(20) NOT NULL DEFAULT 'user',
								  `first_name` varchar(50) NOT NULL,
								  `middle_name` varchar(50) NOT NULL,
								  `last_name` varchar(50) NOT NULL,
								  `notify` tinyint(1) NOT NULL DEFAULT '1',
								  `birth_date` date NOT NULL,
								  `creation_date` date NOT NULL,
								  `pass_value` varchar(1000) NOT NULL
								) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
								CREATE TABLE IF NOT EXISTS `warranties` (
								  `id` int(11) NOT NULL,
								  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
								  `product_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
								  `company_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
								  `price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
								  `contact_info` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
								  `notes` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
								  `start_date` date NOT NULL,
								  `end_date` date NOT NULL,
								  `created_by` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Unspecified',
								  `creation_date` date NOT NULL,
								  `notification_count` int(11) NOT NULL DEFAULT '0'
								) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
								");*/
							echo '
								<p> Setup the Admin Account</p>
								<div class="content">
									<table>
										<tr>
											<th><text>Username:</text></th>
											<th><input type="text" name="setup_admin_username" value="admin"/></th>
										</tr>
										<tr>
											<th><text>Password:</text></th>
											<th><input type="text" name="setup_admin_password"/></th>
										</tr>
										<tr>
											<th><text>Password Retype:</text></th>
											<th><input type="text" name="setup_admin_password_retype"/></th>
										</tr>
									</table>
									<br/>
									<input type="submit" value="Back" name="back" style="float: left;">
									<input type="submit" value="Next" name="setup_admin_submit" style="float: right;">
								</div>
							';
						} else if(isset($_POST['setup_admin_submit'])) {
							echo '
								<p> Setup the database </p>
								<div class="content">
									<table>
										<tr>
											<th><text>SMTP Server:</text></th>
											<th><input type="text" name="setup_smtp_server" value=""/></th>
										</tr>
										<tr>
											<th><text>SMTP Port:</text></th>
											<th><input type="text" name="setup_smtp_port" value="25" style="width: 4em; float: left"/></th>
										</tr>
										<tr>
											<th><text>SMTP Email:</text></th>
											<th><input type="text" name="setup_smtp_email" value=""/></th>
										</tr>
										<tr>
											<th><text>SMTP Password:</text></th>
											<th><input type="text" name="setup_smtp_password" value=""/></th>
										</tr>
									</table>
									<br/>
									<input type="submit" value="Back" name="back" style="float: left;">
									<input type="submit" value="Next" name="setup_email_submit" style="float: right;">
								</div>
							';
						} else if(isset($_POST['setup_email_submit'])) {
							echo '<script>window.location.assign("index.php")</script>';
						} else {
							$content = "";
							$myfilename = "LICENSE";
							if(file_exists($myfilename)){
							  $content = file_get_contents($myfilename);
							}
							if($content == "") {
								echo 'The license file `'.$myfilename.'` was not found. This product is under the 
										Eclipse Public License. You are not permeted to user the program
										without agreeing to the Eclipse Public License.';
							} else {
								echo '
									<p>You hereby agree to the terms and condition listed below:</p>
									<textarea class="license" readonly>
									'.$content.'
									</textarea>
									<br/>
									<hr/>
									<br/>
										<input type="checkbox" value="" name="accept_terms">I accept the terms and conditions.</input>
										<input type="submit" value="Continue" name="accept_terms_submit" style="float: right;"/>
								';
							}
						}
					?>
				</form>
			</div>
		</div>
	</body>
</html>