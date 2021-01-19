@extends('layouts.main')

@section('page-title', __('Report') . ' ' . __('Vendors'))
@section('page-heading', __('Report') . ' ' . __('Vendors'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('clients.index')}}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{route('clients.show', $client)}}">{{ $client->present()->name ?? $client->email }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a>{{__('Report') . ' ' . __('Vendors')}}</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h1>@lang('Report') @lang('Vendors')</h1>
    @include('reports.partials.header', ['route' => 'reports.report_vendors'])


    @if (count($vendor_groups))
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
                </div>
            </div>
        </div>
    @endif

@endsection
