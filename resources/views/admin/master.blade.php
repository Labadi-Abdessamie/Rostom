<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | UBold - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    @yield('styles')

    <script src="{{ asset('assets/js/head.js') }}"></script>

</head>

<!-- body start -->

<body data-layout-mode="default" data-theme="light" data-topbar-color="dark" data-menu-position="fixed"
    data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>

    <!-- Begin page -->
    <div id="wrapper">

        @include('admin.nav')
        @include('admin.sidebar')
        <div class="content-page">
            @yield('content')
            @include('admin.footer')
        </div>
    </div>
    <!-- END wrapper -->
    @include('admin.rightbar')


    <!-- Vendor JS -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    @yield('scripts')

    <!-- App JS -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>

</html>
