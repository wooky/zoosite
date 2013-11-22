<?php session_start();
if(!@$_SESSION['member'] || $_SESSION['member'] == "")
{
	if(!@$_GET['ticket'] || $_GET['ticket'] == "")
		header("Location: https://cas.ucalgary.ca/cas/login?service=http://zoo.ucalgary.ca/admin/&ca.ucalgary.authent.mustpost=true");
	else
	{
		$cont = "<item xmlns:cas='http://schemas.google_apps_sync.com'>" .
			file_get_contents("https://cas.ucalgary.ca/cas/ucserviceValidate?ticket=" . $_GET['ticket'] .
			"&service=http://zoo.ucalgary.ca/admin/") .
			"</item>";
		$xml = simplexml_load_string($cont,null,0,"cas",TRUE);
		@$subelem = $xml->serviceResponse->authenticationSuccess->userOnly;
		if(!$subelem)
		{
			echo 'You have failed to log in. <a href=".">Click here to try again</a>.';
			echo '<hr>Full XML dump:<pre>';
			print_r($xml);
			echo '</pre><hr>Full file dump:<pre>' . $cont . '</pre>';
			exit();
		}
		try
		{	
			$db = new PDO("sqlite:../pla/news");
			$sth = $db->prepare("select id,it_uname,pla_auth from member where it_uname=?");
			$sth->bindValue(1,$subelem,PDO::PARAM_STR);
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			if($result['it_uname'] != $subelem)
				die("You are not a member of Zoo! If this is an error, contact one of the Zoo members or the Super Admin");
			$_SESSION['member'] = $result['id'];
			$_SESSION['pla_auth'] = $result['pla_auth'];
			header('Location: /');
		} catch(PDOException $e) {
			die("A database error ocurred: " . $e->getMessage());
		}
	}
}else
	header("Location: panel.php");
