<?php
	echo '
	<form class="control_menu" method="POST">
		<div class="access_info">
				<text> Username: (*) </text>
				<input type="text" name="username"></input>
				<br/>
				<text> Password: (*) </text>
				<input type="text" name="password"></input>
		</div>
		<div class="actions">
			<input type="submit" value="Edit" name="edit"/>
			<input type="submit" value="Delete" name="delete"/>
		</div>
	</form>
	';

?>