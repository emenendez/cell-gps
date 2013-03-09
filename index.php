<?php

include_once('~admin/inc.php');

noCahche();

$db = dbConnect();

if(isset($_GET['id']))
{
	// Get location
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
else if(isset($_GET['update']))
{
	// update database with loc
	mysql_query("update gps set loc='" . $_GET['loc'] ."' where id=" . $_GET['update']);
	echo('Position received.');
}

?>