<?php require_once('../res/template.php');
try
{
	$db = new PDO("sqlite:../pla/news");
	$sth = $db->prepare("select * from article where private is null order by id desc limit 30");
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
<?xml version="1.0" encoding="UTF-8"?><rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
	<atom:link href="http://zoo.ucalgary.ca/news/rss.php" rel="self" type="application/rss+xml" />
	<title>Zoosite RSS Feed</title>
	<description>Catch the latest news from your favorite student society!</description>
	<link>http://zoo.ucalgary.ca</link>
<?php echo "\t<lastBuildDate>" . date("r",$result[0]['timestamp_created']) . "</lastBuildDate>\n\n";
	foreach($result as $m)
	{
		echo "\t<item>\n";
		echo "\t\t<title>" . $m['title'] . "</title>\n";
		echo "\t\t<description>" . htmlspecialchars($m['content'],ENT_NOQUOTES) . "</description>\n";
		echo "\t\t<link>http://zoo.ucalgary.ca/news/?article=" . $m['id'] . "</link>\n";
		echo "\t\t<guid>http://zoo.ucalgary.ca/news/?article=" . $m['id'] . "</guid>\n";
		echo "\t\t<pubDate>" . date("r",$m['timestamp_created']) . "</pubDate>\n";
		echo "\t</item>\n\n";
	}
	echo "</channel>\n</rss>";
} catch(PDOException $e)
{
	die("An error ocurred: " . $e->getMessage());
}
