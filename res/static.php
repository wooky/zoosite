<?php session_start();
if(!@$_SESSION['member'] || $_SESSION['member'] == "" || !count($_POST))
	header("Location: /");
try
{
	$db = new PDO("sqlite:../pla/news");
	$sth = $db->prepare("update staticmsg set contents=? where field=?");
	$sth->bindValue(1,$_POST['contents'],PDO::PARAM_STR);
	$sth->bindValue(2,$_POST['field'],PDO::PARAM_STR);
	$sth->execute();
	if($sth->rowCount() == 0)
		die("Failed to save your article!");
	header("Location: " . $_POST['ret']);
} catch(PDOException $e) {
	echo $e->getMessage();
}