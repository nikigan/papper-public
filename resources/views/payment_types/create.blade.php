@extends('layouts.app')

@section('page-title', __('Add Payment Type'))
@section('page-heading', __('Add Payment Type'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('payment_types.index') }}">@lang('Payment Types')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Add Payment Type')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'payment_types.store']) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">@lang('Type Name')</label>
                        <input type="text" class="form-control input-solid" id="name"
                               name="name" placeholder="@lang('Type Name')" required value="{{ old('name') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Add Payment Type')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
