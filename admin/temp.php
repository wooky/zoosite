<?php session_start();
if(!@$_SESSION['member'])
	header("Location: /");
?>
<form method="get" action="/news/editor.php">Edit article #<input type="text" name="edit"> (leave empty to create a new one)
<br><input type="submit" value="Go!"></form>
