@extends('layouts.app')

@section('page-title', __('Add Expense Type'))
@section('page-heading', __('Add Expense Type'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('expense_types.index') }}">@lang('Expense Types')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Add Expense Type')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'expense_types.store']) !!}
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
                @lang('Add Expense Type')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
