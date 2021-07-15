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
            @php($sum = 0)
            @foreach ($invoices as $invoice)
                @php($sum += $invoice->grand_total)
                <tr>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->customer->name }}</td>
                    <td>{{ number_format($invoice->grand_total, 2) }}</td>
                    <td>
                        <a href="{{ route('invoice.show', $invoice) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('invoice.download', $invoice) }}" class="btn btn-sm btn-warning"><i class="fa fa-download"></i></a>
                        @if(!$invoice->trashed())
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
                        @else
                            <a href="{{ route('invoices.restore', ['invoice' => $invoice ]) }}"
                               class="btn btn-icon"
                               title="@lang('Restore Document')"
                               data-toggle="tooltip"
                               data-placement="top"
                               data-method="GET"
                               data-confirm-title="@lang('Please Confirm')"
                               data-confirm-text="@lang('Are you sure that you want to restore this document?')"
                               data-confirm-get="@lang('Yes, restore it!')">
                                <i class="fas fa-trash-restore"></i>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    {{number_format($sum, 2)}}
                </td>
                <td></td>
            </tr>
        @else
            <tr>
                <td colspan="5"><em>@lang('No records found.')</em></td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
{{$invoices->withQueryString()->links()}}
