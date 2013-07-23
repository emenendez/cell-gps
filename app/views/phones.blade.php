<!DOCTYPE html>
<?php
$providers = array(
  '' => 'Other',
  'message.alltel.com' => 'Alltel',
  'txt.att.net' => 'AT&T',
  'txt.bellmobility.ca' => 'Bell Canada',
  'myboostmobile.com' => 'Boost Mobile',
  'sms.mycricket.com' => 'Cricket',
  'messaging.nextel.com' => 'Nextel (now Sprint Nextel)',
  'pcs.ntelos.com' => 'nTelos',
  'messaging.sprintpcs.com' => 'Sprint (now Sprint Nextel)',
  'tmomail.net' => 'T-Mobile',
  'email.uscc.net' => 'US Cellular',
  'vtext.com' => 'Verizon',
  'vmobl.com' => 'Virgin Mobile'
  );
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Cellular geolocation web app</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="{{ asset('css/bootstrap-responsive.min.css') }}" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="{{ asset('js/html5shiv.js') }}"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="http://www.asrc.net"><img src="{{ asset('img/asrclogo.gif') }}" style="margin: -8px 0;" alt="ASRC" width="29" height="29" /></a>
          <a class="brand" href="#">Cell GPS</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as {{ link_to_route('logout', Auth::user()->email, array(), array('class' => 'navbar-link')) }}
            </p>
            <ul class="nav">
              <li><a href="#" data-toggle="collapse" data-target="#help">Help</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid collapse" id="help">
        <div class="span12 well">
          <p>Welcome... This web app provides the ability to prompt a recipient to share their location via a text message sent to their cell phone containing a URL link. By clicking on the link, the recipient is permitting the phone to send its current location as determined by the location services enabled on the device.</p>
          <p><strong>This app cannot &#8220;turn on&#8221; location services or independently extract location without acknowledgement by the recipient!</strong></p>
          <p>Example of the text:
            <pre>asrc_admin@eucalyptus.dreamhost.com(ASRCAdministrator) S:Tap link to send location to SAR M:http://gps.asrc.net/Mq</pre>
          </p>
          <p>To send an SMS message from this web app, the sender must provide the phone's SMS gateway. A list of SMS gateways for some of the major North American providers is included. <a href="http://en.wikipedia.org/wiki/List_of_SMS_gateways">A more complete list is available here</a> and/or by Googling.</p>
          <p>Questions/comments/suggestions/defects: <a href="mailto:ericmenendez@gmail.com">ericmenendez@gmail.com</a></p>
        </div>
      </div>
      <div class="row-fluid" id="sms">
        <div class="span12">
          <h2>Send SMS requesting location</h2>
          {{ Form::open(array('url' => '/', 'class' => 'form-inline')) }}
            <h6>SMS email address:</h6>
            <div class="controls controls-row">
              {{ Form::label('provider', 'Provider') }} {{ Form::select('provider', $providers, '', array('class' => 'input-small')) }}
              <span class="input-append">
                {{ Form::text('phone', '', array('placeholder' => 'Phone No.', 'class' => 'input-small')) }}
              </span><span class="input-prepend input-append">
                <span></span><span class="add-on">@</span><span></span>
              </span><span class="input-prepend">
                {{ Form::text('gateway', '', array('placeholder' => 'Gateway', 'class' => 'input-small')) }}
              </span>
              {{ Form::text('subject', '', array('placeholder' => 'Message subject')) }}
              {{ Form::text('message', '', array('placeholder' => 'Message body')) }}

              {{ Form::submit('Send', array('class' => 'btn btn-primary')) }}
            </div>
            <h6>Message preview:</h6>
            <p><span id="preview"></span></p>
          {{ Form::close() }}
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Location</th>
                <th>Accuracy (m)</th>
                <th>Altitude (m)</th>
                <th>Heading (deg)</th>
                <th>Speed (m/s)</th>
                <th>Time of location</th>
                <th>Time received</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $phones = Phone::where('user_id', Auth::user()->id)
                  ->orWhere('user_id', 1)
                  ->orderBy('created_at', 'desc')
                  ->get();
              ?>
              @foreach ($phones as $phone)
                <tr>
                  <?php
                    $location = $phone->locations()->orderBy('created_at', 'desc')->first();
                  ?>
                  <td>{{ link_to_route('phone', $phone->id, array($phone->id)) }}</td>
                  <td>{{ link_to_route('phone', $phone->email, array($phone->id), array('title' => 'SMS sent ' . $phone->created_at )) }}</td>
                  <td>{{ HTML::link('http://maps.google.com/maps?q=' . urlencode($location->location), $location->location) }}</td>
                  <td>{{ $location->accuracy }}</td>
                  <td>{{ $location->altitude ? $location->altitude . '&#xB1;' . $location->altitudeAccuracy . 'm' : '' }}</td>
                  <td>{{ $location->heading }}</td>
                  <td>{{ $location->speed }}</td>
                  <td>{{ $location->location_time }}</td>
                  <td>{{ $location->created_at }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; ASRC 2013. {{ HTML::mailto('ericmenendez@gmail.com', 'Comments/Suggestions/Bugs/Questions') }}</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

  </body>
</html>
