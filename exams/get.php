<?php session_start();
if(!isset($_SESSION['member']) && !isset($_SESSION['payer']) && !isset($_SESSION['nonpayer']))
	header('Location: /exams/');

$fname = str_replace("/","",$_GET['f']);
if(!file_exists("files/$fname"))
{
	require_once("../res/template.php");
	headon("Exam not Found");
	echo '<div class="supertitle">Exam not Found</div>The exam you have requested to view was not found. Check your spelling and try again.';
	footon();
	exit;
}

if(isset($_SESSION['nonpayer']))
{
	$nonpayer = str_replace('.','_',$_SESSION['nonpayer']);
	if(isset($_COOKIE[$nonpayer]) && $_COOKIE[$nonpayer] <= 0)
		header('Location: /exams/');
	setcookie($nonpayer,(isset($_COOKIE[$nonpayer]) ? $_COOKIE[$nonpayer]-1 : 2),strtotime('tomorrow'));
}

header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=$fname");
@readfile("files/$fname");
