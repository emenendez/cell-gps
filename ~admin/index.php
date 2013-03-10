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
	<div id="help-toggle">Show Help</div>
	<div id="help">
		<p>Welcome... This web app provides the ability to prompt a recipient to share their location via a text message sent to their phone containing a URL link. By clicking on the link, the recipient is permitting the phone to send its current location as determined by the location services enabled on the device.</p>
		<p><strong>This app cannot &#8220;turn on&#8221; location services or independently extract location without acknowledgement by the recipient!</strong></p>
		<p>Example of the text:<br />
			asrc_admin@eucalyptus.dreamhost.com(ASRCAdministrator) S:Tap link to send location to SAR M:http://myasrc.dreamhosters.com/gps/Mq</p>
		<p>To send an SMS message from this web app, the user must provide the phone's SMS gateway. A list of SMS gateways for some of the major North American providers is included. <a href="http://en.wikipedia.org/wiki/List_of_SMS_gateways">A more complete list is available here</a> and/or by Googling.</p>
		<p>Questions/comments/suggestions/defects: <a href="mailto:ericmenendez@gmail.com">ericmenendez@gmail.com</a></p>
	</div>
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
	if(!$db->query("insert into phones (email) values ('" . mysqli::escape_string($email) . "')") || $db->insert_id == 0)
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
	$altitude = $row['accuracy'] ? $row['accuracy'] . '&#xB1;' . $row['altitudeAccuracy'] . 'm' : '';
	printf('<tr%s><td>%d</td><td title="%s">%s</td><td><a href="http://maps.google.com/maps?q=%s">%s</a></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
		$shade?' class="shade"':'',$row['phone_id'], $row['email_time'], $row['email'], urlencode($row['loc']), $row['loc'], $row['accuracy'], $altitude, $row['heading'], $row['speed'], $row['location_time'], $row['time']);
	$shade = !$shade;
}

?>
		</table>
	</div>
</body>
</html>