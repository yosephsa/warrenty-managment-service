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
						<input type="submit" value="احفظ" name="save"/>
						<input type="submit" value="ارجع" name="back"/>
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
							
							$title_css = "active";
							
							echo '
								<input type="hidden" name="warranty_id" value="'.$warranty['warranty_id'].'">
								<input type="hidden" name="product_name" value="'.$warranty['product_name'].'">
								<input type="hidden" name="company_name" value="'.$warranty['company_name'].'">
								<div class="entry">
									<div class="content">
										<div class="header">
											<text class="title"> <a href="search.php?warranty_id='.$warranty['warranty_id'].'" class="'.$title_css.'">'.$warranty['product_name'].'</a></text>
											<text class="date">'.$warranty['company_name'].'</text>
										</div><br/><hr/><br/>
										<div class="details"><br/>
											<p style="float: right;"><text style="float: right">:المدة </text> <input type="text" name="start_date" id="start_date" value="'.date($prefs['date_format'], strtotime($warranty['end_date'])).'"/> to <input type="text" name="end_date" id="end_date" value="'.date($prefs['date_format'], strtotime("+30 days ", strtotime($warranty['end_date']))).'"/></p><br/>
											<br/><br/><br/><p style="float: right;"><text style="float: right">:السعر </text>  <input type="text" name="price" value="'.$warranty['price'].'"></input></p><br/>
											<br/><br/><br/><p style="float: right;"><text style="float: right">:الحاله </text>
												<select name="status" id="status">
													<option value="active" selected>Active</option>
													<option value="pending">Pending</option>
													<option value="expired">Expired</option>
													<option value="canceled">Canceled</option>
												</select>
											</p>
											<br/><br/><br/><br/><p style="float: right;"><div id="pending_notes"><p style="padding-left: 80%">:ملاحضات الحالة</p><textarea name="pending_notes" class="pending_notes">'.$warranty['pending_notes'].'</textarea></div></p><br/>
											<p style="float: right;"><div id="contact_info"><p style="float: right;">:معلمات التواصل</p> <textarea name="contact_info" class="contact_info">'.$warranty['contact_info'].'</textarea></div>
											<p style="float: right;"><div class="notes"><p style="float: right;">:ملحظات</p><br/><br/><br/><textarea name="notes" id="notes" class="notes">'.$warranty['notes'].'</textarea></div></p><br/>
										';
										if (strpos($warranty['files'], ":") == 0)
											$warranty['files'] = substr($warranty['files'], 1);
										if(strpos($warranty['files'], ":") !== false) {
											$files = explode(":",  $warranty['files']);
										} else if($warranty['files'] != "") {
											//echo $warranty['files'];
											$files = array($warranty['files']);
										}
										if(isset($files)) {
											echo '<label><input type="hidden" name="include_files[]" value="-"/></label>';
											echo '<p> Include Files: </p> <div style="padding-left: 2em">';
											$j = 0;
											while($j < count($files)) {
												if($files[$j] != "") {
													if($j != 0)
														echo ', ';
													echo '<label><input type="checkbox" name="include_files[]" value="'.$files[$j].'"/>'.substr($files[$j], strrpos($files[$j], '/') + 1).'</label>';
												}
												$j++;
											}
											echo '</div>';
										}
										
										echo '
										
										
										<br/><br/><br/><br/><br/><p style="float: right;"> حمل ملفات: </p> <div style="padding-left: 2em">
											<div style="float: right;"><br/><br/><br/><input style="float: right;" type="file" name="fileToUpload" id="fileToUpload"/></div>
										</div>
										<div style="float: left;"><br/><br/><br/><br/><br/><input style="float: right;" type="submit" value="Save" name="save"/></div>
										
								</div>
								<script>tinymce.init({ selector:\'textarea\' });</script>
							';
							end_if_987:
						}
						if(isset($_POST['back'])) {
							echo '<script type="text/javascript">window.history.go(-2);</script>';
						}
						
						if(isset($_GET['warranty_id']) && isset($_POST['create'])) {
							include_once 'mysql_connect.php';
							include_once 'search_functions.php';
							include_once "user_auth.php";
							include_once 'constants.php';
							$prefs = get_preferences();
							$link = connectDatabase();
							if(isset($_SESSION['status']) && $_SESSION['status'] == 1) {
								$uploadOk = 1;
								$file_dir = "/uploads/" . basename($_FILES["fileToUpload"]["name"]);
								$target_file = "C://xampp/htdocs/" . $file_dir;
								print_r($_FILES["fileToUpload"]);
								if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
									
								} else if ($_FILES["fileToUpload"]['name'] != ""){
									$uploadOk = 0;
									echo "<script type='text/javascript'>alert('Could not upload file.')</script>";
									goto end_if_3d0s7;
									
								}
								//Creating query string
								$query = 'INSERT INTO '. $prefs["mysql_table_warranties"] .'
										(warranty_id, product_name, company_name, status, pending_notes, price, contact_info, notes, start_date, end_date, created_by, creation_date, files)
									VALUES
										("'.bhp($link, $_POST['warranty_id']).'", "'.bhp($link, $_POST['product_name']).'",
										"'.bhp($link, $_POST['company_name']).'", "'.bhp($link, $_POST['status']).'",
										"'.bhp($link, $_POST['pending_notes']).'", "'.bhp($link, $_POST['price']).'",
										"'.bhp($link, $_POST['contact_info']).'", "'.bhp($link, $_POST['notes']).'",
										"'.date('Y-m-d', strtotime(bhp($link, $_POST['start_date']))).'",
										"'.date('Y-m-d', strtotime(bhp($link, $_POST['end_date']))).'",
										"'.$_SESSION['first_name'].' '.$_SESSION['middle_name'].' '.$_SESSION['last_name'].'",
										"'.date('Y-m-d', strtotime("today")).'", "';
										
										if(isset($_POST['include_files']) && is_array($_POST['include_files'])) {
											$files = $_POST['include_files'];
											$size = count($files);
											for($i = 0; $i < $size; $i++) {
												if($files[$i] != "-"){
													if($i == 0)
														$query .= $files[$i];
													else
														$query .= ':'.$files[$i];
												}
											}
										}
										if($_FILES["fileToUpload"]['name'] != "") {
											$query .= ':'.$file_dir;
										} else {
											$query .= ', ""';
										}
										
										$query .= '")';
										//echo htmlentities($query);
								//Sending query.
								$update_result = db_query($link, $_SESSION['username'], $query);
								if(!$update_result) {
									echo "<script type='text/javascript'>alert('Could not update warranty.')</script>";
								} else {
									echo "<script type='text/javascript'>window.location.assign('search.php?id=".bbhp($_POST['warranty_id'])."')</script>";
								}
								end_if_3d0s7:
							} else {
								echo "<script type='text/javascript'>alert('You must be logged in.')</script>";
							}
							end_if_008:
							mysqli_close($link);
						}
						
					?>
				
				</div>
			</form>
		</div>
	</body>

</html>