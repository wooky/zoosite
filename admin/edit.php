<?php session_start();
if(@!$_SESSION['member'])
	header("Location: /");
require_once("../res/template.php");
headon("Edit Profile");
try
{
	$db = new PDO("sqlite:../pla/news");
	$sth = $db->prepare("update member set name=?,role=?,email=?,facebook=?,twitter=? where id=?");
	$sth->bindValue(1,@$_POST['name'],PDO::PARAM_STR);
	$sth->bindValue(2,@$_POST['role'],PDO::PARAM_STR);
	$sth->bindValue(3,@$_POST['email'] ? $_POST['email'] : null,PDO::PARAM_STR);
	$sth->bindValue(4,@$_POST['facebook'] ? $_POST['facebook'] : null,PDO::PARAM_STR);
	$sth->bindValue(5,@$_POST['twitter'] ? $_POST['twitter'] : null,PDO::PARAM_STR);
	$sth->bindValue(6,@$_SESSION['member'],PDO::PARAM_INT);
	$sth->execute();
	if($sth->rowCount())
		echo "<p>Successfully updated your profile!</p>";
	else
		echo "<p>Oh noes! Failed to update your profile for some reason! D:</p>";
} catch(PDOException $e) {
	echo "An error occurred: " . $e->getMessage();
	footon();
	die();
}

$err = array();
if($_FILES['profpic']['name'])
{
	$result = $db->query("select it_uname from member where id=" . $_SESSION['member'])->fetch(PDO::FETCH_ASSOC);
	if($_FILES['profpic']['type'] != "image/jpeg")
		$err[] = "The type of the photo is not a JPEG";
	if($_FILES['profpic']['size'] == 0)
		$err[] = "Your photo's file size was too big (maximum is 100kb)";
	@$p = getimagesize($_FILES['profpic']['tmp_name']);
	if(@$p[0] < 190 || @$p[0] > 210 || @$p[1] < 190 || @$p[1] > 210)
		$err[] = "Your photo is not around 200X200 (detected " . $p[0] . "X" . $p[1] . ")";
	if(!count($err) && !move_uploaded_file($_FILES['profpic']['tmp_name'],"../contact/" . $result['it_uname'] . ".jpg"))
		$err[] = "Failed to move the photo to the proper directory";
		
	if(count($err))
	{
		echo "<p><b>...However...</b></p><p>Your photo failed to upload due to the following reasons:<ul>";
		foreach($err as $m)
			echo "<li>$m</li>";
		echo "</ul></p>";
	} else
		echo "<p>Additionally, your profile pic has been updated.</p>";
}
echo '<p><a href=".">Click here to go back to the Admin Panel</a> &middot; <a href="/">Home Page</a></p>';
footon();?>
