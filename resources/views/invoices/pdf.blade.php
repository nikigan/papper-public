@extends('layouts.pdf')

@section('content')
    <div class="clearfix">
        {{--<div class="text-center">
            <img src="{{ asset('assets/img/vanguard-logo-no-text.png') }}"/>
        </div>
--}}
        <div class="text-center">
            <b>{{$document_name}} {{ $invoice->invoice_number }}</b>
            <br>
            {{ $invoice->invoice_date }}
        </div>
    </div>

    <div class="clearfix mt-3">
        <div class="float-left">
            <b>To</b>:
            {{ $invoice->customer->name }}
            <br/><br/>

            <b>Address</b>:
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
                <br/><br/><b>Phone</b>: {{ $invoice->customer->phone }}
            @endif
            @if ($invoice->customer->email != '')
                <br/><br/><b>Email</b>: {{ $invoice->customer->email }}
            @endif
            @if ($invoice->customer->vat_number != '')
                <br/><br/><b>VAT number</b>: {{ $invoice->customer->vat_number }}
            @endif

            @if ($invoice->customer->customer_fields)
                @foreach ($invoice->customer->customer_fields as $field)
                    <br/><br/><b>{{ $field->field_key }}</b>: {{ $field->field_value }}
                @endforeach
            @endif
        </div>

        <div class="float-right">
            <b>From</b>: {{ $invoice->creator->present()->name() }}
            <br/><br/>
            @if ($invoice->creator->address)
                <b>Address</b>: {{ $invoice->creator->address }}
                <br/><br/>
            @endif
            <b>Email</b>: {{ $invoice->creator->email }}
            {{--@if (is_array(config('invoices.seller.additional_info')))
                @foreach (config('invoices.seller.additional_info') as $key => $value)
                    <br /><br />
                    <b>{{ $key }}</b>: {{ $value }}
                @endforeach
            @endif--}}
        </div>
    </div>

    <div class="clearfix mt-3">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center"> #</th>
                <th> Product</th>
                <th class="text-center"> Qty</th>
                <th class="text-center"> Price ({{ $currency->ISO_code }})</th>
                <th class="text-center"> Total ({{ $currency->ISO_code }})</th>
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
            <div class="float-left col-md-7">
                <p>{{$invoice->note}}</p>
            </div>
        @endif
        <table class="float-right table tbl-total">
            <tbody>
            @if ($invoice->tax_percent > 0)
                <tr>
                    <th class="text-right">Sub Total ({{ $currency->ISO_code  }}):</th>
                    <td class="text-left">
                        {{ number_format($invoice->total_amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <th class="text-right">Tax:</th>
                    <td class="text-left">
                        {{ $invoice->tax_percent }}%
                </tr>
                <tr>
                    <th class="text-right">Tax Amount ({{ $currency->ISO_code  }}):</th>
                    <td class="text-left">
                        {{ number_format($invoice->total_amount * $invoice->tax_percent / 100, 2) }}
                    </td>
                </tr>
            @endif
            <tr>
                <th class="text-right">Grand Total ({{ $currency->ISO_code  }}):</th>
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

    <div class="clearfix mt-3">
        {{ config('invoices.footer_text') }}
    </div>
@endsection
