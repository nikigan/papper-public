@extends('layouts.app')

@section('page-title', 'Invoices')
@section('page-heading', 'Invoices')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Invoices')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h1>List of created invoices</h1>

    <div class="card">
        <div class="card-body">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                </div>

                <div class="col-md-2 mt-2 mt-md-0">
                </div>

                <div class="col-md-6">
                    <a href="{{ route('invoice.create') }}" class="btn btn-primary btn-rounded float-right mr-2">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Create Invoice')
                    </a>
                </div>
            </div>
            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-borderless table-striped">
                    <thead>
                    <tr>
                        <th>@lang("Invoice Date")</th>
                        <th>@lang("Invoice Number")</th>
                        <th>@lang("Customer")</th>
                        <th>@lang("Total Amount")</th>
                        <th>@lang("Action")</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($invoices))
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->customer->name }}</td>
                                <td>{{ number_format($invoice->total_amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('invoice.show', $invoice) }}" class="btn btn-sm btn-primary">@lang("View invoice")</a>
                                    <a href="{{ route('invoice.download', $invoice) }}" class="btn btn-sm btn-warning">@lang("Download PDF")</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5"><em>@lang('No records found.')</em></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            {{$invoices->withQueryString()->links()}}
        </div>
    </div>
@endsection
