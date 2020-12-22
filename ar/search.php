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
						<input type="submit" value="تعديل" name="edit" />
						<input type="submit" value="جديد" name="renew" />
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
									$pending_notes = '<p> <label float: right; class="clickableLabel" onClick="toggleDisplay(\'pending_notes'.$row['id'].'\')">:ملحضات للحاله </label> <div style="" id="pending_notes'.$row['id'].'" style="padding-left: 1em;">'.$row['pending_notes'].' </div></p><br/>';
								} else if(date_in_range($current_time, date("Y-m-d", strtotime("+90 day", $current_time)), $row['end_date'])) {
									$title_css = "near_expired";
								} else {
									$title_css = "active";
								}
								
								echo '
								<div class="entry">
									<div class="content">
										<div class="header">
											<text class="title"> <a href="search.php?warranty_id='.$row['warranty_id'].'" class="'.$title_css.'">'.$row['product_name'].'</a></text>
											<text class="date">'.$row['company_name'].'</text>
										</div><br/><hr/><br/>
										<input type="button" onClick="location.href=\'edit_warranty.php?id='.$row['id'].'\'")" value="تعديل" />
										<div class="details"><br/>
											<p style="float: right;"><text style="float: right">:الحاله </text>
												<text class="'.$title_css.'">'.strtoupper($title_css).'</text>
											</p><br/><br/>
											<p style="float: right;"><text style="float: right">:من تاريخ </text> <input style="background: lightgray;" type="text" name="end_date" id="end_date" value="'.date($prefs['date_format'], strtotime($row['end_date'])).'"readonly/> الى تاريخ <input style="background: lightgray;" type="text" name="start_date" id="start_date" value="'.date($prefs['date_format'], strtotime($row['start_date'])).'"readonly/></p><br/>
											<br/><br/><br/><p style="float: right;"><text style="float: right">:المبلغ </text> <input style="background: lightgray;" type="text" name="price" value="'.$row['price'].'"></input></p><br/>
											<br/><br/><br/>
											<p style="float: right;"><div id="pending_notes"><p>Pending Notes:</p> <text name="pending_notes" class="pending_notes">'.$row['pending_notes'].'</text></div></p><br/>
											<p style="float: right;"><div id="contact_info"><p style="float: right;">:معلومات التواصل</p> <br/><br/><br/><text name="contact_info" class="contact_info">'.$row['contact_info'].'</text></div></p><br/>
											<br/><br/><br/><br/><br/>
											<p style="float: right;"><div class="notes"><p style="float: right;">:ملاحظات</p><br/><br/><br/><text name="notes" id="notes" class="notes">'.$row['notes'].'</text></div></p><br/>
										';
										if (strpos($row['files'], ":") == 0)
											$row['files'] = substr($row['files'], 1);
										if(strpos($row['files'], ":") !== false) {
											$files = explode(":",  $row['files']);
										} else if($row['files'] != "") {
											echo $row['files'];
											$files = array($row['files']);
										}
										if(isset($files)) {
											echo '<label><input type="hidden" name="delete_files[]" value="-"/></label>';
											echo '<br/><br/><br/><br/><br/><br/><br/><p style="float: right;"> : الملفات</p> <div style="padding-left: 2em"><br/><br/><br/>';
											$j = 0;
											while($j < count($files)) {
												if($files[$j] != "") {
													
													if($j != 0)
														echo '<label style="float: right;">&nbsp;&nbsp; ,</label>';
													echo '<label style="float: right;"><a href="'.$files[$j].'">'.substr($files[$j], strrpos($files[$j], '/') + 1).'</a> </label>';
												}
												$j++;
											}
											echo '</div>';
										}
										
										echo '
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