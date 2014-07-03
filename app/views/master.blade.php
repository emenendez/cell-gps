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
          <a class="brand" href="http://www.asrc.net"><img src="{{ asset('img/asrclogo.gif') }}" style="margin: -8px 0;" alt="ASRC" width="29" height="29" /></a>
          {{ link_to_route('index', 'Cell GPS', array(), array('class' => 'brand')) }}
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as {{ link_to_route('logout', Auth::user()->email, array(), array('class' => 'navbar-link')) }}
            </p>
            <ul class="nav">
              <li id="help-link"><a href="javascript:toggleHelp()">Help</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid collapse" id="help">
        <div class="span12 well">
          @include('help')
        </div>
      </div>
      <div class="row-fluid" id="sms">
        <div class="span12">
          <h2>Send SMS requesting location</h2>
          {{ Form::open(array('route' => 'send-sms', 'class' => 'form-inline')) }}
            @if (count($errors->all()))
              <div class="alert alert-error">
                @foreach ($errors->all() as $message)
                  <strong>Error:</strong> {{ $message }}<br>
                @endforeach
              </div>
            @endif
            <div class="controls controls-row">
              <input type="text" name="phone" placeholder="Phone No." class="input-medium" value="{{ $phone }}"
                title="Subject's mobile phone number" required>
              {{ Form::text('message', $message, array('placeholder' => 'Message (optional)', 'class' => 'input-xlarge', 'maxlength' => '290')) }}
              {{ Form::submit('Send', array('class' => 'btn btn-primary')) }}
            </div>
          {{ Form::close() }}
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
          @yield('content')
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; ASRC 2013. {{ HTML::mailto('ericmenendez@gmail.com?subject=Cell GPS Feedback', 'Feedback') }}</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/libphonenumber.js') }}"></script> {{-- from https://github.com/nathanhammond/libphonenumber/ --}}
    <script src="{{ asset('js/script.js') }}"></script>

  </body>
</html>
