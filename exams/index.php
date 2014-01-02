<?php require_once("../res/template.php");
partialHead("Exams");
echo '<script type="text/javascript" src="parsefilename.js"></script>';
partialBody();
echo '<div class="supertitle">EXAMS</div>';
try {
$db = new PDO("sqlite:../pla/news");
staticText($db,"examinfo");

if(isset($_SESSION['member']))
	echo "<br>The following is displayed to non-logged in users:";
if(isset($_SESSION['member']) || (!isset($_SESSION['payer']) && !isset($_SESSION['nonpayer'])))
	staticText($db,"examlogin");

if(isset($_SESSION['member']))
        echo "<br>The following is displayed to logged in non-members (i.e. those who haven't paid their dues):";
if(isset($_SESSION['member']) || (!isset($_SESSION['payer']) && isset($_SESSION['nonpayer'])))
        staticText($db,"examlimit");


echo "<hr>";
$res = $db->query("select name as name,description as value from examnames")->fetchAll(PDO::FETCH_KEY_PAIR);
if($handle=opendir('./files'))
{
	//require_once('parsefilename.php');
	echo "<ul class='examlist'>";
	$prevname = null;
	$preventry = "0";
	$tagopened = false;
	while(false !== ($entry = readdir($handle)))
	{
		if($entry != "." && $entry != "..")
		{
			$e = substr($entry,0,strlen($preventry));
			if($preventry == $e)
			{
				if(!$tagopened)
				{
					$tagopened = true;
					echo "<ul class='examlist'>";
				}
			}
			else
			{
				if($tagopened)
				{
					$tagopened = false;
					echo "</ul>";
				}
				$preventry = substr($entry,0,-4);
			}

			$nom = substr($entry,0,7);
			if($prevname != $nom)
			{
				$prevname = $nom;
				echo "</ul><br><br><div class='smallertitle'>" . strtoupper($prevname) . (isset($res[$prevname]) && $res[$prevname] != "" ? " - {$res[$prevname]}" : "")  . "</div><ul>";
			}

			//echo "<li><a" . (@$_SESSION['member'] || @$_SESSION['payer'] || @$_SESSION['nonpayer'] ? " href='get.php?f=$entry' target='_blank'" : "") . ">" . parseFilename($entry)  . "</a>";
			echo "<li><span class='examelem'>$entry</span>";
		}
	}
	closedir($handle);
	echo '</ul><script type="text/javascript">elems = document.getElementsByClassName("examelem");for(j = 0; j < elems.length; j++)	fullParse(elems[j],';
	echo (@$_SESSION['member'] || @$_SESSION['payer'] || @$_SESSION['nonpayer'] ? 'true' : 'false') . ');</script>';
}
} catch(PDOException $e) { echo $e->getMessage(); }
footon();?>
