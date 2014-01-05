<?php require_once("../res/template.php");
partialHead("Exams");
echo '<script type="text/javascript" src="parsefilename.js"></script>';
if(isset($_SESSION['member']))
	echo '<script type="text/javascript" src="admin.js"></script>';
partialBody();
echo '<div class="supertitle">EXAMS</div>';
try {
$db = new PDO("sqlite:../pla/news");
staticText($db,"examinfo");

if(isset($_SESSION['member']))
	echo "<br>The following is displayed to non-logged in users:";
if(isset($_SESSION['member']) || (!isset($_SESSION['payer']) && !isset($_SESSION['nonpayer'])))
	staticText($db,"examlogin");

$nonpayer = isset($_SESSION['nonpayer']) ? str_replace('.','_',$_SESSION['nonpayer']) : null;
if(isset($_SESSION['member']))
	echo "<br>The following is displayed to logged in non-members (i.e. those who haven't paid their dues):";
if(isset($_SESSION['member']) || ($nonpayer && (!isset($_COOKIE[$nonpayer]) || $_COOKIE[$nonpayer] > 0)))
	staticText($db,"examlimit",array('%times%',(isset($_COOKIE[$nonpayer]) ? $_COOKIE[$nonpayer] : 3)));

if(isset($_SESSION['member']))
	echo '<br>The following is displayed to non-members who have exceeded their daily quota:';
if(isset($_SESSION['member']) || ($nonpayer && (isset($_COOKIE[$nonpayer]) && @$_COOKIE[$nonpayer] <= 0)))
	staticText($db,'examexceed',array('%time_remaining%',date_diff(new DateTime('now'),new DateTime('tomorrow'))->format('%h:%I:%S')));

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
				$descpresent = isset($res[$prevname]) && $res[$prevname] != '';
				echo "</ul><br><br><span class='smallertitle'>" . strtoupper($prevname) . ($descpresent ? " - {$res[$prevname]}" : "")  . "</span>";
				if(isset($_SESSION['member']))
					echo " (<a href='javascript:editTxt(\"$prevname\"" . ($descpresent ? ",\"{$res[$prevname]}\"" : '') . ")'>edit</a>)";
				echo "<ul>";
			}

			//echo "<li><a" . (@$_SESSION['member'] || @$_SESSION['payer'] || @$_SESSION['nonpayer'] ? " href='get.php?f=$entry' target='_blank'" : "") . ">" . parseFilename($entry)  . "</a>";
			echo "<li><span class='examelem'>$entry</span>" . (isset($_SESSION['member']) ? " (<a href='#' onclick='deleteExam(\"$entry\");return false'>delete</a>)" : '');
		}
	}
	closedir($handle);
	echo '</ul><script type="text/javascript">elems = document.getElementsByClassName("examelem");for(j = 0; j < elems.length; j++)	fullParse(elems[j],';
	echo (@$_SESSION['member'] || @$_SESSION['payer'] || @$_SESSION['nonpayer'] ? 'true' : 'false') . ');</script>';
}
} catch(PDOException $e) { echo $e->getMessage(); }
footon();?>
