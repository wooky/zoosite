<?php
/*
 * IMPORTANT!
 * In calendar/connector/db_common.php, each of insert(), update(), and delete() must have the following code at the beginning:
	if(!@$_SESSION['member'] || $_SESSION['member'] == "")
		exit;
 * This is to prevent non-members from posting
 */

session_start();
require("calendar/connector/scheduler_connector.php");
require("calendar/connector/db_pdo.php");
 
$res = new PDO('sqlite:../pla/news');
 
$scheduler = new SchedulerConnector($res,"PDO");
$scheduler->render_table("events","id","start_date,end_date,text");
?>