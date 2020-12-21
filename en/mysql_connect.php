<?php
	function bhp($link, $dat) {
		return mysqli_escape_string($link, bbhp($dat));
	}
	
	function bbhp($dat) {
		return addslashes(stripslashes($dat));
	}
	
	function connectDatabase() {
		include_once "constants.php";
		$prefs = get_preferences();
		return mysqli_connect($prefs['mysql_host'], $prefs['mysql_username'], $prefs['mysql_password'], $prefs['mysql_database']);
	}
	function db_query($link, $username, $query) {
		$result = mysqli_query($link, $query);
		//record_query($link, $username, $query);
		return $result;
	}
	
	function record_query($link, $username, $query) {
		$prefs = get_preferences();
		$query = strtolower($query);
		$table = "";
		$entry_id = "";
		$action = "";
		$entry_log = "";
		//Get action
		if(substr($query, 0, 6) == 'update') {
			$action='edit';
			$query = substr($query, 7);
		}
		else if(substr($query, 0, 6) == 'delete') {
			$action='delete';
			$query = substr($query, 7);
		} else if(substr($query, 0, 11) == 'insert into') {
			$action='create';
			$query = substr($query, 12);
		}
		else
			return;
		//Get table name
		if(substr($query, 0, strlen($prefs['mysql_table_warranties'])) == $prefs['mysql_table_warranties']) {
			$table=$prefs['mysql_table_warranties'];
			$query = substr($query, strlen($prefs['mysql_table_warranties'])+1);
		}
		else if(substr($query, 0, strlen($prefs['mysql_table_users'])) == $prefs['mysql_table_users']) {
			$table=$prefs['mysql_table_users'];
			$query = substr($query, strlen($prefs['mysql_table_users'])+1);
		}
		else
			return;
		$table = str_replace('`', '', $table);
		
		//Get id
		if($action == 'create') {
			$entry_id = mysqli_insert_id($link);
		} else if(preg_match('/(\\d+)?\\s*id=\\s*(\\d+)?/i', $query, $regs) and count($regs) > 1) {
			if(!$regs[1] and !$regs[2])
				return;
			else
				$entry_id=floatval($regs[1] ? $regs[1] : $regs[2]);
		}
		
		//Get logging info
		if($action == 'edit') {
			$start = strpos($query, 'set');
			$end = strrpos($query, 'where');
			$entry_log = substr($query, $start, $end);
		} else if($action == 'create') {
			$entry_log = $query;
		}
		add_to_log($link, $username, $table, $entry_id, $action, $entry_log);
	}
	
	function add_to_log($link, $username, $table, $entry_id, $action, $entry_log) {
		$prefs = get_preferences();
		$query = 'INSERT INTO '.$prefs['mysql_table_log'].'
				(entry_table, entry_action, entry_id, entry_log, changed_by, date)
			VALUES
				("'.addslashes($table).'", "'.addslashes($action).'", "'.addslashes($entry_id).'", "'.addslashes($entry_log).'", "'.addslashes($username).'", "'.date("Y-m-d", strtotime("today")).'")';
		$result = mysqli_query($link, $query);
		mysqli_close($link);
	}
?>