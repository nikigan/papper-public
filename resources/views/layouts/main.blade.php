<!doctype html>
<html lang="{{config('app.locale')}}" dir="{{config('app.dir')}}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') - {{ setting('app_name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/plugins/owl/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/slick/slick-theme.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon/favicon-16x16.png') }}" sizes="16x16">

    <meta name="application-name" content="{{ setting('app_name') }}"/>

    <link media="all" type="text/css" rel="stylesheet" href="{{ url(mix('assets/css/vendor.css')) }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ url(mix('assets/css/app.css')) }}">
    <link rel="stylesheet" href="{{asset('vendor/Chart.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">


    @yield('styles')

    @hook('app:styles')
</head>
<style>
    @if(config('app.dir') == "rtl")

        body {
        text-align: right;
        direction: rtl;
    }

    .content-page {
        margin-left: unset;
        margin-right: 250px;
    }

    @media (max-width: 991.98px) {
        .content-page {
            margin-right: 0;
        }
    }

    @media (max-width: 991.98px) {
        .sidebar:not(.expanded) {
            margin-left: unset;
            margin-right: -250px;
        }
    }

    .navbar .page-header {
        margin-right: 0;
        margin-left: 15px;
    }

    .action-btn {
        float: left;
        margin-right: 10px;
    }

    .sidebar-list {
        padding-right: 0;
        text-align: right;
    }

    @else

        .action-btn {
        float: right;
        margin-left: 10px;
    }
    @endif
</style>

<body class="text-right">
@include('partials.navbar')
<div id="page-container"
     class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow side-trans-enabled">
    <div id="page-overlay"></div>
    @include('partials.client-sidebar.main')
    @include('partials.client-navbar')
    <main id="main-container" class="pr-280">
        <div class="heading__wrapper">
            <div class="content-full container py-3">
                <ol class="breadcrumb mb-0 font-weight-light">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}" class="text-muted">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    @yield('breadcrumbs')
                </ol>
            </div>
        </div>
        <div class="container py-2">
            @yield('content')
        </div>
    </main>


    {{--<div class="container-fluid">
        <div class="row">
            @include('partials.sidebar.main')

            <div class="content-page">
                <main role="main" class="px-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>--}}
</div>

<script src="{{ url(mix('assets/js/vendor.js')) }}"></script>
<script src="{{ url('assets/js/as/app.js') }}"></script>
<script src="{{asset('vendor/Chart.bundle.min.js')}}"></script>
<script src="{{asset('vendor/chartjs-plugin-datalabels.min.js')}}"></script>
<script src="{{ asset('assets/plugins/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/plugins/owl/owl.carousel.min.js') }}"></script>
<script src="{{ url('assets/js/custom.js') }}"></script>
@yield('scripts')

@hook('app:scripts')
</body>
</html>
