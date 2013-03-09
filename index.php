<?php

include_once('~admin/inc.php');

noCache();

$db = dbConnect();

if(isset($_GET['update']))
{
	// Page being called from XMLHttpRequest()
	// Update database with location using ID
	// Return a confirmation to user
	$db->query("update gps set loc='" . $_GET['loc'] ."' where id=" . $_GET['update']);
	echo('Position received.');
}
else
{
	// Page being visited in browser

	// Use mod_rewrite to rewrite URL as ID

	if(isset($_GET['id']))
	{
		// Base64-decode ID
	}
	else
	{
		// Use IP address to look up or generate ID
	}

	// Get location
	// Use position tracking
	// Graceful error handling
	// Minimize initial download size
	?><!DOCTYPE html>
	<htmk><head><script type="text/javascript">
	function getPos(position) {
		document.getElementById('startLat').innerHTML = 'Getting position...';
		var pos = '(' + position.coords.latitude + ', ' + position.coords.longitude + ')';
	    document.getElementById('startLat').innerHTML = pos;
	    var req = new XMLHttpRequest();
	    req.open("get", "index.php?update=<?php echo($_GET['id']); ?>&loc=" + encodeURI(pos));
	    req.send();
	}

	function err(error) {
    	document.getElementById('startLat').innerHTML = 'Error: ' + error.code;
	}

	window.onload = function() {
		if(navigator.geolocation) {
			document.getElementById('startLat').innerHTML = 'Loading...';
			navigator.geolocation.getCurrentPosition(getPos, err, {enableHighAccuracy:true});
		}
		else
		{
			// Geolocation not supported
			document.getElementById('startLat').innerHTML = 'Geolocation not supported by this device.';
		}
	};
	</script></head><body><span id="startLat">?</span></body></html><?php

}

?>