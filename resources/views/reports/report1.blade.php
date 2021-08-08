@extends('layouts.main')

@section('page-title', __('Report 1'))
@section('page-heading', __('Report 1'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('clients.index')}}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{route('clients.show', $client)}}">{{ $client->present()->name ?? $client->email }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Report 1')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h1>@lang('Report 1')</h1>
    @include('reports.partials.header', ['route' => 'reports.report1'])

    @if (count($expenses))
        <h2>@lang('Expense') <small>({{count($expenses)}})</small></h2>
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
                        @foreach ($expenses as $item)
                            <tr data-href="{{ route('documents.show', $item) }}" class="text-danger">
                                <td><a class="text-danger"
                                       href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                <td>{{ $item->document_date }}</td>
                                <td>
                                    <a href="{{route('clients.expenses', ['client' => $client, 'expense_type' => $item->expense_type])}}">{{ $item->expense_type->name ?? __('Other Expense') }}</a>
                                </td>
                                <td>{{ number_format($item->sum / $item->currency->value, 2) }}</td>
                                <td>{{number_format($item->vat / $item->currency->value, 2)}}</td>
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
                            <tr data-href="{{ route('documents.show', $item) }}" class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                <td>{{ $item->document_date }}</td>
                                <td>{{ $item->dt->name ?? __('Other Income') }}</td>
                                <td>{{ number_format($item->sum / $item->currency->value, 2) }}</td>
                                <td>{{number_format($item->vat / $item->currency->value, 2)}}</td>
                            </tr>
                        @endforeach
                        @foreach ($invoices_with_vat as $item)
                            <tr data-href="{{ route('invoice.show', $item) }}" class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('invoice.show', $item) }}">{{ $item->invoice_number }}</a>
                                </td>
                                <td>{{ $item->invoice_date }}</td>
                                <td>{{ $item->dt->name ?? __('Other Income') }}</td>
                                <td>{{ number_format($item->total_amount / $item->currency->value, 2) }}</td>
                                <td>{{ number_format($item->total_amount / $item->currency->value * $item->tax_percent / 100, 2) }}</td>
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
                            <tr data-href="{{ route('documents.show', $item) }}" class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                <td>{{ $item->document_date }}</td>
                                <td>{{ $item->dt->name ?? __('Other Income') }}</td>
                                <td>{{ number_format($item->sum / $item->currency->value, 2) }}</td>
                                <td>{{number_format($item->vat / $item->currency->value, 2)}}</td>
                            </tr>
                        @endforeach
                        @foreach ($invoices_without_vat as $item)
                            <tr data-href="{{ route('invoice.show', $item) }}" class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('invoice.show', $item) }}">{{ $item->invoice_number }}</a>
                                </td>
                                <td>{{ $item->invoice_date }}</td>
                                <td>{{ $item->dt->name ?? __('Other Income') }}</td>
                                <td>{{ number_format($item->total_amount / $item->currency->value, 2) }}</td>
                                <td>{{ number_format($item->total_amount / $item->currency->value * $item->tax_percent / 100, 2) }}</td>
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
                            <tr data-href="{{ route('documents.show', $item) }}" class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                <td>{{ $item->document_date }}</td>
                                <td>{{ $item->dt->name ?? __('Other Income') }}</td>
                                <td>{{ number_format($item->sum / $item->currency->value, 2) }}</td>
                                <td>{{number_format($item->vat / $item->currency->value, 2)}}</td>
                            </tr>
                        @endforeach
                        @foreach ($acceptances as $item)
                            <tr data-href="{{ route('documents.show', $item) }}" class="text-success">
                                <td><a class="text-success"
                                       href="{{ route('invoice.show', $item) }}">{{ $item->invoice_number }}</a>
                                </td>
                                <td>{{ $item->invoice_date }}</td>
                                <td>{{ $item->dt->name ?? __('Other Income') }}</td>
                                <td>{{ number_format($item->total_amount / $item->currency->value, 2) }}</td>
                                <td>{{ number_format($item->total_amount  / $item->currency->value * $item->tax_percent / 100, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif


@endsection
