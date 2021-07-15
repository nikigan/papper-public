@extends('layouts.main')

@section('page-title', __('Clients'))
@section('page-heading', __('Clients'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('clients.index') }}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>
            {{ $user->present()->nameOrEmail }}
        </a>
    </li>
@stop

@section('content')
    @include('partials.messages')

    <ul class="nav nav-pills pb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{route('clients.last', ['client' => $user])}}">@lang('Last')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('clients.waiting', ['client' => $user])}}">@lang('Waiting')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('clients.info', ['client' => $user])}}">@lang('Info')</a>
        </li>
    </ul>

    <div class="card">
        <div class="card-body">
            <h2>{{ $user->present()->name }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            @include('clients.partials.card', $last_card->toArray())
        </div>
        <div class="col-lg-4">
            @include('clients.partials.card', $customers_card->toArray())
        </div>
        <div class="col-lg-4">
            @include('clients.partials.card', $vendors_card->toArray())
        </div>
    </div>

    <h4>@lang('Overview')</h4>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped">
                            <thead>
                            <tr>
                                <th class="min-width-180">@lang('Month')</th>
                                <th class="min-width-180">@lang('Sum')</th>
                                <th class="min-width-180">@lang('VAT')</th>
                                <th class="text-center min-width-180">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($monthly_docs))
                                @foreach ($monthly_docs as $month => $document)
                                    <tr>
                                        <td class="align-middle"><a
                                                href="{{ route('clients.documents', ['client' => $user, 'month' => explode('/', $month)[0], 'year' => explode('/', $month)[1]]) }}">{{$month}}</a>
                                        </td>
                                        <td class="align-middle">
                                            <span class="{{$document['class']}}">@money($document['sum'])</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="{{$document['class']}}">@money($document['vat'])</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="dropdown show d-inline-block">
                                                <a class="btn btn-icon"
                                                   href="#" role="button" id="dropdownMenuLink"
                                                   data-toggle="dropdown"
                                                   aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="1"></td>
                                    <td><strong class="{{$sum_class}}">@money($sum)</strong></td>
                                    <td><strong class="{{$sum_class}}">@money($vat)</strong></td>
                                    <td></td>
                                </tr>
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
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    @include('clients.partials.chart', $monthly_docs)
                </div>
            </div>
        </div>
    </div>
    <h4>@lang('Documents')</h4>
    <div class="card">
        <div class="card-body">
            <a href="{{ route('clients.documents.create', ['client' => Request::route('client')]) }}"
               class="btn btn-primary btn-rounded action-btn mr-lg-2">
                <i class="fas fa-plus mr-2"></i>
                @lang('Create Document')
            </a>
            <div class="table-responsive" id="users-table-wrapper">
                @include('document.partials.table')
            </div>
        </div>
    </div>

    <h4>@lang('Invoices')</h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-striped" data-table="invoices">
                    <thead>
                    <tr>
                        <th><a data-sort-prop="invoice_date" class="table-sort-btn">@lang("Invoice Date")</a></th>
                        <th><a data-sort-prop="invoice_number" class="table-sort-btn">@lang("Invoice Number")</a></th>
                        <th>@lang("Customer")</th>
                        <th>@lang("Total Amount")</th>
                        <th>@lang("Action")</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($invoices))
                        @php($sum = 0)
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
                            @php($sum += $invoice->grand_total)
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                {{number_format($sum, 2)}}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5"><em>@lang('No records found.')</em></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
