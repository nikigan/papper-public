@extends('layouts.app')

@section('page-title', __('Add Customer'))
@section('page-heading', __('Create New Customer'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('customers.index') }}">@lang('Customers')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Create Customer')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'customers.store']) !!}
    <div class="card">
        <div class="card-body">
            @include('customers.partial.details')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Create Customer')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
