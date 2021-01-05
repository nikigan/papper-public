@extends('layouts.app')

@section('page-title', __('Last documents'))
@section('page-heading', __('Last documents'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('clients.index') }}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('clients.show', ['client' => $user]) }}">
            {{ $user->present()->nameOrEmail }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        <a href="">@lang('Last documents')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')

    <ul class="nav nav-pills pb-3">
        <li class="nav-item">
            <a class="nav-link @if(!$waiting)active @endif" href="{{route('clients.last', ['client' => $user])}}">@lang('Last')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($waiting) active @endif" href="{{route('clients.waiting', ['client' => $user])}}">@lang('Waiting')</a>
        </li>
    </ul>

    <h4>@lang('Documents')</h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" id="users-table-wrapper">
                @include('document.partials.table')
                @extends('document.partials.table')
                @section('table-head')
                    <h1>Hello world</h1>
                    @stop

            </div>
        </div>
    </div>
@endsection
