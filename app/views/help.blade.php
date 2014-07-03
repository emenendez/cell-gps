 <p>This web app provides the ability to prompt a recipient to share his/her location via a text message sent to his/her mobile phone containing a URL link. By tapping the link, the recipient permits the phone to send its current location as determined by the location services enabled on the device.</p>

        <p><strong>This app cannot &#8220;turn on&#8221; location services or independently extract location without acknowledgement by the recipient.</strong></p>
        
        <p>Example of a text message:
          <blockquote>Tap link to send location to SAR: {{ route('get-location') }}/Mq</blockquote>
        </p>

          <p>To send an SMS message from this web app, the sender must provide the phone's SMS gateway. A list of SMS gateways for some of the major North American providers is included. <a href="http://en.wikipedia.org/wiki/List_of_SMS_gateways" target="_blank">A more complete list is available here</a> and/or by <a href="http://www.google.com/search?q=List+of+SMS+gateways" target="_blank">Googling</a>.</p>
          <p>Feedback: <a href="mailto:ericmenendez@gmail.com?subject=Cell GPS Feedback">ericmenendez@gmail.com</a></p>