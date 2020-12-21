<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Warranty Managment System</title>
	</head>

	<body>
		<div class="wrapper">
			<?php
				include_once 'header.php';
				include_once 'required_imports.php';
			?>
			<script>
				$( function() {
				$( "#edit_account_birth_date" ).datepicker({dateFormat: "dd-mm-yy"});
				$( "#create_account_birth_date" ).datepicker({dateFormat: "dd-mm-yy"});
				$( "#create_account_birth_date" ).datepicker({dateFormat: "dd-mm-yy"});
				} );
			</script>
			<form method="POST">
				<div class="control_menu">
					<?php
					include_once 'login.php';
					echo '<div class="actions">';
					if(isset($_POST['list_all_accounts']))
						echo '<input type="submit" value="رجع" name="back"/>';
					if(isset($_POST['edit_account']))
						echo '<input type="submit" value="إحفظ" name="edit_account_submit"/>
							  <input type="submit" value="رجع" name="back"/>';
					if(isset($_POST['create_account']))
						echo '<input type="submit" value="إظاف" name="create_account_submit"/>
							  <input type="submit" value="رجع" name="back"/>';
					if(isset($_POST['remove_account']))
						echo '<input type="submit" value="إزال" name="remove_account_submit"/>
							  <input type="submit" value="رجع" name="back"/>';
					echo '</div>';
					?>
				</div>
				
				<div class="body_content">
					<div class="entry">
						<div class="content">
							<div class="header">
								<div class="title"><p>الاعدادات </p></div>
							</div>
							<hr/>
							<div class="details"><br/>
							<?php
								include_once 'mysql_connect.php';
								include_once 'user_auth.php';
								include_once 'constants.php';
								$prefs = get_preferences();
								$link = connectDatabase();
								if(isset($_POST['list_all_accounts'])) {
									//Authenticate user
									if(!isset($_SESSION['status']) || $_SESSION['status'] != 1 || $_SESSION['permission'] != 'admin') {
										echo "<script type='text/javascript'>alert('You must be logged in or you don't have permission.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_101;
									}
									
									//Retrieving user base.
									$query = 'SELECT * FROM '.$prefs['mysql_table_users'].'';
									$result = db_query($link, $_SESSION['username'], $query);
									if(!$result || mysqli_num_rows($result) == 0) {
										echo "<script type='text/javascript'>alert('There are no registered users.')</script>";
										echo '<script type="text/javascript">window.location.assign("settings.php");</script>';
										goto end_if_101;
									}
									//$result_arr = mysqli_fetch_array($result);
									
									//Printing user base.
									echo '
										<table style="width:100%">
											<tr>
												<th style="font-weight: bold;">الأسم</th>
												<th style="font-weight: bold;">:اسم المستخدم</th>
												<th style="font-weight: bold;">الاذونات</th>
												<th style="font-weight: bold;">البريد الكتروني</th>
												<th style="font-weight: bold;">تريخ الانشاء</th>
											</tr>
									';
									while($row = mysqli_fetch_array($result)) {
										echo '
											<tr>
												<th style="font-weight: normal;">'.$row['first_name'] .' '.$row['middle_name'].' '.$row['last_name'].'</th>
												<th style="font-weight: normal;">'.$row['username'].'</th>
												<th style="font-weight: normal;">'.$row['permission'].'</th>
												<th style="font-weight: normal;">'.$row['email'].'</th>
												<th style="font-weight: normal;">'.date($prefs['date_format'], strtotime($row['creation_date'])).'</th>
											</tr>
										';
									}
									echo '</table>';
									
									echo '<br/><hr/><br/><input type="submit" value="رجع" name="back"/>';
									end_if_101:
									
								} else if(isset($_POST['edit_account'])) {
									//Authenticate user
									if(!isset($_SESSION['status']) || $_SESSION['status'] != 1 || !($_SESSION['permission'] == 'admin' || bbhp($_POST['edit_account_username']) == $_SESSION['username'])) {
										echo "<script type='text/javascript'>alert('You must be logged in or you don't have permission.')</script>";
										echo '<script type="text/javascript">window.location.assign("settings.php");</script>';
										goto end_if_102;
									}
									$query = 'SELECT * FROM '.$prefs['mysql_table_users'].' WHERE username="'.bhp($link, $_POST['edit_account_username']).'"';
									$result = db_query($link, $_SESSION['username'], $query);
									if(!$result || mysqli_num_rows($result) == 0) {
										echo '<script type="text/javascript">alert("Request user to edit does not exist.")</script>';
										echo '<script type="text/javascript">window.location.assign("settings.php");</script>';
										goto end_if_102;
									}
									//Fetch account information.
									$result_arr = mysqli_fetch_array($result);
									//Print info to page
									$editibility = "readonly";
									$password_fields = "";
									if(bbhp($_POST['edit_account_username']) == $_SESSION['username']) {
										$editibility = "";
										$password_fields = '
											<p><label style="float: right;">كلمة المرور</label> <input type="password" name="edit_account_password" value=""/></p>
											<p><label style="float: right;">اعادة كلمت المرور</label> <input type="password" name="edit_account_password_retype" value=""/></p>
										';
									}
									$admin_selected = "";
									if($result_arr['permission'] == 'admin')
										$admin_selected = 'selected';
									$notify_checked = '';
									if($result_arr['notify'] == 1) {
										$notify_checked = 'checked';
									}
									echo '
											<table style="width:100%;" class="user_name">
												<tr>
													<th>الاسم الثاني</th>
													<th>اسم العائلة</th>
													<th>الاسم الاول</th>
												</tr>
												<tr>
													<th><input type="text" name="edit_account_last_name" value="'.$result_arr['last_name'].'" '.$editibility.'/></th>
													<th><input type="text" name="edit_account_middle_name" value="'.$result_arr['middle_name'].'" '.$editibility.'/></th>
													<th><input type="text" name="edit_account_first_name" value="'.$result_arr['first_name'].'" '.$editibility.'/></th>
												</tr>
											</table>
										<p><label style="float: right;">اسم المستخدم</label> <input type="text" name="edit_account_username" value="'.$result_arr['username'].'" readonly/></p>
										<p><label style="float: right;">البريد الكتروني</label> <input type="text" name="edit_account_email" value="'.$result_arr['email'].'" '.$editibility.'/></p>
										<input type="hidden" name="edit_account_birth_date" id="edit_account_birth_date" value="'.date($prefs['date_format'], strtotime($result_arr['birth_date'])).'" '.$editibility.'/>
										<p>
											<label style="float: right;">الاذونات</label> 
											<select name="edit_account_permission">
												<option value="user">Default User</option>
												<option value="admin" '.$admin_selected.'>Admin</option>
											</select>
										</p>
										<p><label style="float: right;">اشار بريد الكتروني</label> <input type="checkbox" name="edit_account_notify" '.$notify_checked.'/></p>
										'.$password_fields.'
										
									';
									
									echo '<br/><hr/><br/>
									<input type="submit" value="حفذ" name="edit_account_submit"/>
									<input type="submit" value="رجع" name="back"/>';
									end_if_102:
								} else if(isset($_POST['create_account'])) {
									//Authenticate user
									if(!isset($_SESSION['status']) || $_SESSION['status'] != 1 || $_SESSION['permission'] != 'admin') {
										echo "<script type='text/javascript'>alert('You must be logged in or you don't have permission.')</script>";
										echo '<script type="text/javascript">window.location.assign("settings.php");</script>';
										goto end_if_103;
									}
									echo '
											<table style="width:100%;" class="user_name">
												<tr>
													<th>الاسم الثاني</th>
													<th>اسم العائلة</th>
													<th>الاسم الاول</th>
												</tr>
												<tr>
													<th><input type="text" name="create_account_first_name" value="" /></th>
													<th><input type="text" name="create_account_middle_name" value="" /></th>
													<th><input type="text" name="create_account_last_name" value="" /></th>
												</tr>
											</table>
										<p><label style="float: right;">اسم المستخدم</label> <input type="text" name="create_account_username" value="" /></p>
										<p><label style="float: right;">البريد الكتروني</label><input type="text" name="create_account_email" value="" /></p>
										<input type="hidden" name="edit_account_birth_date" id="edit_account_birth_date" value="00-00-0000"/>
										<p>
											<label style="float: right;">الاذونات</label> 
											<select name="create_account_permission">
												<option value="user">Default User</option>
												<option value="admin">Admin</option>
											</select>
										</p>
										<p><label style="float: right;">اشار بريد الكتروني</label> <input type="checkbox" name="create_account_notify"/></p>
										<p><label style="float: right;">كلمة المرور</label> <input type="password" name="create_account_password" value=""/></p>
										<p><label style="float: right;">اعادة كلمت المرور</label> <input type="password" name="create_account_password_retype" value=""/></p>
										
									';
									
									echo '<br/><hr/><br/>
											<input type="submit" value="انشاء" name="create_account_submit"/>
											<input type="submit" value="رجع" name="back"/>';
									end_if_103:
								} else if(isset($_POST['remove_account'])) {
									//Authenticate user
									if(!isset($_SESSION['status']) || $_SESSION['status'] != 1 || !($_SESSION['permission'] == 'admin' || bbhp($_POST['edit_account_username']) == $_SESSION['username'])) {
										echo "<script type='text/javascript'>alert('You must be logged in or you don't have permission.')</script>";
										echo '<script type="text/javascript">window.location.assign("settings.php");</script>';
										goto end_if_104;
									}
									$query = 'SELECT * FROM '.$prefs['mysql_table_users'].' WHERE username="'.bhp($link, $_POST['remove_account_username']).'"';
									$result = db_query($link, $_SESSION['username'], $query);
									if(!$result || mysqli_num_rows($result) == 0) {
										echo '<script type="text/javascript">alert("Request user to delete does not exist.")</script>';
										echo '<script type="text/javascript">window.location.assign("settings.php");</script>';
										goto end_if_104;
									}
									//Fetch account information.
									$result_arr = mysqli_fetch_array($result);
									
									//Print info to page
									echo '
										<p>
										<text style="font-size: 1.2em;">هل انت متأكد من ازالة هذا الحساب؟</text><br/>
										</p>
										<p><label style="float: right;">الرجاء اعادة كتابت اسم المستخدم</label> <input type="hidden" name="remove_account_username" value="'.bbhp($_POST['remove_account_username']).'" readonly/> <input type="text" name="remove_account_verify_username"/></p>
										';
									
									echo '	<br/><hr/><br/>
											<input type="submit" value="ازال" name="remove_account_submit" style="margin:0.6";/>
											<input type="submit" value="رجع" name="remove_account_cancel"/>';
									end_if_104:
								} else if(isset($_POST['remove_account_submit'])) {
									//Authenticate user
									if(!isset($_SESSION['status']) || $_SESSION['status'] != 1 || !($_SESSION['permission'] == 'admin' || bbhp($_POST['edit_account_username']) == $_SESSION['username'])) {
										echo "<script type='text/javascript'>alert('You must be logged in or you don't have permission.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_105;
									}
									//Check verification
									if(bbhp($_POST['remove_account_username']) != bbhp($_POST['remove_account_verify_username'])) {
										echo "<script type='text/javascript'>alert('Please retype the username correctly.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_105;
									}
									
									$query = 'DELETE FROM '.$prefs['mysql_table_users'].' WHERE username="'.bhp($link, $_POST['remove_account_username']).'"';
									$query_result = db_query($link, $_SESSION['username'], $query);
									if(!$query_result) {
										echo "<script type='text/javascript'>alert('Could not delete account.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_105;
									}
									echo "<script type='text/javascript'>window.location.assign('settings.php')</script>";
									end_if_105:
								} else if(isset($_POST['edit_account_submit'])) {
									//Authenticate user
									if(!isset($_SESSION['status']) || $_SESSION['status'] != 1 || !($_SESSION['permission'] == 'admin' || bbhp($_POST['edit_account_username']) == $_SESSION['username'])) {
										echo "<script type='text/javascript'>alert('You must be logged in or you don't have permission.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_106;
									}
									$edit_as_admin = true;
									if($_SESSION['username'] == bbhp($_POST['edit_account_username'])) {
										$edit_as_admin = false;
									}
									//check if new password requested match
									if(!$edit_as_admin && bbhp($_POST['edit_account_password']) != "" && bbhp($_POST['edit_account_password']) != bbhp($_POST['edit_account_password_retype'])) {
										echo "<script type='text/javascript'>alert('New password donsen\'t match the retype field.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_106;
									}
									//Check if requested account exists.
									$query = 'SELECT * FROM '.$prefs['mysql_table_users'].' WHERE username="'.bhp($link, $_POST['edit_account_username']).'"';
									$result = db_query($link, $_SESSION['username'], $query);
									if(!$result || mysqli_num_rows($result) == 0) {
										echo '<script type="text/javascript">alert("Request user to delete does not exist.")</script>';
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_106;
									}
									//Fetch account information.
									$result_arr = mysqli_fetch_array($result);
									$new_account = array('email'=>bbhp($_POST['edit_account_email']), 'username'=>bbhp($_POST['edit_account_username']), 'first_name'=>bbhp($_POST['edit_account_first_name']), 'middle_name'=>bbhp($_POST['edit_account_middle_name']), 'last_name'=>bbhp($_POST['edit_account_last_name']), 'birth_date'=>bbhp($_POST['edit_account_birth_date']), 'permission'=>bbhp($_POST['edit_account_permission']));
									if(!$edit_as_admin)
										$new_account = array('email'=>bbhp($_POST['edit_account_email']), 'username'=>bbhp($_POST['edit_account_username']), 'first_name'=>bbhp($_POST['edit_account_first_name']), 'middle_name'=>bbhp($_POST['edit_account_middle_name']), 'last_name'=>bbhp($_POST['edit_account_last_name']), 'birth_date'=>bbhp($_POST['edit_account_birth_date']), 'permission'=>bbhp($_POST['edit_account_permission']), 'password'=>bbhp($_POST['edit_account_password']));
									
									//Update account data
									if($edit_as_admin) {
										$query = 'UPDATE '.$prefs['mysql_table_users'].'
										SET
											permission="'.$new_account['permission'].'"
										WHERE
											username="'.$new_account['username'].'"
									';
									} else {
										$notify_value = 1;
										if (!isset($_POST['edit_account_notify']))
											$notify_value = 0;
										$query = 'UPDATE '.$prefs['mysql_table_users'].'
											SET
												email="'.bhp($link, $new_account['email']).'",
												first_name="'.bhp($link, $new_account['first_name']).'",
												middle_name="'.bhp($link, $new_account['middle_name']).'",
												last_name="'.bhp($link, $new_account['last_name']).'",
												permission="'.bhp($link, $new_account['permission']).'",
												notify="'.bhp($link, $notify_value).'",
												birth_date="'.date("Y-m-d", strtotime(bhp($link, $new_account['birth_date']))).'"
											WHERE
												username="'.bhp($link, $new_account['username']).'"
										';
									}
									$result = db_query($link, $_SESSION['username'], $query);
									if(!$result) {
										echo '<script type="text/javascript">alert("Could not update account.")</script>';
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_106;
									}
									//Update account password
									if(!$edit_as_admin) {
										$password_change = $_SESSION['password'];
										if($new_account['password'] != "")
											$password_change = $new_account['password'];
										$pass_hash = get_pass_hash($new_account['username'], $password_change);
										$query = 'UPDATE '.$prefs['mysql_table_users'].'
											SET
												pass_hash="'.bhp($link, $pass_hash).'"
											WHERE
												username="'.bhp($link, $new_account['username']).'"
										';
										$result = db_query($link, $_SESSION['username'], $query);
										if(!$result) {
											echo '<script type="text/javascript">alert("Could not update password.")</script>';
											echo '<script type="text/javascript">window.history.back();</script>';
											goto end_if_106;
										}
									}
									echo '<script type="text/javascript">window.location.assign(\'settings.php\');</script>';
									end_if_106:
								} else if(isset($_POST['create_account_submit'])) {
									//Authenticate user
									if(!isset($_SESSION['status']) || $_SESSION['status'] != 1 || $_SESSION['permission'] != 'admin') {
										echo "<script type='text/javascript'>alert('You must be logged in or you don't have permission.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_107;
									}
									//Check if new user already exists
									$query = 'SELECT * FROM '.$prefs['mysql_table_users'].' WHERE username="'.bhp($link, $_POST['create_account_username']).'"';
									$result = db_query($link, $_SESSION['username'], $query);
									if(!(!$result) && mysqli_num_rows($result) == 1) {
										echo "<script type='text/javascript'>alert('This username already exists.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_107;
									}
									$query = 'SELECT * FROM '.$prefs['mysql_table_users'].' WHERE email="'.bhp($link, $_POST['create_account_email']).'"';
									$result = db_query($link, $_SESSION['username'], $query);
									if(!(!$result) && mysqli_num_rows($result) == 1) {
										echo "<script type='text/javascript'>alert('This email is already registered.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_107;
									}
									//check if password requested match
									if(bbhp($_POST['create_account_password']) != "" && bbhp($_POST['create_account_password']) != bbhp($_POST['create_account_password_retype'])) {
										echo "<script type='text/javascript'>alert('New password donsen\'t match the retype field.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_107;
									}
									//Create account
									$notify_value = 1;
									if(!isset($_POST['create_account_notify']))
										$notify_value = 0;
									$query = '
										INSERT INTO '. $prefs['mysql_table_users'] .'
											(email, username, permission, notify, first_name, middle_name, last_name, birth_date, creation_date, pass_hash)
										VALUES
											(
											"'.bhp($link, $_POST['create_account_email']).'",
											"'.bhp($link, $_POST['create_account_username']).'",
											"'.bhp($link, $_POST['create_account_permission']).'",
											"'.$notify_value.'",
											"'.bhp($link, $_POST['create_account_first_name']).'",
											"'.bhp($link, $_POST['create_account_middle_name']).'",
											"'.bhp($link, $_POST['create_account_last_name']).'",
											"'.date("Y-m-d", strtotime(bhp($link, $_POST['create_account_birth_date']))).'",
											"'.date("Y-m-d", strtotime("today")).'",
											""
											
											)
									';
									echo $query;
									$result = db_query($link, $_SESSION['username'], $query);
									if(!$result) {
										echo "<script type='text/javascript'>alert('Could not create account.')</script>";
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_107;
									}
									//Update account password
									$password = bbhp($_POST['create_account_password']);
									$pass_hash = get_pass_hash(bbhp($_POST['create_account_username']), $password);
									$query = 'UPDATE '.$prefs['mysql_table_users'].'
										SET
											pass_hash="'.$pass_hash.'"
										WHERE
											username="'.bhp($link, $_POST['create_account_username']).'"
									';
									$result = db_query($link, $_SESSION['username'], $query);
									if(!$result) {
										echo '<script type="text/javascript">alert("Account was not created properly. It exists but you won\'t be able to login")</script>';
										echo '<script type="text/javascript">window.history.back();</script>';
										goto end_if_107;
									}
									echo '<script type="text/javascript">window.location.assign(\'settings.php\');</script>';
									end_if_107:
								} else {
									echo '
									<p><label style="float: right;"> :قائمة الحسابات </label><input type="submit" value="أذهب" name="list_all_accounts"></p>
									<p><label style="float: right;"> :تعديل الحساب </label><input type="submit" value="أذهب" name="edit_account"/><input type="text" value="" name="edit_account_username"/></p>
									<p><label style="float: right;"> :انشاء حساب جديد </label><input type="submit" value="أذهب" name="create_account"/></p>
									<p><label style="float: right;"> :ازالة الحساب </label><input type="submit" value="أذهب" name="remove_account"/><input type="text" value="" name="remove_account_username"/></p>
									';
								}
								mysqli_close($link);
							?>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</body>

</html>