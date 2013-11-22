<?php session_start();
if(!@$_SESSION['member'] || !@$_GET['id'])
	header("Location: /");
try
{
	$db = new PDO("sqlite:../pla/news");
	$query = (@$_GET['method']) ? "update article set private=NULL where id=?" : "update article set private=1 where id=?";
	$sth = $db->prepare($query);
	$sth->bindValue(1,$_GET['id'],PDO::PARAM_INT);
	$sth->execute();
	if(!$sth->rowCount())
		die("Article not found");
	header("Location: " . ((@$_GET['ret'] && $_GET['ret'] != "") ? $_GET['ret'] : "/"));
} catch(PDOException $e) {
	die("Database error: " . $e->getMessage());
}
