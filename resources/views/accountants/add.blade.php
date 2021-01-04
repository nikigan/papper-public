@extends('layouts.app')

@section('page-title', __('Add Accountant'))
@section('page-heading', __('Create New Accountant'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('accountants.index') }}">@lang('Accountants')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Create Accountant')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'accountants.store', 'files' => true, 'id' => 'user-form']) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        @lang('User Details')
                    </h5>
                    <p class="text-muted font-weight-light">
                        @lang('A general user profile information.')
                    </p>
                </div>
                <div class="col-md-9">
                    @include('accountants.partials.details', ['edit' => false, 'profile' => false])
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        @lang('Login Details')
                    </h5>
                    <p class="text-muted font-weight-light">
                        @lang('Details used for authenticating with the application.')
                    </p>
                </div>
                <div class="col-md-9">
                    @include('user.partials.auth', ['edit' => false])
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Create Accountant')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop

@section('scripts')
    {!! HTML::script('assets/js/as/profile.js') !!}
{{--    {!! JsValidator::formRequest('Vanguard\Http\Requests\CreateAccountantRequest', '#user-form') !!}--}}
@stop
