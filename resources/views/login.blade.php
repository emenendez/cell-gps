<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login | Cellular geolocation web app</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
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
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
      .register-box {
        max-width: 300px;
        padding: 19px 29px 19px;
        margin: 0 auto 0;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }

    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="{{ asset('js/html5shiv.js') }}"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  </head>

  <body>

    <div class="container">
      <div class="row">
        <div class="span8">
        <h1>ASRC Cell GPS</h1>
        @include('help')       
        </div>
        <div class="span4">
          <div class="register-box">
            <form action="{{ route('login') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <h2 class="form-signin-heading">Please sign in</h2>
              @unless ($error == '')
                <div class="alert alert-error">
                  {{ $error }}
                </div>
              @endunless
              <input type="email" name="email" class="input-block-level" placeholder="E-mail address" required>
              <input type="password" name="password" class="input-block-level" placeholder="Password" required>
              <label class="checkbox">
                <input type="checkbox" name="remember" checked="false"> Remember me
              </label>
              <input type="submit" value="Sign in" class="btn btn-large btn-primary">
              <a href="{{ route('login-guest') }}" class="btn btn-large">Sign in as guest</a>
            </form>

            <a href="{{ route('register') }}" class="btn btn-large btn-block">Register</a>
          </div>
        </div>

      </div>
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
