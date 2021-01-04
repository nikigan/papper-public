@extends('layouts.app')

@section('page-title', __('Report') . '1')
@section('page-heading', __('Report') . '1')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Report') 1</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h1>@lang('Report') 1</h1>
    <div class="card">
        <div class="card-body">
            <div class="col-md-6">
                <form action="" method="GET" class="mb-0" id="search-form">

                    <div class="form-row align-items-center">
                        <div class="col">
                            <div class="form-group">
                                <label for="startDate">@lang('From'):</label>
                                <input type="date" name="start_date" class="form-control datechk" id="startDate"
                                       value="{{Request::get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-1 year"))}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="endDate">@lang('To'):</label>
                                <input type="date" name="end_date" class="form-control datechk" id="endDate"
                                       value="{{ Request::get('end_date') ?? date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">{{ __('Make report')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h2>@lang('Expenses')</h2>
    <div class="card">
        <div class="card-body">
            @include('reports.partials.table', ['items' => $expenses, 'columns' => $expenses_columns, 'class' => 'text-danger'])
        </div>
    </div>

    <h2>@lang('Income')</h2>
    <div class="card">
        <div class="card-body">
            @include('reports.partials.table', ['items' => $incomes, 'columns' => $income_columns, 'class' => 'text-success'])
        </div>
    </div>

    <h2>@lang('Income without VAT')</h2>
    <div class="card">
        <div class="card-body">
            @include('reports.partials.table', ['items' => $expenses, 'columns' => $expenses_columns, 'class' => 'text-danger'])
        </div>
    </div>

@endsection
