<?php

include_once('../inc.php');

noCache();

$db = dbConnect();

if(isset($_GET['update']))
{
	// Page being called from XMLHttpRequest()
	// Update database with location using ID
	// Return a confirmation to user

	$error = true;
	$_GET['update'] = (int) $_GET['update'];
	if($_GET['update'] > 0)
	{
		$_GET['loc'] = $db->escape_string($_GET['loc']);
		$_GET['altitude'] = $_GET['altitude'] == 'null'?'null':(int) $_GET['altitude'];
		$_GET['accuracy'] = $_GET['accuracy'] == 'null'?'null':(int) $_GET['accuracy'];
		$_GET['altitudeAccuracy'] = $_GET['altitudeAccuracy'] == 'null'?'null':(int) $_GET['altitudeAccuracy'];
		$_GET['heading'] = $_GET['heading'] == 'null'?'null':(int) $_GET['heading'];
		$_GET['speed'] = $_GET['speed'] == 'null'?'null':(int) $_GET['speed'];
		$_GET['location_time'] = (int) ($_GET['location_time']/1000);
		if($db->query('insert into gps (id, loc, altitude, accuracy, altitudeAccuracy, heading, speed, location_time) ' .
			"VALUES (" . $_GET['update'] . ",'" . $_GET['loc'] . "'," . $_GET['altitude'] . "," . $_GET['accuracy'] . "," . 
			$_GET['altitudeAccuracy'] . "," . $_GET['heading'] . "," . $_GET['speed'] . ",FROM_UNIXTIME(" . $_GET['location_time'] . "))"))
		{
			echo('Your location has been received by Search &amp; Rescue.');
			$error = false;
		}
	}

	if($error)
	{
		// Error
		echo('Error: <a href="./">Location not received. Tap here to reload page.</a>');
	}
}
else
{
	// Page being visited in browser

	// Use mod_rewrite to rewrite URL as ID

	$id = 0;
	if(isset($_GET['id']))
	{
		// Base64url-decode ID
		$id = (int) base64url_decode($_GET['id']);
		if(!($id > 0 && $db->query('select id from phones where id=' . $id)->num_rows > 0))
		{
			// Invalid ID
			$id = 0;
		}
	}
	
	if($id == 0)
	{
		// Use IP address to generate ID
		$userString = $db->escape_string($_SERVER['REMOTE_ADDR'] . ':' . $_SERVER['REMOTE_PORT'] . ' ' . $_SERVER['HTTP_USER_AGENT']);
		$db->query('insert into phones (user_id,email) values (1,\'' . $userString .'\')');
		$id = $db->insert_id;
	}

	// Get location
	// Use position tracking
	// Graceful error handling
	// Minimize initial download size
	?><!DOCTYPE html>
	<html><head><title>Search &amp; Rescue Cell Phone Locator</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<script type="text/javascript">
	function reqReceived() {
		document.getElementById('status').innerHTML = this.responseText;
	}

	function reqError() {
		document.getElementById('status').innerHTML += '<br />Error. Retrying...';
		this.send();
	}

	function receivePos(position) {
		var loc = '(' + position.coords.latitude + ', ' + position.coords.longitude + ')';
	    document.getElementById('status').innerHTML = 'Your location: ' + loc;
	    var req = new XMLHttpRequest();
	    req.open("get", "index.php?update=<?php echo($id); ?>&loc=" + encodeURI(loc) +
	    	"&altitude=" + position.coords.altitude +
	    	"&accuracy=" + position.coords.accuracy +
	    	"&altitudeAccuracy=" + position.coords.altitudeAccuracy +
	    	"&heading=" + position.coords.heading +
	    	"&speed=" + position.coords.speed +
	    	"&location_time=" + position.timestamp, true);
	    req.onload = reqReceived;
	    req.onerror = reqError;
	    req.onabort = reqError;
	    document.getElementById('status').innerHTML += '<br />Sending location to Search &amp; Rescue...';
	    req.send();
	}

	function posError(error) {
		var errorText = '<a href="./<?php echo(base64url_encode($id)); ?>">Error: ';
		if(error.code == error.PERMISSION_DENIED) {
			errorText += 'Permission Denied. Please enable location sharing in your device web browser\'s Privacy and/or Security settings, then tap here to reload this page.</a>';
		}
		else if(error.code == error.POSITION_UNAVAILABLE) {
			errorText += 'Position Unavailable. Please turn on GPS and/or location services on your device, then tap here to reload this page.</a>';
		}
		else if(error.code == error.TIMEOUT) {
			errorText = document.getElementById('status').innerHTML + '<br />Timeout. Retrying...';
			getPos();
		}
		else {
			errorText += 'Unknown Code ' + error.code +'. Please turn on GPS and/or location services on your device and enable location sharing, then tap here to reload this page.</a>';
		}
		document.getElementById('status').innerHTML = errorText;
	}

	function watchPosError(error) {
		// Do nothing for now. May log later.
	}

	function getPos() {
		navigator.geolocation.getCurrentPosition(receivePos, posError, {enableHighAccuracy:true});
	}

	window.onload = function() {
		if(navigator.geolocation) {
			document.getElementById('status').innerHTML = 'Waiting for location...';
			getPos();
			//navigator.geolocation.watchPosition(receivePos, watchPosError, {enableHighAccuracy:true});
		}
		else {
			// Geolocation not supported
			document.getElementById('status').innerHTML = 'Geolocation not supported by this device.';
		}
	};
	</script><style>
	body {
		font-size:1.5em;
		font-family: "Georgia", serif;
		background-color: #e30;
		color: #fff;
	}
	p {
		text-align: center;
	}
	#allow {
		font-weight: bold;
	}
	</style></head><body>
	<p id="allow">Tap &#8220;Allow&#8221; to send your location to Search &amp; Rescue.</p>
	<p id="status"></p>
	</body></html><?php

}

?>