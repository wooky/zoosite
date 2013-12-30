<?php session_start();
try
{
	$db = new PDO("sqlite:../pla/news");
	if(@$_GET['article'] && $_GET['article'] != "")
	{
		$sth = $db->prepare("select * from article where id=?" . (@$_SESSION['member'] ? "" : " and private is null"));
		$sth->bindValue(1,$_GET['article'],PDO::PARAM_INT);
                $sth->execute();
                $result = $sth->fetch(PDO::FETCH_ASSOC);
                if($_GET['article'] != $result['id'])
		{
			$title = "Article not Found";
			$cont = "The article you have selected was not found. Please ensure you typed the correct URL, and if you have been referred
				by another site (or even this one!), please contact that site's owner.";
		} else {
			$title = $result['title'];
			$cont = $result['content'];
			$date = $result['timestamp_created'];
			$mod = $result['timestamp_modified'];
			$author = $result['author'];
		}
	}
	else
		$title = "News";
} catch(PDOException $e) {
	$title = "Database Error";
	$content = $e->getMessage();
}

require_once('../res/template.php');
require('util.php');
headon($title);
if(@$_GET['article'])
{
	if(@$result['author_editor'] && $result['author_editor'] != "")
	{
		$sth = $db->prepare("select name from member where id=?");
		$sth->bindValue(1,$result['author_editor'],PDO::PARAM_INT);
		$sth->execute();
		$res2 = $sth->fetch(PDO::FETCH_ASSOC);
	}

	parseArticle($title,$cont,@$date,@$mod,@$res2['name']);
	if(@$_SESSION['member'])
	{
		echo '<b>';
		putEdit($_GET['article']);
		echo ' &middot; ';
		putPrivate($result);
		echo '</b>';
	}
	if(@$author && $author != 0)
	{
		$sth = $db->prepare("select name,role,it_uname from member where id=?");
		$sth->bindValue(1,$author,PDO::PARAM_INT);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		if(count($result) != 0)
		{
			echo '<div style="background:darkgrey; width: 680px;margin:20px;padding:20px;border-style:solid"><div class="smallertitle">';
			echo 'Article written by</div><div style="float:left;width:220px"><img src="../contact/';
			echo file_exists("../contact/" . $result['it_uname'] . ".jpg") ? $result['it_uname'] : "nopic";
			echo '.jpg"></div><div style="float:left;width:400px"><div class="supertitle">' . $result['name'] . '</div>';
			echo $result['role'] . '</div><div style="clear:both"></div></div>';
		}

	}
	if(@$date)
	{?>
		<div id="disqus_thread"></div>
		<script type="text/javascript">var disqus_shortname = 'zooengg';
		(function() {
			var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		})();
		</script>    
	<?php }
} else {
	echo '<div class="supertitle">ZOO NEWS</div>';
	if(@$_SESSION['member'])
		echo '<b><a href="editor.php">Create a New Article</a></b><hr>';
	fullParse($db->query("select * from article " . (@$_SESSION['member'] ? "" : "where private is null")  . " order by id desc")->fetchAll(PDO::FETCH_ASSOC));
}
footon();
