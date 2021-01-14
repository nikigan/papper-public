<!DOCTYPE html>
<html lang="{{config('app.locale')}}" dir="{{config('app.dir')}}">
<head>
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
    </style>
    <style>
        body {
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
</head>
<body>
@yield('content')
</body>
</html>
