<?php

include_once('inc.php');

noCache();

$db = dbConnect();

?><!DOCTYPE html>
<html>
<head>
	<title>Cellular geolocation web app</title>
	<link rel="stylesheet" href="../style.css" />
	<script src="../script.js" />
</head>
<body>
	<div id="header"><div id="logo"><img src="asrclogo.gif" alt="ASRC" /></div>
		<div id="sms">
			<!-- Prompt for SMS text and phone number here. Use drop-down list pf providers. Use a message preview to display character limit -->
			<!-- Enter SMS email address (e.g. ##########@vtext.com or ##########@txt.att.net): <input type="text" name="email" /> -->
		</div>
	</div>
	<div id="table">
		<table>
			<tr>
				<td>ID</td><td>Email</td><td>Last location</td><td>Timestamp</td>
			</tr>
		</table>
	</div>
</body>
</html>
<?

if(isset($_POST['submit']))
{
	// Add email to database and get ID
	// Send email
	$result = $db->query("insert into gps (email) values ('" . $_POST['email'] . "')");
	$result = $db->query("select id from gps where email='" . $_POST['email'] . "' order by id desc");
	$array = $result->fetch_assoc();
	mail($_POST['email'], 'Tap link to send location to SAR', "http://myasrc.dreamhosters.com/gps/index.php?id=" . $array['id']);
}

// Get list of phones and last location for each
// Display in table with link to Google maps
$result = $db->query("select * from gps where id=" . $_GET['check']);
$array = $result->fetch_assoc();
if($array['loc'] != '')
{
	// Location found
	?><!DOCTYPE html>
	<html><body>Location: <a href="http://maps.google.com/maps?q=<?php echo(urlencode($array['loc'])); ?>"><?php echo($array['loc']); ?></a></body></html><?php
}

?>