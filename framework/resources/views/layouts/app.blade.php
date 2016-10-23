<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', trans('app.login')) | Watchdog!</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,00,600|Open+Sans:300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.png') }}">
</head>
<body>

<div id="wrapper">
    @yield('content')
</div>

<script src="//code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/login.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>
<script type="text/javascript">
    @if(session()->has('message'))
        var type = "{{ session('alert_type', 'info') }}";
        toastr.options = {"newestOnTop": true, "positionClass": "toast-bottom-right", "showDuration": "1000"};
        toastr[type]("{{ session('message') }}");
    @endif
</script>
</body>
</html>