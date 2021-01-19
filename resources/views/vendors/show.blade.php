@extends('layouts.main')

@section('page-title', __('Vendor'))
@section('page-heading', __('Vendor'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('vendors.index') }}">@lang('Vendors')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>{{ $vendor->name }}</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    <form action="{{route('vendors.update', $vendor)}}" method="POST">
        @csrf
        @method('PUT')
    <div class="card">
        <div class="card-body">
            @include('vendors.partial.details', ['edit' => true])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Update Vendor')
            </button>
        </div>
    </div>
    </form>

    <br>
@stop
