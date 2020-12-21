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
						<th><label> Username (*): </label></th>
						<th><input type="text" name="username" style="margin-bottom: 0.5em;"></input></th>
						<th></th>
					</tr>
					
					<tr>
						<th><label> Password (*):  </label></th>
						<th><input type="password" name="password"></input></th>
						<th><input style="margin-left: 1em;" type="submit" value="Login" name="login_submit"></th>
					</tr>
				</table>
			</div>
			
		';
	} else {
		
		echo '
			<div class="access_info">
				<table>
					<tr>
						<th><label> Hello</label></th>
						<th>'.$_SESSION['first_name'].'</th>
						<th><input type="submit" value="Logout" name="logout"/></th>
						
					</tr>
				</table>
			</div>
		';
	}
	
	
?>