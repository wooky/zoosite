<?php session_start();
if(!@$_SESSION['member'])
	header("Location: /");
$_SESSION = array();
session_destroy();
header("Location: " . $_SERVER['HTTP_REFERER']);
?>
