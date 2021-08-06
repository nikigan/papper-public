@extends('layouts.main')

@section('page-title', __('Report') . ' ' . __('Customers'))
@section('page-heading', __('Report') . ' ' . __('Customers'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('clients.index')}}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{route('clients.show', $client)}}">{{ $client->present()->name ?? $client->email }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a>{{__('Report') . ' ' . __('Customers')}}</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h1>@lang('Report') @lang('Customers')</h1>
    @include('reports.partials.header', ['route' => 'reports.report_customers'])

    @if (count($customers))
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped">
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
                                <td>
                                    <a href="{{ route('customers.show', ['customer' => $customer['id']]) }}">{{ $customer['name'] ?? 'N/A'}}</a>
                                <td>{{ $customer['vat_number'] ?? 'N/A'}}</td>
                                <td>{{ $customer['amount'] ?? 'N/A'}}</td>
                                <td>{{ number_format($customer['sum'], 2) ?? 'N/A'}}</td>
                                <td>{{ number_format($customer['avg'], 2) ?? 'N/A'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

@endsection
