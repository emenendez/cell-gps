<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sign Up | Cellular geolocation web app</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"],
      .form-signin input[type="email"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
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

    <div class="container">

      <form action="{{ route('register-submit') }}" method="POST" class="form-signin">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <h2 class="form-signin-heading">Register</h2>
        @if (count($errors->all()))
          <div class="alert alert-error">
            @foreach ($errors->all() as $message)
              <strong>Error:</strong> {{ $message }}<br>
            @endforeach
          </div>
        @endif
        <input type="email" name="email" placeholder="E-mail address" class="input-block-level" required>
        <input type="password" name="password" placeholder="Password" class="input-block-level" required>
        <input type="password" name="password_confirmation" placeholder="Confirm password" class="input-block-level" required>
        <input type="text" name="organization" placeholder="Organization" class="input-block-level">
        <input type="submit" value="Sign up" class="btn btn-large btn-primary">
        <a href="{{ route('index') }}" class="btn btn-large">Cancel</a>
      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.placeholder.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

  </body>
</html>
