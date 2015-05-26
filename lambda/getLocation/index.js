// Receive location from subject device and store in cognito.
//  Parameters:
//   token: Token from the link the subject opened
//   longitude
//   latitude
//   altitude
//   accuracy
//   altitudeAccuracy
//   heading
//   speed
//   location_time
exports.handler = function(event, context) {

	var location = {};

    location.longitude = event.longitude;
    location.latitude = event.latitude;
    location.altitude = event.altitude;
    location.accuracy = event.accuracy;
    location.altitudeAccuracy = event.altitudeAccuracy;
    location.heading = event.heading;
    location.speed = event.speed;
    location.location_time = event.location_time;

    console.log('Token:', event.token);
    console.log(location)

    // TODO: Save location in Cognito

    context.succeed('Your location has been received by Search &amp; Rescue.');

}
