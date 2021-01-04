@extends('layouts.app')

@section('page-title', __('Edit Expense Type'))
@section('page-heading', __('Edit Expense Type'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('expense_types.index') }}">@lang('Expense Types')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang($expenseType->name)</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    <form action="{{route('expense_types.update', $expenseType)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('Type Name')</label>
                            <input type="text" class="form-control input-solid" id="name"
                                   name="name" placeholder="@lang('Type Name')" required value="{{ $expenseType->name }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    @lang('Edit Expense Type')
                </button>
            </div>
        </div>
    </form>

    <br>
@stop
