// Send a text message to phone number via Twilio
//  Parameters:
//   to: Recipient phone number
//   copy: Message
//   url: Link to include after message
exports.handler = function(event, context) {

	var credentials = require('./.env.js');
	var client = require('twilio')(credentials.accountSid, credentials.authToken);
	 
	client.messages.create({
	    body: event.copy.concat(' ', event.url),
	    to: event.to,
	    from: credentials.number,
	}, function(err, message) {
		if(err) context.fail();
	    context.succeed();
	});

}
