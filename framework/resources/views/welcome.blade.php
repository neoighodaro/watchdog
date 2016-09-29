<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Watchdog! - @lang('app.login')</title>
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600|Open+Sans:300" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
  <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.png') }}">
</head>
<body>
  <div class="flex-center position-ref full-height">
    <div class="top-right links">
      <a href="https://github.com/hotelsng/watchdog" target="_blank">@lang('app.contribute')</a>
    </div>

    <div class="content">
      <div class="watchdog-logo">
        <img src="{{ asset('img/watchdog-small.png') }}">
      </div>
      <div class="title m-b-md">Watchdog!</div>
      <div class="login-form">
        <form method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}
          <div class="username-input">
            <input type="email" name="email" class="login-input username" placeholder="@lang('app.email_address')" value="{{ old('email') }}" />
          </div>
          <div class="password-input">
            <input type="password" name="password" class="login-input password" placeholder="@lang('app.password')" />
          </div>
          <div class="submit-button">
            <button type="submit" class="submit-btn" disabled>@lang('app.login')</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="//code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ asset('js/login.js') }}"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>
  <script type="text/javascript">
      @if(session()->has('message'))
      var type = "{{ session('alert_type', 'info') }}";
      toastr.options = {"newestOnTop": true, "positionClass": "toast-bottom-right", "showDuration": "1000"};
      toastr[type]("{{ session('message') }}");
      @endif
  </script>
</body>
</html>
