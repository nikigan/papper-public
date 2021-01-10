@extends('layouts.app')

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

    <h4>@lang('Overview')</h4>
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

                                        {{-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                             <a href="{{ route('documents.show', $document) }}" class="dropdown-item text-gray-500">
                                                 <i class="fas fa-eye mr-2"></i>
                                                 @lang('View Document')
                                             </a>
                                         </div>--}}
                                    </div>


                                    {{--<a href="{{ route('documents.show', $document) }}"
                                       class="btn btn-icon"
                                       title="@lang('View Document')"
                                       data-toggle="tooltip"
                                       data-placement="top">
                                        <i class="fas fa-eye mr-2"></i>
                                    </a>--}}
                                    {{--@if($current_user->hasPermission('document.edit'))
                                        <a href="- route('documents.edit', $document) -"
                                           class="btn btn-icon edit"
                                           title="@lang('Edit document')"
                                           data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif--}}
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
    <h4>@lang('Documents')</h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" id="users-table-wrapper">
                @include('document.partials.table')
            </div>
        </div>
    </div>

    <h4>@lang('Invoices')</h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
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
                                    <a href="{{ route('invoice.show', $invoice) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('invoice.download', $invoice) }}" class="btn btn-sm btn-warning"><i class="fa fa-download"></i></a>
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
        </div>
    </div>
@endsection
