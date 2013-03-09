<?php

include_once('inc.php');

noCache();

$db = dbConnect();

?><!DOCTYPE html>
<html>
<head>
	<title>Cellular geolocation web app</title>
	<link rel="stylesheet" href="../style.css" />
	<script src="../script.js"></script>
</head>
<body onload="onLoad_admin()">
	<div id="header"><div id="logo"><img src="asrclogo.gif" alt="ASRC" /></div>
		<div id="sms">
			<!-- Prompt for SMS text and phone number here. Use drop-down list pf providers. Use a message preview to display character limit -->
			<!-- Enter SMS email address (e.g. ##########@vtext.com or ##########@txt.att.net): <input type="text" name="email" /> -->
			<form method="POST" action="index.php">
				SMS email address: <select id="provider" name="provider"><option value="">Other</option></select>
				<input type="text" name="phone" id="phone" size="10" /> @ <input type="text" name="gateway" id="gateway" size="8" /><br />
				<input type="text" name="subject" id="subject" size="20" /> <input type="text" name="message" id="message" size="20" />
				<input type="submit" value="Send" name="submit" /><br />
				Message preview: <span id="preview"></span>
			</form>
		</div>
	</div>
	<div id="table">
		<table>
			<tr>
				<td>ID</td><td>Email</td><td>location</td><td>Timestamp</td>
			</tr>
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

// Get list of phones and locations
// Display in table with link to Google maps
$result = $db->query('select * from gps left join phones using(phone_id) order by time desc');
while($row = $result->fetch_assoc())
{
	printf('<tr><td>%d</td><td>%s</td><td><a href="http://maps.google.com/maps?q=%s">%s</a></td><td>%s</td></tr>',
		$row['phone_id'], $row['email'], urlencode($row['loc']), $row['loc'], $row['time']);
}

?>
		</table>
	</div>
</body>
</html>