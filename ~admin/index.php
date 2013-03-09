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
	<div id="header"><div id="logo"><a href="./"><img src="asrclogo.gif" alt="ASRC" /></a></div>
		<div id="sms">
			<h2>Send SMS requesting location</h2>
			<form method="POST" action="index.php">
				<p>
					<em>SMS email address:</em><br />
					Provider: <select id="provider" name="provider"><option value="">Other</option></select>
					<input type="text" name="phone" id="phone" size="12" />@<input type="text" name="gateway" id="gateway" size="8" /><br />
					<input type="text" name="subject" id="subject" size="22" /> <input type="text" name="message" id="message" size="22" />
					<input type="submit" value="Send" name="submit" />
				</p>
				<p>
					<em>Message preview:</em><br />
					<span id="preview"></span>
				</p>
			</form>
		</div>
	</div>
<?php

if(isset($_POST['submit']))
{
	// Add email to database and get ID
	// Send email
	$email = $_POST['phone'] . '@' . $_POST['gateway'];
	if(!$db->query("insert into phones (email) values ('" . $email . "')") || $db->insert_id == 0)
	{
		// Error
		echo('<div id="error">SMS email could not be inserted into database.</div>');
	}
	else
	{
		$id = base64url_encode($db->insert_id);
		if(!mail($email, $_POST['subject'], $BASE_URL . $id . ' ' . $_POST['message']))
		{
			// Error
			echo('<div id="error">Could not send email.</div>');
		}
	}	
}

?>
	<div id="table">
		<a href="./">Refresh</a>
		<table>
			<tr class="header">
				<td>ID</td><td>Email</td><td>Location</td><td>Accuracy (m)</td><td>Altitude (m)</td><td>Heading (deg)</td><td>Speed (m/s)</td><td>Time of location</td><td>Time received</td>
			</tr>
<?php

// Get list of phones and locations
// Display in table with link to Google maps
$result = $db->query('select * from gps right join phones using(phone_id) order by time desc');
$shade = false;
while($row = $result->fetch_assoc())
{
	printf('<tr%s><td>%d</td><td>%s</td><td><a href="http://maps.google.com/maps?q=%s">%s</a></td><td>%d</td><td>%d &#xB1;%dm</td><td>%d</td><td>%d</td><td>%s</td><td>%s</td></tr>',
		$shade?' class="shade"':'',$row['phone_id'], $row['email'], urlencode($row['loc']), $row['loc'], $row['accuracy'], $row['altitude'], $row['altitudeAccuracy'], $row['heading'], $row['speed'], $row['location_time'], $row['time']);
	$shade = !$shade;
}

?>
		</table>
	</div>
</body>
</html>