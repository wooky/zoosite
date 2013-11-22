<?php function truncateArticle($content)
{
	$content = strip_tags($content);
	$content = (strlen($content) > 200) ? substr($content,0,strpos(wordwrap($content,200),"\n")) . "..." : $content;
	return $content;
}

function parseArticle($title,$content,$timestamp_created = null,$timestamp_modified = null,$author_editor = null)
{
	echo '<p><span class="smallertitle">' . $title . '</span><br>';
	if($timestamp_created)
	{
		date_default_timezone_set("America/Edmonton");
		echo '<span class="timestamp">Posted on ' . date("l, F j, Y, g:i A T",$timestamp_created);
		if($timestamp_modified)
		{
			echo ', last modified on ' . date("l, F j, Y, g:i A T",$timestamp_modified);
			if($author_editor)
				echo ' by ' . $author_editor;
		}
		echo '</span><br>';
	}
	echo $content;
}

function fullParse($result,$truncate = FALSE)
{
	foreach($result as $m)
	{
		$content = $truncate ? truncateArticle($m['content']) : $m['content'];
		parseArticle($m['title'],$content,$m['timestamp_created'],$m['timestamp_modified']);
		echo '<br>(<a href="/news/?article=' . $m['id'] . '">Read More</a>)';
		if(@$_SESSION['member'])
		{
			echo ' &middot; (';
			putEdit($m['id']);
			echo ') &middot; (';
			putPrivate($m);
			echo ')';
		}
		echo '</p><hr>';
	}
}

//The following 2 functions require the code to manually check for $_SESSION['member']
function putEdit($id)
{
	echo '<a href="/news/editor.php?edit=' . $id . '">Edit Article</a>';
}

function putPrivate($result)
{
	echo '<a href="/news/privatize.php?id=' . $result['id'] . '&ret=' . $_SERVER['REQUEST_URI'];
	echo ($result['private']) ? '&method=1" style="color:green">Publicize' : '" style="color:red">Privatize';
	echo ' Article</a>';
}?>
