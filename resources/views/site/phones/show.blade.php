<!DOCTYPE html>
<html><head><title>Search &amp; Rescue Cell Phone Locator</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script>
function reqReceived() {
  document.getElementById('status').innerHTML = this.responseText;
}

function reqError() {
  document.getElementById('status').innerHTML += '<br>Error. Retrying...';
  this.send();
}

function receivePos(position) {
  document.getElementById('status').innerHTML = 'Your location: (' + position.coords.latitude + ', ' + position.coords.longitude + ')';
  var req = new XMLHttpRequest();
  req.open('get', 'api/update/{{ $phone->token }}' +
    '/' + position.coords.longitude +
    '/' + position.coords.latitude +
    '/' + position.coords.altitude +
    '/' + position.coords.accuracy +
    '/' + position.coords.altitudeAccuracy +
    '/' + position.coords.heading +
    '/' + position.coords.speed +
    '/' + position.timestamp, true);
  req.onload = reqReceived;
  req.onerror = reqError;
  req.onabort = reqError;
  document.getElementById('status').innerHTML += '<br />Sending location to Search &amp; Rescue...';
  req.send();
}

function posError(error) {
  var errorText = '<a href="{{ $phone->token }}">Error: ';
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
</script>
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
<style>
body {
    margin: 0;
    font-family: "Lato", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    font-size: 1.3rem;
    font-weight: 400;
    line-height: 1.5;
    color: #EBEBEB;
    text-align: left;
    background-color: #2B3E50;
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
</body></html>
