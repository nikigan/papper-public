@extends('layouts.app')

@section('page-title', __('Report') . '1')
@section('page-heading', __('Report') . '1')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('clients.index')}}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{route('clients.show', $client)}}">{{ $client->present()->name ?? $client->email }}</a>
    </li>
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
                                       value="{{Request::get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-1 month"))}}">
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

    <h2>@lang('Expense')</h2>
    <div class="card">
        <div class="card-body">
{{--            @include('reports.partials.table', ['items' => $expenses, 'columns' => $expenses_columns, 'class' => 'text-danger'])--}}
            <div class="table-responsive">
                <table class="table table-borderless table-striped">
                    <thead>
                    <tr>
                        <th>@lang('#')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Type')</th>
                        <th>@lang('Sum')</th>
                        <th>@lang('VAT')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($expenses))
                        @foreach ($expenses as $item)
                            <tr class="text-danger">
                                <td><a class="text-danger" href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                <td>{{ $item->document_date }}</td>
                                <td>{{ $item->expense_type->name ?? 'Other' }}</td>
                                <td>{{ number_format($item->sum, 2) }}</td>
                                <td>{{number_format($item->vat, 2)}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5"><em>@lang('No records found.')</em></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <h2>@lang('Income')</h2>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-striped">
                    <thead>
                    <tr>
                        <th>@lang('#')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Type')</th>
                        <th>@lang('Sum')</th>
                        <th>@lang('VAT')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($incomes))
                        @foreach ($incomes as $item)
                            <tr class="text-success">
                                <td><a class="text-success" href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                <td>{{ $item->document_date }}</td>
                                <td>{{ $item->dt->name ?? 'Other' }}</td>
                                <td>{{ number_format($item->sum, 2) }}</td>
                                <td>{{number_format($item->vat, 2)}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5"><em>@lang('No records found.')</em></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <h2>@lang('Income without VAT')</h2>
    <div class="card">
        <div class="card-body">
            @include('reports.partials.table', ['items' => $expenses, 'columns' => $expenses_columns, 'class' => 'text-danger'])
        </div>
    </div>

@endsection
