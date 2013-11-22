<?php session_start();
if(!@$_SESSION['member'])
	header("Location: /");
require_once("../res/template.php");
headon("New User Status");
try
{
	$db = new PDO("sqlite:../pla/news");
	$sth = $db->prepare("select it_uname from member where it_uname=?");
	$sth->bindValue(1,$_POST['eid'],PDO::PARAM_STR);
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_ASSOC);
	if($result['it_uname'] == $_POST['eid'])
		echo "Error: a user with the same eid already exists. Please ask them to log in and change whatever values they need to";
	else
	{
		$sth = $db->prepare("insert into member (name,it_uname,rank,role,added_by) values (?,?,?,?,?)");
		$sth->bindValue(1,@$_POST['name'],PDO::PARAM_STR);
		$sth->bindValue(2,$_POST['eid'],PDO::PARAM_STR);
		$sth->bindValue(3,(@$_POST['rank']) ? $_POST['rank'] : null,PDO::PARAM_INT);
		$sth->bindValue(4,(@$_POST['role']) ? $_POST['role'] : null,PDO::PARAM_STR);
		$sth->bindValue(5,$_SESSION['member'],PDO::PARAM_INT);
		$sth->execute();
		if(!$sth->rowCount())
			echo "An error ocurred while adding a new user. Please try again or contact the admin if this problem persists.";
		else
			echo "Successfully added a new user!";
	}
} catch(PDOException $e) {
	echo "A database error ocurred: " . $e->getMessage();
}
echo '<p><a href="panel.php">Go back to Admin Panel</a> &middot; <a href="/">Go to homepage</a></p>';
footon();
