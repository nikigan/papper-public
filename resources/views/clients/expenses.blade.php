@extends('layouts.main')

@section('page-title', __('Expenses'))
@section('page-heading', __('Expenses'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('clients.index') }}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('clients.show', ['client' => $client]) }}">
            {{ $client->present()->nameOrEmail }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        <a href="">@lang('Expenses')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')

    <h4>{{$expense_type->name}}</h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                @include('document.partials.table')
            </div>
        </div>
    </div>
@endsection
