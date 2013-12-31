<?php require_once('../res/template.php');
headon("About Zoo");
try
{
	$db = new PDO("sqlite:../pla/news");
} catch(PDOException $e) {
	echo $e->getMessage();
}
echo '<div class="supertitle">ABOUT ZOO</div>';
staticText($db,"aboutzoo");
footon();
?>