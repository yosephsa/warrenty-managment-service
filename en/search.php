<?php
	include_once 'mysql_connect.php';
	if(!isset($_GET["warranty_id"]) || !is_numeric(bbhp($_GET["warranty_id"])) || bbhp($_GET["warranty_id"]) < 0) {
		header('Location: index.php');
		exit();
	}
?>
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
			
		

			<form method="POST">
				<div class="control_menu">
					<?php
						include_once 'login.php';
					?>
					<div class="actions">
						<input type="submit" value="Edit" name="edit" />
						<input type="submit" value="Renew" name="renew" />
					</div>
				</div>
				<div class="body_content">
				<script> 
					function toggleDisplay(id) {
						 //$('#'+id).toggle();
					}
				</script>
					
					<?php
						if(isset($_POST['edit'])) {
							if(isset($_SESSION['status']) && $_SESSION['status'] == 1) {
								include_once 'user_auth.php';
								$message = "";
								echo "<script type='text/javascript'>window.location.assign('edit_warranty.php?warranty_id=".bbhp($_GET['warranty_id'])."')</script>";
							} else {
								echo "<script type='text/javascript'>alert('You must be logged in.');</script>";
							}
							end_if_3031:
						}
						if(isset($_POST['renew'])) {
							if(isset($_SESSION['status']) && $_SESSION['status'] == 1) {
								include_once 'user_auth.php';
								$message = "";
								echo "<script type='text/javascript'>window.location.assign('add_entry.php?warranty_id=".bbhp($_GET['warranty_id'])."')</script>";
							} else {
								echo "<script type='text/javascript'>alert('You must be logged in.');</script>";
							}
							end_if_3041:
						}
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
							$status = "!canceled";
							if(isset($_GET['status'])) {
								$status = bbhp($_GET['status']);
							}
							$pending_notes = "";
							$price = "";
							$contact_info = "";
							$notes = "";
							$date_range = "";
							if(isset($_GET['date_range'])) {
								$date_range = bbhp($_GET['date_range']);
							}
							$created_by = "";
							$result = search_warranties($id, $warranty_id, $product_name, $company_name, $status, $pending_notes, $price, $contact_info, $notes, $date_range, $created_by);
							while($row = mysqli_fetch_array($result))
								$result_array[] = $row;
							
							$i = 0;
							while($i < count($result_array)) {
								$row = $result_array[$i];
								$i ++;
								$current_time = strtotime("today");
								$title_css = "";
								$pending_notes = "";
								if($row['status'] == 'canceled') {
									$title_css = "canceled";
								} else if($row['status'] == 'expired') {
									$title_css = "expired";
								} else if($row['status'] == 'pending') {
									$title_css = "pending";
									$pending_notes = '<p> <label class="clickableLabel" onClick="toggleDisplay(\'pending_notes'.$row['id'].'\')">Pending Notes: </label> <div id="pending_notes'.$row['id'].'" style="padding-left: 1em;">'.$row['pending_notes'].' </div></p><br/>';
								} else if(date_in_range($current_time, date("Y-m-d", strtotime("+90 day", $current_time)), $row['end_date'])) {
									$title_css = "near_expired";
								} else {
									$title_css = "active";
								}
								
								echo '
								<div class="entry">
									<div class="content">
										<div class="header">
											<text class="title"> <a href="/search.php?warranty_id='.$row['warranty_id'].'" class="'.$title_css.'">'.$row['product_name'].'</a></text>
											<text class="date">'.$row['company_name'].'</text>
										</div>
										<hr/>
										<div class="details"><br/>
											<p> Status: <text class="'.$title_css.'">'.strtoupper($title_css).'</text><label style="float: right;"><input type="button" onClick="location.href=\'edit_warranty.php?id='.$row['id'].'\'")" value="Edit Entry" /></label></p><br/>
											'.$pending_notes.'
											<p> Warranty Period: <text style="padding-left: 2em; color: #000066;">'.date($prefs['date_format'], strtotime($row['start_date'])). '</text> to <text style="color: #000066;">' .date($prefs['date_format'], strtotime($row['end_date'])).'</text></p><br/>
											<p> Price: '.$row['price'].' '.$prefs['currency'].'</p><br/>
											<p><label class="clickableLabel" onClick="toggleDisplay(\'contact_info'.$row['id'].'\')"> Contact Info: </label><div id="contact_info'.$row['id'].'" style="padding-left: 2em;">'.$row['contact_info'].'</div> </p><br/>
											<p><label class="clickableLabel" onClick="toggleDisplay(\'notes'.$row['id'].'\')"> Notes: </label><div id="notes'.$row['id'].'" style=" padding-left: 1em;">'.$row['notes'].'</div> </p><br/>
											';
								
								if (strpos($row['files'], ":") == 0)
											$row['files'] = substr($row['files'], 1);
								if(strpos($row['files'], ":") !== false) {
									$files = explode(":",  $row['files']);
								} else if($row['files'] != "") {
									$files = array($row['files']);
								}
								if(isset($files)) {
									echo '<label class="clickableLabel" onClick="toggleDisplay(\'files'.$row['id'].'\')"> Files: </label> <div id="files'.$row['id'].'" style="padding-left: 2em">';
									$j = 0;
									while($j < count($files)) {
										if($files[$j] == "") {
											$j++;
											continue;
										}
										if($j != 0)
											echo ', ';
										echo '<a href="'.$files[$j].'">'.substr($files[$j], strrpos($files[$j], '/') + 1).'</a>';
										$j++;
									}
									echo '</div><div style="padding-bottom: 1em;"></div>';
								}
								echo '
											<p> Created by: '.$row['created_by'].' </p><br/>
										</div>
									</div>
								</div>
								';
							}
						}
					?>
				</div>
			</form>
		</div>
	</body>

</html>