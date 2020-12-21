<?php
	notifyBrowser();
	$print_message = updateEntries();
	$print_message .= notifyOfExperation();
	if(isset($_GET['display']) && $_GET['display'] == 'true') {
		echo '<br/><hr/><br/>' . $print_message;
	}
	function updateEntries() {
		$print_message = "";
		//Include necessary files
		include_once 'mysql_connect.php';
		include_once 'constants.php';
		$prefs = get_preferences();
		$link = connectDatabase();
		//<-- SET EXPIRED --!>
		//Retrieve Warranties to update
		$query = 'SELECT * FROM '.$prefs['mysql_table_warranties'].' WHERE status="active" AND end_date < CURRENT_DATE()';
		$result = db_query($link, "Periodic Updater", $query);
		if(!$result || mysqli_num_rows($result) <= 0) {
			$print_message .= 'No warranty to update.<br/>';
			goto middle_if_123;
		}
		//Update warranties
		$query = 'UPDATE '.$prefs["mysql_table_warranties"].' SET status="expired" WHERE ';
		$i=0;
		while($row = mysqli_fetch_array($result)) {
			if($i!=0)
				$query.=' AND ';
			$query .= 'id='.$row["id"];
		}
		$print_message .= 'Update status query: '.$query.'<br/>';
		$result = db_query($link, "Periodic Updater", $query);
		middle_if_123:
		//<-- SET ACTIVE -->
		$query = 'SELECT * FROM '.$prefs['mysql_table_warranties'].' WHERE status="expired" AND end_date > CURRENT_DATE()';
		$result = db_query($link, "Periodic Updater", $query);
		if(!$result || mysqli_num_rows($result) <= 0) {
			$print_message .= 'No warranty to update.<br/>';
			return $print_message;
		}
		//Update warranties
		$query = 'UPDATE '.$prefs["mysql_table_warranties"].' SET status="active" WHERE ';
		$i=0;
		while($row = mysqli_fetch_array($result)) {
			if($i!=0)
				$query.=' AND ';
			$query .= 'id='.$row["id"];
		}
		$print_message .= 'Update status query: '.$query.'<br/>';
		$result = db_query($link, "Periodic Updater", $query);
		mysqli_close($link);
		
		return $print_message;
	}
	function notifyOfExperation() {
		if(!isset($_GET['send_email']) || addslashes($_GET['send_email']) != 'true')
			return '';
		$print_message = "";
		//Include necessary files.
		include_once 'PHPMailer/PHPMailerAutoload.php';
		include_once 'mysql_connect.php';
		include_once 'constants.php';
		$prefs = get_preferences();
		//Create instance of PHPMailer And configure
		$mail = new PHPMailer(); // create a new object
		$mail->SMTPDebug = 1;
		$mail->SMTPSecure = $prefs['email_smtp'];
		$mail->Host = $prefs['email_smtp_host'];
		$mail->Port = $prefs['email_smtp_port'];
		$mail->IsHTML(true);
		$mail->Username = $prefs['email_username'];
		$mail->Password = $prefs['email_password'];
		$mail->SetFrom($prefs['email_username']);
		$mail->AddReplyTo($prefs['email_username']);
		$mail->AddAddress($prefs['email_username']);
		

		$nd_start = date("Y-m-d", strtotime("today"));
		$nd_end = date("Y-m-d", strtotime("+90 days"));
		
		
		//Retrives warranties and emailers list.
		$query_warranties = 'SELECT * FROM '.$prefs['mysql_table_warranties'].' WHERE status="active" AND notification_count < 4 AND end_date between "'.$nd_start.'" AND "'.$nd_end.'"';
		$print_message .= 'Warranties Query = ' . $query_warranties . '<br/>';
		$query_notify = 'SELECT * FROM '.$prefs['mysql_table_users'].' WHERE notify=1';
		$print_message .= 'Notify Query = ' . $query_notify . '<br/>';
		$result_warranties = db_query("Periodic Updater", $query_warranties);
		$result_notify = db_query("Periodic Updater", $query_notify);
		if(!$result_notify) {
			$print_message .= 'No emailers to send to.';
			return $print_message;
		}
		if(!$result_warranties) {
			$print_message .= 'No warranties to notify about.';
			return $print_message;
		}
		//Creating necessary emailing fields.
		$subject = "Some warranties are expiring soon.";
		$message = "";
		$i = 0;
		
		//Add emailers to send list.
		$i = 0;
		while($row = mysqli_fetch_array($result_notify)) {
			$mail->AddAddress($row['email']);
		}
		
		//Composing email body.
		$message .= '
			<p>Dear Admin,</p>
			<p>The following warranties are ending soon.</p>
			<ul>
			';
		$i = 0;
		while($row = mysqli_fetch_array($result_warranties)) {
			$num_days_remaining;
			$letter_s = "s";
			switch($row['notification_count']) {
				case 0: $num_days_remaining=60; break;
				case 1: $num_days_remaining=30; break;
				case 2: $num_days_remaining=10; break;
				case 3: 
					$num_days_remaining=1; 
					$letter_s=''; 
					break;
			}
			$message .= '<li style="padding-left: 30px;">In '.$num_days_remaining.' day'.$letter_s.', <a href="/search.php/?id='.$row['id'].'">'.$row['product_name'].'</a> will expire.</li>';
		}
		$message .= '
			</ul>
			<p>To learn more you may click on a specific warranty or click here to see all <a href="/?date_range=60">near expiring warranties</a>.</p>
			<p>Thank you.</p>
			<p>&nbsp;</p>';
		//Compose email
		$mail->Subject = "Test";
		$mail->Body = $message;
		
		//Add email to print log.
		$print_message .= '<br/><br/> Email: <br/>
		<p style="padding-left: 30px;">
			Subject: '.$subject.'<br/>
			To: ...<br/>
			Message: <br/>'.$message.'<br/>
			
		</p>';
		//Send and report
		if(!$mail->Send()) {
		  echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else {
		  echo "Message sent!";
		}
		return $print_message;
	}
	function notifyBrowser() {
		//Include necessary files.
		include_once 'PHPMailer/PHPMailerAutoload.php';
		include_once 'mysql_connect.php';
		include_once 'constants.php';
		$prefs = get_preferences();
		
		$nd_start = date("Y-m-d", strtotime("today"));
		$nd_end = date("Y-m-d", strtotime("+90 days"));
		
		
		//Retrives warranties and emailers list.
		$query_warranties = 'SELECT * FROM '.$prefs['mysql_table_warranties'].' WHERE status="active" AND end_date between "'.$nd_start.'" AND "'.$nd_end.'"';
		$query_notify = 'SELECT * FROM '.$prefs['mysql_table_users'].' WHERE notify=1';
		$link = connectDatabase();
		$result_warranties = db_query($link, "Periodic Updater", $query_warranties);
		$result_notify = db_query($link, "Periodic Updater", $query_notify);
		if(!$result_notify) {
			return $print_message;
		}
		if(!$result_warranties) {
			echo 'no warranties';
			return;
		}
		//Creating necessary emailing fields.
		$subject = "Some warranties are expiring soon.";
		$message = "";
		$i = 0;
		
		
		//Composing email body.
		$message .= '
			<p>Dear Admin,</p>
			<p>The following warranties are ending soon.</p>
			<ul>
			';
		$i = 0;
		while($row = mysqli_fetch_array($result_warranties)) {
			$num_days_remaining = date("d", strtotime($row['end_date']) - strtotime("today"));
			$letter_s = "s";
			
			$message .= '<li style="padding-left: 30px;">In '.$num_days_remaining.' day'.$letter_s.', <a href="/search.php/?id='.$row['id'].'">'.$row['product_name'].'</a> will expire.</li>';
		}
		$message .= '
			</ul>
			<p>To learn more you may click on a specific warranty or click here to see all <a href="/?date_range=60">near expiring warranties</a>.</p>
			<p>Thank you.</p>
			<p>&nbsp;</p>';
		
		
	}
?>