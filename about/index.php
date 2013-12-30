<?php require_once('../res/template.php');
headon("About Zoo");
try
{
	$db = new PDO("sqlite:../pla/news");
} catch(PDOException $e) {
	echo $e->getMessage();
}
echo '<div class="supertitle">About Zoo</div>';
staticText($db,"aboutzoo");
echo '<hr><div class="smallertitle">Message from the President</div>';
staticText($db,"prezmsg");
footon();
?>