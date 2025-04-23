<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('vendor/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    @yield('styles')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('vendor.nav')
            @include('vendor.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            @include('vendor.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('vendor/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/popper.js') }}"></script>
    <script src="{{ asset('vendor/modules/tooltip.js') }}"></script>
    <script src="{{ asset('vendor/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    @yield('scripts')

    <!-- Template JS File -->
    <script src="{{ asset('vendor/js/scripts.js') }}"></script>
    <script src="{{ asset('vendor/js/custom.js') }}"></script>
</body>

</html>
