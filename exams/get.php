<?php session_start();
//Logic here to check if the user is logged in, a member, or has not exceeded the allowed max amt of files
$fname = str_replace("/","",$_GET['f']);
if(!file_exists("files/$fname"))
{
	require_once("../res/template.php");
	headon("Exam not Found");
	echo '<div class="supertitle">Exam not Found</div>The exam you have requested to view was not found. Check your spelling and try again.';
	footon();
	exit;
}
//Logic here to subtract the amount of exams a user can view, if applicable
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=$fname");
@readfile("files/$fname");
