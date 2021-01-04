@extends('layouts.app')

@section('page-title', __('Add Currency'))
@section('page-heading', __('Add Currency'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('currency.index') }}">@lang('Currencies')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Add Currency')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'currency.store']) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">@lang('Currency Name')</label>
                        <input type="text" class="form-control input-solid" id="name"
                               name="name" placeholder="@lang('Currency Name')" required value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="sign">@lang('Currency Sign')</label>
                        <input type="text" class="form-control input-solid" id="sign"
                               name="sign" placeholder="@lang('Currency Sign')" required value="{{ old('sign') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="iso">@lang('ISO code')</label>
                        <input type="text" maxlength="3" class="form-control input-solid" id="iso"
                               name="iso_code" placeholder="@lang('Type Prefix')" required value="{{ old('iso') }}">
                    </div>
                    <div class="form-group">
                        <label for="value">@lang('Currency Value')</label>
                        <input type="number" step="0.001" class="form-control input-solid" id="value"
                               name="value" placeholder="@lang('Currency Value')" required value="{{ old('value') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Add Currency')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
