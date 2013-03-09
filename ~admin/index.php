<?php

include_once('inc.php');

noCache();

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
	// Redirect to check page
	$result = mysql_query("insert into gps (email) values ('" . $_POST['email'] . "')");
	$result = mysql_query("select id from gps where email='" . $_POST['email'] . "' order by id desc");
	$array = mysql_fetch_array($result);
	mail($_POST['email'], 'Tap link to send location to SAR', "http://myasrc.dreamhosters.com/gps/index.php?id=" . $array['id']);
	header("Location: index.php?check=" . $array['id']);
}
else if(isset($_GET['check']))
{
	// Check to see if loc is in database
	// display with link to google maps
	$result = mysql_query("select * from gps where id=" . $_GET['check']);
	$array = mysql_fetch_array($result);
	if($array['loc'] != '')
	{
		// Location found
		?><!DOCTYPE html>
		<html><body>Location: <a href="http://maps.google.com/maps?q=<?php echo(urlencode($array['loc'])); ?>"><?php echo($array['loc']); ?></a></body></html><?php
	}
	else
	{
		// Wait 5 sec
		?><!DOCTYPE html>
		<html><head><meta http-equiv="refresh" content="5" /></head><body>Location not found. Waiting...</body></html><?php
	}
}
else
{
	// Ask for SMS email
	// POST to submit
	?><!DOCTYPE html>
	<html><body><form method="POST" action="index.php">
	Enter SMS email address (e.g. ##########@vtext.com or ##########@txt.att.net): <input type="text" name="email" />
	<input type="submit" name="submit" /></form>
	</body></html>
	<?php
}

?>