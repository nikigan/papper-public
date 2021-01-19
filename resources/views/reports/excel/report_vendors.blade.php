@extends('layouts.excel')
@section('content')

    @if (count($vendor_groups))
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
            @foreach ($vendor_groups as $vendor)
                <tr>
                    <td>{{ $vendor->name ?? 'N/A'}}
                    <td>{{ $vendor->vat_number ?? 'N/A'}}</td>
                    <td>{{ $vendor->amount ?? 'N/A'}}</td>
                    <td>{{ number_format($vendor->sum, 2) ?? 'N/A'}}</td>
                    <td>{{ number_format($vendor->avg, 2) ?? 'N/A'}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

@stop
