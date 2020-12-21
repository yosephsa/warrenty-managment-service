<?php
function search_warranties($id, $warranty_id, $product_name, $company_name, $status, $pending_notes, $price, $contact_info, $notes, $date_range, $created_by) {
	include_once 'mysql_connect.php';
	include_once 'constants.php';
	$link = connectDatabase();
	$prefs = get_preferences();
	$search_fields = "";
	$entries_search_fields = "";
	$single_search = " end_date IN (SELECT MAX(end_date) FROM ".$prefs['mysql_table_warranties']." GROUP BY warranty_id)";
	if($id != "") {
		$search_fields .= " id = '".bhp($link, $id)."'";
		$single_search = "";
	} else if($warranty_id != "") {
		$search_fields .= " warranty_id = '".bhp($link, $warranty_id)."'";
		$single_search = "";
	} else {
		if($product_name != "") {
			if($search_fields != "")
				$search_fields .= "AND";
			$search_fields .= " product_name LIKE '%".bhp($link, $product_name)."%' ";
		}
		if($company_name != "") {
			if($search_fields != "")
				$search_fields .= "AND";
			$search_fields .= " company_name LIKE '%". bhp($link, $company_name)."%' ";
		}
		if($status != "") {
			if($search_fields != "")
				$search_fields .= "AND";
			if(substr($status, 0, 1) == '!')
				$search_fields .= " status!='".substr($status, 1)."' ";
			else
				$search_fields .= " status='".$status."' ";
		}
		if($pending_notes != "") {
			if($search_fields != "")
				$search_fields .= "AND";
			$search_fields .= " pending_notes LIKE '%". bhp($link, $pending_notes)."%' ";
		}
		if($price != "") {
			if($search_fields != "")
				$search_fields .= "AND";
			$search_fields .= " price='". bhp($link, $price)."' ";
		}
		if($contact_info != "") {
			if($search_fields != "")
				$search_fields .= "AND";
			$contact_info .= " price LIKE '%". bhp($link, $contact_info)."%' ";
		}
		if($notes != "") {
			if($search_fields != "")
				$search_fields .= "AND";
			$search_fields .= " notes LIKE '%". bhp($link, $notes)."%' ";
		}
		if($created_by != "") {
			if($search_fields != "")
				$search_fields .= "AND";
			$search_fields .= " created_by LIKE '%".bhp($link, $created_by)."%' ";
		}
		if($date_range != "") {
			if($search_fields != "")
				$search_fields .= "AND";
			if(substr($date_range, 0, 1) != "+" || substr($date_range, 0, 1) != "-")
				$date_range = "+".$date_range;
			$start = date("Y-m-d", strtotime("today"));
			$end = date("Y-m-d", strtotime($date_range . " days"));
			$search_fields .= " end_date between ".$start." and ".$end." ";
		}
	}
	$and = "AND";
	if($search_fields == "" || $single_search == "")
		$and = "";
	
	$query = "SELECT * FROM ".$prefs['mysql_table_warranties']." WHERE ".$single_search." ".$and." ".$search_fields." ORDER BY end_date DESC";
	//echo $query;
	$result_set = db_query($link, "Anonymous", $query);
	mysqli_close($link);
	return $result_set;
}

function date_in_range($start_date, $end_date, $date_input)
{
  // Convert to timestamp
  $start_ts = strtotime($start_date);
  $end_ts = strtotime($end_date);
  $user_ts = strtotime($date_input);

  // Check that user date is between start & end
  return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

?>