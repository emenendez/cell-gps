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

      {{ Form::model($user, array('route' => 'register-submit', 'class' => 'form-signin')) }}
        <h2 class="form-signin-heading">Register</h2>
        @if (count($errors->all()))
          <div class="alert alert-error">
            @foreach ($errors->all() as $message)
              <strong>Error:</strong> {{ $message }}<br>
            @endforeach
          </div>
        @endif
        {{ Form::input('email', 'email', '', array('class' => 'input-block-level', 'placeholder' => 'Email address', 'required')) }}
        {{ Form::input('password', 'password', '', array('class' => 'input-block-level', 'placeholder' => 'Password', 'required')) }}
        {{ Form::input('password', 'password_confirmation', '', array('class' => 'input-block-level', 'placeholder' => 'Confirm password', 'required')) }}
        {{ Form::input('text', 'organization', '', array('class' => 'input-block-level', 'placeholder' => 'Organization')) }}
        {{ Form::submit('Sign up', array('class' => 'btn btn-large btn-primary')) }}
        {{ link_to_route('index', 'Cancel', array(), array('class' => 'btn btn-large')) }}
      {{ Form::close() }}

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

  </body>
</html>
