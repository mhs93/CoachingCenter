<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>

    {{-- Fav Icon --}}
    <link rel="icon" width="33px" height="33px" type="image/x-icon" href="{{ asset('images/setting/favicon/'.setting('favicon')) }}">
    {{-- Fav Icon End --}}

    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/simplebar/css/simplebar.css')}}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/vendors/simplebar.css')}}">
    <!-- Main styles for this application-->
    <link href="{{ asset('dashboard/css/style.css')}}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link href="{{ asset('dashboard/css/examples.css')}}" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        // Shared ID
        gtag('config', 'UA-118965717-3');
        // Bootstrap ID
        gtag('config', 'UA-118965717-5');
    </script>
    <link href="{{ asset('vendors/@coreui/chartjs/css/coreui-chartjs.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .icon-m-r .nav-link i {
            margin-right: 7px;
            font-size: 20px;
        }
    </style>

    @stack('css');
</head>
<body>
{{-- Sidebar --}}
@include('layouts.dashboard.partials.sidebar')
{{--/.Sidebar--}}

<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    {{-- Header --}}
    @include('layouts.dashboard.partials.header')
    {{--./ Header --}}

    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            @yield('content')
        </div>
    </div>
    <footer class="footer">
        <div><a href="https://coreui.io">CoreUI </a><a href="https://coreui.io">Bootstrap Admin Template</a> © 2022 creativeLabs.</div>
        <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/docs/">CoreUI UI Components</a></div>
    </footer>
</div>

<!-- CoreUI and necessary plugins-->
<script src="{{ asset('dashboard/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('dashboard/vendors/simplebar/js/simplebar.min.js') }}"></script>
<!-- Plugins and scripts required by this view-->
<script src="{{ asset('dashboard/vendors/chart.js/js/chart.min.js') }}"></script>
<script src="{{ asset('dashboard/vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
<script src="{{ asset('dashboard/vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
<script src="{{ asset('dashboard/js/main.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>

<!-- Tostr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<script>
    @if(Session::has('t-success'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        };

        toastr.success("{{ session('t-success') }}");
    @endif

    @if(Session::has('t-error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        };
        toastr.error("{{ session('t-error') }}");
    @endif

    @if(Session::has('t-info'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        };
        toastr.info("{{ session('t-info') }}");
    @endif

    @if(Session::has('t-warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        };
        toastr.warning("{{ session('t-warning') }}");
    @endif
</script>

@stack('js')

</body>
</html>
