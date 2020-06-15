@extends('site.layouts.app')

@section('content')
<p class="alert alert-danger">This app cannot "turn on" location services or independently extract location without acknowledgement by the recipient.</p>

<p>This web app provides the ability to prompt a recipient to share his/her location via a text message sent to his/her mobile phone containing a URL link. By tapping the link, the recipient permits the phone to send its current location as determined by the location services enabled on the device.</p>

<p>Example of a text message:
	<blockquote>Tap link to send location to SAR: {{ route('home') }}/1df5</blockquote>
</p>

<p>The unique URL that is generated for the user will only contain the following characters: abdegjkmnpqrvwxyz23456789</p>

<p>Things to note:</p>
<ul>
    <li>no capital letters are used</li>
    <li>easily confused combinations aren't used: 1, l</li>
</ul>

<h3>Join</h3>
<p>
    This tool is provided, free of charge to Search and Rescue organizations and their members.  <a href="{{ route('register') }}">Join now!</a>
</p>

<h3>Warning</h3>
<p>
    This tool is intended for <strong>non-life-threatening</strong> situations only, and is likely not the best way to find the location of a mobile device. If you are working with an emergency services organization, you should take the following steps before using this app:
    <ol>
        <li>Ask the subject to dial 911</li>
        <li>Contact the Air Force Rescue Coordination Center and request cell phone forensics support</li>
    </ol>
</p>

<h3>Support</h3>

<p>Every effort is made to provide a stable, reliable service.  Ultimately, no warranty or guarantee of service is provided by this service.</p>

<p>Contact Chris Thompson for support</p>
<ul>
    <li>e: <a href="mailto:christhompsontldr@gmail.com">christhompsontldr@gmail.com</a></li>
    <li>p: <a href="tel:7042660594">704.266.0594</a></li>
</ul>
@endsection
