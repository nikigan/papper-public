@extends('layouts.app')

@section('page-title', __('Add Income Group'))
@section('page-heading', __('Add Income Group'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('income_groups.index') }}">@lang('Income Groups')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Add Income Group')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'income_groups.store']) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">@lang('Group Name')</label>
                        <input group="text" class="form-control input-solid" id="name"
                               name="name" placeholder="@lang('Group Name')" required value="{{ old('name') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button group="submit" class="btn btn-primary">
                @lang('Add Income Group')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
