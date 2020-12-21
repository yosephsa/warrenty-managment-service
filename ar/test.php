<?php
include 'required_imports.php'; 
?>
<html>
	<script>
		function toggleDisplay(id) {
			 $('#'+id).toggle();
		}
	</script>

	<label onClick="toggleDisplay('files14')">Click Here</label>
	<div id="files14" class="files14">Content</div>
</html>