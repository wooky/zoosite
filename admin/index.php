<?php session_start();
if(!isset($_SESSION['member']) && !isset($_SESSION['payer']) && !isset($_SESSION['nonpayer']))
{
	if(!isset($_GET['ticket']))
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
			$sth = $db->prepare("select id,it_uname,pla_auth,rank from member where it_uname=?");
			$sth->bindValue(1,$subelem,PDO::PARAM_STR);
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			if($result['it_uname'] != $subelem)
				$_SESSION['nonpayer'] = (string)$subelem;
			else
			{
				if($result['rank'])
					$_SESSION['member'] = $result['id'];
				else
					$_SESSION['payer'] = $result['id'];
				$_SESSION['pla_auth'] = $result['pla_auth'];
			}
			header('Location: /');
		} catch(PDOException $e) {
			die("A database error ocurred: " . $e->getMessage());
		}
	}
}elseif(isset($_SESSION['member']))
	header("Location: panel.php");
else
	header("Location: /");
