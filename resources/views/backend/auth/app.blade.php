<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">

    @yield('meta')

    <title>{{ _site_name() }} | @yield('title')</title>

    <link href="{{ asset('backend/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/vendors/themify-icons/css/themify-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/pages/auth-light.css') }}" rel="stylesheet" />

    @yield('page-styles')
    @yield('styles')
</head>

<body class="bg-silver-300">
    @yield('content')

    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>

    <script src="{{ asset('backend/vendors/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/vendors/popper.js/dist/umd/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/vendors/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/vendors/jquery-validation/dist/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/js/app.js') }}" type="text/javascript"></script>

    @yield('page-scripts')
    @yield('scripts')

</body>

</html>
