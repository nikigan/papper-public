@extends('layouts.app')

@section('page-title', __('Add Expense Group'))
@section('page-heading', __('Add Expense Group'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('expense_groups.index') }}">@lang('Expense Groups')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Add Expense Group')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'expense_groups.store']) !!}
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
                @lang('Add Expense Group')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
