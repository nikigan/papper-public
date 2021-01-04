@extends('layouts.app')

@section('page-title', __('Add Vendor'))
@section('page-heading', __('Create New Vendor'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('vendors.index') }}">@lang('Vendors')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Create Vendor')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'vendors.store']) !!}
    <div class="card">
        <div class="card-body">
            @include('vendors.partial.details')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Create Vendor')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
