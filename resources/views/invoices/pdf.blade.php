@extends('layouts.pdf')

@section('content')
    <div class="clearfix">
        <div class="text-center">
            <b>{{__($document_name)}} {{ $invoice->invoice_number }}</b>
            <br>
            {{ $invoice->invoice_date }}
        </div>
    </div>

    <div class="clearfix mt-3" style="display: flex">
        <div class="float-left" style="float: left">
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

            @if ($invoice->customer->customer_fields)
                @foreach ($invoice->customer->customer_fields as $field)
                    <br/><br/><b>{{ $field->field_key }}</b>: {{ $field->field_value }}
                @endforeach
            @endif
        </div>

        <div class="float-right" style="float:right;">
            <b>@lang('From')</b>: {{ $invoice->creator->present()->name() }}
            <br/><br/>
            @if ($invoice->creator->address)
                <b>@lang('Address')</b>: {{ $invoice->creator->address }}
                <br/><br/>
            @endif
            <b>@lang('Email')</b>: {{ $invoice->creator->email }}
        </div>
    </div>

    <div class="clearfix mt-3">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center"> #</th>
                <th>@lang('Product')</th>
                <th class="text-center">@lang('Qty')</th>
                <th class="text-center">@lang('Price') ({{ $currency->ISO_code }})</th>
                <th class="text-center">@lang('Total') ({{ $currency->ISO_code }})</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($invoice->invoice_items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-center">{{ $item->price }}</td>
                    <td class="text-center">{{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <div class="clearfix mt-3">
        @if($invoice->note)
            <div class="float-left text-right" style="width: 60%">
                <p style="text-align: right">{{$invoice->note}}</p>
            </div>
        @endif
        <table class="float-right table tbl-total">
            <tbody>
            @if ($invoice->tax_percent > 0)
                <tr>
                    <th class="text-right">@lang('Sub Total') ({{ $currency->ISO_code  }}):</th>
                    <td class="text-left">
                        {{ number_format($invoice->total_amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <th class="text-right">@lang('Tax'):</th>
                    <td class="text-left">
                        {{ $invoice->tax_percent }}%
                </tr>
                <tr>
                    <th class="text-right">@lang('Tax Amount') ({{ $currency->ISO_code  }}):</th>
                    <td class="text-left">
                        {{ number_format($invoice->total_amount * $invoice->tax_percent / 100, 2) }}
                    </td>
                </tr>
            @endif
            <tr>
                <th class="text-right">@lang('Grand Total') ({{ $currency->ISO_code  }}):</th>
                <td class="text-left">
                    @if ($invoice->tax_percent > 0)
                        {{ number_format($invoice->total_amount + ($tax_k * $invoice->total_amount * $invoice->tax_percent / 100), 2) }}
                    @else
                        {{ number_format($invoice->total_amount, 2) }}
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection
