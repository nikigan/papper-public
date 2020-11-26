@extends('layouts.app')

@section('page-title', 'Uploaded documents')
@section('page-heading', 'Uploaded documents')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a href="{{ Route::current()->uri() }}">@lang('Uploaded documents')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
@endsection
