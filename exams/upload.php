<?php session_start();
if(!isset($_SESSION['member']))
	header('Location: .');
require_once('../res/template.php');
partialHead('Upload Exams');
echo '<script type="text/javascript" src="parsefilename.js"></script><script type="text/javascript" src="admin.js"></script>';
partialBody();
echo '<div class="supertitle">UPLOAD EXAMS</div>';
if(isset($_FILES['pdf']))
{
	if(move_uploaded_file($_FILES['pdf']['tmp_name'],'files/' . basename($_FILES['pdf']['name'])))
		echo '<h2>Your file has been successfully uploaded!</h2><hr>';
	else
		echo '<h2>Failed to upload file! D: It might be because the file already exists or some other error ocurred</h2><hr>';
}
echo '<b>For fast upload</b>, have the filenames in the following form:
<blockquote>umpl666_1984f_m1_extras.pdf</blockquote>where<ul>
<li>umpl666: course name; must be 4 letters and 3 digits, no spaces</li>
<li>1984f: 4-digit year, optionally followed by season: [f]all, [w]inter, s[p]ring, [s]ummer</li>
<li>m1: exam type, optionally followed my exam number. Types: [q]uiz, [t]est, [m]idterm, final e[x]am</li>
<li>extras: optional. One of the following, separated by underscores (_):<ul>
<li>solutions: contains only the solutions to the exam</li>
<li>mconly: contains only multiple choice. May be combined with _solutions_, but not with _wronly_</li>
<li>wronly: contains only written response. May be combined with _solutions_, but not with _wronly_</li>
<li>scan: the file is not an original, but is scanned</li>
<li>unofficial: the questions/answers are not provided by the original prof</li>
<li>partial: not all the questions/answers are provided. Use _mconly_/_wronly_ if appropriate</li>
</ul></li></ul>';

echo '<h1>For now, have the filenames only in that format for uploading!</h1>Otherwise your file will be categorized incorrectly, and we don\'t want that to happen, right?';
echo '<form method="post" action="upload.php" enctype="multipart/form-data"><input type="file" name="pdf"><input type="submit" value="Send"></form>';

footon();?>
