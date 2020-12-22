<!DOCTYPE html>
<html>
	<head>
		<title>Warranty Managment System</title>
		
	</head>

	<body>
		<div class="wrapper">
			
			<?php
				include_once 'header.php';
				include_once 'required_imports.php';
			?>
			<script>
				$(document).ready(function(){
					$( function() {
						$( "#start_date" ).datepicker({dateFormat: "dd-mm-yy"});
						$( "#end_date" ).datepicker({dateFormat: "dd-mm-yy"});
					} );
					$('#status').on('change', function() {
						if ( this.value == 'pending')
						{
							$("#pending_notes").show();
						}
						else
						{
							$("#pending_notes").hide();
						}
					});
					tinymce.init({ selector:'textarea.notes'});
					tinymce.init({ selector:'textarea.pending_notes'});
					tinymce.init({ selector:'textarea.contact_info'});
					
					$("form").on("submit", function () {
						var hvalue = $('.pending_notes').text();
						$(this).append("<input type='hidden' name='pending_notes' value=' " + hvalue + " '/>");
						var hvalue = $('.contact_info').text();
						$(this).append("<input type='hidden' name='contact_info' value=' " + hvalue + " '/>");
					});
				});
			</script>
			<form method="POST" enctype="multipart/form-data">
				<div class="control_menu" >
					<?php
					include_once 'login.php';
					?>
					<div class="actions">
						<input type="submit" value="احفظ" name="create"/>
						<input type="submit" value="ارجع" name="cancel"/>
					</div>
				</div>
				<?php
				
				if(isset($_POST['status'])) {
					$status = $_POST['status'];
					if($_POST['status'] == 'canceled') {
						$canceled = 'selected';
					} else if($_POST['status'] == 'expired') {
						$expired = 'selected';
					} else if($_POST['status'] == 'pending') {
						$pending = 'selected';
					} else {
						$active = 'selected';
					}
				}
				
				echo '
					<div class="body_content">
						<div class="entry">
							<div class="content">
								<div class="header">
									<div class="title"><p>Product Name: </p><input type="text" name="product_name" value="'.@$_POST['product_name'].'"></input></div>
									
									<div class="date"><p>Company Name: </p><input type="text" name="company_name" value="'.@$_POST['company_name'].'"></input></div>
									
								</div>
								<hr/>
								<div class="details"><br/>
									<p>Warranty Period: <input type="text" name="start_date" id="start_date" value="'.@$_POST['start_date'].'"/> to <input type="text" name="end_date" id="end_date" value="'.@$_POST['end_date'].'"/></p><br/>
									<p>Price: <input type="text" name="price" value="'.@$_POST['price'].'"></input></p><br/>
									<p>Status: 
										<select name="status" id="status">
											<option value="active" '.@$active.'>Active</option>
											<option value="pending" '.@$pending.'>Pending</option>
											<option value="expired" '.@$expired.'>Expired</option>
											<option value="canceled" '.@$canceled.'>Canceled</option>
										</select>
									</p>
									<p><div id="pending_notes"><p>Pending Notes:</p> <textarea name="pending_notes" class="pending_notes">'.@$_POST['pending_notes'].'</textarea></div></p><br/>
									<div id="contact_info"><p>Contact Info:</p> <textarea name="contact_info" class="contact_info">'.@$_POST['contact_info'].'</textarea></div>
									<p>Notes: <div class="notes"><textarea name="notes" id="notes" class="notes">'.@$_POST['notes'].'</textarea></div></p><br/>
									<p> Upload File: </p> <div style="padding-bottom: 2em; padding-left: 2em">
										<input type="file" name="fileToUpload" id="fileToUpload"/>
									</div>
								</div>
							</div>
							<div class="actions" style="padding-top: 1em;">
								<br/><hr/><br/>
								<input type="submit" value="احفظ" name="create"/>
								<input type="submit" value="ارجع" name="cancel"/>
							</div>
						</div>
					</div>
			</form>
						<script>
							
						</script>
					';
						if(isset($_POST['cancel'])) {
							echo '<script type="text/javascript">window.location.assign("/index.html");</script>';
						}
						if(isset($_POST['create'])) {
							//Include necessaru files.
							include_once 'mysql_connect.php';
							include_once 'search_functions.php';
							include_once "user_auth.php";
							include_once 'constants.php';
							$prefs = get_preferences();
							$link = connectDatabase();
							
							//authenticate username and password.
							if(isset($_SESSION['status']) && $_SESSION['status'] == 1) {
								//Retrieving warranty id
								$result = db_query($link, $_SESSION['username'], 'SELECT max(warranty_id) FROM '.$prefs['mysql_table_warranties'].'');
								$warranty_id = mysqli_fetch_array($result)['max(warranty_id)'] + 1;
								$uploadOk = 1;
								$file_dir = "/uploads/" . basename($_FILES["fileToUpload"]["name"]);
								$target_file = "C://xampp/htdocs/" . $file_dir;
								print_r($_FILES["fileToUpload"]);
								if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
									
								} else if ($_FILES["fileToUpload"]['name'] != ""){
									$uploadOk = 0;
									echo "<script type='text/javascript'>alert('Could not upload file.')</script>";
									goto end_if_007;
									
								}
								//Creating warranty entry query
								$entry_query = 'INSERT INTO '. $prefs["mysql_table_warranties"] .'
									(warranty_id, product_name, company_name, status, pending_notes, price, contact_info, notes, start_date, end_date, created_by, creation_date, files)
									VALUES 
									  ( 
										"'.$warranty_id.'",
										"'.bhp($link, $_POST['product_name']).'", 
										"'.bhp($link, $_POST['company_name']).'",
										"'.bhp($link, $_POST['status']).'", 
										"'.bhp($link, $_POST['pending_notes']).'",
										"'.bhp($link, $_POST['price']).'",
										"'.bhp($link, $_POST['contact_info']).'",
										"'.bhp($link, $_POST['notes']).'",
										"'.date("Y-m-d", strtotime(bhp($link, $_POST['start_date']))).'",
										"'.date("Y-m-d", strtotime(bhp($link, $_POST['end_date']))).'",
										"' . $_SESSION['first_name'] . ' ' . $_SESSION['middle_name'] . ' ' . $_SESSION['last_name'] . '",
										"'.date("Y-m-d", strtotime("today")).'"';
										
										if($_FILES["fileToUpload"]['name'] != "") {
											$entry_query .= ', "'.$file_dir.'"';
										} else {
											$entry_query .= ', ""';
										}
										$entry_query.= ')';
								//echo $entry_query . '<br/><br/>';
								
								//Sending warranty query.
								$update_result = db_query($link, $_SESSION['username'], $entry_query);
								if(!$update_result){
									echo "<script type='text/javascript'>alert('Could not create warranty.')</script>";
									goto end_if_007;
								}
								
								//Redirecting to warranty page
								echo "<script type='text/javascript'>window.location.assign('search.php?warranty_id=".$warranty_id."')</script>";
							} else {
								echo "<script type='text/javascript'>alert('You must be logged in to create a warranty.')</script>";
							}
							end_if_007:
							mysqli_close($link);
						}
					?>
				
			
					
	</body>

</html>