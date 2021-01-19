@extends('layouts.excel')
@section('content')
    @if (count($customers))
        <table class="table">
            <thead>
            <tr>
                <th>@lang('Name')</th>
                <th>@lang('VAT Number')</th>
                <th>@lang('Amount')</th>
                <th>@lang('Sum')</th>
                <th>@lang('Average')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer['name'] ?? 'N/A'}}
                    <td>{{ $customer['vat_number'] ?? 'N/A'}}</td>
                    <td>{{ $customer['amount'] ?? 'N/A'}}</td>
                    <td>{{ number_format($customer['sum'], 2) ?? 'N/A'}}</td>
                    <td>{{ number_format($customer['avg'], 2) ?? 'N/A'}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@stop
