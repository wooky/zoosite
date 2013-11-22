<?php require_once('res/template.php');
require_once('news/util.php');
headon();?>
<div class="supertitle">WELCOME TO THE ZOO HOMEPAGE!</div>
<p>Welcome to the University of Calgary's Electrical, Computer, and Software Engineering Student Society (Zoo)! As you can see, this page is under
construction. This, of course, should surprise nobody as the previous attempt at getting this website to be of any use was never complete. Have
fun looking around the current design and seeing how blatantly stolen it is. Have fun!</p>
<p>If you wish to see the old website design for some reason (e.g. because you're curious/insane/really insane), <a href="/old/page-home.htm">go here</a>.</p>
<hr>
<div class="supertitle">LATEST NEWS</div>
<?php try
{
	$db = new PDO("sqlite:pla/news");
	$query = (@$_SESSION['member']) ? "select * from article order by id desc limit 6" :
		"select * from article where private is null order by id desc limit 3";
	$sth = $db->prepare($query);
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	if(count($result) == 0)
	{
		echo "Oh noes! There are no news to report! This might be because one of the following reasons:
		<ul><li>The database is experiencing some difficulties, and was thus unable to retreive any news</li>
		<li>Someone malicious entity managed to hack into the Zoo website and purge all the news articles</li>
		<li>There were never news articles to begin with</li></ul>
		By the way, the last reason is actually the most plausible.";
	} else {
		fullParse($result,TRUE);
	}
}
catch(PDOException $e)
{
	echo $e->getMessage();
}
echo '<b><a href="/news">Read All News</a></b>';
if(@$_SESSION['member'])
	echo ' &middot; <b><a href="/news/editor.php">Create a New Article</a></b>';
footon();?>
