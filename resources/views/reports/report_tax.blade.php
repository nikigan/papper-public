@extends('layouts.main')

@section('page-title', __('Report') . ' ' . __('Tax'))
@section('page-heading', __('Report') . ' ' . __('Tax'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('clients.index')}}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{route('clients.show', $client)}}">{{ $client->present()->name ?? $client->email }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a>{{__('Report') . ' ' . __('Tax')}}</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h1>@lang('Report Taxes') {{$client->present()->name}}</h1>
    @include('reports.partials.header.tax')


    <h2>@lang('VAT')</h2>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Total Income')</span>
                        <h3 class="font-weight-bold">{{$in_sum}}</h3>
                    </div>
                </div>
                <div class="col-lg-9 tax-column">
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Income VAT')</span>
                        <h3 class="text-success">{{$in_vat}}</h3>
                    </div>
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Expense VAT')</span>
                        <h3 class="text-danger">{{$exp_vat}}</h3>
                    </div>
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('VAT to pay')</span>
                        <h3 class="font-weight-bold">{{$diff_vat}}</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('VAT Number')</span>
                        <h3>{{$client->vat_number}}</h3>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Equipment VAT')</span>
                        <h3 class="text-danger">{{$equipment_vat}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2>@lang('Taxes')</h2>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Total Income')</span>
                        <h3 class="font-weight-bold">{{$in_sum}}</h3>
                    </div>
                </div>
                <div class="col-lg-4 tax-column">
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Income Tax')</span>
                        <h3 class="text-success">{{$in_tax}}</h3>
                    </div>
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Tax Percent')</span>
                        <h3>{{$client->tax_percent}}%</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 tax-column">
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('VAT Number')</span>
                        <h3>{{$client->vat_number}}</h3>
                    </div>
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('MH deductions book')</span>
                        <h3>{{$client->mh_deductions}}</h3>
                    </div>
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Book of MH Advances')</span>
                        <h3>{{$client->mh_advances}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2>@lang('Social Security')</h2>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 tax-column">
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Social Security Payment')</span>
                        <h3 class="text-success">{{$client->social_security}}</h3>
                    </div>
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Social Security register')</span>
                        <h3>{{$client->social_security_number}}</h3>
                    </div>
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('Employed insurance portfolio')</span>
                        <h3>{{$client->portfolio}}</h3>
                    </div>
                    <div class="tax-block">
                        <span class="tax-block__title">@lang('VAT Number')</span>
                        <h3>{{$client->vat_number}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
