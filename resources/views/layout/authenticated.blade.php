<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StudyPlanner</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js')}} "></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">
        <img src="/images/studyplanner_logo_auth.png" width="150" height="150" class="d-inline-block align-top img-fluid" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav float-right">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>
            @yield('nav')
            {{--<li class="nav-item">
                <a class="nav-link" href="/documentation">Documentation</a>
            </li>--}}
        </ul>
    </div>
</nav>
@yield('content')
<nav class="navbar fixed-bottom navbar-light bg-light row">
    <div class="col-lg-6 offset-lg-3">
        <div class="row">
            <div class="col-4 text-center">
                Portfolio
            </div>
            <div class="col-4 text-center">
                <i class="bi bi-github"></i>
            </div>
            <div class="col-4 text-center">
                <i class="bi bi-envelope"></i>
            </div>
        </div>
    </div>
</nav>
</body>
</html>
