<?php 
	session_start();
	include_once 'user_auth.php';
	include_once 'constants.php';
	include_once 'mysql_connect.php';
	if(isset($_POST['login_submit']) && isset($_POST['username']) && isset($_POST['password'])) {
		$auth_status = authenticate(bbhp($_POST['username']), bbhp($_POST['password']));
		if($auth_status == 1) {
			$link = connectDatabase();
			$result = db_query($link, bbhp($_POST['username']), 'SELECT * FROM '.$prefs['mysql_table_users'].' WHERE username="'.bhp($link, $_POST['username']).'"');
			if(!$result){
				echo 'Couldn\'t login';
			} else {
				$userinfo = mysqli_fetch_array($result);
			}
			$_SESSION['status'] = 1;
			$_SESSION['username'] = $userinfo['username'];
			$_SESSION['password'] = bbhp($_POST['password']);
			$_SESSION['first_name'] = $userinfo['first_name'];
			$_SESSION['last_name'] = $userinfo['last_name'];
			$_SESSION['middle_name'] = $userinfo['middle_name'];
			$_SESSION['permission'] = $userinfo['permission'];
			$_SESSION['email'] = $userinfo['email'];
			mysqli_close($link);
		}
	}
	
	if(isset($_POST['logout'])) {
		session_unset();
		session_destroy();
	}
	
	if(!isset($_SESSION['status']) || $_SESSION['status'] != 1) {
		echo '
			<div class="access_info">
				<table>
					<tr>
						<th></th>
						<th><input type="text" name="username" style="margin-bottom: 0.5em;"></input></th>
						<th><label> :اسم المستخدم </label></th>
						<th></th>
					</tr>
					
					<tr>
						<th><input style="margin-right: 1em;" type="submit" value="تسجيل دخول" name="login_submit"></th>
						<th><input type="password" name="password"></input></th>
						<th><label> :الرقم السري  </label></th>
					</tr>
				</table>
			</div>
			
		';
	} else {
		
		echo '
			<div class="access_info">
				<table>
					<tr>
						<th><input type="submit" value="تسجيل خروج" name="logout"/></th>
						<th>'.$_SESSION['first_name'].'</th>
						<th><label> اهلن</label></th>
						
						
						
					</tr>
				</table>
			</div>
		';
	}
	
	
?>