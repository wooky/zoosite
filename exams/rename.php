<?php session_start();
if(!isset($_SESSION['member']) || !isset($_GET))
	header('Location: /');
try
{
	$db = new PDO('sqlite:../pla/news');
	$sth = $db->prepare("insert or replace into examnames (name,description) values (?,?)");
	$sth->bindValue(1,$_GET['elem'],PDO::PARAM_STR);
	$sth->bindValue(2,$_GET['txt'],PDO::PARAM_STR);
	$sth->execute();
	header('Location: /exams/');
} catch(PDOException $e) {
	echo $e->getMessage();
}