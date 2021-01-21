<!doctype html>
<html lang="{{config('app.locale')}}" dir="{{config('app.dir')}}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') - {{ setting('app_name') }}</title>

    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{ url('assets/img/icons/apple-touch-icon-144x144.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="152x152"
          href="{{ url('assets/img/icons/apple-touch-icon-152x152.png') }}"/>
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons/favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons/favicon-16x16.png') }}" sizes="16x16"/>
    <meta name="application-name" content="{{ setting('app_name') }}"/>
    <meta name="msapplication-TileColor" content="#FFFFFF"/>
    <meta name="msapplication-TileImage" content="{{ url('assets/img/icons/mstile-144x144.png') }}"/>

    <link media="all" type="text/css" rel="stylesheet" href="{{ url(mix('assets/css/vendor.css')) }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ url(mix('assets/css/app.css')) }}">
    <link rel="stylesheet" href="{{asset('vendor/Chart.min.css')}}">
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

    <body>
    @include('partials.navbar')

    <div class="container-fluid">
        <div class="row">
            @include('partials.sidebar.main')

            <div class="content-page">
                <main role="main" class="px-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="{{ url(mix('assets/js/vendor.js')) }}"></script>
    <script src="{{ url('assets/js/as/app.js') }}"></script>
    <script src="{{asset('vendor/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/chartjs-plugin-datalabels.min.js')}}"></script>
    <script src="{{ url('assets/js/custom.js') }}"></script>
    @yield('scripts')

    @hook('app:scripts')
    </body>
</html>
