@extends('layouts.app')

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
    <h1>@lang('Report') @lang('Tax')</h1>
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
                <div class="tax-block">
                    <span class="tax-block__title">@lang('VAT Number')</span>
                    <h3>{{$client->vat_number}}</h3>
                </div>
            </div>
        </div>
    </div>

    <h2>@lang('Tax')</h2>
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
