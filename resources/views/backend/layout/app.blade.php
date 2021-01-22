<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend.layout.meta')

    <title>{{ _site_name() }} | @yield('title')</title>

    @include('backend.layout.styles')
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        @include('backend.layout.header')

        @include('backend.layout.left-sidebar')

        <div class="content-wrapper">

            @yield('content')

            @include('backend.layout.footer')
        </div>
    </div>

    @include('backend.layout.right-sidebar')

    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>

    @include('backend.layout.scripts')
</body>

</html>
