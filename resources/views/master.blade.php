<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cellular geolocation web app</title>
    <meta name="description" content="Locate a cell phone with an SMS">
    <meta name="viewport" content="width=device-width">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <!-- Le styles -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="{{ asset('js/html5shiv.js') }}"></script>
    <![endif]-->
  </head>
  <body ng-app="cellGpsAngularApp" ng-controller="MainCtrl">
    <!--[if lte IE 8]>  
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.asrc.net"><img src="{{ asset('img/asrclogo.gif') }}" alt="ASRC" width="29" height="29" /></a>
          <a class="navbar-brand" href="{{ route('index') }}">Cell GPS</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <div class="navbar-form navbar-left">
            <a href="#" class="btn btn-danger" ng-click="showHelp = !showHelp" ng-class="{active: showHelp}">Help</a>
          </div>
          <p class="navbar-text navbar-right">
            Signed in as <a class="navbar-link" href="{{ route('logout') }}">{{ Auth::user()->email }}</a>
          </p>
        </div>
      </div>
    </nav>

    <div class="app container-fluid">
      <div id="help" class="row" ng-show="showHelp">
        <div class="col-sm-12">
          @include('help')
        </div>
      </div>

      <div id="send" class="row">
        <div class="col-sm-12">
          <h2>Send SMS requesting location</h2>
          <form action="{{ route('messages.store') }}" method="POST" class="form-inline">
            <input class="form-control" type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="form-control" type="text" name="phone" id="phone" placeholder="Phone No." title="Subject's mobile phone number" required>
            <input class="form-control" type="text" name="message" id="message" placeholder="Message (optional)" maxlength="290">
            <button class="btn btn-default" type="submit">Send</button>
          </form>
        </div>
      </div>

      <div id="dashboard" class="row">
        <div class="col-sm-12">
          <h1>Phones</h1>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Phone</th>
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
              <tr ng-repeat="phone in phones">
                <td>@{{ phone.id }}: @{{ phone.token }}</td>
                <td>@{{ phone.number_pretty }}: @{{ phone.created_at }}</td>
                <td>@{{ phone.last_location.location }}</td>
                <td>@{{ phone.last_location.accuracy }}</td>
                <td>@{{ phone.last_location.altitude }} &#xB1; @{{ phone.last_location.altitudeAccuracy }}</td>
                <td>@{{ phone.last_location.heading }}</td>
                <td>@{{ phone.last_location.speed }}</td>
                <td>@{{ phone.last_location.location_time }}</td>
                <td>@{{ phone.last_location.created_at }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <footer class="container-fluid">
      @include('tagline')
    </footer>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID -->
     <script>
       !function(A,n,g,u,l,a,r){A.GoogleAnalyticsObject=l,A[l]=A[l]||function(){
       (A[l].q=A[l].q||[]).push(arguments)},A[l].l=+new Date,a=n.createElement(g),
       r=n.getElementsByTagName(g)[0],a.src=u,r.parentNode.insertBefore(a,r)
       }(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

       ga('create', 'UA-XXXXX-X');
       ga('send', 'pageview');
    </script>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular-resource.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-poller/0.4.1/angular-poller.js"></script>
    <script src="{{ asset('js/all.js') }}"></script>
  </body>
</html>
