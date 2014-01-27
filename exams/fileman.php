<?php session_start();
if(!isset($_SESSION['member']) || !isset($_GET['fname']) || !isset($_GET['act']))
	header('Location: .');

if($_GET['act'] == 'delete' && unlink('files/' . $_GET['fname']) === FALSE)
	die("Exam not found!");
elseif($_GET['act'] == 'move' && isset($_GET['dest']) && rename('files/' . $_GET['fname'], 'files/' . $_GET['dest']) === FALSE)
	die("Failed to rename exam!");
header('Location: .');
