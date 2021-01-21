<!DOCTYPE html>
<html lang="{{config('app.locale')}}" dir="{{config('app.dir')}}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
    <style>

        body {
            direction: {{config('app.dir')}};
            background: inherit;
            font-size: 14px;
        }
        .tbl-total {
            width: inherit;
            border: 0;
        }
        .tbl-total th, .tbl-total tr, .tbl-total td {
            border: 0;
        }

    </style>
    <style>
        @if(config('app.dir') == "rtl")
        body {
            text-align: right;
            direction: rtl;
        }
        table * {
            text-align: right !important;
        }
        @endif
    </style>
</head>
<body>
@yield('content')
</body>
</html>
