@extends('layouts.app')

@section('page-title', __('Edit Document Type'))
@section('page-heading', __('Edit Document Type'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('document_types.index') }}">@lang('Document Types')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang($documentType->name)</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    <form action="{{route('currency.update', $currency)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('Currency Name')</label>
                            <input type="text" class="form-control input-solid" id="name"
                                   name="name" placeholder="@lang('Currency Name')" required value="{{ $currency->name }}">
                        </div>
                        <div class="form-group">
                            <label for="sign">@lang('Currency Sign')</label>
                            <input type="text" class="form-control input-solid" id="sign"
                                   name="sign" placeholder="@lang('Currency Sign')" required value="{{ $currency->sign }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="iso">@lang('ISO code')</label>
                            <input type="text" maxlength="3" class="form-control input-solid" id="iso"
                                   name="iso_code" placeholder="@lang('Type Prefix')" required value="{{ $currency->iso_code }}">
                        </div>
                        <div class="form-group">
                            <label for="value">@lang('Currency Value')</label>
                            <input type="number" step="0.001" class="form-control input-solid" id="value"
                                   name="value" placeholder="@lang('Currency Value')" required value="{{ $currency->value }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    @lang('Edit Currency')
                </button>
            </div>
        </div>
    </form>

    <br>
@stop
