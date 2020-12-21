<?php
	//echo get_pass_hash("admin", "pass");
	function authenticate($username, $password) {
		return check_pass_hash($username, $password);
	}
	function get_pass_hash($username, $password) {
		$pass_value = get_user_specific_pass($username, $password);
		return crypt_password($pass_value);
	}
	function check_pass_hash($username, $password) {
		$pass_value = get_user_specific_pass($username, $password);
		include_once 'mysql_connect.php';
		include_once "constants.php";
		$link = connectDatabase();
		$prefs = get_preferences();
		// Getting info on specified user.
		$query = "SELECT * FROM ".$prefs["mysql_table_users"]." WHERE username='".$username."'";
		$result_set = db_query($link, "Anonymous", $query);
		$user = mysqli_fetch_array($result_set);
		$pass_hash = $user['pass_hash'];
		return password_verify($pass_value, $pass_hash);
	}
	
	function crypt_password($pass_value) {
		$pass_value = password_hash($pass_value, PASSWORD_BCRYPT);
		return $pass_value;
	}
	function get_user_specific_pass($username, $password) {
		include_once 'mysql_connect.php';
		include_once "constants.php";
		$link = connectDatabase();
		$prefs = get_preferences();
		// Getting info on specified user.
		$query = "SELECT * FROM ".$prefs["mysql_table_users"]." WHERE username='".$username."'";
		$result_set = db_query($link, "Anonymous", $query);
		
		//Turning result set into an array.
		$rs_array = array();
		while($row = mysqli_fetch_array($result_set)) {
			$rs_array[] = $row;
		}
		if(sizeof($rs_array) != 1)
			return 1;
		//Saving strings as arrays.
		$email_arr = array();
		$user_name_arr = array();
		$password_arr = array();
		$first_name_arr = array();
		$last_name_arr = array();
		$birth_date_arr = array();
		$creation_date_arr = array();
		
		$email_arr = str_split($rs_array[0]['email']);
		$user_name_arr = str_split($rs_array[0]['username']);
		$password_arr = str_split($password);
		$first_name_arr = str_split($rs_array[0]['first_name']);
		$middle_name_arr = str_split($rs_array[0]['middle_name']);
		$last_name_arr = str_split($rs_array[0]['last_name']);
		$birth_date_arr = str_split($rs_array[0]['birth_date']);
		$creation_date_arr = str_split($rs_array[0]['creation_date']);
		
		//Constructing the pass value
		$inprogress = true;
		$finished = array("email" => false, "user_name" => false, "password" => false, "first_name" => false, "middle_name" => false, "last_name" => false, "birth_date" => false, "creation_date" => false);
		$indexes = array("email" => 0, "user_name" => 0, "password" => 0, "first_name" => 0, "middle_name" => 0, "last_name" => 0, "birth_date" => 0, "creation_date" => 0);
		$raw_string = "";
		while($inprogress == true) {
			if($indexes['email'] < sizeof($email_arr)) {
				$raw_string .= $email_arr[$indexes['email']];
				$indexes['email'] += 1;
			} else {
				$finished['email'] = true;
			}
			if($indexes['user_name'] < sizeof($user_name_arr)) {
				$raw_string .= $user_name_arr[$indexes['user_name']];
				$indexes['user_name'] += 1;
			} else {
				$finished['user_name'] = true;
			}
			if($indexes['password'] < sizeof($password_arr)) {
				$raw_string .= $password_arr[$indexes['password']];
				$indexes['password'] += 1;
			} else {
				$finished['password'] = true;
			}
			if($indexes['first_name'] < sizeof($first_name_arr)) {
				$raw_string .= $first_name_arr[$indexes['first_name']];
				$indexes['first_name'] += 1;
			} else {
				$finished['first_name'] = true;
			}
			if($indexes['middle_name'] < sizeof($middle_name_arr)) {
				$raw_string .= $middle_name_arr[$indexes['middle_name']];
				$indexes['middle_name'] += 1;
			} else {
				$finished['middle_name'] = true;
			}
			if($indexes['last_name'] < sizeof($last_name_arr)) {
				$raw_string .= $last_name_arr[$indexes['last_name']];
				$indexes['last_name'] += 1;
			} else {
				$finished['last_name'] = true;
			}
			if($indexes['birth_date'] < sizeof($birth_date_arr)) {
				$raw_string .= $birth_date_arr[$indexes['birth_date']];
				$indexes['birth_date'] += 1;
			} else {
				$finished['birth_date'] = true;
			}
			if($indexes['creation_date'] < sizeof($creation_date_arr)) {
				$raw_string .= $creation_date_arr[$indexes['creation_date']];
				$indexes['creation_date'] += 1;
			} else {
				$finished['creation_date'] = true;
			}
			if($finished["email"] && $finished["user_name"] && $finished["password"] && $finished["first_name"] && $finished["middle_name"] && $finished["last_name"] && $finished["birth_date"] && $finished["creation_date"]) {
				$inprogress = false;
			}
		}
		$pass_value = hash("md2", $raw_string);
		if(isset($prefs['security'])) {
			switch ($prefs['security']) {
				case 'none': $iter = 1; break;
				case 'low': $iter = 3000; break;
				case 'medium': $iter = 70000; break;
				case 'high': $iter = 200000; break;
				default: $iter = 50000; break;
			}
		} else {
			$iter = 50000;
		}
		for($i = 0; $i < $iter; $i++) {
			$pass_value = hash("md2", $raw_string);
		}
		return $pass_value;
	}
	
?>