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
			<form class="search" method="POST">
				
				<div style="float: right;">
					<table style="float: right;">
						<tr>
							<th><input type="text" name="product_name" style="margin-bottom: 0.5em;"/></th>
							<th><label> :اسم الضمان </label></th>
						</tr>
						<tr>
							<th><input type="text" name="company_name" style="margin-bottom: 0.5em;"/></th>
							<th><label> :اسم الشركه </label></th>
						</tr>
						<tr>
							<th><input type="text" name="date_range"/></th>
							<th><label> :(ينتهي بعد (أيام </label></th>
						</tr>
					</table>
					<table style="float: right;">
						<tr>
							<th><input type="text" name="created_by" style="margin-bottom: 0.5em;"/></th>
							<th><label> :إستضاف بي </label></th>
						</tr>
						<tr>
							<th><input type="text" name="notes"/></th>
							<th><label>:ملاحظات </label></th>
						</tr>
					</table>
				</div>
				<div class="submission">
					<input type="submit" name="submit" value="أعرض" onClick="location.reload(false);" id="submit" />
					<input type="text" name="result_amount" id="result_amount" value="30" style="width: 2em;"/> 
					<label>عرض اضمنات</label>
				</div>
			</form>
			<div class="body_content">
				<?php
					include_once 'mysql_connect.php';
					include_once 'search_functions.php';
					//For some reason I still can't find submit from post for some reason.
					if(isset($_POST['submit']))
					{
						$result_amount = bbhp($_POST['result_amount']);
						
						$id = "";
						$warranty_id = "";
						$product_name = bbhp($_POST['product_name']);
						$company_name = bbhp($_POST['company_name']);
						$status = "";
						if(isset($_GET['status'])) {
							$status = bbhp($_GET['status']);
						}
						$pending_notes = bbhp($_POST['notes']);
						$price = "";
						$contact_info = bbhp($_POST['notes']);
						$notes = bbhp($_POST['notes']);
						$date_range = bbhp($_POST['date_range']);
						if(isset($_GET['date_range'])) {
							$date_range = bbhp($_GET['date_range']);
						}
						$created_by = bbhp($_POST['created_by']);
						
						search($id, $warranty_id, $product_name, $company_name, $status, $pending_notes, $price, $contact_info, $notes, $date_range, $created_by, $result_amount);
						
					} else {
						$result_amount = 30;
						
						$id = "";
						$warranty_id = "";
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
						
						search($id, $warranty_id, $product_name, $company_name, $status, $pending_notes, $price, $contact_info, $notes, $date_range, $created_by, $result_amount);
						
					}
					
					function search($id, $warranty_id, $product_name, $company_name, $status, $pending_notes, $price, $contact_info, $notes, $date_range, $created_by, $result_amount) {
						
						include_once 'mysql_connect.php';
						include_once 'search_functions.php';
						include_once 'constants.php';
						$prefs = get_preferences();
						$result_set = search_warranties($id, $warranty_id, $product_name, $company_name, $status, $pending_notes, $price, $contact_info, $notes, $date_range, $created_by);
						$i = 0;
						while(($row = mysqli_fetch_array($result_set)) && $i < $result_amount) {
							$id = $row['warranty_id'];
							$product_name = $row['product_name'];
							$company_name = $row['company_name'];
							$created_by = $row['created_by'];
							$creation_date = $row['creation_date'];
							$current_time = strtotime("today");
							$title_css = "";
							$status = $row['status'];
							$end_date = $row['end_date'];
							$start_date = $row['start_date'];
							
							if($status == 'canceled') {
								$title_css = "canceled";
							} else if($status == 'pending') {
								$title_css = "pending";
							} else if($status == 'expired') {
								$title_css = "expired";
							} else if(date_in_range($current_time, date("Y-m-d", strtotime("+90 day", $current_time)), $end_date)) {
								$title_css = "near_expired";
							} else {
								$title_css = "active";
							}
							echo "<div class=\"entry_brief\">
								<div class=\"content\">
									<div class=\"title\">
										<text> <a href=\"search.php?warranty_id=".$id."\" class=\"".$title_css."\">".$product_name."</a> </text>
									</div>
									<div class=\"details\">
										<text> ".$company_name." </text>
									</div>
								</div>
								<div class=\"date\">
									<text>".date($prefs['date_format'], strtotime($end_date))."</text>
								</div>
							</div>";
							$i = $i + 1;
						}
					}
				?>
			</div>
		</div>
	</body>

</html>