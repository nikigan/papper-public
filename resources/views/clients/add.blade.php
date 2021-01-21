@extends('layouts.main')

@section('page-title', __('Add Client'))
@section('page-heading', __('Create New Client'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('clients.index') }}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Create Client')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'clients.store', 'files' => true, 'id' => 'user-form']) !!}
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
                    @include('clients.partials.details', ['edit' => false, 'profile' => false])
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

                    {{ $edit = false }}
                    <div class="form-group">
                        <label for="email">@lang('Email')</label>
                        <input type="email"
                               class="form-control input-solid"
                               id="email"
                               name="email"
                               placeholder="@lang('Email')"
                               required
                               value="{{ $edit ? $user->email : old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="username">@lang('Username')</label>
                        <input id="username"
                               autocapitalize="off"
                               autocomplete="off"
                               class="form-control input-solid"
                               name="username"
                               placeholder="(@lang('optional'))"
                               type="text"
                               value="{{ $edit ? $user->username : old('username') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Create User')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop

@section('scripts')
    {!! HTML::script('assets/js/as/profile.js') !!}
@stop
