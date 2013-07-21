var BASE_URL = 'http://gps.asrc.net/';

function preview()
{
	subject = $('#subject').val();
	if(subject.length == 0) {
		subject = 'Tap link to send location to SAR';
	}
	sms = '[' + subject + '] ' + BASE_URL + 'xyz ' + $('#message').val();
	$('#preview').text(sms.substring(0, 140));
}

$(document).ready(function() {
	$('#subject, #message').change(function() {
		preview();
	});

	$('#subject, #message').blur(function() {
		preview();
	});

	$('#provider').change(function() {
		$('#gateway').val($('#provider').val());
	});

	preview();
});
