<?php session_start();
if(!@$_SESSION['member'])
	header("Location: /");
require_once("../res/template.php");
headon("Admin Panel");
?><div class="supertitle">ADMIN PANEL</div>Actions:
<ul class="actionlist"><li><a href="logout.php">Log out</a></li>

<li><a href="javascript:void(0)" onclick="document.getElementById('edit').style.display='block';return false">Edit profile</a>
<blockquote id="edit" style="display:none"><form method="post" action="edit.php" enctype="multipart/form-data"><?php $db = new PDO("sqlite:../pla/news");
$sth = $db->prepare("select * from member where id=?");
$sth->bindValue(1,$_SESSION['member'],PDO::PARAM_INT);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);
echo "eID: " . $result['it_uname'] . " (this cannot be changed! If you want it changed, complain to whoever added you to the site in the first place)";
echo '<br>Name: <input type="text" name="name" value="' . @$result['name'] . '">';
echo '<br>Role: <input type="text" name="role" value="' . @$result['role'] . '">';
echo '<br>Email: <input type="text" name="email" value="' . @$result['email'] . '"> (start with @ to put a comment instead of an email, e.g. @Contact VP of Pointlessness)';
echo '<br>Facebook: <input type="text" name="facebook" value="' . @$result['facebook'] . '"> (put your username after the facebook.com/ part)';
echo '<br>Twitter: <input type="text" name="twitter" value="' . @$result['twitter'] . '"> (don\'t put a @ at the start; only put in if you\'re actively using it)';
?><input type="hidden" name="MAX_FILE_SIZE" value="100000">
<br>New profile pic: <input type="file" name="profpic"> (JPEG only; must be 200X200 (&plusmn;10px) or it will be rejected! Crop the picture yourself, you know how to use MSPaint)
<p>You may not change your rank at this time. If for some reason you changed rank (and if you dropped rank, lolnoob), contact someone with PLA access. Hopefully they know how to use that.</p>
<input type="submit" value="Edit Profile"></form></blockquote></li>

<!--li><a href="javascript:void(0)" onclick="document.getElementById('add').style.display='block';return false">Add member</a>
<blockquote id="add" style="display:none"><form method="post" action="add.php" onsubmit="if(!document.getElementById('add1').value){alert('The very least you can do is put the eID. Gosh!');return false;}">
Name: <input type="text" name="name">
<br>eID (for CAS): <input type="text" name="eid" id="add1"> (<b>Mandatory!</b> Cannot be changed!)
<br>Rank: <select name="rank"><option>None</option><option value="1">Prez</option>
<option value="2">VP</option><option value="3">Commissioner</option></select>
<br>Role: <input type="text" name="role"> (e.g. VP of Money Wasting, Commissioner of Unemployment, etc.; leave blank if no rank)
<p>Email and Twitter can be added by the user at a later time.</p>
<p><b>Important:</b> your username will be recorded as you add a new user. Remember to add only legitimate
users, not people who are not part of the Zoo council, such as your friends, that homeless bum who lives in a
cardboard box, or that weirdo who demands you to accept Chthulu as your lord and savior (which is ironic). You
might not be removed from the council (because I'm a face, not a human), but you will be blacklisted from here
all the way to <span style="color:black;background-color:black">the nether</span>.</p>
<input type="submit" value="Add New User"></form></blockquote></li-->
</ul><?php footon();
?>
