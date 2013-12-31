<?php require_once('../res/template.php');
headon("Join/Sponsor");
try
{
	$db = new PDO("sqlite:../pla/news");
} catch(PDOException $e) {
	echo $e->getMessage();
}
echo '<div class="supertitle">JOIN/SPONSOR ZOO</div>';
staticText($db,"sponsor");
footon();
?>