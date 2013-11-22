<?php function displayContactInfo($result)
{
	echo '<div style="width:680px"><div style="float:left;width:220px"><img src="';
	echo file_exists($result['it_uname'] . ".jpg") ? $result['it_uname'] : "nopic";
	echo '.jpg"></div><div style="float:left;width:420px"><div class="supertitle">';
	echo $result['name'] . '</div><div class="timestamp">' . $result['role'] . '</div><p>';
	if($result['email']) echo ($result['email'][0] == '@') ? substr($result['email'],1) : '<img src="email.png"> <a href="mailto:' . $result['email'] . '">' . $result['email'] . '</a>';
	if($result['facebook']) echo '<br><img src="facebook.ico"> <a href="http://facebook.com/' . $result['facebook'] .'">facebook.com/' . $result['facebook'] . '</a>';
	if($result['twitter']) echo '<br><img src="twitter.png"> <a href="http://twitter.com/' . $result['twitter'] . '">@' . $result['twitter'] . '</a>';
	echo '</div><div style="clear:both"></div></div><br>';
}

require_once("../res/template.php");
addQuickLink("President","#prez",'anchor');
addQuickLink("Vice Presidents","#vp",'anchor');
addQuickLink("Comissioners","#noobs",'anchor');
headon("Contact Zoo");
?><div class="supertitle">CONTACT ZOO COUNCIL</div>
<div style="background:darkgrey; width: 680px;margin:20px;padding:20px;border-style:solid">
<div style="float:left;width:130px"><img src="zoo.png"></div><div style="float:left;width:510px">
<div class="smallertitle">For general concerns, contact Zoo Council public concern box thing</div>
<p><img src="email.png"> <a href="mailto:zoo@ucalgary.ca">zoo@ucalgary.ca</a></p>
<p><img src="facebook.ico"> <a href="http://facebook.com/zooengg">facebook.com/zooengg</a></p>
<p><img src="twitter.png"> <a href="http://twitter.com/zooengg">@zooengg</a></p></div>
<div style="clear:both"></div></div>
<?php try
{
	$db = new PDO("sqlite:../pla/news");
	$result = $db->query("select it_uname,name,role,email,facebook,twitter,rank from member where rank is not null order by rank,id")->fetchAll(PDO::FETCH_ASSOC);
	$i = 0;
	echo "<h1 id='prez'>President</h1>";
	for(;$result[$i]['rank'] == 1;$i++)
		displayContactInfo($result[$i]);
	echo "<h1 id='vp'>Vice Presidents</h1>";
	for(;$result[$i]['rank'] == 2;$i++)
		displayContactInfo($result[$i]);
	echo "<h1 id='noobs'>Comissioners</h1>";
	for(;$i < count($result);$i++)
		displayContactInfo($result[$i]);
} catch(PDOException $e) {
	echo "An error ocurred: " . $e->getMessage();
}
footon();?>
