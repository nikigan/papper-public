@extends('layouts.app')

@section('page-title', 'Upload document')
@section('page-heading', 'Upload document')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a href="{{ route('upload-document') }}">@lang('Upload document')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')


@stop
