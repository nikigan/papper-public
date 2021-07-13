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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="group">@lang('Group')</label>
                            <select class="form-control" name="expense_group_id" id="group">
                                <option value="">@lang('Other')</option>
                                @foreach($expense_groups as $group)
                                    <option value="{{$group->id}}" @if($group->id == $expenseType->expense_group_id) selected @endif>@lang($group->name)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="vat_rate">@lang('VAT Rate')</label>
                            <select class="form-control" name="vat_rate_id" id="vat_rate">
                                @foreach($vat_rates as $vat_rate)
                                    <option value="{{$vat_rate->id}}" @if($vat_rate->id == $expenseType->vat_rate_id) selected @endif>{{$vat_rate->vat_rate * 100}}%</option>
                                @endforeach
                            </select>
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
