<?php
include_once 'constants.php';
include_once 'periodic.php'; 
$prefs = get_preferences();
if(!isset($prefs['initialized'])) {
	echo '<script>window.location.assign("setup.php");</script>';
}
?>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>