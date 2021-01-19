@extends('layouts.excel')
@section('content')
    @if (count($expenses))
        <table class="table">
            <tr>
                <th colspan="5" style="font-size: 18px; text-align: right;">
                    <span>@lang('Expense') <small>({{count($expenses)}})</small></span>
                </th>
            </tr>
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
                    <td>{{ $item->expense_type->name ?? __('Other Expense') }}</td>
                    <td>{{ number_format($item->sum / $item->currency->value, 2) }}</td>
                    <td>{{number_format($item->vat / $item->currency->value, 2)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    @if (count($incomes_with_vat) || count($invoices_with_vat))
        <table class="table">
            <tr>
                <th colspan="5" style="font-size: 18px;">
                    <span>@lang('Income') <small>({{count($incomes_with_vat) + count($invoices_with_vat)}})</small></span>
                </th>
            </tr>
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
                    <td>{{ $item->dt->name ?? __('Other Income') }}</td>
                    <td>{{ number_format($item->sum / $item->currency->value, 2) }}</td>
                    <td>{{number_format($item->vat / $item->currency->value, 2)}}</td>
                </tr>
            @endforeach
            @foreach ($invoices_with_vat as $item)
                <tr class="text-success">
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
    @endif
    @if (count($incomes_without_vat) || count($invoices_without_vat))
        <table class="table">
            <tr>
                <th colspan="5" style="font-size: 18px;">
                    <span>@lang('Income without VAT') <small>({{count($incomes_without_vat)+count($invoices_without_vat)}})</small></span>
                </th>
            </tr>
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
                    <td>{{ $item->dt->name ?? __('Other Income') }}</td>
                    <td>{{ number_format($item->sum / $item->currency->value, 2) }}</td>
                    <td>{{number_format($item->vat / $item->currency->value, 2)}}</td>
                </tr>
            @endforeach
            @foreach ($invoices_without_vat as $item)
                <tr class="text-success">
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
    @endif
    @if (count($document_acceptances) || count($acceptances))
        <table class="table">
            <tr>
                <th colspan="5" style="font-size: 18px;">
                    <span>@lang('Income without taxes') <small>({{count($document_acceptances) + count($acceptances)}})</small></span>
                </th>
            </tr>
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
                    <td>{{ $item->dt->name ?? __('Other Income') }}</td>
                    <td>{{ number_format($item->sum / $item->currency->value, 2) }}</td>
                    <td>{{number_format($item->vat / $item->currency->value, 2)}}</td>
                </tr>
            @endforeach
            @foreach ($acceptances as $item)
                <tr class="text-success">
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
    @endif

@stop
