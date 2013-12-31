<?php session_start();
if(!@$_SESSION['member'] || $_SESSION['member'] == "")
	header("Location: /");
elseif(!@$_POST)
{
	if(@$_GET['edit'] && $_GET['edit'] != "")
	{
		$db = new PDO("sqlite:../pla/news");
		$sth = $db->prepare("select id,title,content,private from article where id=?");
		$sth->bindValue(1,$_GET['edit'],PDO::PARAM_INT);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		if($result['id'] != $_GET['edit'])
			die("Article not found!");
	}

require_once("../res/template.php");
partialHead("Edit Article");?>
<script src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
function sub()
{
	if(document.ed.elements["title"].value.length == 0 || document.ed.elements["editor"].value.length == 0)
		alert("Both title and content must be filled in");
	else
	{
		document.ed.action = "<?php echo $_SERVER['REQUEST_URI'];?>";
		document.ed.submit();
	}
}
</script><?php partialBody();?>
</head><body><form method="post" name="ed" action="javascript:sub()"><div style="font-size:18pt">Article title:
<input type="text" name="title" id="title" size="53" style="font-size:18pt;" value="<?php echo @$result['title'];?>"></div>
<textarea name="editor" id="editor"><?php echo @$result['content'];?></textarea>
<label><input type="checkbox" name="private" <?php if(@$result['private']) echo "checked"; ?>> Privatize the article (i.e. make it only visible to Zoo council members)</label></form>
<h2>Remember to hit the <span style="background-image:url(http://zoo.ucalgary.ca/news/ckeditor/skins/moono/icons.png);background-position:0 -1704px;background-size:auto;width:16px;height:16px;display:inline-block">&nbsp;</span>Save button to publish your article!</h2>
<script type="text/javascript">CKEDITOR.replace('editor');</script></body></html>
<?php footon();
}
else
{
	try
	{
		$db = new PDO("sqlite:../pla/news");
		$db->beginTransaction();
		if(@$_GET['edit'])
		{
			$sth = $db->prepare("update article set author_editor=?,title=?,content=?,timestamp_modified=?,private=? where id=?");
			$sth->bindValue(6,$_GET['edit']);
		} else
			$sth = $db->prepare("insert into article(author,title,content,timestamp_created,private) values (?,?,?,?,?)");
		$sth->bindValue(1,$_SESSION['member'],PDO::PARAM_INT);
		$sth->bindValue(2,$_POST['title'],PDO::PARAM_STR);
		$sth->bindValue(3,$_POST['editor'],PDO::PARAM_STR);
		$sth->bindValue(4,time(),PDO::PARAM_INT);
		$sth->bindValue(5,@$_POST['private'] ? 1 : null,PDO::PARAM_INT);
		$sth->execute();
		if($sth->rowCount() == 0)
			die("Failed to save your article!");
		
		$id = $db->lastInsertId();
		if($id == 0)
			$id = $_GET['edit'];
		$db->commit();
		header("Location: /news/?article=$id");
	} catch(PDOException $e) {
		die("An error ocurred: " . $e->getMessage());
	}
}
