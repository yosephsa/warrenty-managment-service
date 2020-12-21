<?php
	include_once 'mysql_connect.php';
	if(isset($_GET["warranty_id"]) && is_numeric(bbhp($_GET["warranty_id"])) && bbhp($_GET["warranty_id"]) >= 0) {
		
	} else if(isset($_GET["id"]) && is_numeric(bbhp($_GET["id"])) && bbhp($_GET["id"]) >= 0) {

	} else {
		header('Location: index.php');
		exit();
	}
?>
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
					tinymce.init({
						selector: 'div.contact_info',
						theme: 'inlite',
						plugins: 'image table link paste contextmenu textpattern autolink',
						insert_toolbar: 'quickimage quicktable',
						selection_toolbar: 'bold italic | quicklink h2 h3 blockquote',
						inline: true
					});
					tinymce.init({
						selector: 'div.pending_notes',
						theme: 'inlite',
						plugins: 'image table link paste contextmenu textpattern autolink',
						insert_toolbar: 'quickimage quicktable',
						selection_toolbar: 'bold italic | quicklink h2 h3 blockquote',
						inline: true
					});
					
				});
			</script>
			<form method="POST" enctype="multipart/form-data">
				<div class="control_menu">
					<?php
					include_once 'login.php';
					?>
					<div class="actions">
						<input type="submit" value="Save" name="save"/>
						<input type="submit" value="Back" name="back"/>
					</div>
				</div>
				<div class="body_content">
					<?php
						if(isset($_GET['warranty_id']))
						{
							include_once 'mysql_connect.php';
							include_once 'search_functions.php';
							include_once 'constants.php';
							
							$prefs = get_preferences();
							
							$id = "";
							$warranty_id = bbhp($_GET['warranty_id']);
							$product_name = "";
							$company_name = "";
							$status = "";
							$pending_notes = "";
							$price = "";
							$contact_info = "";
							$notes = "";
							$date_range = "";
							$created_by = "";
							
							$result = search_warranties($id, $warranty_id, $product_name, $company_name, $status, $pending_notes, $price, $contact_info, $notes, $date_range, $created_by);
							if(!$result || mysqli_num_rows($result) <= 0) {
								echo '<script>alert("No such warranty Exists")</script>';
								goto end_if_987;
							}
							$warranty = mysqli_fetch_array($result);
						
							$current_time = strtotime("today");
							if(isset($_POST['product_name']))
								$warranty['product_name'] = $_POST['product_name'];
							if(isset($_POST['company_name']))
								$warranty['company_name'] = $_POST['company_name'];
							echo '
								<div class="entry">
									<div class="content">
										<div class="header">
											<div class="title"><p>Product Name: </p><input type="text" name="product_name" value="'.$warranty['product_name'].'"></input></div>
											<div class="date"><p>Company Name: </p><input type="text" name="company_name" value="'.$warranty['company_name'].'"></input></div>
										</div>
									</div>
									<div class="actions" style="padding-top: 1em;">
										<br/><br/><hr/><br/>
										<input type="submit" value="Save" name="save"/>
									</div>
								</div>
								<script>tinymce.init({ selector:\'textarea\' });</script>
							';
							end_if_987:
						}
						if(isset($_GET['id']))
						{
							include_once 'mysql_connect.php';
							include_once 'search_functions.php';
							include_once 'constants.php';
							
							$prefs = get_preferences();
							
							$id = bbhp($_GET['id']);
							$warranty_id = "";
							$product_name = "";
							$company_name = "";
							$status = "";
							$pending_notes = "";
							$price = "";
							$contact_info = "";
							$notes = "";
							$date_range = "";
							$created_by = "";
							
							$result = search_warranties($id, $warranty_id, $product_name, $company_name, $status, $pending_notes, $price, $contact_info, $notes, $date_range, $created_by);
							if(!$result || mysqli_num_rows($result) <= 0) {
								echo '<script>alert("No such warranty Exists")</script>';
								goto end_if_989;
							}
							$warranty = mysqli_fetch_array($result);
							
							
							if(isset($_POST['end_date']))
								$warranty['end_date'] = $_POST['end_date'];
							if(isset($_POST['start_date']))
								$warranty['start_date'] = $_POST['start_date'];
							if(isset($_POST['price']))
								$warranty['price'] = $_POST['price'];
							if(isset($_POST['pending_notes']))
								$warranty['pending_notes'] = $_POST['pending_notes'];
							if(isset($_POST['contact_info']))
								$warranty['contact_info'] = $_POST['contact_info'];
							if(isset($_POST['notes']))
								$warranty['notes'] = $_POST['notes'];
							if(isset($_POST['status']))
								$warranty['status'] = $_POST['status'];
							
							
							$current_time = strtotime("today");
							
							if($warranty['status'] == 'canceled') {
								$title_css = "canceled";
								$canceled = 'selected';
							} else if($warranty['status'] == 'expired') {
								$title_css = "expired";
								$expired = 'selected';
							} else if($warranty['status'] == 'pending') {
								$title_css = "pending";
								$pending = 'selected';
							} else if(date_in_range($current_time, date("Y-m-d", strtotime("+90 day", $current_time)), $warranty['end_date'])) {
								$title_css = "near_expired";
								$active = 'selected';
							} else {
								$title_css = "active";
								$active = 'selected';
							}
							
							echo '
								<input type="hidden" name="warranty_id" value="'.$warranty['warranty_id'].'">
								<div class="entry">
									<div class="content">
										<div class="header">
											<text class="title"> <a href="/search.php?warranty_id='.$warranty['warranty_id'].'" class="'.$title_css.'">'.$warranty['product_name'].'</a></text>
											<text class="date">'.$warranty['company_name'].'</text>
										</div><br/><hr/><br/>
										<div class="details"><br/>
											<p>Warranty Period: <input type="text" name="start_date" id="start_date" value="'.date($prefs['date_format'], strtotime($warranty['start_date'])).'"/> to <input type="text" name="end_date" id="end_date" value="'.date($prefs['date_format'], strtotime($warranty['end_date'])).'"/></p><br/>
											<p>Price: <input type="text" name="price" value="'.$warranty['price'].'"></input></p><br/>
											<p>Status: 
												<select name="status" id="status">
													<option value="active" '.@$active.'>Active</option>
													<option value="pending" '.@$pending.'>Pending</option>
													<option value="expired" '.@$expired.'>Expired</option>
													<option value="canceled" '.@$canceled.'>Canceled</option>
												</select>
											</p>
											<p><div id="pending_notes"><p>Pending Notes:</p> <textarea name="pending_notes" class="pending_notes">'.$warranty['pending_notes'].'</textarea></div></p><br/>
											<div id="contact_info"><p>Contact Info:</p> <textarea name="contact_info" class="contact_info">'.$warranty['contact_info'].'</textarea></div>
											<p>Notes: <div class="notes"><textarea name="notes" id="notes" class="notes">'.$warranty['notes'].'</textarea></div></p><br/>
										';
										if (strpos($warranty['files'], ":") == 0)
											$warranty['files'] = substr($warranty['files'], 1);
										if(strpos($warranty['files'], ":") !== false) {
											$files = explode(":",  $warranty['files']);
										} else if($warranty['files'] != "") {
											echo $warranty['files'];
											$files = array($warranty['files']);
										}
										if(isset($files)) {
											echo '<label><input type="hidden" name="delete_files[]" value="-"/></label>';
											echo '<p> Delete Files: </p> <div style="padding-left: 2em">';
											$j = 0;
											while($j < count($files)) {
												if($files[$j] != "") {
													
													if($j != 0)
														echo ', ';
													echo '<label><input type="checkbox" name="delete_files[]" value="'.$files[$j].'"/>'.substr($files[$j], strrpos($files[$j], '/') + 1).'</label>';
												}
												$j++;
											}
											echo '</div>';
										}
										
										echo '
										<p> Upload File: </p> <div style="padding-left: 2em">
											<input type="file" name="fileToUpload" id="fileToUpload"/>
										</div>
										</div>
										<div class="actions" style="padding-top: 1em;">
											<hr/><br/>
											<input type="submit" value="Save" name="save"/>
										</div>
								</div>
								<script>tinymce.init({ selector:\'textarea\' });</script>
							';
							end_if_989:
						}
						if(isset($_POST['back'])) {
							if(isset($_POST['warranty_id'])) {
								echo "<script type='text/javascript'>window.location.assign('search.php?warranty_id=".bbhp($_POST['warranty_id'])."')</script>";
							} else {
								$result = search_warranties(bbhp($_GET['id']), "" , "", "", "", "", "", "", "", "", "");
								$warranty = mysqli_fetch_array($result);
								echo "<script type='text/javascript'>window.location.assign('search.php?warranty_id=".bbhp($warranty['warranty_id'])."')</script>";
							}
						}
						if(isset($_GET['warranty_id']) && (isset($_POST['cancel']) || isset($_POST['save']))) {
							include_once 'mysql_connect.php';
							include_once 'search_functions.php';
							include_once "user_auth.php";
							include_once 'constants.php';
							$prefs = get_preferences();
							$link = connectDatabase();
							if(isset($_SESSION['status']) && $_SESSION['status'] == 1) {
								$result_set = search_warranties("", bbhp($_GET['warranty_id']), "", "", "", "", "", "", "", "", "");
								$warranty_id = bbhp($_GET['warranty_id']);
								$id = mysqli_fetch_array($result_set)['id'];
								if(!is_numeric($id)) {
								
								} else if(isset($_POST['save'])) {
									
									//Creating query string
									$query = "UPDATE ". $prefs["mysql_table_warranties"] ." 
										SET 
											product_name=\"".bhp($link, $_POST['product_name'])."\", 
											company_name=\"".bhp($link, $_POST['company_name'])."\"
											";
									
									$query.=" 
										WHERE
											warranty_id=".$warranty_id."
											";
									//Sending query.
									$update_result = db_query($link, $_SESSION['username'], $query);
									
									
									if(!$update_result) {
										echo "<script type='text/javascript'>alert('Could not update warranty.')</script>";
									} else {
										echo "<script type='text/javascript'>window.location.assign('search.php?warranty_id=".$_GET['warranty_id']."')</script>";
									}
								}
							} else {
								echo "<script type='text/javascript'>alert('You must be logged in.')</script>";
							}
							
						} else if(isset($_GET['id']) || isset($_POST['save'])) {
							include_once 'mysql_connect.php';
							include_once 'search_functions.php';
							include_once "user_auth.php";
							include_once 'constants.php';
							$prefs = get_preferences();
							$link = connectDatabase();
							if(isset($_SESSION['status']) && $_SESSION['status'] == 1) {
								if(isset($_POST['save'])) {
									$uploadOk = 1;
									$file_dir = "/uploads/" . basename($_FILES["fileToUpload"]["name"]);
									$target_file = "C://xampp/htdocs/" . $file_dir;
									print_r($_FILES["fileToUpload"]);
									if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
										
									} else if ($_FILES["fileToUpload"]['name'] != ""){
										$uploadOk = 0;
										goto end_if_3d07;
										echo "<script type='text/javascript'>alert('Could not upload file.')</script>";
									}
									//Creating query string
									$query = 'UPDATE '. $prefs["mysql_table_warranties"] .'
										SET 
											status="'.bhp($link, $_POST['status']).'",
											pending_notes="'.bhp($link, $_POST['pending_notes']).'",
											price="'.bhp($link, $_POST['price']).'",
											contact_info="'.bhp($link, $_POST['contact_info']).'",
											notes="'.bhp($link, $_POST['notes']).'", 
											start_date="'.date('Y-m-d', strtotime(bhp($link, $_POST['start_date']))).'",
											end_date="'.date('Y-m-d', strtotime(bhp($link, $_POST['end_date']))).'"
											';
									
									if(isset($_POST['delete_files']) && is_array($_POST['delete_files'])) {
										$files = $_POST['delete_files'];
										$size = count($files);
										for($i = 0; $i < $size; $i++) {
											if($files[$i] != "-") {
												$query .= ', files = REPLACE(files, "'.$files[$i].':", "") ';
												$query .= ', files = REPLACE(files, ":'.$files[$i].'", "") ';
												$query .= ', files = REPLACE(files, "'.$files[$i].'", "") ';
											}
										}
									}
									if($_FILES["fileToUpload"]['name'] != "") {
										$query .= ', files = CONCAT(files, ":'.$file_dir.'")';
									}
									$query .= '
										WHERE
											id='.bhp($link, $_GET['id']).'
											';
									//Sending query.
									$update_result = db_query($link, $_SESSION['username'], $query);
									if(!$update_result) {
										echo "<script type='text/javascript'>alert('Could not update warranty.')</script>";
									} else {
										echo "<script type='text/javascript'>window.location.assign('search.php?warranty_id=".bbhp($_POST['warranty_id'])."')</script>";
									}
									end_if_3d07:
								}
							} else {
								echo "<script type='text/javascript'>alert('You must be logged in.')</script>";
							}
							mysqli_close($link);
						}
						
					?>
				
				</div>
			</form>
		</div>
	</body>

</html>