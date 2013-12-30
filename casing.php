<?php
if(!@$_GET['svc'] || $_GET['svc'] == "")
{
	echo "<h1>U of C Shared CAS</h1><b>Do not distribute this link!</b>
	<p>To use this service use the following method:<ol>
	<li>Pass the variable <tt>svc</tt> with the base64 of your website. <b>It must not contain &amp; or ?</b></li>
	<li>If the user logs in successfully, it will redirect to the decoded supplied <tt>svc</tt> and supply a
	<tt>ticket</tt> given by the CAS server</li>
	<li>Your server must then respond back to the same URL along with the same <tt>svc</tt>, the supplied
	<tt>ticket</tt>, and set <tt>ret</tt> to 1</li>
	<li>You will receive XML data. You must process it yourself</li></ol>";
	exit();
}

$url = "http://zoo.ucalgary.ca/casing.php?svc=" . $_GET['svc'];
if(!@$_GET['ticket'] || $_GET['ticket'] == "")
	header("Location: https://cas.ucalgary.ca/cas/login?service=$url&ca.ucalgary.authent.mustpost=true");
elseif(!@$_GET['ret'] || $_GET['ret'] == "")
	header('Location: ' . base64_decode($_GET['svc']) . '?ticket=' . $_GET['ticket']);
else
	echo file_get_contents("https://cas.ucalgary.ca/cas/ucserviceValidate?ticket=" . $_GET['ticket'] . "&service=$url");
?>