<p>This web app provides the ability to prompt a recipient to share his/her location via a text message sent to his/her mobile phone containing a URL link. By tapping the link, the recipient permits the phone to send its current location as determined by the location services enabled on the device.</p>

<p><strong>This app cannot &#8220;turn on&#8221; location services or independently extract location without acknowledgement by the recipient.</strong></p>
        
<p>Example of a text message:
	<blockquote>Tap link to send location to SAR: {{ route('get-location') }}/Mq</blockquote>
</p>

<div class="alert alert-error">
	<h3>Warning</h3>
	<p>
		This tool is intended for <strong>non-life-threatening</strong> situations only, and is likely not the best way to find the location of a mobile device. If you are working with an emergency services organization, you should take the following steps before using this app:
		<ol>
			<li>Ask the subject to dial 911</li>
			<li>Contact the Air Force Rescue Coordination Center and request cell phone forensics support</li>
		</ol>
	</p>

</div>

@include('tagline')