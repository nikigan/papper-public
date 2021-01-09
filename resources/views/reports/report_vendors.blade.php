@extends('layouts.app')

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
