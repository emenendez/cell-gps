<!DOCTYPE html>
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
          <a class="brand" href="http://www.asrc.net"><img src="{{ asset('img/asrclogo.gif') }}" style="margin: -5px 0;" alt="ASRC" width="30" height="30" /></a>
          <a class="brand" href="#">Cell GPS</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link">Username</a>
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
        <div class="span12">
          <p>Welcome... This web app provides the ability to prompt a recipient to share their location via a text message sent to their cell phone containing a URL link. By clicking on the link, the recipient is permitting the phone to send its current location as determined by the location services enabled on the device.</p>
          <p><strong>This app cannot &#8220;turn on&#8221; location services or independently extract location without acknowledgement by the recipient!</strong></p>
          <p>Example of the text:<br />
            asrc_admin@eucalyptus.dreamhost.com(ASRCAdministrator) S:Tap link to send location to SAR M:http://gps.asrc.net/Mq</p>
          <p>To send an SMS message from this web app, the sender must provide the phone's SMS gateway. A list of SMS gateways for some of the major North American providers is included. <a href="http://en.wikipedia.org/wiki/List_of_SMS_gateways">A more complete list is available here</a> and/or by Googling.</p>
          <p>Questions/comments/suggestions/defects: <a href="mailto:ericmenendez@gmail.com">ericmenendez@gmail.com</a></p>
        </div>        
      </div>
      <div class="row-fluid" id="sms">
        <div class="span12">
          <h2>Send SMS requesting location</h2>
          {{ Form::open(array('url' => '/')) }}
            <p>
              <em>SMS email address:</em><br />
              {{ Form::label('provider', 'Provider') }} {{ Form::select('provider', array('1' => 'lorem')) }}
              <div class="input-prepend input-append">
                {{ Form::text('phone', '', array('placeholder' => 'Phone Number', 'class' => 'span2')) }}
                <span class="add-on">@</span>
                {{ Form::text('gateway', '', array('placeholder' => 'Gateway', 'class' => 'span2')) }}
              </div>
              {{ Form::text('subject', '', array('placeholder' => 'Message subject', 'class' => 'span2')) }}
              {{ Form::text('message', '', array('placeholder' => 'Message body', 'class' => 'span2')) }}

              {{ Form::submit('Send') }}
            </p>
            <p>
              <em>Message preview:</em><br />
              <span id="preview"></span>
            </p>
          {{ Form::close() }}
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
          <!-- table -->
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; ASRC 2013</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

  </body>
</html>
