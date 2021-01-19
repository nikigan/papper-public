@extends('layouts.main')

@section('page-title', __('Customer'))
@section('page-heading', __('Customer'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('customers.index') }}">@lang('Customers')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>{{ $customer->name }}</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    <form action="{{route('customers.update', $customer)}}" method="POST">
        @csrf
        @method('PUT')
    <div class="card">
        <div class="card-body">
            @include('customers.partial.details', ['edit' => true])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Update Customer')
            </button>
        </div>
    </div>
    </form>

    <br>
@stop
