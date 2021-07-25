@extends('layouts.main')

@section('page-title', __('Search'))
@section('page-heading', __('Search'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Search')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')

    <div class="card">
        <div class="card-body">
            <form action="" method="GET" class="mb-0" id="search-form">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="input-group custom-search-form">
                            <span class="input-group-append">
                                @if (Request::has('query') && Request::get('query') != '')
                                    <a href="{{ route('search.index') }}"
                                       class="btn btn-light d-flex align-items-center text-muted"
                                       role="button">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                @endif
                                <button class="btn btn-light" type="submit" id="search-users-btn">
                                    <i class="fas fa-search text-muted"></i>
                                </button>
                            </span>
                            <div class="dropdown">
                                <input type="text"
                                       class="form-control input-solid dropdown-toggle"
                                       id="search"
                                       name="query"
                                       data-toggle="dropdown"
                                       value="{{ Request::get('query') }}"
                                       placeholder="@lang('Search...')">
                                <ul id="search_items" class="dropdown-menu"></ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group mb-4">
                                    <label for="startDate">@lang('From'):</label>
                                    <input name="start_date" class="form-control dp" id="startDate"
                                           value="{{Request::get('start_date') ?? \Carbon\Carbon::now()->subYear()->format( config('app.date_format'))}}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-4">
                                    <label for="endDate">@lang('To'):</label>
                                    <input name="end_date" class="form-control dp" id="endDate"
                                           value="{{ Request::get('end_date') ?? \Carbon\Carbon::now()->format( config('app.date_format') ) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h2>@lang('Documents')</h2>
    <div class="card">
        <div class="card-body">
            @include('document.partials.table')
        </div>
    </div>
    <h2>@lang('Clients')</h2>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-borderless table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th class="min-width-80">@lang('Username')</th>
                        <th class="min-width-150">@lang('Full Name')</th>
                        <th class="min-width-100">@lang('Email')</th>
                        <th class="min-width-80">@lang('Registration Date')</th>
                        <th class="min-width-80">@lang('Accountant')</th>
                        <th class="text-center min-width-150">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($clients))
                        @foreach ($clients as $client)
                            @include('clients.partials.row', ['user' => $client])
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7"><em>@lang('No records found.')</em></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <h2>@lang('Invoices')</h2>
    <div class="card">
        <div class="card-body">
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
                                    <a href="{{ route('invoice.show', $invoice) }}" class="btn btn-sm btn-primary"><i
                                            class="fa fa-eye"></i></a>
                                    <a href="{{ route('invoice.download', $invoice) }}"
                                       class="btn btn-sm btn-warning"><i class="fa fa-download"></i></a>
                                    <a href="{{ route('invoice.destroy', $invoice) }}"
                                       class="btn btn-sm btn-danger"
                                       title="@lang('Delete Invoice')"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       data-method="DELETE"
                                       data-confirm-title="@lang('Please Confirm')"
                                       data-confirm-text="@lang('Are you sure that you want to delete this invoice?')"
                                       data-confirm-delete="@lang('Yes, delete it!')">
                                        <i class="fa fa-trash"></i>
                                    </a>
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
@stop

@section('scripts')
    <script>
        // $('input[type=\'date\']').change(function () {
        //     $('#search-form').submit();
        // });

        $(document).ready(function () {
            $(".dp").datepicker({
                language: "en",
                minView: "days",
                view: "days",
                dateFormat: "dd-mm-yyyy",
                onSelect: function () {
                    $('#search-form').submit();
                }
            });
        })

        $("#search").on('input', function () {
            $.ajax('{{route('search.autocomplete')}}', {
                dataType: "json",
                data: {
                    query: $(this).val()
                },
                complete: (res) => {
                    const url = "{{url("/")}}";
                    const si = $("#search_items");
                    {{--const docString = @lang('Document');--}}
                    {{--const invoiceString = @lang('Invoice');--}}
                    {{--const clientString = @lang('Client');--}}
                    si.empty();
                    res.responseJSON.documents.forEach(document => {
                        si.append(`<a target="_blank" class="dropdown-item" href="${url}/documents/${document.id}">Document ${document.document_number}</a>`);
                    });
                    si.append(`<div class="dropdown-divider"></div>`);
                    res.responseJSON.invoices.forEach(invoice => {
                        si.append(`<a target="_blank" class="dropdown-item" href="${url}/invoice/${invoice.id}">Invoice ${invoice.invoice_number}</a>`);
                    });
                    si.append(`<div class="dropdown-divider"></div>`);
                    res.responseJSON.clients.forEach(client => {
                        si.append(`<a target="_blank" class="dropdown-item" href="${url}/clients/${client.id}">Client ${client.username}</a>`);
                    });
                    // si.dropdown();
                }
            })
        });
    </script>
@stop
