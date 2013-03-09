var BASE_URL = 'http://myasrc.dreamhosters.com/gps/';

var defaultValue = new Object;
defaultValue['phone'] = '10-digit #';
defaultValue['gateway'] = '';
defaultValue['subject'] = 'Tap link to send location to SAR';
defaultValue['message'] = 'Custom message';
defaultValue['provider'] = '';

var gateway = new Object;
gateway['Verizon']	= 'vtext.com';
gateway['AT&T']	= 'txt.att.net';

function onChange_admin(id)
{
	function func()
	{
		if(id == 'subject' || id == 'message')
		{
			preview();
		}
		else if(id == 'provider')
		{
			document.getElementById('gateway').value = document.getElementById('provider').value;
		}
	}
	return func;
}

function onFocus_admin(id)
{
	function func()
	{
		if(document.getElementById(id).value == defaultValue[id])
		{
			document.getElementById(id).value = '';
		}
	}
	return func;
}

function onBlur_admin(id)
{
	function func()
	{
		if(document.getElementById(id).value == '')
		{
			document.getElementById(id).value = defaultValue[id];
		}
		if(id == 'subject' || id == 'message')
		{
			preview();
		}
	}
	return func;
}

function onLoad_admin()
{
	for(var id in defaultValue)
	{
		document.getElementById(id).value = defaultValue[id];
		document.getElementById(id).onchange = onChange_admin(id);
		document.getElementById(id).onfocus = onFocus_admin(id);
		document.getElementById(id).onblur= onBlur_admin(id);
	}
	document.getElementById('subject').onkeypress = preview;
	document.getElementById('message').onkeypress = preview;

	other = document.getElementById('provider').options[0];
	for(var provider in gateway)
	{
		var opt = new Option;
		opt.text = provider;
		opt.value = gateway[provider];
		document.getElementById('provider').add(opt, other);
	}
	preview();
}

function preview()
{
	sms = '[' + document.getElementById('subject').value + ']' + ' ' + BASE_URL + 'xyz' + ' ' + document.getElementById('message').value;
	document.getElementById('preview').innerHTML = sms.substring(0, 140);
}

