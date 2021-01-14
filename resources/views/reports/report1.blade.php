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
                                       value="{{Request::get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"))}}">
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

    @if (count($expenses))
    <h2>@lang('Expense') <small>({{count($expenses)}})</small></h2>
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
                        @foreach ($expenses as $item)
                            <tr class="text-danger">
                                <td><a class="text-danger"
                                       href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                <td>{{ $item->document_date }}</td>
                                <td>{{ $item->expense_type->name ?? 'Other' }}</td>
                                <td>{{ number_format($item->sum, 2) }}</td>
                                <td>{{number_format($item->vat, 2)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    @if (count($incomes_with_vat) || count($invoices_with_vat))
        <h2>@lang('Income') <small>({{count($incomes_with_vat) + count($invoices_with_vat)}})</small></h2>
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
                        @foreach ($incomes_with_vat as $item)
                            <tr class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                <td>{{ $item->document_date }}</td>
                                <td>{{ $item->dt->name ?? 'Other' }}</td>
                                <td>{{ number_format($item->sum, 2) }}</td>
                                <td>{{number_format($item->vat, 2)}}</td>
                            </tr>
                        @endforeach
                        @foreach ($invoices_with_vat as $item)
                            <tr class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('invoice.show', $item) }}">{{ $item->invoice_number }}</a>
                                </td>
                                <td>{{ $item->invoice_date }}</td>
                                <td>{{ $item->dt->name ?? 'Other' }}</td>
                                <td>{{ number_format($item->total_amount, 2) }}</td>
                                <td>{{ number_format($item->total_amount * $item->tax_percent / 100, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if (count($incomes_without_vat) || count($invoices_without_vat))
        <h2>@lang('Income without VAT') <small>({{count($incomes_without_vat)+count($invoices_without_vat)}})</small>
        </h2>
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
                        @foreach ($incomes_without_vat as $item)
                            <tr class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                <td>{{ $item->document_date }}</td>
                                <td>{{ $item->dt->name ?? 'Other' }}</td>
                                <td>{{ number_format($item->sum, 2) }}</td>
                                <td>{{number_format($item->vat, 2)}}</td>
                            </tr>
                        @endforeach
                        @foreach ($invoices_without_vat as $item)
                            <tr class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('invoice.show', $item) }}">{{ $item->invoice_number }}</a>
                                </td>
                                <td>{{ $item->invoice_date }}</td>
                                <td>{{ $item->dt ?? 'Other' }}</td>
                                <td>{{ number_format($item->total_amount, 2) }}</td>
                                <td>{{ number_format($item->total_amount * $item->tax_percent / 100, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if (count($document_acceptances) || count($acceptances))
        <h2>@lang('Income without taxes') <small>({{count($document_acceptances) + count($acceptances)}})</small></h2>
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
                        @foreach ($document_acceptances as $item)
                            <tr class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                <td>{{ $item->document_date }}</td>
                                <td>{{ $item->dt->name ?? 'Other' }}</td>
                                <td>{{ number_format($item->sum, 2) }}</td>
                                <td>{{number_format($item->vat, 2)}}</td>
                            </tr>
                        @endforeach
                        @foreach ($acceptances as $item)
                            <tr class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('invoice.show', $item) }}">{{ $item->invoice_number }}</a>
                                </td>
                                <td>{{ $item->invoice_date }}</td>
                                <td>{{ $item->dt ?? 'Other' }}</td>
                                <td>{{ number_format($item->total_amount, 2) }}</td>
                                <td>{{ number_format($item->total_amount * $item->tax_percent / 100, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif


@endsection
