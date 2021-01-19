@extends('layouts.excel')
@section('content')

    @if (count($expense_groups))
        @foreach($expense_groups as $name => $group)
            <table class="table">
                <tr>
                    <th colspan="4" style="font-size: 18px;">
                        <span>@lang($name != "" ? $name : __("Other Expense")) <small>({{count(reset($group))}})</small></span>
                    </th>
                </tr>
                <thead>
                <tr>
                    <th>@lang('#')</th>
                    <th>@lang('Date')</th>
                    <th>@lang('Sum')</th>
                    <th>@lang('VAT')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($group as $item)
                    <tr class="text-danger">
                        <td><a class="text-danger"
                               href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a>
                        </td>
                        <td>{{ $item->document_date }}</td>
                        <td>{{ number_format($item->sum  / $item->currency->value, 2) }}</td>
                        <td>{{number_format($item->vat / $item->currency->value, 2)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
    @if (count($income_groups))
        @foreach($income_groups as $name => $group)
            <table class="table">
                <tr>
                    <th colspan="5" style="font-size: 18px;">
                        <span>@lang($name != "" ? $name : __("Other Income")) <small>({{count(reset($group))}})</small></span>
                    </th>
                </tr>
                <thead>
                <tr>
                    <th>@lang('#')</th>
                    <th>@lang('Date')</th>
                    <th>@lang('Type')</th>
                    <th>@lang('Sum')</th>
                    <th>@lang('VAT')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($group as $items)
                    @if(is_array($items))
                        @foreach($items as $item)
                            <tr class="text-success">
                                @if ($item instanceof \Vanguard\Document)
                                    <td><a href="{{route('documents.show', $item)}}"
                                           class="text-success">{{ $item->document_number }}</a></td>
                                    <td>{{ $item->document_date }}</td>
                                    <td>{{ $item->income_type->name ?? __('Other Income') }}</td>
                                    <td>{{ number_format($item->sum / $item->currency->value, 2) }}</td>
                                    <td>{{number_format($item->vat / $item->currency->value, 2)}}</td>
                                @elseif($item instanceof \Vanguard\Invoice)
                                    <td><a href="{{route('invoice.show', $item)}}"
                                           class="text-success">{{ $item->invoice_number }}</a></td>
                                    <td>{{ $item->invoice_date }}</td>
                                    <td>{{ $item->income_type->name ?? __('Other Income') }}</td>
                                    <td>{{ number_format($item->grand_total / $item->currency->value, 2) }}</td>
                                    <td>{{ number_format($item->grand_total / $item->currency->value * $item->tax_percent / 100, 2) }}</td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-success">
                            @if ($items instanceof \Vanguard\Document)
                                <td><a href="{{route('documents.show', $items)}}"
                                       class="text-success">{{ $items->document_number }}</a></td>
                                <td>{{ $items->document_date }}</td>
                                <td>{{ $items->income_type->name ?? __('Other Income') }}</td>
                                <td>{{ number_format($items->sum / $items->currency->value, 2) }}</td>
                                <td>{{number_format($items->vat / $items->currency->value, 2)}}</td>
                            @elseif($items instanceof \Vanguard\Invoice)
                                <td><a href="{{route('invoice.show', $items)}}"
                                       class="text-success">{{ $items->invoice_number }}</a></td>
                                <td>{{ $items->invoice_date }}</td>
                                <td>{{ $items->income_type->name ?? __('Other Income') }}</td>
                                <td>{{ number_format($items->grand_total / $items->currency->value, 2) }}</td>
                                <td>{{ number_format($items->grand_total / $items->currency->value * $items->tax_percent / 100, 2) }}</td>
                            @endif
                        </tr>
                    @endif

                @endforeach
                </tbody>
            </table>
        @endforeach

    @endif

@stop
