@extends('layouts.main')

@section('page-title', 'Invoice')
@section('page-heading', 'Invoice')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('invoice.index')}}">@lang('Invoices')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Invoice') {{$invoice->invoice_number}}</a>
    </li>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{__($document_name)}} @lang('number') {{ $invoice->invoice_number }}</div>

                    <div class="card-body">
                        <div class="container">

                            <div class="row clearfix">
                                @if (config('invoices.logo_file') != '')
                                    <div class="col-md-12 text-center">
                                        <img src="{{ config('invoices.logo_file') }}"/>
                                    </div>
                                @endif

                                <div class="col-md-4 offset-4 text-center">
                                    <b>{{__($document_name)}} {{ $invoice->invoice_number }}</b>
                                    <br/>
                                    {{ $invoice->invoice_date }}
                                </div>
                            </div>

                            <div class="row clearfix" style="margin-top:20px">
                                <div class="col-md-12">
                                    <div class="float-left col-md-6">
                                        <b>@lang('To')</b>:
                                        {{ $invoice->customer->name }}
                                        <br/><br/>

                                        <b>@lang('Address')</b>:
                                        {{ $invoice->customer->address }}
                                        @if ($invoice->customer->postcode != '')
                                            ,
                                            {{ $invoice->customer->postcode }}
                                        @endif
                                        , {{ $invoice->customer->city }}
                                        @if ($invoice->customer->state != '')
                                            ,
                                            {{ $invoice->customer->state }}
                                        @endif

                                        @if ($invoice->customer->phone != '')
                                            <br/><br/><b>@lang('Phone')</b>: {{ $invoice->customer->phone }}
                                        @endif
                                        @if ($invoice->customer->email != '')
                                            <br/><br/><b>@lang('Email')</b>: {{ $invoice->customer->email }}
                                        @endif
                                        @if ($invoice->customer->vat_number != '')
                                            <br/><br/><b>@lang('VAT number')</b>: {{ $invoice->customer->vat_number }}
                                        @endif
                                    </div>
                                    <div class="float-right col-md-4">
                                        <b>@lang('From')</b>: {{ $invoice->creator->present()->name() }}
                                        <br/><br/>
                                        @if ($invoice->creator->address)
                                        <b>@lang('Address')</b>: {{ $invoice->creator->address }}
                                        <br/><br/>
                                        @endif
                                        <b>@lang('Email')</b>: {{ $invoice->creator->email }}
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix" style="margin-top:20px">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover" id="tab_logic">
                                        <thead>
                                        <tr>
                                            <th class="text-center"> #</th>
                                            <th class="text-center"> @lang('Product')</th>
                                            <th class="text-center"> @lang('Qty')</th>
                                            <th class="text-center"> @lang('Price') ({{ $currency->ISO_code }})</th>
                                            <th class="text-center"> @lang('Total') ({{ $currency->ISO_code }})</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($invoice->invoice_items as $item)
                                            <tr id='addr0'>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row clearfix" style="margin-top:20px">
                                <div class="col-md-12">
                                    @if($invoice->note)
                                    <div class="float-left col-md-7">
                                        <p>{{$invoice->note}}</p>
                                    </div>
                                    @endif
                                    <div class="float-right col-md-5">
                                        <table class="table table-bordered table-hover" id="tab_logic_total">
                                            <tbody>
                                            @if($have_tax)
                                            <tr>
                                                <th class="text-center" width="60%">@lang('Sub Total')
                                                    ({{ $currency->ISO_code }})
                                                </th>
                                                <td class="text-center">{{ number_format($invoice->total_amount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-center">@lang('Tax')</th>
                                                <td class="text-center">{{ $invoice->tax_percent }}%</td>
                                            </tr>
                                            <tr>
                                                <th class="text-center">@lang('Tax Amount') ({{ $currency->ISO_code }})
                                                </th>
                                                <td class="text-center">{{ number_format($invoice->total_amount * $invoice->tax_percent / 100, 2) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th class="text-center">@lang('Grand Total') ({{ $currency->ISO_code }})
                                                </th>
                                                <td class="text-center">{{ number_format($invoice->grand_total, 2) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix" style="margin-top:20px">
                                <div class="col-md-12">
                                    {{ config('invoices.footer_text') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

