@extends('layouts.app')

@section('page-title', __('Client\'s info'))
@section('page-heading', __('Clients\'s info'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('clients.index') }}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('clients.show', $client->id) }}">
            {{ $client->present()->nameOrEmail }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        <a>
            @lang('Client\'s info')
        </a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h2>@lang('Client\'s info')</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{route('clients.update', $client)}}">
                @csrf
                @method('PUT')
                @include('clients.partials.details', ['edit' => true, 'profile' => false, 'user' => $client])
            </form>
        </div>
    </div>
@endsection
