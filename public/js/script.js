var BASE_URL = 'http://gps.asrc.net/';

function toggleHelp()
{
	$('#help').collapse('toggle');
	$('#help-link').toggleClass('active');
}

function preview()
{
	subject = $('[name="subject"]').val();
	if(subject.length == 0) {
		subject = 'Tap link to send location to SAR';
	}
	sms = '[' + subject + '] ' + BASE_URL + 'xyz ' + $('[name="message"]').val();
	$('#preview').text(sms.substring(0, 140));
}

$(document).ready(function() {
	$('[name="subject"], [name="message"]').change(function() {
		preview();
	});

	$('[name="subject"], [name="message"]').blur(function() {
		preview();
	});

	$('[name="subject"], [name="message"]').keyup(function() {
		preview();
	});

	$('[name="provider"]').change(function() {
		$('[name="gateway"]').val($('[name="provider"]').val());
	});

	preview();
});
