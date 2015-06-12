function toggleHelp()
{
	$('#help').collapse('toggle');
	$('#help-link').toggleClass('active');
}

function updatePhone(field, change)
{
	var defaultRegion = 'US';
	var number = field.val();
	var valid = false;

	try
	{
		valid = phoneUtils.isValidNumber(number, defaultRegion)
	}
	catch (e) {}

	if (field[0].setCustomValidity)
	{
		if (valid)
		{
			field[0].setCustomValidity('');
		}
		else
		{
			field[0].setCustomValidity('Please enter a valid phone number.')
		}
	}

	if (valid && change)
	{
		if (phoneUtils.getRegionCodeForNumber(number, defaultRegion) == defaultRegion)
		{
			field.val(phoneUtils.formatNational(number, defaultRegion));
		}
		else
		{
			field.val(phoneUtils.formatInternational(number, defaultRegion));
		}
	}
}

$(document).ready(function() {

	var phoneField = $('[name="phone"]');

	if (phoneField.length > 0)
	{
		phoneField.change(function() {
			updatePhone(phoneField, false);
		});

		phoneField.blur(function() {
			updatePhone(phoneField, true);
		});

		phoneField.keyup(function() {
			updatePhone(phoneField, false);
		});

		updatePhone(phoneField, true);		
	}

	$('input').placeholder();

});
